<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleImage extends Model
{
    use HasFactory;
    protected $fillable = ['vehicle_detail_id', 'image'];

    public function vehicleDetail() {
        return $this->belongsTo(VehicleDetail::class);
    }
}
