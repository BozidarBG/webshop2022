@extends('layouts.admin')
@section('styles')
    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <style>

    </style>
@endsection

@section('content')
    @include('partials.success_msg')
    @include('partials.errors_in_div')
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-cyan">
                <h3>Order no. {{$order->id}}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p>Customer: <strong>{{$order->user->name}}</strong></p>
                        <p>Contact person: <strong>{{$order->shipping->contact_person}}</strong></p>
                        <p>Address: <strong>{{$order->shipping->address}}</strong></p>
                        <p>Zip/City: <strong>{{$order->shipping->zip}}/{{$order->shipping->city}}</strong></p>
                        <p>Phone 1: <strong>{{$order->shipping->phone1}}</strong></p>
                        <p>Phone 2: <strong>{{$order->shipping->phone2}}</strong></p>
                        <p>Email: <strong>{{$order->shipping->email}}</strong></p>
                        <p>Comment: <strong>{{$order->shipping->comment}}</strong></p>
                        <p>Created: <strong>{{formatDate($order->created_at)}}</strong></p>
                    </div>
                    <div class="col-md-6">
                        <p>Subtotal: <strong>{{formatPrice($order->subtotal)}}</strong></p>
                        <p>Subtotal With Coupon: <strong>{{formatPrice($order->subtotal_with_coupon)}}</strong></p>
                        <p>Shipping Fee: <strong>{{formatPrice($order->shipping_fee)}}</strong></p>
                        <p>Coupon Value: <strong>{{$order->getCouponValue()}}</strong></p>
                        <p>Total Order: <strong>{{formatPrice($order->total)}}</strong></p>
                        <p>Payment Type: <strong>{{$order->payment_type}}</strong></p>
                        <p>Payment Status: <strong>{{$order->payment_status}}</strong></p>
                        <p>Paid On: <strong>{{formatDate($order->paid_on) ?? 'pending'}}</strong></p>
                        <p>Shipped On: <strong>{{formatDate($order->shipped_on) ?? 'not yet'}}</strong></p>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Name</th>
                            <th>Accounting code</th>
                            <th>Selling Price</th>
                            <th>Quantity</th>
                            <th>View</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>{{$item->product_id}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->acc_code}}</td>
                                <td>{{formatPrice($item->selling_price)}}</td>
                                <td>{{$item->qty}}</td>
                                <td><a target="_blank" href="{{route('admin.products.edit', $item)}}" class="btn btn-outline-success">View</a></td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>


</script>
@endsection

