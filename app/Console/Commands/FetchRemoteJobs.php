<?php

namespace App\Console\Commands;

use App\Models\JobPosting;
use App\Services\IndeedApiService;
use App\Services\JobScraperService;
use Illuminate\Console\Command;

class FetchRemoteJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs:fetch-remote';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape remote job postings from multiple South African job boards and ingest them into the database.';

    /**
     * The scraper service used to fetch and parse each job board's HTML.
     */
    public function __construct(
        private JobScraperService $scraper,
        private IndeedApiService $indeed,
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting remote job ingestion...');

        // Shared, verified selector map for Careers24. Every industry search
        // below uses the same listing markup: each job is a div.job-card; the
        // title + apply link share the same anchor; the company name only
        // exists in the logo's alt attribute (hence @alt); the location is
        // exposed via the data-location attribute on the share button. The
        // listing cards carry no description snippet, so that field is
        // intentionally left blank here.
        $careers24Selectors = [
            'container' => '.job-card',
            'title' => 'a[data-control="vacancy-title"]',
            'company' => 'img[alt]@alt',
            'location' => '[data-location]@data-location',
            'description' => '.description, .job-summary',
            'apply_url' => 'a[data-control="vacancy-title"]',
        ];

        // Multi-source configuration: each entry defines a South African job
        // board to scrape, its target URL, and the CSS selectors matching its
        // listing markup. Careers24 entries use location-scoped search URLs
        // (lc-south-africa) per industry and paginate up to "max_pages" deep.
        $sources = [
            [
                'name' => 'Careers24 - Finance',
                'url' => 'https://www.careers24.com/jobs/lc-south-africa/q-finance/',
                'max_pages' => 3,
                'selectors' => $careers24Selectors,
            ],
            [
                'name' => 'Careers24 - Engineering',
                'url' => 'https://www.careers24.com/jobs/lc-south-africa/q-engineering/',
                'max_pages' => 3,
                'selectors' => $careers24Selectors,
            ],
            [
                'name' => 'Careers24 - Healthcare',
                'url' => 'https://www.careers24.com/jobs/lc-south-africa/q-healthcare/',
                'max_pages' => 3,
                'selectors' => $careers24Selectors,
            ],
            [
                'name' => 'Careers24 - Retail',
                'url' => 'https://www.careers24.com/jobs/lc-south-africa/q-retail/',
                'max_pages' => 3,
                'selectors' => $careers24Selectors,
            ],
            [
                'name' => 'Careers24 - IT & Software',
                'url' => 'https://www.careers24.com/jobs/lc-south-africa/q-software-developer/',
                'max_pages' => 3,
                'selectors' => $careers24Selectors,
            ],
            [
                'name' => 'Pnet',
                'url' => 'https://www.pnet.co.za/jobs',
                'selectors' => [
                    'container' => 'article[data-qa="result-item"]',
                    'title'     => '[data-qa="job-title"]',
                    'company'   => '[data-qa="company-name"]',
                    'location'  => '[data-qa="job-location"]',
                    'description' => '[data-qa="job-snippet"]', // Or fallback to a generic snippet class if this doesn't exist
                    'apply_url' => 'a[data-qa="job-title"]', // The title usually contains the link
                ],
            ],
        ];

        foreach ($sources as $source) {
            $maxPages = $source['max_pages'] ?? 1;
            $jobs = [];
            $scrapeFailed = false;

            for ($page = 1; $page <= $maxPages; $page++) {
                $pageUrl = $this->sourcePageUrl($source['url'], $page);

                $this->info("Scraping {$source['name']} ({$pageUrl}) - page {$page}/{$maxPages}...");

                try {
                    $pageJobs = $this->scraper->scrape($pageUrl, $source['selectors']);
                } catch (\Exception $e) {
                    $this->error("Failed to scrape {$source['name']} page {$page}: {$e->getMessage()}");
                    $scrapeFailed = true;

                    break; // Don't keep hammering a source that is failing.
                }

                $jobs = array_merge($jobs, $pageJobs);

                // A page with no listings means the results are exhausted.
                if ($pageJobs === []) {
                    break;
                }
            }

            // The same listing can appear on consecutive pages; dedupe before saving.
            $jobs = collect($jobs)->unique('apply_url')->values()->all();

            if ($jobs === []) {
                if (! $scrapeFailed) {
                    $this->warn("No job listings found for {$source['name']}.");
                }

                continue;
            }

            $count = 0;

            foreach ($jobs as $job) {
                // Prevent duplicates via updateOrCreate on apply_url
                JobPosting::updateOrCreate(
                    ['apply_url' => $job['apply_url']],
                    [
                        'title' => $job['title'],
                        'company_name' => $job['company_name'],
                        'location' => $job['location'],
                        'description' => $job['description'],
                        'source' => $source['name'],
                        'is_active' => true,
                    ]
                );
                $count++;
            }

            $this->info("Successfully ingested/updated {$count} jobs from {$source['name']}.");
        }

        // Indeed via RapidAPI: query a range of professional roles, all
        // explicitly locked to South Africa ('za' country code).
        $indeedQueries = ['Financial Accountant', 'Mechanical Engineer', 'Retail Manager', 'Registered Nurse', 'HR Business Partner', 'Test Analyst'];

        foreach ($indeedQueries as $query) {
            $this->info("Fetching Indeed jobs for '{$query}' in South Africa...");

            try {
                $jobs = $this->indeed->fetchJobs($query, 'South Africa', 'za');
            } catch (\Exception $e) {
                $this->error("Failed to fetch Indeed jobs for '{$query}': {$e->getMessage()}");

                continue;
            }

            if ($jobs === []) {
                $this->warn("No Indeed jobs returned for '{$query}'.");

                continue;
            }

            $count = 0;

            foreach ($jobs as $job) {
                // Prevent duplicates via updateOrCreate on apply_url.
                JobPosting::updateOrCreate(
                    ['apply_url' => $job['apply_url']],
                    [
                        'title' => $job['title'],
                        'company_name' => $job['company'],
                        'location' => $job['location'],
                        'description' => $job['description'],
                        'source' => 'Indeed',
                        'is_active' => true,
                    ]
                );
                $count++;
            }

            $this->info("Successfully ingested/updated {$count} Indeed jobs for '{$query}'.");
        }

        $this->info('Remote job ingestion complete.');
    }

    /**
     * Build the URL for a given page of a source. Page 1 uses the base URL
     * unchanged; later pages append the "?page=N" query parameter supported by
     * the job boards (verified for Careers24).
     */
    protected function sourcePageUrl(string $url, int $page): string
    {
        if ($page <= 1) {
            return $url;
        }

        $separator = str_contains($url, '?') ? '&' : '?';

        return $url.$separator.'page='.$page;
    }
}


