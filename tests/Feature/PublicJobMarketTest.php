<?php

namespace Tests\Feature;

use App\Livewire\Public\JobMarketPage;
use App\Models\JobPosting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PublicJobMarketTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Create a job posting with sensible defaults.
     */
    protected function createJob(array $attributes = []): JobPosting
    {
        return JobPosting::create([
            'title' => 'Senior Software Engineer',
            'company_name' => 'Acme Corp',
            'location' => 'Cape Town, Western Cape',
            'description' => 'A great opportunity to build scalable software for a leading South African employer.',
            'apply_url' => 'https://jobs.example.com/apply/123',
            'source' => 'manual',
            'is_active' => true,
            ...$attributes,
        ]);
    }

    public function test_guests_can_access_the_public_job_market_page(): void
    {
        $this->assertGuest();

        $this->get('/jobs')
            ->assertOk()
            ->assertSee('Explore')
            ->assertSee('Open Roles')
            ->assertSee('Job title, keywords, or company')
            ->assertSee("City, province, or 'remote'", false)
            ->assertSee('Find jobs');
    }

    public function test_only_active_job_postings_are_displayed(): void
    {
        $this->createJob(['title' => 'Visible Active Role']);
        $this->createJob([
            'title' => 'Hidden Inactive Role',
            'is_active' => false,
        ]);

        Livewire::test(JobMarketPage::class)
            ->assertOk()
            ->assertSee('Visible Active Role')
            ->assertDontSee('Hidden Inactive Role');
    }

    public function test_keyword_filters_jobs_by_title(): void
    {
        $this->createJob(['title' => 'Senior Laravel Developer']);
        $this->createJob(['title' => 'Data Analyst']);

        Livewire::test(JobMarketPage::class)
            ->set('keyword', 'Laravel')
            ->assertOk()
            ->assertSee('Senior Laravel Developer')
            ->assertDontSee('Data Analyst');
    }

    public function test_keyword_matches_company_and_description(): void
    {
        $this->createJob(['company_name' => 'Globex', 'title' => 'Backend Engineer']);
        $this->createJob(['description' => 'Strong focus on machine learning models.', 'title' => 'Data Scientist']);

        Livewire::test(JobMarketPage::class)
            ->set('keyword', 'Globex')
            ->assertOk()
            ->assertSee('Backend Engineer')
            ->assertDontSee('Data Scientist');

        Livewire::test(JobMarketPage::class)
            ->set('keyword', 'machine learning')
            ->assertOk()
            ->assertSee('Data Scientist')
            ->assertDontSee('Backend Engineer');
    }

    public function test_location_filters_jobs_by_location(): void
    {
        $this->createJob(['location' => 'Johannesburg, Gauteng']);
        $this->createJob(['location' => 'Durban, KwaZulu-Natal']);

        Livewire::test(JobMarketPage::class)
            ->set('location', 'Johannesburg')
            ->assertOk()
            ->assertSee('Johannesburg, Gauteng')
            ->assertDontSee('Durban, KwaZulu-Natal');
    }

    public function test_keyword_and_location_filters_combine(): void
    {
        $this->createJob(['title' => 'Laravel Dev Cape', 'location' => 'Cape Town, Western Cape']);
        $this->createJob(['title' => 'Laravel Dev Durban', 'location' => 'Durban, KwaZulu-Natal']);
        $this->createJob(['title' => 'React Dev Cape', 'location' => 'Cape Town, Western Cape']);

        Livewire::test(JobMarketPage::class)
            ->set('keyword', 'Laravel')
            ->set('location', 'Cape Town')
            ->assertOk()
            ->assertSee('Laravel Dev Cape')
            ->assertDontSee('Laravel Dev Durban')
            ->assertDontSee('React Dev Cape');
    }

    public function test_search_resets_the_pagination(): void
    {
        for ($i = 1; $i <= 12; $i++) {
            $this->createJob(['title' => "Standard Role {$i}"]);
        }
        $this->createJob(['title' => 'Unique Last Role']);

        // Page 1 holds the first 12 roles; the unique role sits on page 2.
        Livewire::test(JobMarketPage::class)
            ->call('gotoPage', 2)
            ->assertSet('paginators.page', 2)
            ->assertSee('Unique Last Role')
            ->assertDontSee('Standard Role 1');

        // Changing the keyword should bring us back to page 1.
        Livewire::test(JobMarketPage::class)
            ->call('gotoPage', 2)
            ->set('keyword', 'Role')
            ->assertSet('paginators.page', 1)
            ->assertSee('Standard Role 1')
            ->assertDontSee('Unique Last Role');

        // Changing the location should also bring us back to page 1.
        Livewire::test(JobMarketPage::class)
            ->call('gotoPage', 2)
            ->set('location', 'Cape Town')
            ->assertSet('paginators.page', 1);
    }

    public function test_apply_button_opens_the_external_url_in_a_new_secure_tab(): void
    {
        $this->createJob(['apply_url' => 'https://careers.example.org/jobs/42']);

        $this->get('/jobs')
            ->assertSee('https://careers.example.org/jobs/42', false)
            ->assertSee('target="_blank"', false)
            ->assertSee('rel="noopener noreferrer"', false);
    }

    public function test_jobs_are_paginated_at_twelve_per_page(): void
    {
        for ($i = 1; $i <= 15; $i++) {
            $this->createJob(['title' => "Paginated Role {$i}"]);
        }

        Livewire::test(JobMarketPage::class)
            ->assertOk()
            ->assertSee('Paginated Role 1')
            ->assertSee('Paginated Role 12')
            ->assertDontSee('Paginated Role 13');
    }
}
