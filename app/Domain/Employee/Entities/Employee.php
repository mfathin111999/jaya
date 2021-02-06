<?php

namespace App\Domain\Employee\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "employees";

    protected $fillable = ['name', 'address', 'village_id', 'district_id', 'regency_id', 'province_id', 'picture', 'ktp', 'phone_number', 'status'];
    
    public function province(){
        return $this->belongsTo(Province::class);
    }

    public function regency(){
        return $this->belongsTo(Regency::class);
    }

    public function district(){
        return $this->belongsTo(District::class);
    }

    public function village(){
        return $this->belongsTo(Village::class);
    }

    public function engagement(){
        return $this->belongsToMany(Engagement::class, 'engagement_has_employees')->withTimestamps();
    }
}
