@extends('layouts.admin')
@section('styles')
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" />
    <style>

    </style>
@endsection

@section('content')
    @include('partials.succes_msg')
    <div class="col-12">
    <div class="card card-primary" id="create_div">
            <div class="card-header">
                <h3 class="card-title">Add new employee</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{route('admin.employees.store')}}" method="POST" >
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{old('name')}}">
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{old('email')}}">
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Role(s)</label>
                        <div class="select2-purple">
                            <select class="select2 select2-hidden-accessible" name="roles[]" multiple=""  data-dropdown-css-class="select2-purple" style="width: 100%;" data-select2-id="15" tabindex="-1" aria-hidden="true">
                               @foreach($roles as $role)
                                   <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                            @error('roles')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" id="create_btn">Create</button>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>

    </div>

@endsection
@section('scripts')
    <script src="{{asset('js/select2.full.min.js')}}"></script>
    <script>
        $('.select2').select2();

    </script>
@endsection




