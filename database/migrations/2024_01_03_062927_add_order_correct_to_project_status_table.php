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
        Schema::table('project_status', function (Blueprint $table) {
            $table->string('order_correct')->nullable();
            \DB::statement("ALTER TABLE `project_status` CHANGE `status` `status` ENUM('0','1','3', '4') CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_status', function (Blueprint $table) {
            //
        });
    }
};
