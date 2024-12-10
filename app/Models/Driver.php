<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'gender', 'phone','nic', 'profile_picture', 'license_number', 'region_id', 'is_deleted', 'status'];

    public function region() {
        return $this->belongsTo(Region::class);
    }

    public function vehicle() {
        return $this->hasOne(Vehicle::class);
    }
}
