<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{ 
    protected $guarded = [];

    public function installments()
    {
        return $this->hasMany(Installment::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function capitalReturn()
    {
        return $this->hasOne(CapitalReturn::class);
    }

    public function profits()
    {
        return $this->hasMany(Profit::class);
    }


}