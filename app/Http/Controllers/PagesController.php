<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cache;
use App\Models\Category;
use App\Models\Product;

class PagesController extends Controller
{

    public $categories;

    public function __construct(){
        $this->categories=Cache::rememberForever('categories.all', function () {
            return Category::all();
        });
    }

    public function home(){
        return view('all_users.home', ['categories'=>$this->categories]);
    }
    public function productsByCategory($slug){

        $category=$this->categories->where('slug', $slug)->first();
        //dd($category->id);
        $products=Product::with('category')->where('category_id', $category->id)->where('stock', '>', 0)->where('published', true)->orderBy('created_at', 'asc')->paginate(12);
        //dd($products);
        return view('all_users.products_by_category', [
            'categories'=>$this->categories, 
            'products'=>$products
        ]);
    }

    public function showProduct($slug){
        $product=Product::with('category')->where('slug',$slug)->firstOrFail();
        return view('all_users.show_product', [
            'categories'=>$this->categories,
            'product'=>$product
        ]);
    }

    public function search(){
        return view('all_users.search', ['categories'=>$this->categories]);
    }

    public function checkout(){
        return view('all_users.checkout', ['categories'=>$this->categories]);
    }

    public function cart(){
        return view('all_users.cart', ['categories'=>$this->categories]);
    }

    public function contactUs(){
        return view('all_users.contact_us', ['categories'=>$this->categories]);
    }

    public function profile(){
        return view('auth_users.profile', ['categories'=>$this->categories]);
    }
}
