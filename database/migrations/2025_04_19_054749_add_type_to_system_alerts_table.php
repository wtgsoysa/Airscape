<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('system_alerts', function (Blueprint $table) {
            // Add the 'type' column after 'message'
            if (!Schema::hasColumn('system_alerts', 'type')) {
                $table->string('type')->default('sensor')->after('message');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('system_alerts', function (Blueprint $table) {
            // Remove the 'type' column if rollback
            if (Schema::hasColumn('system_alerts', 'type')) {
                $table->dropColumn('type');
            }
        });
    }
};
