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

                    <table class="table d-none">
                        <thead>
                        <tr>
                            <th scope="col">Remove</th>
                            <th scope="col">image</th>
                            <th scope="col">Product</th>
                            <th scope="col">Price/RSD</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total/RSD</th>
                        </tr>
                        </thead>
                        <tbody id="cart_items">

                        </tbody>
                        <tbody>
                        <tr class="bottom_button">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <div class="cupon_text d-flex align-items-center justify-content-end">
                                    <input type="text" placeholder="Coupon Code">
                                    <a class="primary-btn" href="#">Apply</a>
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
                                <h5>Subotal RSD</h5>
                                <h5>Subtotal with Coupon RSD</h5>

                                <h5>Shipping RSD</h5>
                                <h4>Total For Payment RSD</h4>
                            </td>
                            <td>
                                <h5 id="subtotal"></h5>
                                <h5>0</h5>

                                <h5 id="shipping_fee"></h5>
                                <h4 id="total"></h4>
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
                                    <a class="gray_btn" href="/">Continue Shopping</a>
                                    <a class="primary-btn ml-2" href="{{route('checkout')}}">Proceed to checkout</a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <p class="text-danger" id="no_items">There are no items in your cart</p>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
<script>
    new Cart();
</script>
@endsection
