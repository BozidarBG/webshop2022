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
                        <h3>Forgot your password?</h3>
                        <div class="m-4 text-sm text-gray-600">
                            {{ __('No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                        </div>
                        @if(session()->has('status'))
                            <div class="my-4 font-medium text-sm text-success">
                                {{session()->get('status')}}
                            </div>
                        @endif
                        <form class="row login_form" action="{{ route('password.email') }}" method="POST">
                            @csrf
                            <div class="col-md-12 form-group">
                                <input type="text" class="form-control @error('email')alert alert-danger @enderror" id="email" name="email" placeholder="Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address'" required>
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-12 form-group">
                                <button type="submit" value="submit" class="button button-login w-100">Request password reset</button>
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







