<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Image;

class AdminProductController extends Controller
{
    public function index(){
        return view('admin.products.index', [
            'products'=>Product::with('category')->where('published', true)->where('stock', '>', 0)->orderBy('created_at','DESC')->paginate(15),
            'page'=>'Products seen by users (published products with stock)'
        ]);
    }

    public function unpublished(){
        return view('admin.products.index', [
            'products'=>Product::with('category')->where('published', false)->orderBy('created_at','DESC')->paginate(15),
            'page'=>'Unpublished products'
        ]);
    }

    public function outOfStock(){
        return view('admin.products.index', [
            'products'=>Product::with('category')->where('stock', 0)->orderBy('created_at','DESC')->paginate(15),
            'page'=>'Out of stock products'
        ]);

    }

    public function search(Request $request){
        //dd($request->all());
        $this->validate($request, [
            'search'=>'required|max:20',
            'field'=>['required', Rule::in(['name', 'acc_code'])],
            'order_by'=>['required', Rule::in(['asc', 'desc'])],
        ]);


       //$products=Product::with('category')->where($request->field, 'like', '%'.$request->search.'%')->orderBy($request->field, $request->order_by)->paginate(15);
        //dd($products);
        return view('admin.products.index', [
            'products'=>Product::with('category')->where($request->field, 'like', '%'.$request->search.'%')->orderBy($request->field, $request->order_by)->paginate(15),//->toSql(),
            'page'=>"Search results for $request->search"
        ]);
    }

    public function create(){
        $categories=Category::all();
        return view('admin.products.create', ['categories'=>$categories, 'page'=>'Create products']);
    }

    public function edit(Product $product){
        //dd($product);
        return view('admin.products.edit', [
            'product'=>$product,//->with('category'),
            'categories'=>Category::all(),
            'page'=>'Edit product'
        ]);
    }

    public function togglePublishProduct(Product $product){
        if($product->published===false){
            $product->published=true;
            $product->save();
            session()->flash('success', 'Product is published!');
            return redirect()->route('admin.products.unpublished');
        }else{
            $product->published=false;
            $product->save();
            session()->flash('success', 'Product is not published anymore!');
            return redirect()->route('admin.products.published');
        }
    }

    public function store(ProductRequest $request){
        //Log::info($request->all());
        $name_count=Product::where('name', $request->name)->count();
        if($name_count==0){
            $slug=Str::slug($request->name);
        }else {
            $slug = Str::slug($request->name) . '-' . $name_count;
        }
        $product=new Product();
        $product->name=$request->name;
        $product->slug=$slug;
        $product->category_id=$request->category;
        $product->acc_code=$request->acc_code;
        $product->short_desc=$request->short_description;
        $product->description=$request->description;
        $product->price=$request->price*100;
        $product->action_price=$request->action_price*100;
        $product->stock=$request->stock;

        if($request->has('image')){
            $image = $request->file('image');
            //$input['product_image'] = time() . '.' . $image->extension();
            $request->image=time().'.'.$image->extension();

            // Get path of thumbnails folder from /public
            $thumbnailFilePath = public_path(Product::$storage);

            $img = Image::make($image->path());

            // Image resize to given aspect dimensions
            // Save this thumbnail image to /public/thumbnails folder
//            $img->resize(540, 580, function ($const) {
//                $const->aspectRatio();
//            })->save($thumbnailFilePath . '/' . $request->image);
            $img->crop(540, 580);
            $img->save($thumbnailFilePath . '/' . $request->image);
            $product->image=$request->image;
//            // Product images folder
//            $ImageFilePath = public_path('images');
//
//            // Store product original images
//            $image->move($ImageFilePath, $request->image);
        }


        $product->save();
        session()->flash('success', "Product $product->name created successfully!");
        return redirect()->route('admin.products.create');


    }

    public function update(ProductRequest $request, Product $product){
        $name_count=Product::where('name', $request->name)->count();
        if($name_count==0){
            $slug=Str::slug($request->name);
        }else{
            $slug=Str::slug($request->name).'-'.$name_count;
        }
        //dd($name_count);
        $product->name=$request->name;
        $product->slug=$slug;
        $product->category_id=$request->category;
        $product->acc_code=$request->acc_code;
        $product->short_desc=$request->short_description;
        $product->description=$request->description;
        $product->price=$request->price*100;
        $product->action_price=$request->action_price*100;
        $product->stock=$request->stock;

        if($request->has('image')){

            //delete old image
            if(\File::exists(public_path(Product::$storage.'/'.$product->image))){

                \File::delete(public_path(Product::$storage.'/'.$product->image));
            }
            //create new image
            $image = $request->file('image');
            $request->image=time().'.'.$image->extension();

            // Get path of thumbnails folder from /public
            $thumbnailFilePath = public_path(Product::$storage);

            $img = Image::make($image->path());

            $img->crop(540, 580);
            $img->save($thumbnailFilePath . '/' . $request->image);
            $product->image=$request->image;
        }


        $product->save();
        session()->flash('success', "Product $product->name updated successfully!");
        return redirect()->route('admin.products.update', [$product]);
    }

    public function destroy(Product $product){
        $product->delete();
        return response()->json(['success'=> 'Product deleted!']);

    }

    public function deletedProducts(){
        return view('admin.products.index', [
            'products'=>Product::with('category')->onlyTrashed()->orderBy('created_at','DESC')->paginate(15),
            'page'=>'Deleted products'
        ]);
    }

    public function restore($id){

        $product=Product::withTrashed()->find($id);
        if($product){
            $product->restore();
            return response()->json(['success'=> 'Product restored!']);

        }
        return response()->json(['errors'=> 'Product not found!']);

    }
}
