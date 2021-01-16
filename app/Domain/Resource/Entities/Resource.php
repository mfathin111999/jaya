<?php

namespace App\Domain\Resource\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resource extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "resources";

    protected $fillable = ['name', 'type', 'type_service', 'description', 'price', 'width', 'length', 'height', 'unit', 'color', 'material'];

}
