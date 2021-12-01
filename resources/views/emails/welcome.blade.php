@component('mail::message')
# Welcome!!! {{$user->firstname}}  {{$user->lastname }}
You have been register as an admin to use the platform. You log in credential are listed below<br>
Email: {{$user->email}}<br>
Password: {{$user->password}}<br>
<a href="https://leica.local/login">Click here to login</a><br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
