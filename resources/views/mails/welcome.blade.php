@component('mail::message')
# Olá {{ $name }}!

Seja bem vindo ao {{  config('app.name') }}, entre em nosso site clicando no botão abaixo:

@component('mail::button', ['url' => config('app.url')])
Acessar Site
@endcomponent

Atenciosamente,<br>
{{ config('app.name') }}
@endcomponent
