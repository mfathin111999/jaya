<?php

namespace App\Domain\Engagement\Entities;

use App\Domain\Engagement\Entities\Engagement;
use App\Domain\Employee\Entities\Employee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EngagementHasEmployee extends Model
{
    use HasFactory;

    protected $table = "engagement_has_services";

    protected $fillable = ['engagement_id', 'employee_id', 'created_at', 'updated_id'];

    public function service(){
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function employee(){
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
