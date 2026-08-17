<?php

namespace App\Console\Commands;

use App\Models\JobPosting;
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
    public function __construct(private JobScraperService $scraper)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting remote job ingestion...');

        // Multi-source configuration: each entry defines a South African job
        // board to scrape, its target URL, and the CSS selectors matching its
        // listing markup. Verify each board's real markup in browser DevTools
        // before enabling it for production ingestion.
        $sources = [
            [
                'name' => 'Careers24',
                'url' => 'https://www.careers24.com/jobs',
                'selectors' => [
                    'container' => '.job-list .job, .job-card',
                    'title' => 'h2, .job-title',
                    'company' => '.company, .company-name',
                    'location' => '.location, .job-location',
                    'description' => '.description, .job-summary',
                    'apply_url' => 'a.apply, a[data-job-url]',
                ],
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
            $this->info("Scraping {$source['name']} from {$source['url']}...");

            try {
                $jobs = $this->scraper->scrape($source['url'], $source['selectors']);
            } catch (\Exception $e) {
                $this->error("Failed to scrape {$source['name']}: {$e->getMessage()}");

                continue; // Keep ingesting the remaining sources.
            }

            if ($jobs === []) {
                $this->warn("No job listings found for {$source['name']}.");

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

        $this->info('Remote job ingestion complete.');
    }
}


