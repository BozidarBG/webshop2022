<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    public function getValueAttribute($value){
        if($this->type==="fixed"){
            return $value/100;
        }else{
            return $value;
        }
    }

    public function getCartValueAttribute($value){
        return $value/100;
    }
}
