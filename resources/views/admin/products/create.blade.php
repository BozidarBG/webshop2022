@extends('layouts.admin')
@section('styles')
    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <style>

    </style>
@endsection

@section('content')
    @include('partials.success_msg')
    <div class="col-12">
        <!-- Table -->
        <div class="card card-info">
            <div class="card-header ">
                <h3 class="card-title">Add new product</h3>
            </div>

                <form method="POST" action="{{route('admin.products.store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Product name" value="{{old('name')}}">
                                    @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Code from accountant dept.</label>
                                    <input type="text" name="acc_code" class="form-control @error('acc_code') is-invalid @enderror" placeholder="Account code" value="{{old('acc_code')}}">
                                    @error('acc_code')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Category (choose one)</label>
                                    <select name="category" class="form-control @error('category') is-invalid @enderror">
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}" @if($category->id == old('category')) selected @endif>{{$category->name}}</option>
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
                                    <input type="number" min="0" step="any"  name="regular_price" class="form-control @error('regular_price') is-invalid @enderror" placeholder="Price" value="{{old('regular_price')}}" @if(!auth()->user()->isProductManager()) disabled @endif>
                                    @error('regular_price')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Action price (if any)</label>
                                    <input type="number" min="0" step="any"  name="action_price" class="form-control @error('number') is-invalid @enderror" placeholder="Action price if any" value="{{old('action_price')}}" @if(!auth()->user()->isProductManager()) disabled @endif>
                                    @error('action_price')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Stock quantity</label>
                                    <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" placeholder="0" value="{{old('stock')}}" @if(!auth()->user()->isProductManager()) disabled @endif>
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
                                    <input type="text" name="short_description" class="form-control @error('short_description') is-invalid @enderror" placeholder="Shortly about this product" value="{{old('short_description')}}">
                                    @error('short_description')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea id="summernote" name="description"  class="form-control @error('description') is-invalid @enderror" >{{old('description')}}</textarea>
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
                                    @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        @if(auth()->user()->isProductManager())
                            <div class="row mt-3">
                                <div class="col-6">
                                    <div class="custom-control custom-checkbox checkbox-xl">
                                        <input type="checkbox" class="custom-control-input" id="checkbox_publish" @if($product->published) checked="" @endif name="published">
                                        <label class="custom-control-label"  id="checkbox_label" for="checkbox_publish">@if($product->published) Product is published. Check to un-publish it. @else Product is not published. Check to publish it. @endif</label>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Create</button>
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
@if(auth()->user()->isProductManager())
    <script>
        let checkbox_btn=document.getElementById('checkbox_publish');
        let checkbox_label=document.getElementById('checkbox_label');
        checkbox_btn.addEventListener('change', (e)=>{
            if(e.target.checked){
                checkbox_label.textContent="Product is published. Check to un-publish it";
            }else{
                checkbox_label.textContent="Product is not published. Check to publish it.";
            }
        });
    </script>
@endif
@endsection

