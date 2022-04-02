@component('mail::message')
    # Order Confirmation

    Dear {{$name}},

    Thank you for your order.
    Order confirmation is in attachment.

    If you didn't order from our website, please, contact us about this mistake.

    Best regards,
    {{ $settings->app_name }}
@endcomponent
