{{-- @component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent --}}

<h1>{{$user->full_name}}</h1>
<h1>{{$user->message}}</h1>
