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
    @include('partials.confirmation_modal')
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
                        <p>Contacted by: <strong>{{$order->contactedBy->name ?? 'Not contacted'}}</strong></p>
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
        <div class="card p-3">
            <div class="row">
                @if(auth()->user()->isOrdersAdministrator())
                <div class="col-3 px-5">
                    <h3>Change payment status</h3>
                    <h6>Payment status before change:</h6>
                    <h6 class="text-bold">{{$order->payment_status}}</h6>
                    <form action="{{route('admin.orders.update',$order)}}" method="post">
                        @csrf
                        <div class="form-group">
                            <select name="payment_status" class="form-control">
                                <option value="pending" {{$order->payment_status=="pending" ? 'selected' : null}}>Pending</option>
                                <option value="paid" {{$order->payment_status=="paid" ? 'selected' : null}}>Paid</option>
                                <option value="declined" {{$order->payment_status=="declined" ? 'selected' : null}}>Declined</option>
                                <option value="refunded" {{$order->payment_status=="refunded" ? 'selected' : null}}>Refunded</option>
                            </select>
                        </div>
                        @error('payment_status')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <input type="submit" value="Update" class="btn btn-outline-warning">
                    </form>
                </div>


                <div class="col-3 px-5">
                    <h3>Change payment date</h3>
                    <h6>Payment date before change:</h6>
                    <h6 class="text-bold">{{$order->paid_on ? formatDate($order->paid_on) : 'Not Paid'}}</h6>

                    <form action="{{route('admin.orders.update', $order)}}" method="post">
                        @csrf
                        <div class="form-group">
                            <input type="date" class="form-control" name="paid_on">
                        </div>
                        @error('paid_on')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <input type="submit" value="Update" class="btn btn-outline-success">
                    </form>
                </div>

                <div class="col-3 px-5">
                    <h3>Change shipping status</h3>
                    <h6>Shipping status before change:</h6>
                    <h6 class="text-bold">{{\Illuminate\Support\Str::replace('_', ' ',$order->shipping_status)}}</h6>
                    <form action="{{route('admin.orders.update', $order)}}" method="post">
                        @csrf
                        <div class="form-group">
                            <select name="shipping_status" class="form-control">
                                <option value="pending" {{$order->shipping_status=="pending" ? 'selected' : null}}>Pending</option>
                                <option value="in_preparation" {{$order->shipping_status=="in_preparation" ? 'selected' : null}}>In preparation</option>
                                <option value="canceled" {{$order->shipping_status=="canceled" ? 'selected' : null}}>Canceled</option>
                            </select>
                        </div>
                        @error('shipping_status')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <input type="submit" value="Update" class="btn btn-outline-primary">
                    </form>
                </div>
                @endif
                @if(in_array($order->shipping_status, ['in_preparation', 'waiting_for_courier', 'in_transit', 'returned_by_courier']))
                    @if(auth()->user()->isWarehouseManager())
                    <div class="col-3 px-5">
                        <h3>Change shipping status</h3>
                        <h6>Shipping status before change:</h6>
                        <h6 class="text-bold">{{\Illuminate\Support\Str::replace('_', ' ',$order->shipping_status)}}</h6>
                        <form action="{{route('admin.orders.update', $order)}}" method="post">
                            @csrf
                            <div class="form-group">
                                <select name="shipping_status" class="form-control">
                                    <option value="in_preparation" {{$order->shipping_status=="in_preparation" ? 'selected' : null}}>In preparation</option>
                                    <option value="waiting_for_courier" {{$order->shipping_status=="waiting_for_courier" ? 'selected' : null}}>Waiting for Courier</option>
                                    <option value="in_transit" {{$order->shipping_status=="in_transit" ? 'selected' : null}}>In transit to customer</option>
                                    <option value="returned_by_courier" {{$order->shipping_status=="returned_by_courier" ? 'selected' : null}}>Returned by courier</option>
                                </select>
                            </div>
                            @error('shipping_status')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <input type="submit" value="Update" class="btn btn-outline-primary">
                        </form>
                    </div>


                    <div class="col-3 px-5">
                        <h3>Change shipping date</h3>
                        <h6>Shipping date before change:</h6>
                        <h6 class="text-bold">{{$order->shipped_on ? formatDate($order->shipped_on) : 'Not Shipped'}}</h6>
                        <form action="{{route('admin.orders.update', $order)}}" method="post">
                            @csrf
                            <div class="form-group">
                                <input type="date" class="form-control" name="shipped_on">
                            </div>
                            @error('shipped_on')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                            <input type="submit" value="Update" class="btn btn-outline-info">
                        </form>
                    </div>

                @endif
            @endif
            </div>
        </div>
        <div class="card p-3">
            <div class="row">
                <div class="col-12">
                    <h3>Administrator's comments about this order</h3>
                    <p>{!! $order->admin_comment !!}</p>
                    <form action="{{route('admin.orders.update', $order)}}" method="post">
                        @csrf
                        <div class="form-group">
                            <textarea name="admin_comment" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                        @error('admin_comment')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <button class="btn btn-dark" role="button">Update</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card p-3 mt-3">
            <div class="row">
                <div class="col-12">
                    <h3>Has user been contacted if order is COD?</h3>
                    @if(auth()->user()->isOrdersAdministrator())
                        <form action="{{route('admin.orders.update', $order)}}" method="post">
                        @csrf
                        <div class="custom-control custom-checkbox checkbox-xl">
                            <input type="checkbox" class="custom-control-input" id="checkbox_contacted" @if($order->contacted_by) checked="" @endif >
                            <input type="hidden" name="contacted_by" value="{{$order->contacted_by ?  "on" : "off"}}" id="checkbox_value">
                            <label class="custom-control-label"  id="checkbox_label" for="checkbox_contacted">@if($order->contacted_by) User has being contacted. Un-check if you clicked this by mistake @else User has not being contacted. Check if you have contacted user @endif</label>
                            @error('contacted_by')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                            <button class="btn btn-success mt-4" role="button">Update</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
@if(auth()->user()->isOrdersAdministrator())
    <script>
        let checkbox_btn=document.getElementById('checkbox_contacted');
        let checkbox_label=document.getElementById('checkbox_contacted');
        let checkbox_value=document.getElementById('checkbox_value');
        checkbox_btn.addEventListener('change', (e)=>{
            if(e.target.checked){
                checkbox_label.textContent="User has being contacted. Un-check if you clicked this by mistake";
                checkbox_value.value="on";

            }else{
                checkbox_label.textContent="User has not being contacted. Check if you have contacted user";
                checkbox_value.value="off";
            }
        });
    </script>
@endif
@endsection

