@component('mail::message')
# Welcome!!! {{$user->firstname}}  {{$user->lastname }}
You have been registered to use the platform. Your login credentials are listed below<br>
Email: {{$user->email}}<br>
Password: {{$user->password}}<br>
<a href="https://leica.local/login">Click here to login</a><br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
