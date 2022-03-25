@extends('layouts.all_users')

@section('title', 'checkout')

@section('styles')


@endsection

@section('content')
    @include('partials.hero')
    @include('partials.confirmation_modal')
    <section class="checkout_area section-margin--small">
        <div class="container">
@if(session()->has('errors'))
    @include('partials.errors_in_div')
    <div class="invisible" id="backend_errors"></div>
    @endif
    @if(session()->has('item_errors'))
        @include('partials.errors_in_div')
        {{session()->get('item_errors')}}
    @endif
            <div class="billing_details">
                <form action="{{route('create.order')}}" method="post" id="checkout_form">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <h3>Billing Details</h3>
                        <div class="row contact_form" action="{{route('create.order')}}" method="post">
                            <div class="col-md-6 form-group">
                                <label for="name">Customer's Name (or a companty name if order is made by a companty)</label>
                                <input  type="text" class="form-control @error('name') is-invalid @enderror"  name="name" @auth value="{{auth()->user()->name}}" @endauth @guest value="{{old('name')}}" @endguest>
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="person">Contact Person (leave blank if you are contact person)</label>
                                <input   type="text" class="form-control @error('contact_person') is-invalid @enderror"  name="contact_person" value="{{old('contact_person')}}" >
                                @error('contact_person')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="email">Email Address (to send you order specification)</label>
                                <input   type="email" class="form-control @error('email') is-invalid @enderror"  name="email" @auth value="{{auth()->user()->email}}" @endauth @guest value="{{old('email')}}" @endguest>
                                @error('email')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="address">Delivery Address</label>
                                <input   type="text" class="form-control @error('address') is-invalid @enderror"  name="address" value="ulica br 1" value="{{old('address')}}" >
                                @error('address')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <label for="city">City</label>
                                <input  type="text" class="form-control @error('city') is-invalid @enderror"  name="city" value="" {{-- value="{{old('city')}}"--}} >
                                @error('city')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <label for="zip">Post Code - ZIP</label>
                                <input  type="text" class="form-control @error('zip') is-invalid @enderror"  name="zip" value="11070" value="{{old('zip')}}" >
                                @error('zip')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <label for="phone">Phone</label><br><label> (courier will contact you on this phone before the delivery)</label>
                                <input  type="text" class="form-control @error('phone1') is-invalid @enderror"  name="phone1" value="0123456" value="{{old('phone')}}" >
                                @error('phone1')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group p_star">
                                <label for="phone2">Second Phone</label><br><label> (optional)</label>
                                <input type="text" class="form-control @error('phone2') is-invalid @enderror"  name="phone2" value="064789456" value="{{old('phone1')}}" >
                                @error('phone2')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12 form-group mb-2">
                                <label for="message">Note (optional)</label>
                                <textarea class="form-control @error('comment') is-invalid @enderror" name="comment"  rows="1" >{{old('comment')}}</textarea>
                                @error('comment')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="order_box">
                            <h2>Please, check your order once again. If you wish to change something, please, visit cart page.</h2>

                            <ul class="list" id="checkout_list">
                                <li><a href="#"><h4>Product <span>Total</span></h4></a></li>
                            </ul>
                            <ul class="list list_2">
                                <li><a href="#">Subtotal <span id="checkout_subtotal"></span></a></li>
                                <li id="coupon_placeholder" class="d-none"><a href="#">Subtotal With Coupon<span id="checkout_subtotal_with_coupon"></span></a></li>
                                <li><a href="#">Shipping <span id="checkout_shipping_fee"></span></a></li>
                                <li><a href="#">Total <span id="checkout_total"></span></a></li>
                            </ul>
                            <div>
                                <input type="checkbox" id="confirm_terms" class="confirm_terms_checkbox" name="confirm_terms" checked>

                                <label for="" class="checkmark font-weight-bold">I’ve read and accept the </label>
                                <a href="#">terms &amp; conditions*</a>
                                @error('confirm_terms')
                                <div class="text-danger h6">{{ $message }}</div>
                                @enderror
                            </div>
                            <p>Choose your payment method</p>
                            <div class="">
                                <div class="m-3">
                                    <input type="radio" id="f-option5" class="selector" name="payment_type">
                                    <label for="f-option5">I want to pay with <strong>cache on delivery</strong></label>
                                    <div class="payment_section d-none">
                                        <p>Courier will contact you before the delivery.</p>
                                        <button class="button"data-toggle="modal" data-target="#confirmation_modal" role="button" id="cod_button">Place an order for cache on delivery</button>
                                    </div>
                                </div>

                            </div>
                            <div >
                                <div class="m-3">
                                    <input type="radio" id="f-option6" class="selector" name="payment_type">
                                    <label for="f-option5" >I want to pay with <strong>credit card</strong></label>
                                    <img src="{{asset('app_images/card.jpg')}}" alt="">
                                    <div class="payment_section d-none">
                                        <p>Please, fill all fields bellow. We will not keep your credit cart information in our system.</p>
                                        <div class="row mb-3">
                                            <div class="col-md-6 col-xs-1 mb-3">
                                                <label for="card">Card Number</label>
                                                <input  type="text" class="form-control @error('card') is-invalid @enderror"  name="card" value="4242424242424242" >
                                                @error('card')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 col-xs-1 mb-3">
                                                <label for="e_month">Expiry Month</label>
                                                <input  type="number" class="form-control @error('e_month') is-invalid @enderror"  name="e_month" value="05">
                                                @error('e_month')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 col-xs-1 mb-3">
                                                <label for="e_year">Expiry Year</label>
                                                <input  type="number" class="form-control @error('e_year') is-invalid @enderror"  name="e_year" value="" >
                                                @error('e_year')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 col-xs-1 mb-3">
                                                <label for="cvc">CVC</label>
                                                <input  type="password" class="form-control @error('cvc') is-invalid @enderror"  name="cvc" value="123" >
                                                @error('cvc')
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <button class="button_green" data-toggle="modal" data-target="#confirmation_modal" role="button" id="card_button">Place an order for payment via credit card</button>
                                    </div>
                                </div>

                            </div>


                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
<script>
    new Checkout();
</script>
@endsection
