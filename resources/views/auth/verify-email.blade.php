@extends('layouts.all_users')

@section('title', 'register')

@section('styles')

@endsection

@section('content')


    <section class="login_box_area section-margin">
        <div class="container">
            <div class="row">

                <div class="offset-3 col-lg-6">
                    <div class="login_form_inner register_form_inner">
                        <h3>Almost there...</h3>

                            <div class="row">
                                <div class="col-12 px-4">
                                    Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.
                                </div>
                                @if (session('status') == 'verification-link-sent')
                                    <div class="my-4 font-medium text-sm text-success">
                                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                                    </div>
                                @endif
                                <div class="col-6">
                                    <form class="row login_form" action="{{ route('verification.send') }}" method="POST">
                                        @csrf
                                        <div class="col-md-12 form-group mt-5">
                                            <button type="submit" value="submit" class="button button-register w-100">Resend verification email</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-6">
                                    <form class="row login_form" action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <div class="col-md-12 form-group mt-5">
                                            <button type="submit" class="btn btn-outline-dark w-100">
                                                {{ __('Log Out') }}
                                            </button>
                                        </div>
                                    </form>
                                </div>

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



