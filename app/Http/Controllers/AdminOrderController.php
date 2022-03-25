<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

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
}
