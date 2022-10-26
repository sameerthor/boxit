<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDraftDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('draft_data', function (Blueprint $table) {
            $table->id();
            $table->integer('department_id')->nullable();
            $table->integer('contact_id')->nullable();
            $table->string('date')->nullable();
            $table->integer('draft_id');
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
        Schema::dropIfExists('draft_data');
    }
}
