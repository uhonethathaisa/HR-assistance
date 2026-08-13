<?php

namespace Tests\Feature;

use App\Http\Livewire\CVOptimizer;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class JobMarketConversionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Create an active job posting with sensible defaults.
     */
    protected function createJob(array $attributes = []): JobPosting
    {
        return JobPosting::create([
            'title' => 'Senior Laravel Developer',
            'company_name' => 'Acme Corp',
            'location' => 'Cape Town, Western Cape',
            'description' => 'We are looking for a Senior Laravel Developer to build scalable applications for our growing team.',
            'apply_url' => 'https://jobs.example.com/apply/123',
            'source' => 'manual',
            'is_active' => true,
            ...$attributes,
        ]);
    }

    public function test_job_cards_include_the_optimize_cv_cta_with_target_job_parameter(): void
    {
        $job = $this->createJob();

        $this->get('/jobs')
            ->assertOk()
            ->assertSee('Optimize CV for this role')
            ->assertSee(route('register', ['target_job' => $job->id]), false);
    }

    public function test_registration_view_captures_the_target_job_parameter(): void
    {
        $job = $this->createJob();

        $this->get(route('register', ['target_job' => $job->id]))
            ->assertOk()
            ->assertSee('name="target_job"', false)
            ->assertSee('value="'.$job->id.'"', false)
            ->assertSee($job->title);
    }

    public function test_registration_with_target_job_redirects_to_cv_optimizer_and_stores_context(): void
    {
        $job = $this->createJob();

        $response = $this->post(route('register'), [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'target_job' => $job->id,
        ]);

        $response->assertRedirect(route('cv-optimizer'));

        $this->assertAuthenticated();

        $this->assertTrue(session()->has('pending_cv_optimization'));
        $this->assertEquals($job->title, session('pending_cv_optimization.title'));
        $this->assertEquals($job->description, session('pending_cv_optimization.description'));
        $this->assertEquals($job->location, session('pending_cv_optimization.location'));
    }

    public function test_registration_without_target_job_keeps_the_standard_approval_flow(): void
    {
        $this->post(route('register'), [
            'name' => 'Standard User',
            'email' => 'standard@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])
            ->assertRedirect(route('login'))
            ->assertSessionHas('status');

        $this->assertGuest();
        $this->assertFalse(session()->has('pending_cv_optimization'));
    }

    public function test_cv_optimizer_preloads_the_pending_job_context(): void
    {
        $job = $this->createJob();
        $user = User::factory()->create(['is_approved' => true]);

        session()->put('pending_cv_optimization', $job->toArray());

        Livewire::actingAs($user)
            ->test(CVOptimizer::class)
            ->assertSet('jobTitle', $job->title)
            ->assertSet('companyName', $job->company_name)
            ->assertSet('jobDescription', $job->description)
            ->assertSet('preloadedJob.title', $job->title);

        $this->assertFalse(session()->has('pending_cv_optimization'));
    }
}
