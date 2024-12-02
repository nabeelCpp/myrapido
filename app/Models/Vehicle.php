<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = ['driver_id', 'vehicle_type_id', 'vehicle_number', 'make', 'model', 'year'];

    public function driver() {
        return $this->belongsTo(Driver::class);
    }

    public function vehicleImages() {
        return $this->hasMany(VehicleImage::class);
    }
}
