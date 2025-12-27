<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('countries', function (Blueprint $table) {
            // Check if column exists first
            if (!Schema::hasColumn('countries', 'flag_emoji')) {
                $table->string('flag_emoji')->nullable()->after('code');
            }
        });
    }

    public function down(): void
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn('flag_emoji');
        });
    }
};