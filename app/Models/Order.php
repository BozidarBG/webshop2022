<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function items(){
        return $this->hasMany(OrderItem::class);
    }

    public function shipping(){
        return $this->hasOne(Shipping::class);
    }

    public function user(){
        if($this->user_id==0){
            return $this->belongsTo(Shipping::class);
        }else{
            return $this->belongsTo(User::class);
        }
    }

    public function getCouponValue(){
        if($this->coupon_value){
            $obj=json_decode($this->coupon_value);
            return "type: $obj->type, value: $obj->value, cart value: $obj->cart_value";
        }else{
            return 0;
        }

    }


}
