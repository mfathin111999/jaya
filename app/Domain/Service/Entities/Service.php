<?php

namespace App\Domain\Service\Entities;

use App\Domain\Engagement\Entities\Engagement;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "services";

    protected $fillable = ['name', 'description'];

    public function engagement(){
        return $this->belongsToMany(Engagement::class, 'engagement_has_services')->withTimestamps();
    }

}
