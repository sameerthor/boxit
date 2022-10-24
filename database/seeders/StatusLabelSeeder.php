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
            ],
            [
                'label'=>'Digout complete',
            ],
            [
                'label'=>'Pods delivered',
            ],
            [
                'label'=>'Steel delivered',
            ],
            [
                'label'=>'Plumber completed',
            ],
            [
                'label'=>'Mark',
            ],
            [
                'label'=>'Ready to inspect',
            ],
            [
                'label'=>'Engineer inspection passed',
            ],
            [
                'label'=>'BLC passed',
            ],	
            [
                'label'=>'Council inspection',
            ],
            [
                'label'=>'Concrete poured',
            ],
            [
                'label'=>'Strip the boxing',
            ]	

        ]);
    }
}
