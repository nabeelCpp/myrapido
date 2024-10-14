<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegionVehiclesType extends Model
{
    use HasFactory;

    protected $fillable = ['region_id', 'vehicle_type_id'];
}
