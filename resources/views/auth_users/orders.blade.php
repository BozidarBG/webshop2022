@extends('layouts.admin')

@section('title', 'orders')

@section('styles')

@endsection

@section('content')

    <div class="col-12">
        <div id="fc_toaster" class="position-absolute w-25 alert d-none" style="z-index: 10"></div>

        <!-- Table -->
        <div class="card card-success">
            <div class="card-header ">
                <h3 class="card-title">Orders</h3>

            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                    <tr>
                        <th>Order No.</th>
                        <th>Totals</th>
                        <th>Payment Type</th>
                        <th>Payment Status</th>
                        <th>Paid On</th>
                        <th>Shipped On</th>
                        <th>Shipping Status</th>
                        <th>Order Created</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{$order->id}}</td>
                            <td>{{formatPrice($order->total)}}</td>
                            <td>{{$order->payment_type}}</td>
                            <td>{{$order->payment_status}}</td>
                            <td>{{$order->paid_on ? \Carbon\Carbon::parse($order->paid_on)->format('d.m.Y H:i') : 'Not paid'}}</td>
                            <td>{{$order->shipped_on ? $order->shipped_on->format('d.m.Y H:i') : 'Not shipped'}}</td>
                            <td>{{$order->shipping_status}}</td>
                            <td>{{formatDate($order->created_at)}}</td>
                            <td><a href="{{route('user.orders.show', $order)}}" class="btn btn-outline-warning">View</a></td>
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

            {{ $orders->links() }}
        </ul>

    </div>
@endsection

@section('scripts')

@endsection
