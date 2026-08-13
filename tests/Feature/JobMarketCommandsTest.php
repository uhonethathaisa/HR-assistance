<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use App\Models\JobPosting;

class JobMarketCommandsTest extends TestCase
{
    use RefreshDatabase;

    public function test_fetch_remote_jobs_scrapes_and_ingests_listings()
    {
        // Fake the target careers page with standard listing markup.
        Http::fake([
            'https://example.com/jobs' => Http::response(
                <<<'HTML'
                <div class="job-listing">
                    <h2 class="title">Software Engineer</h2>
                    <div class="company">Tech Corp</div>
                    <div class="location">Remote</div>
                    <div class="description">Great role.</div>
                    <a class="apply-link" href="https://example.com/apply/1">Apply</a>
                </div>
                HTML,
                200
            ),
        ]);

        // Run the command
        $this->artisan('jobs:fetch-remote')
            ->expectsOutputToContain('Successfully ingested/updated 1 jobs.')
            ->assertExitCode(0);

        // Assert job was created
        $this->assertDatabaseHas('job_postings', [
            'apply_url' => 'https://example.com/apply/1',
            'title' => 'Software Engineer',
            'company_name' => 'Tech Corp',
            'location' => 'Remote',
            'source' => 'scraped',
            'is_active' => 1,
        ]);

        // Run again to ensure no duplicates are created
        $this->artisan('jobs:fetch-remote')->assertExitCode(0);

        $this->assertDatabaseCount('job_postings', 1);
    }

    public function test_verify_job_links_deactivates_broken_urls()
    {
        // Create an active job with a working link
        $workingJob = JobPosting::create([
            'title' => 'Working Job',
            'company_name' => 'Valid Corp',
            'location' => 'Johannesburg',
            'description' => 'Valid link.',
            'apply_url' => 'https://working-link.com',
            'is_active' => true,
        ]);

        // Create an active job with a broken link
        $brokenJob = JobPosting::create([
            'title' => 'Broken Job',
            'company_name' => 'Invalid Corp',
            'location' => 'Cape Town',
            'description' => 'Broken link.',
            'apply_url' => 'https://broken-link.com',
            'is_active' => true,
        ]);

        // Mock the HTTP responses
        Http::fake([
            'https://working-link.com' => Http::response('OK', 200),
            'https://broken-link.com' => Http::response('Not Found', 404),
        ]);

        // Run the command
        $this->artisan('jobs:verify-links')
            ->expectsOutputToContain("Deactivated (HTTP 404): https://broken-link.com")
            ->assertExitCode(0);

        // Assert database states
        $this->assertDatabaseHas('job_postings', [
            'id' => $workingJob->id,
            'is_active' => 1,
        ]);

        $this->assertDatabaseHas('job_postings', [
            'id' => $brokenJob->id,
            'is_active' => 0,
        ]);
    }

    public function test_verify_job_links_handles_connection_timeouts()
    {
        $timeoutJob = JobPosting::create([
            'title' => 'Timeout Job',
            'company_name' => 'Slow Corp',
            'location' => 'Pretoria',
            'description' => 'Times out.',
            'apply_url' => 'https://timeout-link.com',
            'is_active' => true,
        ]);

        // Mock a connection exception/timeout
        Http::fake(function (\Illuminate\Http\Client\Request $request) {
            throw new \Illuminate\Http\Client\ConnectionException('Connection timed out');
        });

        $this->artisan('jobs:verify-links')
            ->expectsOutputToContain("Deactivated (Connection Error): https://timeout-link.com")
            ->assertExitCode(0);

        $this->assertDatabaseHas('job_postings', [
            'id' => $timeoutJob->id,
            'is_active' => 0,
        ]);
    }
}
