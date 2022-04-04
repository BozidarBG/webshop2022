@extends('layouts.all_users')

@section('title', 'cart')

@section('styles')
<style>

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
                            <th scope="col">Move To Cart</th>
                        </tr>
                        </thead>
                        <tbody id="favourites_items">

                        </tbody>
                        <tbody>
                        <tr class="out_button_area">
                            <td class="">

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
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <p class="text-danger" id="no_items">There are no items in your favourites cart</p>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
<script>
    new Favourites();
</script>
@endsection
