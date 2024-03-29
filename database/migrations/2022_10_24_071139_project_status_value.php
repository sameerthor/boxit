<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProjectStatusValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_status', function (Blueprint $table) {
            $table->id();
            $table->Integer("project_id");
            $table->Integer("status_label_id");
            $table->enum('status', ['0', '1','3']);
            $table->timestamps();
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
}
