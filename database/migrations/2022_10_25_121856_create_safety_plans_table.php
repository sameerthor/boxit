<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSafetyPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('safety_plans', function (Blueprint $table) {
            $table->id();
            $table->Integer('project_id');
            $table->String('client')->nullable();
            $table->String('date')->nullable();
            $table->String('time_in')->nullable();
            $table->String('time_out')->nullable();
            $table->enum('safe_access_tick', ['0', '1'])->nullable();
            $table->String('safe_access')->nullable();
            $table->enum('site_board_tick', ['0', '1'])->nullable();
            $table->String('site_board')->nullable();
            $table->enum('ppe_tick', ['0', '1'])->nullable();
            $table->String('ppe')->nullable();
            $table->enum('safety_documentation_tick', ['0', '1'])->nullable();
            $table->String('safety_documentation')->nullable();
            $table->enum('communicate_tick', ['0', '1'])->nullable();
            $table->String('communicate')->nullable();
            $table->enum('work_activity_tick', ['0', '1'])->nullable();
            $table->String('work_activity')->nullable();
            $table->enum('gate_closed_tick', ['0', '1'])->nullable();
            $table->String('gate_closed')->nullable();
            $table->enum('hazard_controlled_tick', ['0', '1'])->nullable();
            $table->String('hazard_controlled')->nullable();
            $table->enum('power_access_tick', ['0', '1'])->nullable();
            $table->String('power_access')->nullable();
            $table->enum('foundation', ['0', '1'])->nullable();
            $table->enum('noise', ['0', '1'])->nullable();
            $table->enum('dust', ['0', '1'])->nullable();
            $table->enum('hit_plant', ['0', '1'])->nullable();
            $table->enum('poor_housekeeping', ['0', '1'])->nullable();
            $table->enum('exposed_steel', ['0', '1'])->nullable();
            $table->enum('loose_material', ['0', '1'])->nullable();
            $table->enum('services', ['0', '1'])->nullable();
            $table->json('induction_date')->nullable();
            $table->json('induction_name')->nullable();
            $table->json('sign')->nullable();
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
        Schema::dropIfExists('safety_plans');
    }
}
