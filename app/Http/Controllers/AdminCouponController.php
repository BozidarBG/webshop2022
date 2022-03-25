<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouponRequest;
use App\Models\Coupon;

class AdminCouponController extends Controller
{
    public function index(){
        return view('admin.coupons.index', ['coupons'=>Coupon::all(), 'page'=>'Coupons']);
    }

    public function create(){
        return view('admin.coupons.create', ['page'=>'Create Coupon']);
    }

    public function store(CouponRequest $request){
        $coupon=new Coupon();
        $coupon->code=$request->code;
        $coupon->value=$request->type==="percent" ? $request->value : $request->value*100;
        $coupon->type=$request->type;
        $coupon->cart_value=$request->cart_value*100;
        $coupon->valid_from=$request->valid_from;
        $coupon->valid_until=$request->valid_until;
        $coupon->save();
        session()->flash('success', 'Coupon created successfully.');
        return redirect()->route('admin.coupons');

    }

    public function edit(Coupon $coupon){
        return view('admin.coupons.edit', ['page'=>'Edit Coupon', 'coupon'=>$coupon]);

    }

    public function update(CouponRequest $request, Coupon $coupon){
        $coupon->code=$request->code;
        $coupon->value=$request->type==="percent" ? $request->value : $request->value*100;
        $coupon->type=$request->type;
        $coupon->cart_value=$request->cart_value*100;
        $coupon->valid_from=$request->valid_from;
        $coupon->valid_until=$request->valid_until;
        $coupon->save();
        session()->flash('success', 'Coupon updated successfully.');
        return redirect()->route('admin.coupons');
    }

    public function destroy(Coupon $coupon){
        $coupon->delete();
        return response()->json(['success'=> 'Coupon deleted!']);
    }


}
