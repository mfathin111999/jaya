<?php

namespace App\Domain\Engagement\Entities;

use App\Domain\Engagement\Entities\Engagement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EngagementGalleries extends Model
{
    use HasFactory;

    protected $table = 'engagement_galleries';

    public function engagement(){
    	return $this->belongsTo(Engagement::class, 'reservation_id', 'id');
    }
}
