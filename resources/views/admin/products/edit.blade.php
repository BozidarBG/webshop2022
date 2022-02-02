@extends('layouts.admin')
@section('styles')
    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <style>

    </style>
@endsection

@section('content')
    @include('partials.succes_msg')
{{--    @include('partials.errors_in_div')--}}
    <div class="col-12">
        <!-- Table -->
        <div class="card card-info">
            <div class="card-header ">
                <h3 class="card-title">Edit product</h3>
            </div>

                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="{{route('admin.products.update', [$product])}}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Product name" value="{{$product->name}}">
                                    @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Code from accountant dept.</label>
                                    <input type="text" name="acc_code" class="form-control @error('acc_code') is-invalid @enderror" placeholder="Account code" value="{{$product->acc_code}}">
                                    @error('acc_code')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Category (choose one)</label>
                                    <select name="category" class="form-control @error('category') is-invalid @enderror">
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}" @if($category->id == $product->category_id) selected @endif>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Price </label>
                                    <input type="number" min="0" step="any"  name="price" class="form-control @error('price') is-invalid @enderror" placeholder="Price" value="{{$product->price/100}}">
                                    @error('price')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Action price (if any)</label>
                                    <input type="number" min="0" step="any" name="action_price" class="form-control @error('number') is-invalid @enderror" placeholder="Action price if any" value="{{$product->action_price/100}}">
                                    @error('action_price')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Stock quantity</label>
                                    <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" placeholder="0" value="{{$product->stock}}">
                                    @error('stock')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Short description (not more than 255 characters)</label>
                                    <input type="text" name="short_description" class="form-control @error('short_description') is-invalid @enderror" placeholder="Shortly about this product"
                                           value="{{$product->short_desc}}">
                                    @error('short_description')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea id="summernote" name="description"  class="form-control @error('description') is-invalid @enderror" >{{$product->description}}</textarea>
                                    @error('description')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Image</label>
                                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" placeholder="Product image" >
                                    <img src="{{asset($product->image)}}" width="70px">
                                    @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>


    </div>

@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height:150,
            tabsize:2,
            toolbar:[
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['view', [ 'codeview']]
            ],
        });
    });


</script>
@endsection

