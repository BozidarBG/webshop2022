@extends('layouts.all_users')

@section('title', 'login')

@section('styles')

@endsection

@section('content')


    <section class="login_box_area section-margin">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="login_box_img">
                        <div class="hover">
                            <h4>New to our website?</h4>
                            <p>There are advances being made in science and technology everyday, and a good example of this is the</p>
                            <a class="button button-account" href="{{route('register')}}">Create an Account</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="login_form_inner">
                        <h3>Reset your password</h3>


                        <form class="row login_form" action="{{route('password.update')}}" method="POST">
                            @csrf
                            <!-- Password Reset Token -->
                                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                <div class="col-md-12 form-group">
                                    <input type="text" value="{{old('email')}}" class="form-control @error('email')alert alert-danger @enderror" id="email" name="email" placeholder="Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address'" required>
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
                                    <button type="submit" value="submit" class="button button-register w-100">Reset Password</button>
                                </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')

@endsection
