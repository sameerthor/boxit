<?php

namespace Database\Seeders;
use App\Models\ProjectStatusLabel;
use Illuminate\Database\Seeder;

class StatusLabelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProjectStatusLabel::insert([
            [
                'label'=>'Marked out',
                'department_id'=>'',
            ],
            [
                'label'=>'Digout complete',
                'department_id'=>'',

            ],
            [
                'label'=>'Pods delivered',
                'department_id'=>'3',
            ],
            [
                'label'=>'Steel delivered',
                'department_id'=>'4',
            ],
            [
                'label'=>'Plumber completed',
                'department_id'=>'2',
            ],
            [
                'label'=>'Mark',
                'department_id'=>'',

            ],
            [
                'label'=>'Ready to inspect',
                'department_id'=>'',

            ],
            [
                'label'=>'Engineer inspection passed',
                'department_id'=>'6',
            ],
            [
                'label'=>'BLC passed',
                'department_id'=>'5',
            ],	
            [
                'label'=>'Council inspection',
                'department_id'=>'7',
            ],
            [
                'label'=>'Concrete poured',
                'department_id'=>'8',
            ],
            [
                'label'=>'Strip the boxing',
                'department_id'=>'',
            ]	

        ]);
    }
}
