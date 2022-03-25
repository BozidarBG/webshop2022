<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Shipping;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CartController extends Controller
{
    protected $users_items;
    protected $ids_from_user;
    protected $coupon=null;
    protected $item_errors=[];
    protected $coupon_has_error=false;
    protected $users_items_with_updated_values;
    protected $request_errors=[];

    protected $minimum_for_free_shipping=500000;
    protected $order_subtotal=0;
    protected $order_subtotal_with_coupon=0;
    protected $order_shipping_fee=0;
    protected $order_total=0;

    public function checkCartItemsAndCoupon(Request $request){
        $this->validate($request, [
            'items'=>'required',
        ]);
        //info(json_encode($request->all()));
        $this->populateClassProps($request); //checks items and coupon
        return $this->returnResponseToFrontEnd();
    }

    //receives coupon code and returns coupon object or null
    public function checkCouponAndReturnValue($coupon_code){
        $this->checkCouponsValidity($coupon_code);
        if($this->coupon && !$this->coupon_has_error){
            return response()->json(['success'=>$this->coupon]);
        }else{
            return response()->json(['error'=>'This coupon is not valid']);
        }
    }

//    protected function checkCoupon(){
//        if($this->coupon){
//            $coupon=$this->checkCouponsValidity($this->coupon->code);
//            $this->coupon_has_error=$coupon ? false : 'Coupon is no longer valid';
//        }
//    }


    protected function checkCouponsValidity($coupon_code){
        //info(json_encode($coupon_code));
        if(is_object($coupon_code)){
            $coupon_code=$coupon_code->code;
        }
        $coupon= Coupon::where('code', $coupon_code)->where('valid_from', '<=', Carbon::now())->where('valid_until', '>=', Carbon::now())->first();
        if($coupon){
            $this->coupon=$coupon;
            $this->coupon_has_error=false;
        }else{
            $this->coupon=null;
            $this->coupon_has_error=true;
        }

    }

    protected function populateClassProps($request){
        //dd($request);
        if($request->has('coupon') && Str::length($request->coupon)){
            $this->checkCouponsValidity(json_decode($request->coupon));
        }
        $this->users_items=json_decode($request->items);
        foreach ($this->users_items as $item){
            $this->ids_from_user[]=$item->id;
        }
        $this->checkItems();
        //info($this->coupon);
    }

    protected function checkItems(){
        $products_from_DB=Product::whereIn('id', $this->ids_from_user)->get();

        $this->removeProductsThatDontExist($products_from_DB);

        $this->checkDifferenceBetweenCartAndDB($products_from_DB);
    }




    protected function returnResponseToFrontEnd(){
        $this->populateRequestErrors();

        if($this->request_errors){
            return response()->json(['errors'=>$this->request_errors, 'products_in_cart'=>$this->users_items_with_updated_values]);//order will be changed
        }else{
            //session()->put('cart_items', $this->users_items_with_updated_values);
            //$this->coupon ?? session()->put('coupon', $this->coupon);
            return response()->json(['success'=>'ok', 'location'=>'/checkout']);//order will stay as it is
        }
    }


    protected function changeValuesInCartItems($product_id, $column_name, $new_value){
        foreach ($this->users_items_with_updated_values as $item){
            if($item->id==$product_id){
                $item->{$column_name}=$new_value;
            }
        }


    }

    //checks if stock, action price and regular price (also selling_price) has changed (or user changed html/js)
    //puts errors in item errors, put new values (from DB) in $this->user_items_with_updated_values
    //$this->user_items_with_updated_values will be returned to frontend and displayed + messages about changed prices/stock
    protected function checkDifferenceBetweenCartAndDB($products_from_DB){
        foreach($this->users_items_with_updated_values as $item){
            $result=$products_from_DB->filter(function ($value, $key) use ($item) {
                return $value->id==$item->id;
            });
            $product=$result->first();//$product is from DB
            //since we need to update subtotal (qty * selling_price), we need var $correct_qty
            $correct_qty=0;
            if($item->qty > $product->stock){
                if($product->stock==0){
                    $this->createErrorMsg($product->id, 'qty',"There are no more pc(s) left on the stock for this item.", $product->stock);
                }else{
                    $this->createErrorMsg($product->id, 'qty',"There are only $product->stock pc(s) left on the stock for this item.", $product->stock);
                }
                $this->changeValuesInCartItems($product->id, 'stock', $product->stock);
                $this->changeValuesInCartItems($product->id, 'qty', $product->stock);
                $correct_qty=$product->stock;
            }else if($item->qty < $product->stock){
                $this->changeValuesInCartItems($product->id, 'stock', $product->stock);
                $correct_qty=$item->qty;

            }else{
                $correct_qty=$item->qty;
            }


            //user is buying at action price if action price exists (>0)so if regular price changes, cart values will not be affected
            $selling_price=$product->action_price ? $product->action_price : $product->regular_price;
            //product action price has changed
            if($selling_price != $item->selling_price){
                $this->createErrorMsg($product->id, 'price',"Price has changed. Now, it is ".formatPrice($selling_price).'.', $selling_price);
                $this->changeValuesInCartItems($product->id, 'selling_price', $selling_price);
                if($product->action_price != $item->action_price){
                    $this->changeValuesInCartItems($product->id, 'action_price', $product->action_price);
                }
                if($product->regular_price != $item->regular_price){
                    $this->changeValuesInCartItems($product->id, 'regular_price', $product->regular_price);
                }
            }
            //we need to change subtotal too. we will calculate new subtotal no matter if there were changes
            $new_subtotal=$selling_price * $correct_qty;
            if($new_subtotal != $item->subtotal){
                $this->changeValuesInCartItems($product->id, 'subtotal', $new_subtotal);
            }


        }
    }
    //if user has tempered with html/js or if product is deleted before checkout
    //remove product that id does not exist in DB from $this->user_items_with_updated_values
    protected function removeProductsThatDontExist($products_from_DB){
        $cleaned_items=collect($this->users_items)->each(function ($item, $key) use ($products_from_DB){
            foreach ($products_from_DB as $product_from_DB){
                if($product_from_DB->id==$item->id && $item->qty>=1 && $product_from_DB->stock >=1){
                    return $item;
                }
            }
        });
        $this->users_items_with_updated_values=$cleaned_items;
        //Log::info($this->users_items_with_updated_values);
    }

    protected function createErrorMsg($id, $type, $msg, $solution){
        $this->item_errors[$id][$type] = ['msg' => $msg, 'solution' => $solution];
    }

    protected function calculateSubtotal(){
        foreach ($this->users_items_with_updated_values as $product){
            $this->order_subtotal +=$product->subtotal;
        }
    }

    protected function calculateSubtotalWithCoupon(){
        if($this->coupon && $this->coupon_has_error){
            if($this->order_subtotal >= $this->coupon->cart_value){ //biloje this order subtotal/100
                if($this->coupon->type==="fixed"){
                    $this->order_subtotal_with_coupon=$this->order_subtotal-$this->coupon->value*100;
                }else if($this->coupon->type==='percent'){
                    $this->order_subtotal_with_coupon=$this->order_subtotal/100*(100-$this->coupon->value);
                }
            }else{
                $this->order_subtotal_with_coupon=0;
            }
        }
    }

    protected function calculateShippingFee(){
        if($this->order_subtotal_with_coupon && $this->order_subtotal_with_coupon>=$this->minimum_for_free_shipping){
            $this->order_shipping_fee=0;
        }else if($this->order_subtotal >= $this->minimum_for_free_shipping){
            $this->order_shipping_fee=0;
        }else{
            $this->order_shipping_fee=100000;
        }

    }

    protected function calculateTotal(){
        $this->order_total=$this->order_subtotal_with_coupon ? $this->order_shipping_fee + $this->order_subtotal_with_coupon : $this->order_shipping_fee+$this->order_subtotal;
    }

    protected function populateRequestErrors(){
        //are there errors?
        if($this->item_errors){
            $this->request_errors['items']=$this->item_errors;
        }
        if($this->coupon_has_error){
            $this->request_errors['coupon']=[$this->coupon_has_error];
        }
    }


}
