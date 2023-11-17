<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BookingData;
use App\Jobs\BookingEmailJob;


class EmailReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily reminder email to admin for yesterday bookings';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $bookings=BookingData::whereDate('date', '=', \Carbon\Carbon::yesterday())->whereIn('department_id',[5,6,7])->get();
        foreach($bookings as $booking_data) {
            $details = [];
            $booking_id=$booking_data->booking_id;
            $department = $booking_data->department->title . ($booking_data->service != '' ? ' (' . $booking_data->service . ')' : '');
            $email_body = "Hi,<br>";
            $email_body .= "This is a reminder to check if we have the report for <b>$department</b> at <b>" . $booking_data->booking->address . "</b>.";
            $email_body .= '<br><p style="display:none">Project ID #' . $booking_id . '</p>Thank You,<br><br><img src="https://boxit.staging.app/img/logo2581-1.png" style="width:75px;height:30px" class="mail-logo" alt="Boxit Logo">';
     //       $details['to'] = \config('const.admin1');
                $details['to'] = "sameer@thor.solutions";

            $details['address'] = $booking_data->booking->address;
            $details['subject'] = 'Booking Cancelled';
            $details['body'] = $email_body;

            dispatch(new BookingEmailJob($details));

        }
    }
}
