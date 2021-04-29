<?php

namespace App\Http\Controllers\API\V1;

use Mail;
use App\Mail\PayMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Payment\Entities\Termin;
use App\Domain\Payment\Entities\Payment;
use App\Domain\Report\Entities\Report;

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
                'order_id'      => $order->id,
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
            return response(['message' => 'Invalid signature'], 403);
        }

        $this->initPaymentGateway();
        $statusCode = null;

        $paymentNotification = new \Midtrans\Notification();
        $order = Report::where('id', $paymentNotification->order_id)->firstOrFail();

        if ($order->isPaid()) {
            return response(['message' => 'The order has been paid before'], 422);
        }

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
            'order_id' => $order->id,
            'number' => 'PAY-YYYY-MMM',
            'amount' => $paymentNotification->gross_amount,
            'method' => 'midtrans',
            'status' => $paymentStatus,
            'token' => $paymentNotification->transaction_id,
            'payloads' => $payload,
            'payment_type' => $paymentNotification->payment_type,
            'va_number' => $vaNumber,
            'vendor_name' => $vendorName,
            'biller_code' => $paymentNotification->biller_code,
            'bill_key' => $paymentNotification->bill_key,
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

        $message = 'Payment status is : '. $paymentStatus;

        $response = [
            'code' => 200,
            'message' => $message,
        ];

        return response($response, 200);
    }

    // public function completed(Request $request)
    // {
    //     $code = $request->query('order_id');
    //     $order = Order::where('code', $code)->firstOrFail();
        
    //     if ($order->payment_status == 'unpaid') {
    //         return redirect('payments/failed?order_id='. $code);
    //     }

    //     \Session::flash('success', "Thank you for completing the payment process!");

    //     return redirect('orders/received/'. $order->id);
    // }

    // /**
    //  * Show unfinish payment page
    //  *
    //  * @param Request $request payment data
    //  *
    //  * @return void
    //  */
    // public function unfinish(Request $request)
    // {
    //     $code = $request->query('order_id');
    //     $order = Order::where('code', $code)->firstOrFail();

    //     \Session::flash('error', "Sorry, we couldn't process your payment.");

    //     return redirect('orders/received/'. $order->id);
    // }

    // /**
    //  * Show failed payment page
    //  *
    //  * @param Request $request payment data
    //  *
    //  * @return void
    //  */
    // public function failed(Request $request)
    // {
    //     $code = $request->query('order_id');
    //     $order = Order::where('code', $code)->firstOrFail();

    //     \Session::flash('error', "Sorry, we couldn't process your payment.");

    //     return redirect('orders/received/'. $order->id);
    // }

    public function addCheckout($id)
    {
        $report = Report::with(['engagement', 'subreport' => function($query){
                                    $query->orderBy('id', 'desc');
                                }])->where('id', $id)->first();

        $all = 0;
        foreach ($report->subreport as $key) {
            $all += $key->price_dirt;

        }
        
        $data = $this->getPaymentToken($report, $all);

        Mail::to($report->engagement->email)
             ->send(new PayMail($report, $all));


        return apiResponseBuilder(200, $report);
    }

    public function getByEngagementId($id)
    {
        $termin = Termin::with(['report' => function($query){
                                $query->whereNull('parent_id')->with(['subreport' => function($query){
                                    $query->orderBy('id', 'desc');
                                }]);
                            }])->where('reservation_id', $id)->get();
        $termins = [];
        foreach ($termin as $key) {
            $key[] = [
                'termin'            => $key->termin,
                'persetase'         => $key->persetase,
                'total_customer'    => $key->total_customer,
                'total_vendor'      => $key->total_vendor,
            ];
        }

        return apiResponseBuilder(200, $termin);
    }

    public function store(Request $request){
        $termin = new Termin;

        $termin->termin         = $request->termin;
        $termin->reservation_id = $request->reservation_id;
        $termin->total_customer = $request->total_customer;
        $termin->total_vendor   = $request->total_vendor;
        $termin->persetase      = $request->persetase;
        $termin->report_id      = $request->report_id;

        $termin->save();

        return apiResponseBuilder(200, $termin);
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
}
