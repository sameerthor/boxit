<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStrippingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripping', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->string('pod_rubbished')->nullable();
            $table->string('boxing_scraped')->nullable();
            $table->string('boxing_tied')->nullable();
            $table->string('trailer_loaded')->nullable();
            $table->string('gate_shut')->nullable();
            $table->string('photos_taken')->nullable();
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
        Schema::dropIfExists('stripping');
    }
}
