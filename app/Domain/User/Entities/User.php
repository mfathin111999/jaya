<?php

namespace App\Domain\User\Entities;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Domain\Engagement\Entities\Engagement;
use App\Domain\Engagement\Entities\Engagement as Mandor;
use Laravel\Passport\HasApiTokens;

use App\Domain\Employee\Entities\Vendor;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function partner(){
        return $this->hasOne(Vendor::class, 'user_id', 'id');
    }

    public function engage(){
        return $this->hasMany(Engagement::class, 'mandor_id', 'id');
    }

    public function engageCustomer(){
        return $this->hasMany(Engagement::class, 'user_id', 'id');
    }

    public function vendorEngage(){
        return $this->hasMany(Engagement::class, 'vendor_id', 'id');
    }

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
