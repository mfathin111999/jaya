<?php

namespace App\Domain\Report\Entities;

use App\Domain\Engagement\Entities\Report;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportGalleries extends Model
{
    use HasFactory;

    protected $table = 'report_galleries';

    public function report(){
    	return $this->belongsTo(Report::class, 'report_id', 'id');
    }
}
