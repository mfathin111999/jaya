<?php

namespace App\Domain\Report\Entities;

use App\Domain\Engagement\Entities\Engagement;
use App\Domain\Report\Entities\Report as ParentCategory;
use App\Domain\Report\Entities\Report as SubCategory;
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

    public function subreport(){
    	return $this->hasMany(SubCategory::class, 'parent_id', 'id');
    }

	public function parent(){
    	return $this->belongsTo(ParentCategory::class, 'parent_id', 'id');
    }

    public function report(){
        return $this->hasOne(Report::class, 'report_id', 'id');
    }

}
