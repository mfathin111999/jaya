<?php

namespace App\Domain\Report\Entities;

use App\Domain\Engagement\Entities\Engagement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportGalleries extends Model
{
    use HasFactory;

    protected $table = 'report_galleries';

    public function engagement(){
    	return $this->belongsTo(Engagement::class, 'reservation_id', 'id');
    }
}
