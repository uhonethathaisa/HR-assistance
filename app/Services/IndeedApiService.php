<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class IndeedApiService
{
    /**
     * RapidAPI Indeed Scraper endpoint.
     */
    private const ENDPOINT = 'https://indeed-scraper-api.p.rapidapi.com/api/job';

    /**
     * Fetch full-time job listings from Indeed via the RapidAPI scraper and
     * map them into the application's ingestion format.
     *
     * @return array<int, array{title: string, company: string, location: string, description: string, apply_url: string}>
     *
     * @throws \RuntimeException When RAPIDAPI_KEY is missing or the API request fails.
     */
    public function fetchJobs(string $query, string $location, string $country = 'za', int $maxRows = 15): array
    {
        $apiKey = env('RAPIDAPI_KEY');

        if ($apiKey === null || $apiKey === '') {
            throw new \RuntimeException('RAPIDAPI_KEY is not configured in the environment.');
        }

        $response = Http::withHeaders([
            'x-rapidapi-host' => 'indeed-scraper-api.p.rapidapi.com',
            'x-rapidapi-key' => $apiKey,
            'Content-Type' => 'application/json',
        ])
            // Scraper APIs run headless browsers server-side and can take well
            // over 30 seconds; allow enough headroom for slow upstream responses.
            ->timeout(90)
            ->post(self::ENDPOINT, [
                'scraper' => [
                    'maxRows' => $maxRows,
                    'query' => $query,
                    'location' => $location,
                    'jobType' => 'fulltime',
                    'radius' => '50',
                    'sort' => 'relevance',
                    'fromDays' => '7',
                    'country' => $country,
                ],
            ]);

        if ($response->failed()) {
            throw new \RuntimeException("Indeed API request failed with HTTP status {$response->status()}.");
        }

        $data = $response->json();

        if (!is_array($data)) {
            return [];
        }

        return $this->mapJobs($data);
    }

    /**
     * Normalize the upstream response into the ingestion format. The provider
     * returns a BullMQ job envelope whose actual job listings are a list under
     * "returnvalue.data"; the response shape is deliberately tolerated for the
     * different field namings used by Indeed scraper providers.
     *
     * @return array<int, array{title: string, company: string, location: string, description: string, apply_url: string}>
     */
    private function mapJobs(array $data): array
    {
        if (($data['state'] ?? null) === 'failed') {
            throw new \RuntimeException('Indeed API scraping job failed.');
        }

        $returnValue = $data['returnvalue'] ?? null;

        if (is_array($returnValue)) {
            $items = $returnValue['data'] ?? $returnValue['results'] ?? $returnValue['jobs'] ?? $returnValue;
        } else {
            $items = $data['results'] ?? $data['jobs'] ?? null;

            if ($items === null && isset($data['data']) && is_array($data['data'])) {
                $items = $this->isList($data['data'])
                    ? $data['data']
                    : ($data['data']['results'] ?? $data['data']['jobs'] ?? null);
            }
        }

        if (!is_array($items) || $items === []) {
            return [];
        }

        $jobs = [];

        foreach ($items as $item) {
            if (!is_array($item)) {
                continue;
            }

            $title = $this->first($item, ['title', 'jobTitle', 'job_title', 'positionName']);
            $applyUrl = $this->first($item, ['jobUrl', 'job_url', 'url', 'applyLink', 'apply_url', 'link', 'externalUrl']);

            if ($title === '' || $applyUrl === '') {
                continue; // Skip listings that can't be published.
            }

            $jobs[] = [
                'title' => $title,
                'company' => $this->first($item, ['companyName', 'company_name', 'company', 'employer']),
                'location' => $this->locationText($item['location'] ?? null),
                'description' => $this->first($item, ['descriptionText', 'descriptionHtml', 'description', 'jobDescription', 'job_description', 'snippet', 'jobSnippet', 'summary']),
                'apply_url' => $applyUrl,
            ];
        }

        return $jobs;
    }

    /**
     * Normalize a location value that may be a plain string or a structured
     * object (e.g. {"city": "...", "formattedAddressShort": "..."}).
     *
     * @param mixed $location
     */
    private function locationText($location): string
    {
        if (is_string($location) && trim($location) !== '') {
            return trim($location);
        }

        if (is_array($location)) {
            foreach (['formattedAddressShort', 'formattedAddressLong', 'fullAddress', 'city'] as $key) {
                if (isset($location[$key]) && is_scalar($location[$key]) && trim((string) $location[$key]) !== '') {
                    return trim((string) $location[$key]);
                }
            }
        }

        return '';
    }

    /**
     * Return the first non-empty scalar value among the candidate keys.
     *
     * @param array<string, mixed> $item
     * @param string[]             $keys
     */
    private function first(array $item, array $keys): string
    {
        foreach ($keys as $key) {
            if (isset($item[$key]) && is_scalar($item[$key]) && trim((string) $item[$key]) !== '') {
                return trim((string) $item[$key]);
            }
        }

        return '';
    }

    /**
     * Whether the value is a sequential array (a list of items).
     *
     * @param mixed $value
     */
    private function isList($value): bool
    {
        return is_array($value) && array_keys($value) === range(0, count($value) - 1);
    }
}
