@extends('layouts.admin')
@section('styles')

@endsection

@section('content')
    @include('partials.success_msg')
    <div class="col-12">
        <!-- Table -->
        <div class="card card-info">
            <div class="card-header ">
                <h3 class="card-title">Add new coupon</h3>
            </div>

                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="{{route('admin.coupons.store')}}">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Code</label>
                                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" placeholder="Code" value="{{old('code')}}">
                                    @error('code')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Value</label>
                                    <input type="text" name="value" class="form-control @error('value') is-invalid @enderror" placeholder="Value" value="{{old('value')}}">
                                    @error('value')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Valid from</label>
                                    <input type="date" name="valid_from" class="form-control @error('valid_from') is-invalid @enderror" value="{{old('valid_from')}}">
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
                                        <option value="fixed" @if("fixed" == old('type')) selected @endif>Fixed</option>
                                        <option value="percent" @if("percent" == old('type')) selected @endif>Percent</option>
                                    </select>
                                    @error('type')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Cart Value</label>
                                    <input type="text" name="cart_value" class="form-control @error('cart_value') is-invalid @enderror" placeholder="Cart value" value="{{old('cart_value')}}">
                                    @error('cart_value')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Valid until</label>
                                    <input type="date" name="valid_until" class="form-control @error('valid_until') is-invalid @enderror" value="{{old('valid_until')}}">
                                    @error('valid_until')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
        </div>

    </div>

@endsection
@section('scripts')



@endsection

