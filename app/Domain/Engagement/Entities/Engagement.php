<?php

namespace App\Domain\Engagement\Entities;

use App\Models\Village;
use App\Models\Regency;
use App\Models\District;
use App\Models\Province;
use App\Domain\User\Entities\User;
use App\Domain\Report\Entities\Report;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Payment\Entities\Termin;
use App\Domain\Employee\Entities\Vendor;
use App\Domain\Service\Entities\Service;
use App\Domain\Employee\Entities\Employee;
use App\Domain\User\Entities\User as Mandor;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Domain\Employee\Entities\Vendor as Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Domain\Engagement\Entities\EngagementGalleries;

class Engagement extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "engagements";

    protected $fillable = ["code", "service_id", "user_id", "name", "email", "village_id", "district_id", "regency_id", "province_id", "address", "phone_number", "description", "date", "time", 'status', 'locked'];

	public function user(){
    	return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function mandor(){
        return $this->belongsTo(Mandor::class, 'mandor_id', 'id');
    }

    public function village(){
        return $this->belongsTo(Village::class, 'village_id', 'id');
    }

    public function district(){
        return $this->belongsTo(District::class, 'district_id', 'id');
    }

    public function regency(){
        return $this->belongsTo(Regency::class, 'regency_id', 'id');
    }

    public function province(){
        return $this->belongsTo(Province::class, 'province_id', 'id');
    }

    public function pvillage(){
        return $this->belongsTo(Village::class, 'pvillage_id', 'id');
    }

    public function pdistrict(){
        return $this->belongsTo(District::class, 'pdistrict_id', 'id');
    }

    public function pregency(){
        return $this->belongsTo(Regency::class, 'pregency_id', 'id');
    }

    public function pprovince(){
        return $this->belongsTo(Province::class, 'pprovince_id', 'id');
    }

    public function service(){
        return $this->belongsToMany(Service::class, 'engagement_has_services')->withTimestamps();
    }

    public function employee(){
        return $this->belongsToMany(User::class, 'engagement_has_employees')->withTimestamps();
    }

    public function report(){
        return $this->hasMany(Report::class, 'reservation_id', 'id');
    }

    public function gallery(){
        return $this->hasMany(EngagementGalleries::class, 'reservation_id', 'id');
    }

    public function customer(){
        return $this->hasOne(Customer::class, 'reservation_id', 'id');
    }

    public function vendor(){
        return $this->belongsTo(User::class, 'vendor_id', 'id');
    }

    public function termin(){
        return $this->hasMany(Termin::class, 'reservation_id', 'id');
    }

    public function partner(){
        return $this->hasOne(Vendor::class, 'user_id', 'id');
    }
}
