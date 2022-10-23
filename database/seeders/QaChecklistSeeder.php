<?php

namespace Database\Seeders;
use App\Models\QaChecklist;

use Illuminate\Database\Seeder;

class QaChecklistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        QaChecklist::insert([
        [
            'subject'=>'Date:',
        ],
        [
            'subject'=>'Address:',
        ],
        [
            'subject'=>'Housing Company:',
        ],
        [
            'subject'=>'SSSP Prestart Filled Out and Sent',
        ],
        [
            'subject'=>'Everyone in Team Uniform',
        ],
        [
            'subject'=>'Plans Onsite
            ',
        ],
        [
            'subject'=>'Boards Back Cut
            ',
        ],
        [
            'subject'=>'Location to Boundary Pegs or Offset Pegs
            ',
        ],
        [
            'subject'=>'Mesh Correct Size and Covers

            ',
        ],
        [
            'subject'=>'Profiles Taken Down

            ',
        ],
        [
            'subject'=>'Thickenings Correct Location

            ',
        ],
        [
            'subject'=>'All Gear Back on Trailer
            ',
        ],
        [
            'subject'=>'Shower Rebates Installed in Correct Position
            ',
        ],
        [
            'subject'=>'Site Tidy with Pump Access
            ',
        ],
        [
            'subject'=>'Power and Water Entry Pipes In and Correct Position
            ',
        ],
        [
            'subject'=>'Garage Door Rebates - Cover to Mesh
            ',
        ],
        [
            'subject'=>'Garage Door Rebates - Correct Size
            ',
        ],
        [
            'subject'=>'Garage Door Rebates - Correct Position

            ',
        ],
        [
            'subject'=>'Door Rebates

            ',
        ],
        [
            'subject'=>'Control Joints in Place and Marked for Cutting
            ',
        ],
        [
            'subject'=>'Weld Plates or Portal Bolts
            ',
        ],
        [
            'subject'=>'Pod Bags Tied Off and Secure
            ',
        ],
        [
            'subject'=>'Pod Offcuts & Pod Rubbish Bag Collected - Text Hayden If NOT
            ',
        ],
        [
            'subject'=>'Stand Back -
            Does the work we have produced look of a Professional Standard            
            ',
        ],
        [
            'subject'=>'Nails Removed from Boxing',
        ],
         ]);
    }
}
