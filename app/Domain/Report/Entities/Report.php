<?php

namespace App\Domain\Report\Entities;

use App\Models\PaymentLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Domain\Engagement\Entities\Engagement;
use App\Domain\Payment\Entities\Termin;
use App\Domain\Report\Entities\ReportGalleries;
use App\Domain\Report\Entities\Report as SubCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Domain\Report\Entities\Report as ParentCategory;

class Report extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reports';

    public function engagement(){
    	return $this->belongsTo(Engagement::class, 'reservation_id', 'id');
    }

    public function subreport(){
    	return $this->hasMany(SubCategory::class, 'parent_id', 'id');
    }

	public function parent(){
    	return $this->belongsTo(ParentCategory::class, 'parent_id', 'id');
    }

    public function report(){
        return $this->hasOne(Report::class, 'report_id', 'id');
    }

    public function gallery(){
        return $this->hasMany(ReportGalleries::class, 'report_id', 'id');
    }

    public function payment(){
        return $this->hasMany(PaymentLog::class, 'order_id', 'id');
    }

    public function termin(){
        return $this->belongsTo(Termin::class, 'termin', 'id');
    }

    public function termins(){
        return $this->belongsTo(Termin::class, 'termin', 'id');
    }

}
