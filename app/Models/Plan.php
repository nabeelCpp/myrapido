<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $fillable = ['title','sub_title', 'description', 'status'];

    public function planPrices() {
        return $this->hasMany(PlanPrice::class);

    }

}
