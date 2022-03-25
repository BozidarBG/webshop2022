<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Cart;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class OldCartController extends Controller
{



    public function addToCart(CartRequest $request)
    {
        //info($request->all());


        $product=Product::find($request->id);
        if(!$product){
            //user did something with html
            return response()->json(['errors'=>'Product not found!']);
        }
        if($product->stock < $request->qty){
            return response()->json(['errors'=>"There are only $product->stock left on stock"]);

        }

        //we need to see if this product is already in cart
        $item=$this->getCartItem($request->id);
        //if we have this item in cart, return msg that this item is already in the cart
        if(!is_null($item) && count($item)){
            return response()->json(['errors'=>'This item is already in the cart. You can update quantity in the cart page.']);
        }else{
            $selling_price=$product->action_price > 0 ? $product->action_price : $product->regular_price;
            Cart::add($request->id, $product->name, $request->qty, $selling_price/100, 0,
                ['action_price'=>$product->action_price, 'regular_price'=>$product->regular_price,
                    'image'=>$product->image, 'stock'=>$product->stock,
                    'href'=>route('product.show',['slug'=>$product->slug])]);

        }
        return response()->json(['success'=>Cart::content(), 'new_total'=>Cart::subtotal()]);



    }

    public function updateCart(CartRequest $request)
    {
       // info($request->all());


        $product=Product::find($request->id);
        if(!$product){
            //user did something with html
            return response()->json(['errors'=>'Product not found!']);
        }
        if($product->stock < $request->qty){
            return response()->json(['errors'=>"There are only $product->stock left on stock"]);

        }

        //we need to see if this product is already in cart
        $item=$this->getCartItem($request->id);
        //if we have this item in cart, update qty else add to cart. if user adds same article twice, we will add new qty to old qty
        //info($item);
        if(!is_null($item) && count($item)){
            $row_id=$this->getValueFromCartItem($request->id, 'rowId');
            //$row_old_qty=$this->getValueFromCartItem($request->id, 'qty');
            Cart::update($row_id, $request->qty);
        }else{


        }
        return response()->json(['success'=>Cart::content(), 'new_total'=>Cart::subtotal()]);


    }

    private function getCartItem($id){
        return Cart::count() ? Cart::search(function($cartItem, $rowId) use ($id){
            return $cartItem->id==$id ? $cartItem->rowId : null;
        }) : null;
    }

    private function getValueFromCartItem($product_id, $key){
        $cartItem=$this->getCartItem($product_id);
        $collapsed=Arr::collapse($cartItem->toArray());
        if(array_key_exists($key, $collapsed)){
            return $collapsed[$key];
        }else{
            die("Key $key doses not exist in this array");
        }
    }

    public function removeFromCart(Request $request){
        info($request);
        $this->validate($request, [
            'id'=>'required'
        ]);

        $item=$this->getValueFromCartItem($request->id, 'rowId');
        //info($item);
        if($item){
            Cart::remove($item);
            return response()->json(['success'=>'Item removed from cart', 'new_total'=>Cart::subtotal()]);

        }else{
            return response()->json(['errors'=>'Item not found']);
        }


    }


}
