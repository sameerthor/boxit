<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BookingData;
use App\Models\Booking;
use App\Mail\BookingMail;
use Mail;

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
        $bookings = Booking::whereHas('BookingData', function ($query) {
            $query->whereDate('date', '=', \Carbon\Carbon::today())->whereIn('department_id', [5, 6, 7]);
        })->get();
        $email_body = 'Hi, this is a reminder that the following bookings need to be followed today ie ' . date('d/m/Y');
        foreach ($bookings as $booking) {
            $email_body .= "<br><br>";
            $email_body .= $booking->address."<br>";
            $booking_datas = BookingData::where('booking_id', $booking->id)->whereDate('date', '=', \Carbon\Carbon::today())->whereIn('department_id', [5, 6, 7])->get();
            foreach($booking_datas as $booking_data)
            {
                $email_body .=  $booking_data->department->title . ($booking_data->service != '' ? ' (' . $booking_data->service . ')' : '').' - '.$booking_data->contact->title."<br>";
            }
        }
        $email_body .= '<br>Thank You,<br><br><img src="https://boxit.staging.app/img/logo2581-1.png" style="width:75px;height:30px" class="mail-logo" alt="Boxit Logo">';

        $details['subject'] = 'Booking Reminder';
        $details['body'] = $email_body;
       //$details['to'] = \config('const.admin1');
         $details['to'] = "sameer@thor.solutions";

        $this->info("mailsent");
        Mail::to($details['to'])
            ->send(new BookingMail($details));
    }
}
