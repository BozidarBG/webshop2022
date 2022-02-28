@extends('layouts.all_users')

@section('title', 'cart')

@section('styles')
<style>
.qty_col{
    position: relative;
}
.qty_error{
    position:absolute;
    z-index: 5;
    top:10px;
    left:0;
}
</style>
@endsection

@section('content')
    <section class="cart_area">
        <div class="container">
            <div class="cart_inner">
                <div class="table-responsive">
                    @if(Cart::count())
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Remove</th>
                            <th scope="col">image</th>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                        </tr>
                        </thead>
                        <tbody id="cart_items">

                        @foreach(Cart::content() as $product)
                        <tr class="cart_item" data-image="{{$product->options->image}}"
                            data-id="{{$product->id}}" data-name="{{$product->name}}" data-selling_price="{{$product->price}}"
                            data-regular_price="{{$product->options->regular_price}}" data-action_price="{{$product->options->action_price}}"
                            data-stock="{{$product->options->stock}}" data-qty="{{$product->qty}}">
                            <td class="w-10">
                                <button class="btn btn-outline-danger remove">X</button>
                            </td>
                            <td>
                                <div class="media ">
                                    <div class="d-flex d-phone-none">
                                        <img width="80px" src="{{asset($product->options->image)}}" alt="product_image">
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="media ">
                                    <div class="media-body">
                                        <a href="{{$product->options->href}}">{{$product->name}}</a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h5 class="price">{{\App\Models\Product::formatedPrice($product->price) }} RSD</h5>
                            </td>
                            <td class="qty_col">
                                <p class="qty_error text-danger d-none">You can't order more quantities</p>
                                <div class="d-flex align-items-center  md-column ">
                                    <button class="btn-outline-blue mr-1 btn_minus" type="button" ><i class="fas fa-minus"></i></button>
                                    <input disabled type="number" name="qty" value="{{$product->qty}}" class="quantity mr-1" min="1" max="">
                                    <button class="btn-outline-blue mr-3 btn_plus" type="button" id="plus_"><i class="fas fa-plus"></i></button>
                                </div>
                            </td>
                            <td>
                                <h5 class="single_total">{{\App\Models\Product::formatedPrice($product->price * $product->qty) }} RSD</h5>
                            </td>
                        </tr>
                        @endforeach
                        <tr class="bottom_button">
                            <td>
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                            <td></td>
                            <td></td>
                            <td>
                                <div class="cupon_text d-flex align-items-center">
                                    <input type="text" placeholder="Coupon Code">
                                    <a class="primary-btn" href="#">Apply</a>
                                    <a class="button" href="#">Have a Coupon?</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            </td>
                            <td>
                            </td>
                            <td></td>
                            <td></td>
                            <td>

                                <h4>Total RSD</h4>
                            </td>
                            <td>
                                <h4 id="total">{{ Cart::subtotal()}}</h4>
                            </td>
                        </tr>
                        <tr class="shipping_area">
                            <td class="d-none d-md-block">
                            </td>
                            <td>
                            </td>
                            <td></td>
                            <td></td>
                            <td>
                                <h5>Shipping</h5>
                            </td>
                            <td>
                                <div class="shipping_box">
                                    <ul class="list">
                                        <li><a href="#">Flat Rate: $5.00</a></li>
                                        <li><a href="#">Free Shipping</a></li>
                                        <li><a href="#">Flat Rate: $10.00</a></li>
                                        <li class="active"><a href="#">Local Delivery: $2.00</a></li>
                                    </ul>
                                    <h6>Calculate Shipping <i class="fa fa-caret-down" aria-hidden="true"></i></h6>
                                    <select class="shipping_select" style="display: none;">
                                        <option value="1">Bangladesh</option>
                                        <option value="2">India</option>
                                        <option value="4">Pakistan</option>
                                    </select><div class="nice-select shipping_select" tabindex="0"><span class="current">Bangladesh</span><ul class="list"><li data-value="1" class="option selected">Bangladesh</li><li data-value="2" class="option">India</li><li data-value="4" class="option">Pakistan</li></ul></div>
                                    <select class="shipping_select" style="display: none;">
                                        <option value="1">Select a State</option>
                                        <option value="2">Select a State</option>
                                        <option value="4">Select a State</option>
                                    </select><div class="nice-select shipping_select" tabindex="0"><span class="current">Select a State</span><ul class="list"><li data-value="1" class="option selected">Select a State</li><li data-value="2" class="option">Select a State</li><li data-value="4" class="option">Select a State</li></ul></div>
                                    <input type="text" placeholder="Postcode/Zipcode">
                                    <a class="gray_btn" href="#">Update Details</a>
                                </div>
                            </td>
                        </tr>
                        <tr class="out_button_area">
                            <td class="d-none-l">

                            </td>
                            <td class="">

                            </td>
                            <td>

                            </td>
                            <td></td>
                            <td></td>
                            <td>
                                <div class="checkout_btn_inner d-flex align-items-center">
                                    <a class="gray_btn" href="#">Continue Shopping</a>
                                    <a class="primary-btn ml-2" href="{{route('checkout')}}">Proceed to checkout</a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    @else
                    <p class="text-danger">There are no items in your cart</p>
                    @endif
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')

@endsection
