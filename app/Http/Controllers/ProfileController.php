<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;


class ProfileController extends Controller
{
    //
    public function profile(){
        return view('auth_users.profile', ['page'=>'Profile', 'user'=>auth()->user()]);
    }

    public function editProfile(){
        return view('auth_users.edit', ['page'=>'edit profile', 'user'=>auth()->user()]);

    }

    public function updatePassword(Request $request)
    {

        if(Hash::check($request->old_password, auth()->user()->password)){
            $user=auth()->user();
        }else{
            return redirect()->back()->withErrors(['old_password'=> 'Password is incorrect!']);
        }

        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::min(8)->mixedCase()->numbers()->symbols()]
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);
        session()->flash('success', 'Password changed successfully!');
        return redirect()->route('users.profile');
    }

    public function deleteAccount(Request $request){

        $orders=Order::where('user_id', auth()->id())->get();
        if($orders){
            foreach ($orders as $order){
                $order->user_id=0;
                $order->save();
            }
        }
        auth()->user()->delete();
        auth()->guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        session()->flash('success', 'Profile deleted successfully!');
        return redirect()->route('home');
    }

    public function orders(){
        $orders=Order::with('items', 'shipping')->where('user_id', auth()->id())->orderBy('created_at', 'DESC')->paginate(15);
        return view('auth_users.orders', ['page'=>'Orders', 'orders'=>$orders]);

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
