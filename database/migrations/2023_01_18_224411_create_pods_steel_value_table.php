<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePodsSteelValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pods_steel_value', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->integer('pods_steel_label_id');
            $table->string('done_by1')->nullable();
            $table->string('done_by2')->nullable();
            $table->string('checked_by')->nullable();
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
        Schema::dropIfExists('pods_steel_value');
    }
}
