@extends('adminlte::page')

@section('title', 'Vendedores')

@section('content_header')
    <h1>Vendedores</h1>
@stop

@section('content')
    <sellers-component url="{{ config('app.url') }}"></sellers-component>
@stop

