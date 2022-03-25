@extends('layouts.all_users')

@section('title', 'Thank you')

@section('styles')


@endsection

@section('content')

    @include('partials.hero')
    <section class="order_details section-margin--small">
        <div class="container">
            <h3 class="text-center">Thank you for your order!</h3>
            <p class="text-center billing-alert">Please, check your email for order details. Operators will contact you shortly via email or phone.</p>

        </div>
    </section>

@endsection

@section('scripts')
    @if(Session::has('order_created'))
    <script>
        new ThankYou();
    </script>
        @php Session::forget('order_created') @endphp

    @endif
@endsection
