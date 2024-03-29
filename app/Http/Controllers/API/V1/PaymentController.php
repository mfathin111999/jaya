<?php

namespace App\Http\Controllers\API\V1;

use Mail;
use App\Mail\PayMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Payment\Entities\Termin;
use App\Domain\Payment\Entities\Payment;
use App\Domain\Report\Entities\Report;
use App\Models\PaymentLog;

use App\Mail\SendPaymentNotification;

class PaymentController extends Controller
{
    public function getPaymentToken($order, $price)
    {
        $this->initPaymentGateway();

        $customerDetails = [
            'first_name' => 'Sdr/i',
            'last_name' => $order->engagement->name,
            'email' => $order->engagement->email,
            'phone' => $order->engagement->phone_number,
        ];

        $params = [
            'transaction_details' => [
                'order_id'      => $order->engagement->code.'-'.$order->id,
                'gross_amount'  => $price,
            ],
            'customer_details'  => $customerDetails,
            'enable_payments'   => \App\Domain\Payment\Entities\Payment::PAYMENT_CHANNELS,
            'expiry' => [
                'start_time'    => date('Y-m-d H:i:s T'),
                'unit'          => \App\Domain\Payment\Entities\Payment::EXPIRY_UNIT,
                'duration'      => \App\Domain\Payment\Entities\Payment::EXPIRY_DURATION,
            ],
        ];

        $snap = \Midtrans\Snap::createTransaction($params);
        
        if ($snap->token) {
            $order->payment_token   = $snap->token;
            $order->payment_url     = $snap->redirect_url;
            $order->save();
        }

        return compact('snap');
    }

    public function notification(Request $request)
    {
        $payload = $request->getContent();
        $notification = json_decode($payload);

        $validSignatureKey = hash("sha512", $notification->order_id . $notification->status_code . $notification->gross_amount . env('MIDTRANS_SERVER_KEY'));

        if ($notification->signature_key != $validSignatureKey) {
            return apiResponseBuilder(403, '', 'Invalid signature');
        }

        $this->initPaymentGateway();
        $statusCode = null;


        $paymentNotification = new \Midtrans\Notification();

        $id_code    = substr($paymentNotification->order_id, 8);
        
        $step       = NULL;
        $order      = Termin::where('id', $id_code)->with(['engagement', 'report' => function($query) {
            $query->whereNull('parent_id');
        }])->firstOrFail();

        foreach($order->report as $items){
            if ($step == NULL) {
                $step = $items->name;
            }else{
                $step = $step.', '.$items->name;
            }
        }

        // if ($order->isPaid()) {
        //     return apiResponseBuilder(422, '', 'The order has been paid before');
        // }

        $transaction    = $paymentNotification->transaction_status;
        $type           = $paymentNotification->payment_type;
        $orderId        = $paymentNotification->order_id;
        $fraud          = $paymentNotification->fraud_status;

        $vaNumber       = null;
        $vendorName     = null;
        if (!empty($paymentNotification->va_numbers[0])) {
            $vaNumber   = $paymentNotification->va_numbers[0]->va_number;
            $vendorName = $paymentNotification->va_numbers[0]->bank;
        }

        $paymentStatus = null;
        if ($transaction == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    // TODO set payment status in merchant's database to 'Challenge by FDS'
                    // TODO merchant should decide whether this transaction is authorized or not in MAP
                    $paymentStatus = Payment::CHALLENGE;
                } else {
                    // TODO set payment status in merchant's database to 'Success'
                    $paymentStatus = Payment::SUCCESS;
                }
            }
        } else if ($transaction == 'settlement') {
            // TODO set payment status in merchant's database to 'Settlement'
            $paymentStatus = Payment::SETTLEMENT;
        } else if ($transaction == 'pending') {
            // TODO set payment status in merchant's database to 'Pending'
            $paymentStatus = Payment::PENDING;
        } else if ($transaction == 'deny') {
            // TODO set payment status in merchant's database to 'Denied'
            $paymentStatus = Payment::DENY;
        } else if ($transaction == 'expire') {
            // TODO set payment status in merchant's database to 'expire'
            $paymentStatus = Payment::EXPIRE;
        } else if ($transaction == 'cancel') {
            // TODO set payment status in merchant's database to 'Denied'
            $paymentStatus = Payment::CANCEL;
        }

        $paymentParams = [
            'order_id'      => $order->id,
            'number'        => $order->engagement->code.'-'.$order->termin.'-'.$paymentStatus.'/KWT/NRU-SR/'.self::numberToRomanRepresentation(date('m')).'/'.date('Y'),
            'amount'        => $paymentNotification->gross_amount,
            'method'        => 'midtrans',
            'status'        => $paymentStatus,
            'token'         => $paymentNotification->transaction_id,
            'payloads'      => $payload,
            'payment_type'  => $paymentNotification->payment_type,
            'va_number'     => $vaNumber,
            'vendor_name'   => $vendorName,
            'biller_code'   => $paymentNotification->biller_code,
            'bill_key'      => $paymentNotification->bill_key,
        ];

        $mailParams = [
            'order_id'      => $order->id,
            'code'          => $order->engagement->code,
            'email'         => $order->engagement->email,
            'number'        => $order->engagement->code.'-'.$order->termin.'-'.$paymentStatus.'/KWT/NRU-SR/'.self::numberToRomanRepresentation(date('m')).'/'.date('Y'),
            'amount'        => $paymentNotification->gross_amount,
            'status'        => $paymentStatus,
            'vendor_name'   => $vendorName,
            'payment_type'  => $paymentNotification->payment_type,
            'customer'      => $order->engagement->name,
            'step'          => $step,
        ];

        $payment = PaymentLog::create($paymentParams);

        if ($paymentStatus && $payment) {
            \DB::transaction(
                function () use ($order, $payment) {
                    if (in_array($payment->status, [Payment::SUCCESS, Payment::SETTLEMENT])) {
                        $order->date_pay = date('Y-m-d H:i:s');
                        $order->status = 'doneCustomer';
                        $order->save();
                    }
                }
            );
        }

        Mail::to($mailParams['email'])
             ->send(new SendPaymentNotification($mailParams));

        $message = 'Payment status is : '. $paymentStatus;

        $response = [
            'code' => 200,
            'message' => $message,
        ];

        return apiResponseBuilder(200, $message);
    }

    public function completed(Request $request)
    {
        // $code = $request->query('order_id');
        // $order = Order::where('code', $code)->firstOrFail();
        
        // if ($order->payment_status == 'unpaid') {
        //     return redirect('payments/failed?order_id='. $code);
        // }

        // \Session::flash('success', "Thank you for completing the payment process!");

        return redirect('/');
    }

    public function unfinish(Request $request)
    {
        $code = $request->query('order_id');
        $order = Order::where('code', $code)->firstOrFail();

        \Session::flash('error', "Sorry, we couldn't process your payment.");

        return redirect('/');
    }

    public function finish(Request $request)
    {
        // $code = $request->query('order_id');
        // $order = Order::where('code', $code)->firstOrFail();

        // \Session::flash('error', "Sorry, we couldn't process your payment.");

        return redirect('/');
    }

    public function failed(Request $request)
    {
        $code = $request->query('order_id');
        $order = Order::where('code', $code)->firstOrFail();

        \Session::flash('error', "Sorry, we couldn't process your payment.");

        return redirect('/');
    }

    public function addCheckout($id)
    {
        $termin = Termin::with(['engagement','report' => function($query){
                                    $query->whereNull('parent_id')
                                          ->with('subreport');
                                }])->where('id', $id)->first();

        $all = 0;
        foreach ($termin->report as $key) {
            foreach ($key->subreport as $value) {
                $all += $value->price_dirt * $value->volume;
            }

        }
        
        $data = $this->getPaymentToken($termin, $all);

        Mail::to($termin->engagement->email)
             ->send(new PayMail($termin, $all));


        return apiResponseBuilder(200, $termin);
    }

    public function getByEngagementId($id)
    {
        $termin = Termin::where('reservation_id', $id)
            ->with(['report' => function ($query) use ($id) {
                $query->whereNull('parent_id')
                  ->where('reservation_id', $id)
                  ->with('subreport', function ($query) {
                    $query->orderBy('id', 'asc');
                  });
                }])
            ->withCount(['report' => function ($query) use ($id){
                $query->where('reservation_id', $id);
            }])->get();

        $price_dirt     = 0;
        $price_clean    = 0;
        $data = [];
        foreach ($termin as $key) {
            $data[] = [
                'id'                => $key->id,
                'reservation_id'    => $key->reservation_id,
                'termin'            => $key->termin,
                'termins'           => $key->report,
                'total_customer'    => self::factory($key->report, 0),
                'total_vendor'      => self::factory($key->report, 1),
                'report_count'      => $key->report_count,
            ];
        }

        return apiResponseBuilder(200, $data);
    }

    public static function factory($items, $type = 0){
        $price = 0;
        if ($type == 0) {
            foreach ($items as $item) {
                foreach ($item->subreport as $value) {
                    $price += $value->price_dirt*$value->volume;
                }
            }
        }elseif ($type == 1) {
            foreach ($items as $item) {
                foreach ($item->subreport as $value) {
                    $price += $value->price_clean*$value->volume;
                }
            }
        }

        return $price;
    }

    public function addPayMultiple(Request $request){
        $data = Termin::whereIn('id', $request->id)->update(['status' => 'donePayed', 'date_invoice' => date('Y-m-d'), 'document' => 'PAY/'.uniqid().'/'.date('m').'/'.date('Y')]);

        return $data;
    }

    public function store(Request $request){
        $reservation = Termin::where('reservation_id', $request->reservation_id)->count();

        $termin = new Termin;

        $termin->termin         = $reservation + 1;
        $termin->reservation_id = $request->reservation_id;
        // $termin->persetase      = $request->persetase;

        $termin->save();

        return apiResponseBuilder(200, $termin);
    }

    public function addToTermin(Request $request){
        $data = Report::where('id', $request->id)->first();

        $data->termin = $request->termin;

        $data->save();

        return apiResponseBuilder(200, 'Updated', 'success');
    }

    public function update($id){
        $termin = Termin::find($id);

        $termin->termin         = $request->termin;
        $termin->reservation_id = $request->reservation_id;
        $termin->total_customer = $request->total_customer;
        $termin->total_vendor   = $request->total_vendor;
        $termin->persetase      = $request->persetase;
        $termin->report_id      = $request->report_id;

        $termin->save();

        return apiResponseBuilder(200, $termin);
    }

    public function view($id){
        $termin = Termin::find($id);

        return apiResponseBuilder(200, $termin);
    }

    public function destroy($id){
        $termin = Termin::find($id);

        $termin->delete();

        return apiResponseBuilder(200, $termin);
    }

    public function numberToRomanRepresentation($number) {
        $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }
}
