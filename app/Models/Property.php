<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $guarded = [];

    public function galleryImages(){
        return $this->hasMany(PropertyGalleryImage::class, 'property_id');
    }

    public function location(){
        return $this->belongsTo(Location::class, 'location_id');
    }

     public function time(){
        return $this->belongsTo(Time::class, 'time_id');
    }

    public function investments(){
        return $this->hasMany(Investment::class, 'property_id');
    }


}