<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $guarded = [];

    public function investment()
    {
        return $this->belongsTo(Investment::class);
    }

    public function deposit()
    {
        return $this->hasOne(Deposit::class, 'installment_id');
    }
 
}
 