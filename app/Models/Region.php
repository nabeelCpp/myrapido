<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = ['name', 'city_id', 'admin_id', 'currency_id', 'address', 'phone', 'status'];
    use HasFactory;

    public function admin()  {
        return $this->belongsTo(Admin::class);
    }

    public function city()  {
        return $this->belongsTo(City::class);
    }

    public function vehicleTypes() {
        return $this->hasMany(RegionVehiclesType::class);
    }
}
