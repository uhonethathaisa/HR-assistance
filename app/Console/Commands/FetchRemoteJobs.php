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
    protected $description = 'Scrape remote job postings from a target careers page and ingest them into the database.';

    /**
     * Execute the console command.
     */
    public function handle(JobScraperService $scraper)
    {
        $this->info('Starting remote job ingestion...');

        // ─── TARGET URL ─────────────────────────────────────────────────────
        // Placeholder — point this at the live careers page to scrape, e.g.
        // https://www.example-company.com/careers
        //
        // Retargeting steps:
        //   1. Inspect a job card on the target page (browser dev tools).
        //   2. Update the CSS selectors in app/Services/JobScraperService.php.
        //   3. Set $targetUrl below to the live page.
        //   4. Commit & push to main to trigger the GitHub Actions deploy.
        $targetUrl = 'https://example.com/jobs';

        try {
            $jobs = $scraper->scrape($targetUrl);

            if ($jobs === []) {
                $this->warn('No job listings found on the target page.');

                return;
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
                        'source' => 'scraped',
                        'is_active' => true,
                    ]
                );
                $count++;
            }

            $this->info("Successfully ingested/updated {$count} jobs.");
        } catch (\Exception $e) {
            $this->error('An error occurred during ingestion: ' . $e->getMessage());
        }
    }
}

