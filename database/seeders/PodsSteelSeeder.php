<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PodsSteel;
class PodsSteelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PodsSteel::insert([
         ['label'=>'Polythene Laid and Taped - Minimum 150mm Lap'],
         ['label'=>'Polythene Cut So Max 70mm Up Boxing'],
         ['label'=>'Polythene Cut off Steel'],
         ['label'=>'Pods Laid and Cut As Per Layout – Mark off on pod plan'],
         ['label'=>'All Pod Spacers In and All Checked'],
         ['label'=>'Perimeter Steel Cut and Laid Including Top Steel (Cover)'],
         ['label'=>'Corners'],
         ['label'=>'Thickening Steel Cut and Laid (Cover)'],
         ['label'=>'Pod Bars Laid To Ensure Concrete Cover'],
         ['label'=>'Brick Rebate On and Heights Checked'],
         ['label'=>'Plumbers Pipes Lagged and Cover to Our Reinforcing'],
         ['label'=>'Mesh Correct Size and Laid with Laps As Per Plan'],
         ['label'=>'Mesh Chaired Top Cover and Cover To Pods Checked'],
         ['label'=>'Crack Bars and Pipe Bas Installed'],
         ['label'=>'Garage/Door Rebate Installed (Position Marked On Plan)'],
         ['label'=>'Site Tidied'],
         ['label'=>'Leftover Materials'],
         ['label'=>'Mesh'],
         ['label'=>'Stirrups'],
         ['label'=>'Heights Checked and Marked On Plan over Page'],
         ['label'=>'Datum Right Side Garage'],
         ['label'=>'Diagonals and Dimensions Marked On Plan'], 
         ['label'=>'Control Joints Marked on Boxing'],
         ['label'=>'Sand Kicked'], 
         ['label'=>'Open spacers in back of Ute/Van']   
        ]);
    }
}
