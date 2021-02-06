<?php

namespace App\Domain\Engagement\Entities;

use App\Models\Village;
use App\Models\District;
use App\Models\Regency;
use App\Models\Province;
use App\Domain\User\Entities\User;
use App\Domain\Service\Entities\Service;
use App\Domain\Employee\Entities\Employee;
use App\Domain\Report\Entities\Report;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Engagement extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "engagements";

    protected $fillable = ["code", "service_id", "user_id", "name", "email", "village_id", "district_id", "regency_id", "province_id", "phone_number", "description", "date", "time", 'status'];

	public function user(){
    	return $this->belongsTo(Store::class, 'user_id', 'id');
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

    public function service(){
        return $this->belongsToMany(Service::class, 'engagement_has_services')->withTimestamps();
    }

    public function employee(){
        return $this->belongsToMany(Employee::class, 'engagement_has_employees')->withTimestamps();
    }

    public function report(){
        return $this->hasMany(Report::class, 'reservation_id', 'id');
    }
}
