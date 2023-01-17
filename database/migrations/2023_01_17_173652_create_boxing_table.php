<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoxingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boxing', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->string('nail_doneby')->nullable();
            $table->string('nail_supervisor')->nullable();
            $table->string('profiles_doneby')->nullable();
            $table->string('profiles_supervisor')->nullable();
            $table->string('cut_doneby')->nullable();
            $table->string('screwed_doneby1')->nullable();
            $table->string('screwed_doneby2')->nullable();
            $table->string('measure_doneby')->nullable();
            $table->string('measure_supervisor')->nullable();
            $table->string('lines_doneby')->nullable();
            $table->string('lines_supervisor')->nullable();
            $table->string('pinned_doneby')->nullable();
            $table->string('pinned_supervisor')->nullable();
            $table->string('lift_doneby')->nullable();
            $table->string('lift_supervisor')->nullable();
            $table->string('braced_doneby')->nullable();
            $table->string('braced_supervisor')->nullable();
            $table->string('yellow_doneby')->nullable();
            $table->string('kick_supervisor')->nullable();
            $table->string('kick_doneby')->nullable();
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
        Schema::dropIfExists('boxing');
    }
}
