<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id')->nullable();
            $table->string('date')->nullable();
            $table->text('attendees')->nullable();
            $table->text('site_inspection')->nullable();
            $table->text('upcoming_work')->nullable();
            $table->text('incidents')->nullable();
            $table->text('equipment_issues')->nullable();
            $table->text('employee_issues')->nullable();
            $table->text('safe_reviewed')->nullable();
            $table->text('task_reviewed')->nullable();
            $table->string('date_accident')->nullable();
            $table->string('time')->nullable();
            $table->string('location')->nullable();
            $table->string('date_reported')->nullable();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('age')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('bruiding_checkbox')->nullable();
            $table->string('disclotion_checkbox')->nullable();
            $table->string('other_checkbox')->nullable();
            $table->text('injured_part')->nullable();
            $table->string('strain_checkbox')->nullable();
            $table->string('scratch_checkbox')->nullable();
            $table->string('internal_checkbox')->nullable();
            $table->string('fracture_checkbox')->nullable();
            $table->string('amputation_checkbox')->nullable();
            $table->string('foreign_checkbox')->nullable();
            $table->text('remarks')->nullable();
            $table->string('cut_checkbox')->nullable();
            $table->string('burn_checkbox')->nullable();
            $table->string('chemical_checkbox')->nullable();
            $table->text('property_damaged')->nullable();
            $table->text('desciption')->nullable();
            $table->text('analysis')->nullable();
            $table->string('bad_radio')->nullable();
            $table->string('chance_radio')->nullable();
            $table->text('action_1')->nullable();
            $table->string('whom_1')->nullable();
            $table->string('when_1')->nullable();
            $table->text('action_2')->nullable();
            $table->string('whom_2')->nullable();
            $table->string('when_2')->nullable();
            $table->text('action_3')->nullable();
            $table->string('whom_3')->nullable();
            $table->string('when_3')->nullable();
            $table->text('action_4')->nullable();
            $table->string('whom_4')->nullable();
            $table->string('when_4')->nullable();
            $table->text('action_5')->nullable();
            $table->string('whom_5')->nullable();
            $table->string('when_5')->nullable();
            $table->string('treatment_type')->nullable();
            $table->string('person_name')->nullable();
            $table->string('doctor')->nullable();
            $table->string('investigated_by')->nullable();
            $table->string('worksafe')->nullable();
            $table->string('treatment_date')->nullable();
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
        Schema::dropIfExists('incidents');
    }
}
