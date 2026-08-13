<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

class JobScraperService
{
    /**
     * Scrape job postings from the HTML of the given URL using the provided
     * CSS selector map, so a single service can handle many job boards with
     * different markup structures.
     *
     * Expected $selectors keys (values may be a string or an array of strings):
     *   container   - element(s) that wrap a single job listing
     *   title       - title element(s)
     *   company     - company name element(s)
     *   location    - location element(s)
     *   description - description element(s)
     *   apply_url   - apply link element(s)
     *
     * Each returned item is formatted for direct ingestion into the
     * JobPosting schema (title, company_name, location, description, apply_url).
     *
     * @return array<int, array{title: string, company_name: string, location: string, description: string, apply_url: string}>
     *
     * @throws \RuntimeException When the target page cannot be fetched.
     */
    public function scrape(string $url, array $selectors): array
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

        // Normalize each field selector (string or array) once, before the loop.
        $container = $this->selector($selectors['container'] ?? '.job-listing, .card');
        $title = $this->selector($selectors['title'] ?? 'h2.title, .job-title, .title');
        $company = $this->selector($selectors['company'] ?? '.company, .company-name');
        $location = $this->selector($selectors['location'] ?? '.location, .job-location');
        $description = $this->selector($selectors['description'] ?? '.description, .job-description');
        $applyUrl = $this->selector($selectors['apply_url'] ?? 'a.apply-link, a.apply, .apply a, a[data-apply]');

        $jobs = [];

        $crawler->filter($container)->each(function (Crawler $node) use (&$jobs, $url, $title, $company, $location, $description, $applyUrl) {
            $titleText = $this->text($node, $title);
            $companyText = $this->text($node, $company);
            $locationText = $this->text($node, $location);
            $descriptionText = $this->text($node, $description);

            $applyHref = $this->href($node, $applyUrl);

            // Fallback: treat the first anchor inside the listing as the apply link.
            if ($applyHref === '') {
                $applyHref = $this->href($node, 'a[href]');
            }

            // Skip listings that can't be published (no title / no apply link).
            if ($titleText === '' || $applyHref === '') {
                return;
            }

            $jobs[] = [
                'title' => $titleText,
                'company_name' => $companyText !== '' ? $companyText : 'Unknown Employer',
                'location' => $locationText,
                'description' => $descriptionText,
                'apply_url' => $this->resolveUrl($applyHref, $url),
            ];
        });

        return $jobs;
    }

    /**
     * Normalize a selector value that may be a string or an array of strings.
     */
    protected function selector(string|array $selector): string
    {
        return is_array($selector) ? implode(', ', $selector) : $selector;
    }

    /**
     * Extract and trim the text of the first element matching the selector.
     */
    protected function text(Crawler $node, string $selector): string
    {
        $matches = $node->filter($selector);

        if ($matches->count() === 0) {
            return '';
        }

        return trim($matches->first()->text());
    }

    /**
     * Extract the href of the first element matching the selector.
     */
    protected function href(Crawler $node, string $selector): string
    {
        $matches = $node->filter($selector);

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


