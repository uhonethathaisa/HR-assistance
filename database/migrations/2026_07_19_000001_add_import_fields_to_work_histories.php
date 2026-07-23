<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('work_histories', function (Blueprint $table) {
            $table->string('import_source')->nullable()->after('achievements');
            $table->string('import_method')->nullable()->after('import_source');
            $table->json('import_metadata')->nullable()->after('import_method');
        });
    }

    public function down(): void
    {
        Schema::table('work_histories', function (Blueprint $table) {
            $table->dropColumn(['import_source', 'import_method', 'import_metadata']);
        });
    }
};
