<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cv_optimizations', function (Blueprint $table) {
            $table->text('job_description')->nullable()->after('original_path');
            $table->longText('optimized_content')->nullable()->after('job_description');
            $table->json('ats_breakdown')->nullable()->after('ats_score');
            $table->json('matched_keywords')->nullable()->after('keyword_density');
            $table->json('missing_keywords')->nullable()->after('matched_keywords');
            $table->json('optimized_experiences')->nullable()->after('missing_keywords');
            $table->json('optimized_skills')->nullable()->after('optimized_experiences');
            $table->text('professional_summary')->nullable()->after('optimized_skills');
            $table->string('target_job_title')->nullable()->after('professional_summary');
            $table->string('target_company')->nullable()->after('target_job_title');
        });
    }

    public function down(): void
    {
        Schema::table('cv_optimizations', function (Blueprint $table) {
            $table->dropColumn([
                'job_description',
                'optimized_content',
                'ats_breakdown',
                'matched_keywords',
                'missing_keywords',
                'optimized_experiences',
                'optimized_skills',
                'professional_summary',
                'target_job_title',
                'target_company',
            ]);
        });
    }
};
