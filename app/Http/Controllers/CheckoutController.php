<?php

namespace App\Http\Controllers;

use App\Mail\OrderCreated;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Shipping;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Stripe;
use Illuminate\Support\Str;

class CheckoutController extends CartController
{
    protected $pdf_filename;
    protected $order;
    protected $shipping;
    protected $order_items=[];

//checkout page where user will confirm his order. while he is thinking, something can change so we check once again
    //everything that was checked before he came to this page
    public function checkout(){
        return view('all_users.checkout', ['title'=>'Checkout page']);
    }


    public function thankYou(){
        if(session()->has('order_created')){
            return view('all_users.thank_you', ['title'=>'Order Confirmation']);
        }
        return redirect()->route('home');
    }

    public function createOrder(Request $request){
        //info(json_encode($request->all()));
        $validator=Validator::make($request->all(), [
            //$this->validate($request, [
            'name'=>'required|max:250',
            'contact_person'=>'nullable|max:250',
            'address'=>'required|max:250',
            'city'=>'required|max:250',
            'zip'=>'required|max:5',
            'email'=>'required|email',
            'phone1'=>'required|max:13',
            'phone2'=>'nullable|max:13',
            'items'=>'required',
            'confirm_terms'=>'required',
            'payment_type'=>[Rule::in(['card', 'cod'])],
            'card_number'=>[Rule::when(function ($request){
                return $request->payment_type=='card';
            }, 'required')],
            'expiry_month'=>[Rule::when(function ($request){
                return $request->payment_type=='card';
            }, 'required')],
            'expiry_year'=>[Rule::when(function ($request){
                return $request->payment_type=='card';
            }, 'required')],
            'cvc'=>[Rule::when(function ($request){
                return $request->payment_type=='card';
            }, 'required')]
        ]);


        $this->populateClassProps($request);
        $this->populateRequestErrors();
        //if we have errors, put errors in response and return back
        if($validator->fails() || $this->coupon_has_error || $this->item_errors){
            $errors_arr=['errors'=>true];
            if ($validator->fails()){
                $errors_arr['validation']=$validator->errors();
            }
            if($this->item_errors){
                $errors_arr['items']=$this->item_errors;
                $errors_arr['products_in_cart']=$this->users_items_with_updated_values;
            }
            if($this->coupon_has_error){
                $errors_arr['coupon']='This coupon is not valid. Your total might have changed!';
            }
            return response()->json($errors_arr);
        }


        //everything is ok with items, coupon and input fields, so we populate totals and create order if possible

        $this->calculateSubtotal();
        $this->calculateSubtotalWithCoupon();
        $this->calculateShippingFee();
        $this->calculateTotal();


        $this->setPDFFileName($request->name);

        DB::beginTransaction();

        if($request->payment_type==="cod"){
            $this->payWithCOD($request);
        }else if($request->payment_type==="card"){
            $result=$this->payWithCard($request);
            if(is_array($result) && array_key_exists('status', $result) && $result['status']=='succeeded'){
                $order_id=$this->populateOrderSTable('card', 'paid', Carbon::now());
                $this->populateShippingsTable($request, $order_id);
                $this->populateOrderItemsTable($order_id);
            }else {
                DB::rollBack();
                Log::channel('stripe')->info('stripe error: ' . json_encode($result));
                if (array_key_exists('exception', $result)) {
                    if ($result['exception'] == "Your card number is incorrect.") {
                        return response()->json(['errors' => true, 'card_number' => $result['exception']]);
                    }
                    if ($result['exception'] == "Your card's expiration year is invalid.") {
                        return response()->json(['errors' => true, 'expiry_year' => $result['exception']]);
                    }
                    if ($result['exception'] == "Your card's expiration month is invalid.") {
                        return response()->json(['errors' => true, 'expiry_month' => $result['exception']]);
                    }
                    if ($result['exception'] == "Your card's security code is invalid") {
                        return response()->json(['errors' => true, 'cvc' => $result['exception']]);
                    }

                }
                return response()->json(['errors'=>true, 'other_error'=>true]);
            }

        }
        DB::commit();

        //create pdf order confirmation (filename already set)

        $pdf = PDF::loadView('/templates/order_confirmation', [
                'order'=>$this->order,
                'shipping'=>$this->shipping,
                'order_items'=>$this->order_items,
                'settings'=>cache()->get('settings')
            ])
            ->save('pdfs/'.$this->pdf_filename);
        //send email with order confirmation
        Mail::to($this->shipping)->queue(new OrderCreated($this->shipping->name, $this->pdf_filename));

        session(['order_created'=> 'Ok']);
        $request->items=null;
        return response()->json(['success'=>'ok', 'location'=>'/thank-you']);
    }

    protected function setPDFFileName($name){
        $date=Carbon::now();
        $replaced=Str::replace(' ', '_', $name);
        $this->pdf_filename=$date->format('d_m_Y_h_i').'_'.$replaced.'.pdf';
    }

    protected function payWithCOD($request){
        $order_id=$this->populateOrderSTable('cod', 'pending');
        $this->populateShippingsTable($request, $order_id);
        $this->populateOrderItemsTable($order_id);
    }

    protected function populateOrderItemsTable($order_id){
        foreach($this->users_items_with_updated_values as $product){
            $item=new OrderItem();
            $item->order_id=$order_id;
            $item->product_id=$product->id;
            $item->acc_code=$product->acc_code;
            $item->name=$product->name;
            $item->selling_price=$product->selling_price;
            $item->qty=$product->qty;
            $item->save();
            $this->order_items[]=$item;
            $this->decreaseQtyInProductsTable($product->id, $product->qty);
        }
    }

    protected function populateShippingsTable($request, $order_id){
        $shipping=new Shipping();
        $shipping->order_id=$order_id;
        $shipping->name=$request->name;
        $shipping->address=$request->address;
        $shipping->city=$request->city;
        $shipping->zip=$request->zip;
        $shipping->email=$request->email;
        $shipping->phone1=$request->phone1;
        $shipping->phone2=$request->phone2;
        $shipping->contact_person=$request->contact_person ?? $request->name;
        $shipping->comment=$request->comment;
        $shipping->save();
        $this->shipping=$shipping;
    }

    protected function populateOrderSTable($payment_type, $payment_status, $paid_on=null){
        $order=new Order();
        $order->user_id=auth()->check() ? auth()->id() : 0; //unauthenticated users will have 0 id
        $order->subtotal=$this->order_subtotal;
        $order->subtotal_with_coupon=$this->order_subtotal_with_coupon;
        $order->coupon_value=$this->coupon? json_encode($this->coupon) : null;
        $order->shipping_fee=$this->order_shipping_fee;
        $order->total=$this->order_total;
        $order->payment_type=$payment_type;
        $order->payment_status=$payment_status;
        $order->paid_on=$paid_on;
        $order->pdf=$this->pdf_filename;
        $order->save();
        $this->order=$order;
        return $order->id;
    }

    protected function decreaseQtyInProductsTable($id, $qty){
        $product=Product::find($id);
        $product->decrement('stock', $qty);
    }

    protected function makeMetaData(){
        $arr=[];
        foreach ($this->users_items_with_updated_values as $product){
            $arr[]=[
                'id'=>$product->id,
                'name'=>$product->name,
                'price'=>$product->selling_price,
                'qty'=>$product->qty
            ];
        }
        return json_encode($arr);
    }
    protected function payWithCard(Request $request){
        $order_id=Order::latest()->first()->id+1;
        $key=env('STRIPE_SECRET_KEY');
        $stripe=Stripe::make($key);
        try{
            $token=$stripe->tokens()->create([
                'card'=>[
                    'number'=>$request->card_number,
                    'exp_month'=>$request->expiry_month,
                    'exp_year'=>$request->expiry_year,
                    'cvc'=>$request->cvc
                ]
            ]);
            if(!isset($token['id'])){
                Log::channel('stripe')->info('Token is not set');
                return false;
            }
            $customer=$stripe->customers()->create([
                'name'=>$request->name,
                'email'=>$request->email,
                'phone'=>$request->phone1,
                'source'=>$token['id']
            ]);
            $charge= $stripe->charges()->create([
                'customer'=>$customer['id'],
                'currency'=>'RSD',
                'amount'=>$this->order_total/100,
                'description'=>'Payment for order no. '.$order_id,
                'metadata'=>['products'=>$this->makeMetaData()]
            ]);

            return $charge;

        }catch (\Stripe\Exception\CardException $e){
            Log::channel('stripe')->info('u pay with card keču '.$e->getMessage());
            //return $e->getMessage();
            // Since it's a decline, \Stripe\Exception\CardException will be caught
            Log::channel('stripe')->info('Status is:' . $e->getHttpStatus());
            Log::channel('stripe')->info('Type is:' . $e->getError()->type);
            Log::channel('stripe')->info('Code is:' . $e->getError()->code);
            // param is '' in this case
            Log::channel('stripe')->info('Param is:' . $e->getError()->param);
            Log::channel('stripe')->info('Message is:' . $e->getError()->message);
        } catch (\Stripe\Exception\RateLimitException $e) {
            // Too many requests made to the API too quickly
            Log::channel('stripe')->info('rate limit exception'.$e->getMessage());
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Invalid parameters were supplied to Stripe's API
            Log::channel('stripe')->info('invalid request exception'.$e->getMessage());

        } catch (\Stripe\Exception\AuthenticationException $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            Log::channel('stripe')->info('auth exception'.$e->getMessage());

        } catch (\Stripe\Exception\ApiConnectionException $e) {
            // Network communication with Stripe failed
            Log::channel('stripe')->info('api conn exception'.$e->getMessage());

        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            Log::channel('stripe')->info('api error exception'.$e->getMessage());

        } catch (\Exception $e) {
            // Something else happened, completely unrelated to Stripe
            Log::channel('stripe')->info('exception'.$e->getMessage());
            return ['exception'=>$e->getMessage()];

        }
    }


    /*
     try {
  // Use Stripe's library to make requests...
} catch(\Stripe\Exception\CardException $e) {
  // Since it's a decline, \Stripe\Exception\CardException will be caught
  echo 'Status is:' . $e->getHttpStatus() . '\n';
  echo 'Type is:' . $e->getError()->type . '\n';
  echo 'Code is:' . $e->getError()->code . '\n';
  // param is '' in this case
  echo 'Param is:' . $e->getError()->param . '\n';
  echo 'Message is:' . $e->getError()->message . '\n';
} catch (\Stripe\Exception\RateLimitException $e) {
  // Too many requests made to the API too quickly
} catch (\Stripe\Exception\InvalidRequestException $e) {
  // Invalid parameters were supplied to Stripe's API
} catch (\Stripe\Exception\AuthenticationException $e) {
  // Authentication with Stripe's API failed
  // (maybe you changed API keys recently)
} catch (\Stripe\Exception\ApiConnectionException $e) {
  // Network communication with Stripe failed
} catch (\Stripe\Exception\ApiErrorException $e) {
  // Display a very generic error to the user, and maybe send
  // yourself an email
} catch (Exception $e) {
  // Something else happened, completely unrelated to Stripe
}
     */





}
