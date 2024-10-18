<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanPrice extends Model
{
    use HasFactory;

    protected $fillable = ['plan_id', 'duration_id', 'vehicle_type_id', 'price_pkr', 'price_sar'];

    public function plan()  {
        return $this->belongsTo(Plan::class);
    }
}
