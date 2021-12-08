@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Home</h1>
@stop

@section('content')
<home-component status="{{ session('status') }}"></home-component>
@stop

