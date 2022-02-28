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
/*
    public function getPriceAttribute($price){
        //return number_format($price/100, 2, '.');
        return $price/100;
    }
    public function getActionPriceAttribute($action_price){
        //return number_format($action_price/100, 2, '.');
        return $action_price/100;
    }
*/
    public function getImageAttribute($image){
        return $image ? self::$storage.'/'.$image : 'app_images/no_image.jpg';
    }

    public function formatedRegularPrice(){
        return number_format($this->regular_price/100, 2, ',', '.');
    }

    public static function formatedPrice($price){
        return number_format($price, 2, ',', '.');
    }

    public function formatedActionPrice(){
        return number_format($this->action_price/100, 2, ',','.');
    }

}
