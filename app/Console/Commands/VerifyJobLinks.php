<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\JobPosting;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class VerifyJobLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs:verify-links';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify the health of active job application URLs and deactivate broken links.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting job link verification...');

        $jobs = JobPosting::where('is_active', true)->get();
        $deactivatedCount = 0;

        foreach ($jobs as $job) {
            try {
                // Using GET as some servers block HEAD requests
                $response = Http::timeout(10)->get($job->apply_url);

                if ($response->status() >= 400) {
                    $job->update(['is_active' => false]);
                    $deactivatedCount++;
                    $this->warn("Deactivated (HTTP {$response->status()}): {$job->apply_url}");
                }
            } catch (ConnectionException $e) {
                // Handle timeouts or completely unreachable hosts
                $job->update(['is_active' => false]);
                $deactivatedCount++;
                $this->warn("Deactivated (Connection Error): {$job->apply_url}");
            }
        }

        $this->info("Verification complete. {$deactivatedCount} dead links deactivated.");
    }
}
