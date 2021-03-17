<?php

namespace App\Domain\Engagement\Entities;

use App\Domain\Engagement\Entities\Engagement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EngagementHasVendor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "engagement_has_vendor";

    protected $fillable = ['engagement_id', 'service_id', 'price'];

    public function service(){
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function engagement(){
        return $this->belongsTo(Engagement::class, 'engagement_id', 'id');
    }
}
