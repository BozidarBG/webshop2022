@extends('layouts.all_users')

@section('title', 'home page')

@section('styles')

@endsection

@section('content')
    @include('partials.hero')
    <section class="checkout_area section-margin--small">
        <div class="container">

            <div class="billing_details">
                <div class="row">
                    <div class="col-lg-8">
                        <h3>Billing Details</h3>
                        <form class="row contact_form" action="#" method="post" novalidate="novalidate">
                            <div class="col-md-12 form-group">
                                <label for="name">Customer's Name (or a companty name if order is made by a companty)</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="person">Contact Person</label>
                                <input type="text" class="form-control" id="person" name="person">
                            </div>
                            <div class="col-md-12 form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address">
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="city" name="city">
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <label for="zip">Post Code - ZIP</label>
                                <input type="text" class="form-control" id="zip" name="zip">
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <label for="phone1">Phone</label>
                                <input type="text" class="form-control" id="phone1" name="phone1">
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <label for="phone2">Second Phone (optional)</label>
                                <input type="text" class="form-control" id="phone2" name="phone2">
                            </div>

                            <div class="col-md-12 form-group mb-0">
                                <label for="message">Note (optional)</label>
                                <textarea class="form-control" name="message" id="message" rows="1" ></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4">
                        <div class="order_box">
                            <h2>Your Order</h2>
                            <ul class="list">
                                <li><a href="#"><h4>Product <span>Total</span></h4></a></li>
                                @foreach(Cart::content() as $product)
                                <li><a href="#">{{$product->name}} <span class="middle">x {{$product->qty}}</span> <span class="last">{{$product->price * $product->qty}}</span></a></li>
                               @endforeach
                            </ul>
                            <ul class="list list_2">
                                <li><a href="#">Subtotal <span>{{Cart::subtotal()}}</span></a></li>
                                <li><a href="#">Shipping <span>Flat rate: 1.000,00</span></a></li>
                                <li><a href="#">Total <span>{{(Cart::subtotal())}}</span></a></li>
                            </ul>
                            <div class="payment_item">
                                <div class="radion_btn">
                                    <input type="radio" id="f-option5" name="selector">
                                    <label for="f-option5">Cache on delivery</label>
                                    <div class="cache"></div>
                                </div>
                                <p>Courier will contact you before the delivery.</p>
                                <button class="button" role="submit">Place an order</button>
                            </div>
                            <div class="payment_item active">
                                <div class="radion_btn">
                                    <input type="radio" id="f-option6" name="selector">
                                    <label for="f-option6">Paypal </label>
                                    <img src="img/product/card.jpg" alt="">
                                    <div class="check"></div>
                                </div>
                                <p>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal
                                    account.</p>
                            </div>
                            <div class="creat_account">
                                <input type="checkbox" id="f-option4" name="selector">
                                <label for="f-option4">I’ve read and accept the </label>
                                <a href="#">terms &amp; conditions*</a>
                            </div>
                            <div class="text-center">
                                <a class="button button-paypal" href="#">Proceed to Paypal</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')

@endsection
