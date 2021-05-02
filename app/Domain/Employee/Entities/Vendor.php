<?php

namespace App\Domain\Employee\Entities;

use App\Models\Village;
use App\Models\District;
use App\Models\Regency;
use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Domain\Engagement\Entities\Engagement;


class Vendor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "vendors";
    protected $fillable = ['tax_id', 'user_id', 'ktp', 'owner', 'bank_name', 'bank_account_name', 'bank_account_number', 'vendor', 'customer', 'search_key'];

    public function customerEngage()
    {
    	return $this->hasMany(Engagement::class, 'partner_id', 'id');
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

}
