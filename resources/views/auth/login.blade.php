@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stop

@section('auth_header', 'Efetue o login')

@section('auth_body')
    <div id="app">
        <login-component csrf_token="{{ @csrf_token() }}" :errors="{{ $errors }}" old-email="{{ old('email') }}"></login-component>
    </div>
@stop

@section('auth_footer')
    {{-- Password reset link --}}
    <p class="my-0">
        <a href="password/reset">
            Esqueceu a senha?
        </a>
    </p>

    {{-- Register link --}}
    <p class="my-0">
        <a href="register">
            Não possui conta? Cadastre-se!
        </a>
    </p>
@stop
