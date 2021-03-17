<?php

namespace App\Domain\Employee\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Domain\Engagement\Entities\Engagement;


class Vendor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "vendors";

    public function customerEngagement()
    {
    	return $this->hasMany(Engagement::class, 'vendor_id', 'id');
    }

}
