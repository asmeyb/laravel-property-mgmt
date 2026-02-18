<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CapitalReturn extends Model
{
    protected $guarded = [];
    public function investment()
    {
        return $this->belongsTo(Investment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
