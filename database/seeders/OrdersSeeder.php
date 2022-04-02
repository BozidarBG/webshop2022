<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;



class OrdersSeeder extends Seeder
{
    protected $faker;
    /**
     * Run the database seeds.
     * from jan 2021 to mart 2022, foreach month, create 120-200 orders, every order has from 1-10 articles
     * 800 products, 8-40 users ids
     * @return void
     */

    public function __construct()
    {
        $this->faker = Faker::create();
    }

    public function run()
    {

        $period=CarbonPeriod::create('2021-01-01', '2022-04-02');
        $order_id=1;
        foreach ($period as $date){
            $minutes=345;
            $no_of_orders_for_this_date=rand(2,12);
            for($o=1; $o<=$no_of_orders_for_this_date; $o++){
                //info((new Carbon($date))->addMinutes($minutes));
                $date_time=(new Carbon($date))->addMinutes($minutes);

                $this->createOrder($date_time, $order_id);
                $minutes +=45;
                $order_id +=1;
            }
        }
    }

    protected function createOrder($date_time, $order_id){
        $subtotal=$this->createOrderItems($order_id, $date_time);
        $payment_type=$this->faker->randomElement(['cod', 'card']);
        $order=new Order();
        $order->user_id=rand(8, 40);
        $order->subtotal=$subtotal;
        $order->subtotal_with_coupon=0;
        $order->shipping_fee=0;
        $order->total=$subtotal;
        $order->payment_type=$payment_type;
        $order->payment_status='paid';
        $order->paid_on=$payment_type=="cod" ? (new Carbon($date_time))->addDays(3) : $date_time;
        $order->shipped_on=(new Carbon($date_time))->addDays(1);
        $order->shipping_status='in_transit';
        $order->contacted_by=rand(1,7);
        $order->created_at=$date_time;
        $order->updated_at=$date_time;
        $order->save();
        $user=User::find($order->user_id);
        $this->createShippingRow($order_id, $date_time, $user);
    }

    protected function createOrderItems($order_id, $created_at){
        $items_count=rand(1,6);//how many products are per order
        $product_ids=$this->getRandomNumbers($items_count, 800);
        //info(json_encode($product_ids));
        $total=0;
        for($i=1; $i<=count($product_ids); $i++){
            $item=new OrderItem();
            $item->order_id=$order_id;
            $item->product_id=$product_ids[$i-1];
            $product=Product::find($product_ids[$i-1]);
            $item->acc_code=$product->acc_code;
            $item->selling_price=$product->action_price>0 ? $product->action_price : $product->regular_price;
            $item->name=$product->name;
            $item->qty=rand(1, 5);
            $item->created_at=$created_at;
            $item->updated_at=$created_at;
            $item->save();
            $total +=$item->selling_price * $item->qty;
        }
        return $total;
    }

    protected function createShippingRow($order_id, $created_at, $user){
        $shipping=new Shipping();
        $shipping->order_id=$order_id;
        $shipping->name=$user->name;
        $shipping->address=$this->faker->address;
        $shipping->city=$this->faker->city;
        $shipping->zip=$this->faker->randomNumber(7, true);
        $shipping->email=$user->email;
        $shipping->phone1=$this->faker->phoneNumber;
        $shipping->contact_person=$user->name;
        $shipping->created_at=$created_at;
        $shipping->updated_at=$created_at;
        $shipping->save();
    }


    //numbers_count = we need this many random numbers //5 800 [5,55, 45,88, 1, 256]
    protected function getRandomNumbers($numbers_count, $max){
        $arr=[];

        while(count($arr)<=$numbers_count){
            $num=rand(1, $max);
            if(!in_array($num, $arr)){
                $arr[]=$num;
            }
        }
        return $arr;
    }
}
