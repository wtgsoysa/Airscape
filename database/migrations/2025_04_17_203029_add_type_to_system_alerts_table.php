<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // database/migrations/xxxx_add_type_to_system_alerts_table.php
    public function up()
    {
        Schema::table('system_alerts', function (Blueprint $table) {
            $table->string('type')->default('rule'); // 'rule' or 'sensor'
        });
    }

    public function down()
    {
        Schema::table('system_alerts', function (Blueprint $table) {
            $table->dropColumn('type');
        });
}

};
