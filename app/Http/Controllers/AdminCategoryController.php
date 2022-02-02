<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Cache;

class AdminCategoryController extends Controller
{
    public function index(){

        $categories=Category::all();
        return view('admin.categories', ['categories'=>$categories, 'page'=>'Categories']);
    }

    public function store(Request $request){
        //Log::info($request->all());
        $this->validate($request, [
            'name'=>'required'
        ]);

        $existed=Category::where('name', $request->name)->first();
        //Log::info($existed);
        if($existed){
            return response()->json(['errors'=>'Category exists']);
        }
        $category=new Category();
        $category->name=$request->name;
        $category->slug=Str::slug($request->name);
        $category->save();
        Cache::forget('categories.all');

        return response()->json(['success'=>$category]);
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'name'=>'required'
        ]);

        $existed=Category::where('name', $request->name)->first();
        if($existed){
            return response()->json(['errors'=>'Category exists']);
        }

        $category=Category::find($id);
        if($category){
            $category->name=$request->name;
            $category->slug=Str::slug($request->name);
            $category->save();
            Cache::forget('categories.all');

            return response()->json(['success'=>$category]);
        }else{
            return response()->json(['errors'=>'Category not found']);
        }
    }

    public function destroy($id)
    {
        $category=Category::find($id);

        $product=Product::where('category_id', $id)->first();
        if($product){
            return response()->json(['errors'=>'Category has products. Edit those products before deleting category']);
        }

        if($category){
            $category->delete();
            Cache::forget('categories.all');

            return response()->json(['success'=>'Category deleted']);

        }else{
            return response()->json(['errors'=>'Category not found']);
        }


    }
}
