@component('mail::message')
<h2>Hello {{$name}},</h2>
{!! Str::markdown($body) !!}
Thanks,<br>
{{ config('app.name') }}<br>
Boxit Team.
@endcomponent