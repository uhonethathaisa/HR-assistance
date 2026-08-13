<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

class JobScraperService
{
    /*
    |--------------------------------------------------------------------------
    | CSS SELECTORS
    |--------------------------------------------------------------------------
    |
    | Retarget the scraper by updating these to match the markup of the
    | careers page you want to scrape:
    |
    |   1. Open the target page in a browser and right-click a job card.
    |   2. Inspect the HTML and note the container class (e.g. .job-card,
    |      .job-item) and the child classes for title, company, location
    |      and the apply link.
    |   3. Update the selector arrays below (first match wins per field).
    |
    */

    /** Container(s) that wrap a single job listing. */
    protected array $listingSelectors = ['.job-listing', '.card'];

    /** Title element(s) inside a listing. */
    protected array $titleSelectors = ['h2.title', '.job-title', '.title'];

    /** Company name element(s) inside a listing. */
    protected array $companySelectors = ['.company', '.company-name'];

    /** Location element(s) inside a listing. */
    protected array $locationSelectors = ['.location', '.job-location'];

    /** Description element(s) inside a listing. */
    protected array $descriptionSelectors = ['.description', '.job-description'];

    /** Apply link element(s) inside a listing. */
    protected array $applySelectors = ['a.apply-link', 'a.apply', '.apply a', 'a[data-apply]'];

    /**
     * Scrape job postings from the HTML of the given careers page.
     *
     * Each returned item is formatted for direct ingestion into the
     * JobPosting schema (title, company_name, location, description, apply_url).
     *
     * @return array<int, array{title: string, company_name: string, location: string, description: string, apply_url: string}>
     *
     * @throws \RuntimeException When the target page cannot be fetched.
     */
    public function scrape(string $url): array
    {
        $response = Http::accept('text/html')
            ->timeout(15)
            ->withOptions(['verify' => app()->environment('local') ? false : true])
            ->withHeaders(['User-Agent' => 'HR-Assistance-JobBot/1.0'])
            ->get($url);

        if ($response->failed()) {
            throw new \RuntimeException("Failed to fetch {$url}. HTTP Status: {$response->status()}");
        }

        $crawler = new Crawler($response->body());

        $jobs = [];

        $crawler->filter($this->selector($this->listingSelectors))->each(function (Crawler $node) use (&$jobs, $url) {
            $title = $this->text($node, $this->titleSelectors);
            $company = $this->text($node, $this->companySelectors);
            $location = $this->text($node, $this->locationSelectors);
            $description = $this->text($node, $this->descriptionSelectors);

            $applyUrl = $this->href($node, $this->applySelectors);

            // Fallback: treat the first anchor inside the listing as the apply link.
            if ($applyUrl === '') {
                $applyUrl = $this->href($node, ['a[href]']);
            }

            // Skip listings that can't be published (no title / no apply link).
            if ($title === '' || $applyUrl === '') {
                return;
            }

            $jobs[] = [
                'title' => $title,
                'company_name' => $company !== '' ? $company : 'Unknown Employer',
                'location' => $location,
                'description' => $description,
                'apply_url' => $this->resolveUrl($applyUrl, $url),
            ];
        });

        return $jobs;
    }

    /**
     * Join a set of CSS selectors into a single comma-separated selector.
     */
    protected function selector(array $selectors): string
    {
        return implode(', ', $selectors);
    }

    /**
     * Extract and trim the text of the first element matching the selectors.
     */
    protected function text(Crawler $node, array $selectors): string
    {
        $matches = $node->filter($this->selector($selectors));

        if ($matches->count() === 0) {
            return '';
        }

        return trim($matches->first()->text());
    }

    /**
     * Extract the href of the first element matching the selectors.
     */
    protected function href(Crawler $node, array $selectors): string
    {
        $matches = $node->filter($this->selector($selectors));

        if ($matches->count() === 0) {
            return '';
        }

        return trim((string) $matches->first()->attr('href'));
    }

    /**
     * Convert a possibly-relative href into an absolute URL against the page
     * that was scraped, so stored apply_url values are always clickable.
     */
    protected function resolveUrl(string $href, string $baseUrl): string
    {
        if (Str::startsWith($href, ['http://', 'https://'])) {
            return $href;
        }

        if (Str::startsWith($href, '//')) {
            return 'https:'.$href;
        }

        $base = parse_url($baseUrl);
        $origin = ($base['scheme'] ?? 'https').'://'.($base['host'] ?? '');

        if (isset($base['port'])) {
            $origin .= ':'.$base['port'];
        }

        if (Str::startsWith($href, '/')) {
            return $origin.$href;
        }

        $path = rtrim($base['path'] ?? '/', '/');

        return $origin.$path.'/'.$href;
    }
}

