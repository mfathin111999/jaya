<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    use HasFactory;

    protected $table = 'payment_log';

    protected $fillable = ['order_id', 'number', 'amount', 'method', 'status', 'token', 'payloads', 'payment_type', 'va_number', 'vendor_name', 'biller_code', 'bill_key'];
}
