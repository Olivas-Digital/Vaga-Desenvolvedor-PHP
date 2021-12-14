@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('auth_header', 'Redefinir Senha')

@section('auth_body')

    @if(session('status'))
        <div class="alert alert-success">
            Enviamos um link de redefinição de senha para seu email.
        </div>
    @endif

    <form action="email" method="post">
        @csrf

        {{-- Email field --}}
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" placeholder="E-mail" autofocus>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        {{-- Send reset link button --}}
        <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
            <span class="fas fa-share-square"></span>
            Enviar E-mail
        </button>

    </form>

@stop
