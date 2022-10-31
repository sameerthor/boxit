<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BookingData;
use App\Models\Contact;
use App\Jobs\BookingEmailJob;

class BuildingCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'building:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $booking_data = BookingData::where(array('status' => 0, 'department_id' => 1))->get();
        foreach ($booking_data as $res) {
            $result = BookingData::whereIn('department_id', array(2, 5, 6, 8))->where(array('status' => 1, 'booking_id' => $res->booking_id))->get();
            if (count($result) == 4) {
                $html="<p>The following department are confirmed for ".$res->booking->address." :<p>";
                foreach($result as $con)
                {
                  $html.="<p>".$con->department->title.": ".$con->contact->title."<br>";
                  $html.="Date: ".$con->date."</p>";
                }
                $html.='Thanks,<br>
                Jules,<br>
                BOXIT Sales<br>
                <a href="mailto:admin@boxitfoundations.co.nz">admin@boxitfoundations.co.nz</a>
                <br>
                <a href="https://boxitfoundations.co.nz
        ">https://boxitfoundations.co.nz</a><br>';
                $contact = Contact::find($res->contact_id);
                $details['to'] = $contact->email;
                $details['name'] = $contact->title;
                $details['url'] = 'testing';
                $details['subject'] = 'Booking Confirmation';
                $details['body'] = $html;
                dispatch(new BookingEmailJob($details));
                BookingData::where("id", $res->id)->update(array('status'=>1));
        
            }
        }
        }
}
