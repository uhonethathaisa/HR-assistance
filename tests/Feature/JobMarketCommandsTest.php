<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use App\Models\JobPosting;

class JobMarketCommandsTest extends TestCase
{
    use RefreshDatabase;

    public function test_fetch_remote_jobs_scrapes_multiple_sources()
    {
        // Fake both South African job boards with their own distinct markup.
        Http::fake([
            'https://www.careers24.com/jobs' => Http::response(
                <<<'HTML'
                <div class="job-card">
                    <h2 class="job-title">Careers24 Software Engineer</h2>
                    <div class="company-name">Tech Corp</div>
                    <div class="job-location">Johannesburg, Gauteng</div>
                    <div class="job-summary">Great role.</div>
                    <a class="apply" href="https://example.com/careers24/apply/1">Apply</a>
                </div>
                HTML,
                200
            ),
            'https://www.pnet.co.za/jobs' => Http::response(
                <<<'HTML'
                <div class="job-result">
                    <h3 class="job-title">Pnet Data Analyst</h3>
                    <div class="company">Nimbus Analytics</div>
                    <div class="location">Cape Town, Western Cape</div>
                    <div class="job-description">Analyse large datasets.</div>
                    <a class="apply-link" href="https://example.com/pnet/apply/2">Apply</a>
                </div>
                HTML,
                200
            ),
        ]);

        // Run the command
        $this->artisan('jobs:fetch-remote')
            ->assertExitCode(0)
            ->expectsOutputToContain('Scraping Careers24')
            ->expectsOutputToContain('Scraping Pnet')
            ->expectsOutputToContain('Successfully ingested/updated 1 jobs from Careers24')
            ->expectsOutputToContain('Successfully ingested/updated 1 jobs from Pnet');

        // Assert both jobs were ingested with their board name as the source
        $this->assertDatabaseHas('job_postings', [
            'apply_url' => 'https://example.com/careers24/apply/1',
            'title' => 'Careers24 Software Engineer',
            'company_name' => 'Tech Corp',
            'location' => 'Johannesburg, Gauteng',
            'source' => 'Careers24',
            'is_active' => 1,
        ]);

        $this->assertDatabaseHas('job_postings', [
            'apply_url' => 'https://example.com/pnet/apply/2',
            'title' => 'Pnet Data Analyst',
            'company_name' => 'Nimbus Analytics',
            'location' => 'Cape Town, Western Cape',
            'source' => 'Pnet',
            'is_active' => 1,
        ]);

        // Run again to ensure no duplicates are created
        $this->artisan('jobs:fetch-remote')->assertExitCode(0);

        $this->assertDatabaseCount('job_postings', 2);
    }

    public function test_fetch_remote_jobs_continues_when_a_source_returns_no_jobs()
    {
        Http::fake([
            'https://www.careers24.com/jobs' => Http::response(
                <<<'HTML'
                <div class="job-card">
                    <h2 class="job-title">Careers24 Role</h2>
                    <div class="company-name">Tech Corp</div>
                    <div class="job-location">Johannesburg</div>
                    <div class="job-summary">Desc.</div>
                    <a class="apply" href="https://example.com/careers24/apply/1">Apply</a>
                </div>
                HTML,
                200
            ),
            'https://www.pnet.co.za/jobs' => Http::response('<html><body><p>No jobs available right now</p></body></html>', 200),
        ]);

        $this->artisan('jobs:fetch-remote')
            ->assertExitCode(0)
            ->expectsOutputToContain('No job listings found for Pnet.');

        $this->assertDatabaseHas('job_postings', ['source' => 'Careers24']);
        $this->assertDatabaseCount('job_postings', 1);
    }

    public function test_fetch_remote_jobs_continues_when_a_source_fails_to_fetch()
    {
        Http::fake([
            'https://www.careers24.com/jobs' => function () {
                throw new \Illuminate\Http\Client\ConnectionException('Connection refused');
            },
            'https://www.pnet.co.za/jobs' => Http::response(
                <<<'HTML'
                <div class="job-result">
                    <h3 class="job-title">Pnet Role</h3>
                    <div class="company">Nimbus Analytics</div>
                    <div class="location">Cape Town</div>
                    <div class="job-description">Desc.</div>
                    <a class="apply-link" href="https://example.com/pnet/apply/2">Apply</a>
                </div>
                HTML,
                200
            ),
        ]);

        $this->artisan('jobs:fetch-remote')
            ->assertExitCode(0)
            ->expectsOutputToContain('Failed to scrape Careers24');

        $this->assertDatabaseHas('job_postings', ['source' => 'Pnet']);
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
