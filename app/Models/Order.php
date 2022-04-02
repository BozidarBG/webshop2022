<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable=['payment_status', 'paid_on', 'shipping_status', 'shipped_on', 'admin_comment', 'contacted_by'];

    public function items(){
        return $this->hasMany(OrderItem::class);
    }

    public function shipping(){
        return $this->hasOne(Shipping::class);
    }

    public function user(){

        if((int)$this->user_id===0){
            return $this->hasOne(Shipping::class, 'order_id');
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

    public function contactedBy(){
        return $this->belongsTo(User::class, 'contacted_by');
    }


}
