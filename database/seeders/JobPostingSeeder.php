<?php

namespace Database\Seeders;

use App\Models\JobPosting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobPostingSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobs = [
            [
                'title' => 'Senior Software Engineer',
                'company_name' => 'Lulalend',
                'location' => 'Cape Town, Western Cape',
                'description' => 'We are looking for a Senior Software Engineer to join our growing fintech team in Cape Town. You will be responsible for building scalable microservices, leading technical design discussions, and mentoring junior developers. Experience with PHP, Laravel, and AWS is essential.',
                'apply_url' => 'https://www.linkedin.com/jobs/view/senior-software-engineer-lulalend-cape-town',
                'source' => 'manual',
                'is_active' => true,
            ],
            [
                'title' => 'Project Manager',
                'company_name' => 'Standard Bank Group',
                'location' => 'Johannesburg, Gauteng',
                'description' => 'Standard Bank is seeking an experienced Project Manager to lead cross-functional teams delivering digital banking initiatives. You will manage project scope, budgets, and timelines while ensuring alignment with business objectives. PMP or Prince2 certification is required.',
                'apply_url' => 'https://www.careers.standardbank.co.za/jobs/project-manager-johannesburg',
                'source' => 'manual',
                'is_active' => true,
            ],
            [
                'title' => 'QA Automation Tester',
                'company_name' => 'Discovery Limited',
                'location' => 'Sandton, Gauteng',
                'description' => 'Join Discovery\'s quality engineering team as a QA Automation Tester. You will design, develop, and maintain automated test frameworks for our health insurance applications. Strong knowledge of Selenium, Cypress, and CI/CD pipelines is required.',
                'apply_url' => 'https://www.linkedin.com/jobs/view/qa-automation-tester-discovery-sandton',
                'source' => 'manual',
                'is_active' => true,
            ],
            [
                'title' => 'Full Stack Developer (Remote)',
                'company_name' => 'OfferZen',
                'location' => 'Remote (South Africa)',
                'description' => 'OfferZen is looking for a Full Stack Developer to work remotely from anywhere in South Africa. You will build and maintain features for our developer marketplace platform using React, TypeScript, and Node.js. A passion for clean code and user experience is a must.',
                'apply_url' => 'https://offerzen.com/careers/full-stack-developer-remote',
                'source' => 'manual',
                'is_active' => true,
            ],
            [
                'title' => 'Data Analyst',
                'company_name' => 'Naspers / Prosus',
                'location' => 'Durban, KwaZulu-Natal',
                'description' => 'We are hiring a Data Analyst to join our analytics team in Durban. You will work with large datasets to derive actionable insights, build dashboards, and support data-driven decision-making across the organisation. Proficiency in SQL, Python, and Power BI is required.',
                'apply_url' => 'https://www.linkedin.com/jobs/view/data-analyst-naspers-durban',
                'source' => 'manual',
                'is_active' => true,
            ],
        ];

        foreach ($jobs as $job) {
            JobPosting::create($job);
        }
    }
}
