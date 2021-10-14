<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PayMail extends Mailable
{
    use Queueable, SerializesModels;

    public $price;
    public $report;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($report, $price)
    {
        $this->price    = $price;
        $this->report   = $report;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Pembayaran Pekerjaan')->view('email.payment_confirm');
    }
}
