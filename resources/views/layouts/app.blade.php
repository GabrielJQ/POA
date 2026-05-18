@extends('adminlte::page')

@section('favicons')
    <link rel="icon" type="image/png" href="{{ asset('brand-icon.png') }}?v=5">
    <link rel="shortcut icon" type="image/png" href="{{ asset('brand-icon.png') }}?v=5">
@stop

@section('meta_tags')
    <link rel="icon" type="image/png" href="{{ asset('brand-icon.png') }}?v=5">
@stop

@section('content_top_nav_left')
    <img src="/img/logos/logoAlimentacionBienestar.png" style="height: 33px; margin-top: 5px; margin-left: 10px;">
@stop

@section('content_top_nav_right')
    <img src="/img/logos/gobierno.png" style="height: 33px; margin-top: 5px; margin-right: 10px;">
@stop
