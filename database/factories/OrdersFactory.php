<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\Shipping;
use App\Models\OrderItem;

class OrdersFactory extends Factory
{
    /**
     * Define the model's default state.
     * 800 products, 8-40 users,
     * @return array
     */
    public function definition()
    {
        $subtotal=$this->createOrderItems();
        //$paid_on
        return [
            'user_id'=>rand(8, 40),
            'subtotal'=>$subtotal,
            'subtotal_with_coupon'=>0,
            'shipping_fee'=>0,
            'total'=>$subtotal,
            'payment_type'=>$this->faker->randomElement(['cod', 'card']),
            'payment_status'=>'paid',
            //'paid_on'=>
        ];
    }

    protected function createOrderItems(){
        $items_count=rand(1,10);
        for($i=1; $i<=$items_count; $i++){

        }
    }
}
