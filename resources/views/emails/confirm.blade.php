

<x-mail::message>
# Hello {{$user->name}}

You changed your email. So we want to verify this new address. Please use the button below:

<x-mail::button :url="route('verify',$user->verification_token)">
Verify Account</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

