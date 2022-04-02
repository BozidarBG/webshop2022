<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    //
    public function profile(){
        return view('auth_users.profile', ['page'=>'Profile', 'user'=>auth()->user()]);
    }

    public function editProfile(){
        return view('auth_users.edit', ['page'=>'edit profile', 'user'=>auth()->user()]);

    }

    public function updateProfile(){

    }

    public function deleteProfile(){

    }

    public function orders(){
        $orders=Order::with('items', 'shipping')->where('user_id', auth()->id())->paginate(15);
        return view('auth_users.orders', ['page'=>'orders', 'orders'=>$orders]);

    }

    public function ordersShow($id){
        $order=Order::with('items.product')->find($id);
        if($order && $order->user_id===auth()->id()){
            return view('auth_users.order', ['page'=>'order no. '.$id, 'order'=>$order]);
        }
        return redirect()->route('user.orders');
    }

    public function downloadFile($filename){
        $file=public_path()."/pdfs/".$filename;
        if(file_exists($file)){
            $headers=['Content-Type: application/pdf'];
            return response()->download($file, $filename, $headers);
        }else{
            session()->flash('error', 'Order confirmation PDF not found');
            return redirect()->route('user.orders');
        }

    }
}
