<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profit extends Model
{
    protected $guarded = [];
    public function property(){
        return $this->belongsTo(Property::class);
    }

     public function investment(){
        return $this->belongsTo(Investment::class);
    }


     public function user(){
        return $this->belongsTo(User::class);
    }
}
