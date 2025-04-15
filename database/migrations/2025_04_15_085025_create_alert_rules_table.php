<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('alert_rules', function (Blueprint $table) {
            $table->id();
            $table->string('pollutant_type');
            $table->integer('threshold');
            $table->string('frequency');
            $table->boolean('email_alert')->default(false);
            $table->boolean('system_alert')->default(false);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alert_rules');
    }
};
