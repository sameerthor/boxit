<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProjectQaChecklist extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_qa_checklist', function (Blueprint $table) {
            $table->id();
            $table->Integer("project_id");
            $table->Integer("qa_checklist_id");
            $table->text("initial")->nullable();;
            $table->text("office_use")->nullable();;
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
        Schema::table('project_qa_checklist', function (Blueprint $table) {
            //
        });
    }
}
