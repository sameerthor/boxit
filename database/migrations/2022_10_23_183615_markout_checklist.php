<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MarkoutChecklist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('markout_checklist', function (Blueprint $table) {
            $table->id();
            $table->Integer("project_id");
            $table->String("date")->nullable();
            $table->String("address")->nullable();
            $table->String("housing_company")->nullable();
            $table->String("power")->nullable();
            $table->String("site_fenced")->nullable();
            $table->String("toilet")->nullable();
            $table->String("water")->nullable();
            $table->String("boundary_pegs")->nullable();
            $table->String("draw_in")->nullable();
            $table->String("boundary_dimension")->nullable();
            $table->String("ffl_set")->nullable();
            $table->String("ffl_height_min")->nullable();
            $table->String("ffl_height_max")->nullable();
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
        Schema::table('markout_checklist', function (Blueprint $table) {
            //
        });
    }
}
