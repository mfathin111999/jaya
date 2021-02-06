<?php

namespace App\Domain\Report\Entities;

use App\Domain\Engagement\Entities\Engagement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reports';

    public function engagement(){
    	return $this->belongsTo(Engagement::class, 'reservation_id', 'id');
    }
}
