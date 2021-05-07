<?php

namespace App\Domain\Payment\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Domain\Engagement\Entities\Engagement;
use App\Domain\Report\Entities\Report;
use App\Models\PaymentLog;


class Termin extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "termins";

    public function engagement(){
    	return $this->belongsTo(Engagement::class, 'reservation_id', 'id');
    }

    public function report(){
    	return $this->hasMany(Report::class, 'termin', 'id');
    }

    public function payment(){
    	return $this->hasMany(PaymentLog::class, 'order_id', 'id');
    }

    public function isPaid()
    {
        return $this->status == 'donePayed';
    }
}
