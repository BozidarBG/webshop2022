<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Cache;
use App\Models\Category;
use App\Models\Product;
use App\Models\Contact;
use DB;
use Illuminate\Support\Arr;
use Illuminate\Pagination\LengthAwarePaginator;

class PagesController extends Controller
{


    public function home(){
        $products=Product::with('category')->where('stock', '>', 0)->where('published', 1)->inRandomOrder()->limit(16)->get();
        return view('all_users.home',
            [
                'products'=>$products->take(8),
                'best_sellers'=>$products->take(-8)
                ]);
    }
    public function productsByCategory(Request $request, $slug){
        //dd($request);
        $categories=Cache::rememberForever('categories.all', function () {
            return Category::all();
        });

        $per_page=12;
        $order_by="name";
        $order_direction="asc";
        $props_to_return=[];

        $category=$categories->where('slug', $slug)->first();
        $props_to_return[] = ['category' => $category];


        if($request->has('order-by') && in_array($request->input('order-by'), ['name-a-to-z', 'name-z-to-a', 'price-low-to-high', 'price-high-to-low'])){
            switch ($request->input('order-by')){
                case 'name-a-to-z':
                    $order_by="name";
                    $order_direction="asc";
                    break;
                case 'name-z-to-a':
                    $order_by="name";
                    $order_direction="desc";
                    break;
                case 'price-low-to-high':
                    $order_by="regular_price";
                    $order_direction="asc";
                    break;
                case 'price-high-to-low':
                    $order_by="regular_price";
                    $order_direction="desc";
                    break;
            }
            $props_to_return[]=['order_by'=>$request->input('order-by')];
        }

        if($request->has('per-page') && in_array($request->input('per-page'), ['12', '24', '36', '48'])){
            $per_page=$request->input('per-page');
            $props_to_return[]=['per_page'=>$request->input('per-page')];
        }

        $products=Product::with('category')->where('category_id', $category->id)
            ->where('stock', '>', 0)
            ->where('published', true)
            ->orderBy($order_by, $order_direction)
            //->paginate($per_page);
            ->get();


        //dd(Arr::collapse($props_to_return));
        $page=LengthAwarePaginator::resolveCurrentPage();

        $results=$products->slice(($page-1)*$per_page, $per_page)->values();

        $paginated = new LengthAwarePaginator($results, $products->count(), $per_page, $page,[
            'path'=>LengthAwarePaginator::resolveCurrentPath()
        ]);

        $paginated->appends(request()->all());

        $props_to_return[] = ['products' => $paginated];

        return view('all_users.products_by_category', Arr::collapse($props_to_return));
    }

    public function showProduct($slug){
        $product=Product::with('category')->where('slug',$slug)->firstOrFail();
        return view('all_users.show_product', [
            'product'=>$product
        ]);
    }

    public function search(){
        return view('all_users.search');
    }

    public function checkout(){
        return view('all_users.checkout',['title'=>'Checkout']);
    }

    public function cart(){
        return view('all_users.cart');
    }

    public function favourites(){
        return view('all_users.favourites');
    }
    public function contactUs(){
        return view('all_users.contact_us', ['title'=>'Contact Us']);
    }

    public function storeContactUs(Request $request){
        $this->validate($request, [
            'name'=>'required|max:50',
            'email'=>'required|email|max:150',
            'subject'=>'required|max:255',
            'message'=>'required|max:2000'
        ]);

        $contact=new Contact();
        $contact->name=$request->name;
        $contact->email=$request->email;
        $contact->subject=$request->subject;
        $contact->message=$request->message;
        $contact->save();

        session()->flash('success', 'Your inquiry is saved. Someone will contact you soon!');
        return redirect()->route('contact.us');

        //status: pending, email_sent, closed
        //solution if closed: discarded, answered,
    }

    public function profile(){
        return view('auth_users.profile');
    }


}
