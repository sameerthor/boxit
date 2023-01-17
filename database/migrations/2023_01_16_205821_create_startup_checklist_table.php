<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class CreateStartupChecklistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('startup_checklist', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->string('height_floor')->nullable();
            $table->string('bracket_spacing')->nullable();
            $table->string('mesh_size')->nullable();
            $table->string('main_beam')->nullable();
            $table->string('rib_detail')->nullable();
            $table->string('columns')->nullable();
            $table->text('foreman_sign')->nullable();
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
        Schema::dropIfExists('startup_checklist');
    }
}
