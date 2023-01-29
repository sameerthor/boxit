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
                    $b_date=   date("d-m-Y h:i A",strtotime($con->date));  
                  $html.="<p>".$con->department->title.": ".$con->contact->title."<br>";
                  $html.="Date: ".$b_date."</p>";
                }
                $html.='Thank You,<br>
                Jules<br><br>
                <img src="https://boxit.staging.app/img/logo2581-1.png" style="width:75px;height:30px" class="mail-logo" alt="Boxit Logo">

                ';
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
