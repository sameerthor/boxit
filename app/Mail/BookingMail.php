<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingMail extends Mailable
{
    use Queueable, SerializesModels;
    public $details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details=$details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        if(isset($this->details['address']))
        {
        $this->subject($this->details['address']);
        }else{
            $this->subject('Boxit Foundations Booking Request');
        }
        $this->markdown('emails.bookingMail',$this->details);
        if(isset($this->details['files']))
        {
        foreach($this->details['files'] as $file) {
            $this->attach($file);
        }
        }    
        return $this;

    }
}
