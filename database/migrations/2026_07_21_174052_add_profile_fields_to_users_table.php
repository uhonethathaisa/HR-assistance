<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 30)->nullable()->after('email');
            $table->string('job_title', 255)->nullable()->after('phone');
            $table->string('company', 255)->nullable()->after('job_title');
            $table->string('location', 255)->nullable()->after('company');
            $table->text('bio')->nullable()->after('location');
            $table->string('timezone', 100)->nullable()->after('bio');
            $table->string('locale', 10)->default('en')->after('timezone');
            $table->json('preferences')->nullable()->after('locale');
            $table->timestamp('last_active_at')->nullable()->after('preferences');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone', 'job_title', 'company', 'location', 'bio',
                'timezone', 'locale', 'preferences', 'last_active_at'
            ]);
        });
    }
};
