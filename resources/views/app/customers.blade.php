@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
    <h1>Clientes</h1>
@stop

@section('content')
    <customers-component url="{{ config('app.url') }}" :customer-types="{{ $customerTypes }}"></customers-component>
@stop