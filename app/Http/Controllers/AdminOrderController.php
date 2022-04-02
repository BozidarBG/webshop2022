<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class AdminOrderController extends Controller
{
    //

    public function index(){
        return view('admin.orders.index', [
            'orders'=>Order::with('shipping', 'user')->orderBy('created_at', 'desc')->paginate(15),
            'page'=>'Orders']);
    }

    public function edit(Order $order){
        //dd($order);
        return view('admin.orders.edit', [
            'order'=>$order,
            'page'=>'Order']);
    }

    public function update(Request $request, Order $order){
        $log_msg="";
        if($request->has('payment_status')){
            if(auth()->user()->isOrdersAdministrator()){
                $this->validate($request, ['payment_status'=>Rule::in(['pending', 'paid', 'declined', 'refunded'])]);
                //$order->payment_status=$request->payment_status;
                $order->update(['payment_status'=>$request->payment_status]);
                $log_msg=" payment status to ". $request->payment_status.".";
                session()->flash('success', 'Payment status changed to '.$request->payment_status);
            }
        }
        if($request->has('paid_on')){
            if(auth()->user()->isOrdersAdministrator()){
                $this->validate($request, ['paid_on'=>'date']);
                $order->update(['paid_on'=>$request->paid_on]);
                $log_msg=" paid on to ". formatDate($request->paid_on).".";
                session()->flash('success', 'Payment date changed to '.formatDate($request->paid_on));
            }
        }
        if($request->has('shipping_status')){
            if(auth()->user()->isOrdersAdministrator()){
                $this->validate($request, ['shipping_status'=>Rule::in(['pending', 'in_preparation', 'canceled'])]);
                $order->update(['shipping_status'=>$request->shipping_status]);
                $log_msg=" shipping status to ". $request->shipping_status.".";
                session()->flash('success', 'Shipping status changed to '.$request->shipping_status);
            }
        }
        if($request->has('shipping_status')){
            if(auth()->user()->isWarehouseManager()){
                $this->validate($request, ['shipping_status'=>Rule::in(['in_preparation', 'waiting_for_courier', 'in_transit_to_customer', 'returned'])]);
                $order->update(['shipping_status'=>$request->shipping_status]);
                $log_msg=" shipping status to ". $request->shipping_status.".";
                session()->flash('success', 'Shipping status changed to '.$request->shipping_status);
            }
        }
        if($request->has('shipped_on')){
            if(auth()->user()->isWarehouseManager()){
                $this->validate($request, ['shipped_on'=>'date']);
                $order->update(['shipped_on'=>$request->shipped_on]);
                $log_msg=" shipped on to ". formatDate($request->shipped_on).".";
                session()->flash('success', 'Shipping date changed to '.formatDate($request->shipped_on));
            }
        }
        if($request->has('admin_comment')){
            $this->validate($request, ['admin_comment'=>'min:2']);
            $order->update(['admin_comment'=>$order->admin_comment."<br>".formatDate(now()).": "."User id: ".auth()->id()." ".auth()->user()->name.": ".$request->admin_comment]);
            $log_msg=" comment: ".$request->admin_comment.".";
            session()->flash('success', 'Admin comment for this order is updated successfully.');
        }

        //$order->save();
        Log::channel('orders_update')->info("User id: ".auth()->id()." ".auth()->user()->name." has updated order no. ".$order->id.":".$log_msg);
        return redirect()->route('admin.orders.edit', $order);
    }

}
