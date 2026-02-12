<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function property(){
        return $this->belongsTo(Property::class, 'property_id');
    }

     public function time(){
        return $this->belongsTo(Time::class, 'time_id');
    }

    public function installments(){
        return $this->hasMany(Installment::class, 'investment_id');
    }

}
