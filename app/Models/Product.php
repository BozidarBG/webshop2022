<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    public static $storage='products';

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function getImageAttribute($image){
        return $image ? self::$storage.'/'.$image : 'app_images/no_image.jpg';
    }


}
