<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use PDF;
use File;
use Storage;

class SendPaymentNotification extends Mailable
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
        if ($datas['status'] != 'settlement' || $datas['status'] != 'success') {

            $datas = $this->engagement;
            $pdf = PDF::loadView('export.payment', compact('datas'));
          
            $content = $pdf->download()->getOriginalContent();

            $title = 'PS-'.$datas['code'].'-'.$datas['order_id'].date('ymdhis').".pdf";

            Storage::put('public/customer/'.$title, $content);
            return $this->subject('Pembayaran')
                        ->view('email.payment')
                        ->attachData($pdf->output(), $title);

        }else{
            return $this->subject('Pembayaran')->view('email.payment');
        }
    }
}
