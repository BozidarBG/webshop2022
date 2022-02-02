@extends('layouts.admin')
@section('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

    <style>

    </style>
@endsection

@section('content')
    @include('partials.succes_msg')

    <div class="col-12" >
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Application Settings</h3>
            </div>
            <div class="card-body">
                <form action="{{route('admin.settings.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Application name</label>
                                <input type="text" name="app_name" class="form-control @error('app_name') is-invalid @enderror" value="{{$settings->app_name}}" disabled>
                                @error('app_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{$settings->address}}" disabled>
                                @error('address')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{$settings->email}}" disabled>
                                @error('email')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Phone 1</label>
                                <input type="text" name="phone1" class="form-control @error('phone1') is-invalid @enderror" value="{{$settings->phone1}}" disabled>
                                @error('phone1')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Phone 2</label>
                                <input type="text" name="phone2" class="form-control @error('phone2') is-invalid @enderror" value="{{$settings->phone2}}" disabled>
                                @error('phone2')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Phone 3</label>
                                <input type="text" name="phone3" class="form-control @error('phone3') is-invalid @enderror" value="{{$settings->phone3}}" disabled>
                                @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Website address</label>
                                <input type="text" name="website" class="form-control @error('website') is-invalid @enderror" value="{{$settings->website}}" disabled>
                                @error('webiste')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Author</label>
                                <input type="text" name="author" class="form-control @error('author') is-invalid @enderror" value="{{$settings->author}}" disabled>
                                @error('author')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" name="description" class="form-control @error('description') is-invalid @enderror" value="{{$settings->description}}" disabled>
                                @error('description')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Keywords (comma separated)</label>
                                    <input type="text" name="keywords" class="form-control @error('keywords') is-invalid @enderror" value="{{$settings->keywords}}" disabled>
                                    @error('keywords')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Generator (application powered by)</label>
                                    <input type="text" name="generator" class="form-control @error('generator') is-invalid @enderror" value="{{$settings->generator}}" disabled>
                                    @error('generator')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        
                        </div>
                        <div class="row">
                            <div class="col-12">
                            <div class="form-group">
                                <label>About Us</label>
                                <textarea id="" name="about_us"  class="form-control @error('about_us') is-invalid @enderror" disabled>{!! $settings->about_us !!}</textarea>
                                @error('about_us')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Favicon</label>
                                    <input type="file" name="favicon" class="form-control @error('favicon') is-invalid @enderror" disabled>
                                    <img src="{{asset($settings->favicon)}}" width="50px" class="mt-2">
                                    @error('favicon')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Logo</label>
                                    <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror" disabled>
                                    <img src="{{asset($settings->logo)}}" width="130px" class="mt-2">
                                    @error('logo')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <button class="btn btn-danger" role="button" id="edit_btn">Edit Settings</button>
                                    <button class="btn btn-primary d-none mr-4" role="submit" id="update_btn">Update</button>
                                    <button class="btn btn-success d-none"  id="cancel_btn">Cancel Update</button>
                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>


@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>
    const prepareToEdit=()=>{
        let inputs=document.getElementsByTagName('input');
        let textarea=document.getElementsByTagName('textarea')[0];
        textarea.removeAttribute('disabled');
        textarea.setAttribute('id', 'summernote')
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

        for(let i=0; i<inputs.length; i++){
            inputs[i].removeAttribute('disabled');
        }
        document.getElementById('edit_btn').classList.add('d-none');
        document.getElementById('update_btn').classList.remove('d-none');
        document.getElementById('cancel_btn').classList.remove('d-none');

        const cancelEdit=()=>{
            textarea.setAttribute('disabled', true);
            //textarea.removeAttribute('id');
            $('#summernote').summernote('destroy');
            for(let i=0; i<inputs.length; i++){
            inputs[i].setAttribute('disabled', true);
            document.getElementById('edit_btn').classList.remove('d-none');
            document.getElementById('update_btn').classList.add('d-none');
            document.getElementById('cancel_btn').classList.add('d-none');
        }

        }
        new Listener('click', 'cancel_btn', 'id', cancelEdit)

    }

    new Listener('click', 'edit_btn', 'id', prepareToEdit)

</script>
@endsection

