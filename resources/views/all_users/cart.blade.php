@extends('layouts.all_users')

@section('title', 'cart')

@section('styles')

@endsection

@section('content')
    <section class="cart_area">
        <div class="container">
            <div class="cart_inner">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Remove</th>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr>
                            <td>
                                <button class="btn btn-outline-danger">X</button>
                            </td>
                            <td>
                                <div class="media ">
                                    <div class="d-flex d-sm-none">
                                        <img src="img/cart/cart3.png" alt="">
                                    </div>
                                    <div class="media-body">
                                        <p>Minimalistic shop for multipurpose use</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h5>$360.00</h5>
                            </td>
                            <td>
                                <div class="d-flex align-items-center  md-column ">
                                    <button class="btn-outline-blue mr-1 btn_minus" type="button" id=""><i class="fas fa-minus"></i></button>
                                    <input id="qty" type="number" name="qty" value="1" class="quantity mr-1" min="1" max="">
                                    <button class="btn-outline-blue mr-3 btn_plus" type="button" id=""><i class="fas fa-plus"></i></button>
                                </div>
                            </td>
                            <td>
                                <h5>$720.00</h5>
                            </td>
                        </tr>

                        <tr class="bottom_button">
                            <td>
                                <a class="button" href="#">Update Cart</a>
                            </td>
                            <td>

                            </td>
                            <td>

                            </td>
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
                            <td>
                                <h5>Subtotal</h5>
                            </td>
                            <td>
                                <h5>$2160.00</h5>
                            </td>
                        </tr>
                        <tr class="shipping_area">
                            <td class="d-none d-md-block">

                            </td>
                            <td>

                            </td>
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
                            <td>
                                <div class="checkout_btn_inner d-flex align-items-center">
                                    <a class="gray_btn" href="#">Continue Shopping</a>
                                    <a class="primary-btn ml-2" href="#">Proceed to checkout</a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    <script>
        let qty_error=document.getElementById('qty_error');

        let qty=document.getElementById('qty');
        let max_qty={{$product->stock}};

        const hideQtyError=()=>{
            qty_error.classList.add('d-none');
        }
        const showQtyError=()=>{
            qty_error.classList.remove('d-none');
        }

        const decreaseQty=()=>{
            hideQtyError();
            if(qty.value>0){
                qty.value = parseInt(qty.value)-1;
            }

        }

        const increaseQty=()=>{
            hideQtyError();
            if(qty.value<max_qty){
                qty.value = parseInt(qty.value)+1;
            }else{
                showQtyError();
            }
        }

        class QtyUpdater {
            constructor(){
                this.,minus
            }
        }

        let show_product=new QtyUpdater();
        new Listener('click', 'btn_minus', 'id', show_product.decreaseQty);
        new Listener('click', 'btn_plus', 'id', show_product.increaseQty);



    </script>
@endsection
