<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ThanksMail extends Mailable
{
    public $engagement;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($engagement)
    {
        $this->engagement   = $engagement;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Reservasi Baru')->view('email.thanks');
    }
}
