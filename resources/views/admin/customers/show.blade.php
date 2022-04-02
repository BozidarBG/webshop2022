@extends('layouts.admin')
@section('title', 'customer')
@section('styles')
    <style>

    </style>
@endsection

@section('content')
    @include('partials.success_msg')


    <div class="col-12">
        <div id="fc_toaster" class="position-absolute w-25 alert d-none" style="z-index: 10"></div>

        <!-- Table -->
        <div class="card card-success">
            <div class="card-header ">
                <h3 class="card-title">User {{$user->name}}</h3>

            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Totals</th>
                        <th>Payment Type</th>
                        <th>Payment Status</th>
                        <th>Paid On</th>
                        <th>Shipped On</th>
                        <th>Shipping Status</th>
                        <th>Contacted By</th>
                        <th>Order Created</th>
                        <th>Edit</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($user->orders as $order)
                        <tr>
                            <td>{{$order->id}}</td>
                            <td>{{$order->user->name}}</td>
                            <td>{{formatPrice($order->total)}}</td>
                            <td>{{$order->payment_type}}</td>
                            <td>{{$order->payment_status}}</td>
                            <td>{{$order->paid_on ? formatDate($order->paid_on) : 'Not paid'}}</td>
                            <td>{{$order->shipped_on ? formatDate($order->shipped_on): 'Not shipped'}}</td>
                            <td>{{$order->shipping_status}}</td>
                            <td>{{$order->contacted_by ? $order->contactedBy->name : 'Not yet'}}</td>
                            <td>{{formatDate($order->created_at)}}</td>
                            <th><a href="{{route('admin.orders.edit', $order)}}" class="btn btn-outline-primary">Go To</a></th>
                        </tr>
                    @empty
                        <tr><td>There are no orders</td></tr>
                    @endforelse
                    </tbody>
                </table>

            </div>
            <!-- /.card-body -->
        </div>
        <!-- end table -->
        <ul class="pagination pagination-sm">


        </ul>

    </div>

@endsection


