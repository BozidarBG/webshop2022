@extends('layouts.admin')
@section('styles')

@endsection

@section('content')
    <div class="col-12">
        <!-- Table -->
        <div class="card card-primary">
            <div class="card-header ">
                <h3 class="card-title">Edit coupon</h3>
            </div>

            <!-- /.card-header -->
            <!-- form start -->
            <form method="POST" action="{{route('admin.coupons.update', $coupon)}}">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Code</label>
                                <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{$coupon->code}}">
                                @error('code')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Value</label>
                                <input type="text" name="value" class="form-control @error('value') is-invalid @enderror" value="{{$coupon->value}}">
                                @error('value')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Valid from</label>
                                <input type="date" name="valid_from" class="form-control @error('valid_from') is-invalid @enderror" value="{{\Carbon\Carbon::parse($coupon->valid_from)->format('Y-m-d')}}">
                                @error('valid_from')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Type</label>
                                <select name="type" class="form-control @error('type') is-invalid @enderror">
                                    <option value="">Select one</option>
                                    <option value="fixed" @if("fixed" == $coupon->type)) selected @endif>Fixed</option>
                                    <option value="percent" @if("percent" == $coupon->type)) selected @endif>Percent</option>
                                </select>
                                @error('type')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Cart Value</label>
                                <input type="text" name="cart_value" class="form-control @error('cart_value') is-invalid @enderror"  value="{{$coupon->cart_value}}">
                                @error('cart_value')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Valid until</label>
                                <input type="date" name="valid_until" class="form-control @error('valid_until') is-invalid @enderror" value="{{\Carbon\Carbon::parse($coupon->valid_until)->format('Y-m-d')}}">
                                @error('valid_until')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-dark">Update</button>
                </div>
            </form>
        </div>

    </div>

@endsection
@section('scripts')



@endsection

