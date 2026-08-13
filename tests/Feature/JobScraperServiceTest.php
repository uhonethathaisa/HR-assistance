<?php

namespace Tests\Feature;

use App\Services\JobScraperService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class JobScraperServiceTest extends TestCase
{
    /**
     * Selector map matching the default test fixtures.
     */
    protected function defaultSelectors(): array
    {
        return [
            'container' => '.job-listing, .card',
            'title' => 'h2.title, .job-title, .title',
            'company' => '.company, .company-name',
            'location' => '.location, .job-location',
            'description' => '.description, .job-description',
            'apply_url' => 'a.apply-link, a.apply, .apply a, a[data-apply]',
        ];
    }

    public function test_scrape_extracts_job_data_from_listing_markup(): void
    {
        Http::fake([
            'https://careers.example.com/jobs' => Http::response(
                <<<'HTML'
                <html>
                <body>
                    <div class="job-listing">
                        <h2 class="title">Senior Laravel Developer</h2>
                        <div class="company">Acme Corp</div>
                        <div class="location">Cape Town, Western Cape</div>
                        <div class="description">Build scalable Laravel applications.</div>
                        <a class="apply-link" href="/jobs/42">Apply</a>
                    </div>
                    <div class="card">
                        <h2 class="title">Data Analyst</h2>
                        <div class="company">Nimbus Analytics</div>
                        <div class="location">Johannesburg, Gauteng</div>
                        <div class="description">Analyse large datasets.</div>
                        <a class="apply" href="https://nimbus.example/apply/7">Apply</a>
                    </div>
                    <div class="job-listing">
                        <h2 class="title">No Link Role</h2>
                        <div class="company">No Link Co</div>
                        <div class="location">Durban</div>
                        <div class="description">Missing apply link.</div>
                    </div>
                </body>
                </html>
                HTML,
                200
            ),
        ]);

        $jobs = (new JobScraperService())->scrape('https://careers.example.com/jobs', $this->defaultSelectors());

        $this->assertCount(2, $jobs);

        $this->assertSame([
            'title' => 'Senior Laravel Developer',
            'company_name' => 'Acme Corp',
            'location' => 'Cape Town, Western Cape',
            'description' => 'Build scalable Laravel applications.',
            'apply_url' => 'https://careers.example.com/jobs/42',
        ], $jobs[0]);

        $this->assertSame('Data Analyst', $jobs[1]['title']);
        $this->assertSame('Nimbus Analytics', $jobs[1]['company_name']);
        $this->assertSame('https://nimbus.example/apply/7', $jobs[1]['apply_url']);
    }

    public function test_scrape_uses_custom_selectors_for_a_different_markup_structure(): void
    {
        Http::fake([
            'https://boards.example.com/roles' => Http::response(
                <<<'HTML'
                <div class="custom-job">
                    <h3 class="role">Custom Role</h3>
                    <div class="org">Custom Org</div>
                    <div class="city">Pretoria, Gauteng</div>
                    <div class="summary">A completely different markup structure.</div>
                    <a class="go" href="/custom/apply/1">Apply</a>
                </div>
                HTML,
                200
            ),
        ]);

        $jobs = (new JobScraperService())->scrape('https://boards.example.com/roles', [
            'container' => '.custom-job',
            'title' => 'h3.role',
            'company' => '.org',
            'location' => '.city',
            'description' => '.summary',
            'apply_url' => 'a.go',
        ]);

        $this->assertCount(1, $jobs);
        $this->assertSame([
            'title' => 'Custom Role',
            'company_name' => 'Custom Org',
            'location' => 'Pretoria, Gauteng',
            'description' => 'A completely different markup structure.',
            'apply_url' => 'https://boards.example.com/custom/apply/1',
        ], $jobs[0]);
    }

    public function test_scrape_resolves_relative_urls_including_the_port(): void
    {
        Http::fake([
            'http://127.0.0.1:8126/jobs' => Http::response(
                <<<'HTML'
                <div class="job-listing">
                    <h2 class="title">Role</h2>
                    <div class="company">Co</div>
                    <div class="location">Remote</div>
                    <div class="description">Description.</div>
                    <a class="apply-link" href="/apply/1">Apply</a>
                </div>
                HTML,
                200
            ),
        ]);

        $jobs = (new JobScraperService())->scrape('http://127.0.0.1:8126/jobs', $this->defaultSelectors());

        $this->assertSame('http://127.0.0.1:8126/apply/1', $jobs[0]['apply_url']);
    }

    public function test_scrape_skips_listings_without_a_title(): void
    {
        Http::fake([
            'https://careers.example.com/jobs' => Http::response(
                <<<'HTML'
                <div class="job-listing">
                    <div class="company">No Title Co</div>
                    <a class="apply-link" href="https://careers.example.com/apply/9">Apply</a>
                </div>
                HTML,
                200
            ),
        ]);

        $this->assertSame([], (new JobScraperService())->scrape('https://careers.example.com/jobs', $this->defaultSelectors()));
    }

    public function test_scrape_throws_when_the_page_cannot_be_fetched(): void
    {
        Http::fake([
            'https://careers.example.com/down' => Http::response('Service Unavailable', 503),
        ]);

        $this->expectException(\RuntimeException::class);

        (new JobScraperService())->scrape('https://careers.example.com/down', $this->defaultSelectors());
    }
}

