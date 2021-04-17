<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;


class SendEngage extends Mailable
{
    use Queueable, SerializesModels;

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
        $pdf = PDF::loadView('export.customer', $this->engagement);

        return $this->subject('Penawaran Harga')
                    ->view('email.engage')
                    ->attachData($pdf->output(), "penawaran.pdf");
    }
}
