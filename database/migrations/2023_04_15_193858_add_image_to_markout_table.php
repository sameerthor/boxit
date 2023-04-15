<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('markout_checklist', function (Blueprint $table) {
            $table->string('power_image')->nullable();
            $table->string('site_fenced_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('markout_checklist', function (Blueprint $table) {
            //
        });
    }
};
