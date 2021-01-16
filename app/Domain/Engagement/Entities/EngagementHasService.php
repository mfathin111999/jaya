<?php

namespace App\Domain\Engagement\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class EngagementHasService extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "engagement_has_services";

    protected $fillable = ['engagement_id', 'service_id', 'price'];

}
