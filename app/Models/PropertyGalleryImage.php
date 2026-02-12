<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyGalleryImage extends Model
{
    protected $guarded = [];

    public function galleryImages(){
        return $this->hasMany(PropertyGalleryImage::class, 'property_id');
    }

    public function property(){
        return $this->belongsTo(Property::class, 'property_id');
    }


}