@extends('layouts.all_users')

@section('title', 'register')

@section('styles')

@endsection

@section('content')


<section class="login_box_area section-margin">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="login_box_img">
                    <div class="hover">
                        <h4>Already have an account?</h4>
                        <p>There are advances being made in science and technology everyday, and a good example of this is the</p>
                        <a class="button button-account" href="{{route('login')}}">Login Now</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="login_form_inner register_form_inner">
                    <h3>Create an account</h3>
                    <form class="row login_form" action="{{route('register.store')}}" id="register_form" method="POST">
                        @csrf
                        <div class="col-md-12 form-group ">
                            <input type="text" class="form-control @error('name')alert alert-danger @enderror" id="name" name="name" placeholder="Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Name'" required value="{{old('name')}}">
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-12 form-group">
                            <input type="text" class="form-control @error('email')alert alert-danger @enderror" id="email" name="email" placeholder="Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address'" required value="{{old('email')}}">
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="password" class="form-control @error('password')alert alert-danger @enderror" id="password" name="password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'" required>
                            @error('password')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12 form-group">
                            <input type="password" class="form-control @error('password_confirmation')alert alert-danger @enderror" id="confirmPassword" name="password_confirmation" placeholder="Confirm Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Confirm Password'" required>
                        </div>

                        <div class="col-md-12 form-group mt-5">
                            <button type="submit" value="submit" class="button button-register w-100">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
    <script>
        new BaseCart();
    </script>
@endsection
