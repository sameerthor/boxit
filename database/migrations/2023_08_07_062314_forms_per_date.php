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

        Schema::create('forms_per_date', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->string('date');
            $table->integer('creator_id');
            $table->integer('submission_id')->nullable();
            $table->enum('form_type', ['1', '2', '3'])->comment('1=onsite,2=safety,3=accident');
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
        //
    }
};
