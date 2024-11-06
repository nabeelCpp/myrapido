<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'phone', 'region_id', 'vehicle_type_id', 'license_number', 'nic', 'status'];

    public function region() {
        return $this->belongsTo(Region::class);
    }

    public function vehicleDetail() {
        return $this->hasOne(VehicleDetail::class);
    }
}
