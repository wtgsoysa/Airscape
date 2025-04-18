<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('system_alerts', function (Blueprint $table) {
            $table->string('message')->after('id');
        });
    }

    public function down()
    {
        Schema::table('system_alerts', function (Blueprint $table) {
            $table->dropColumn('message');
        });
    }

};
