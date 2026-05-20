@extends('adminlte::master')

@php
    $passEmailUrl = View::getSection('password_email_url') ?? config('adminlte.password_email_url', 'password/email');
    $loginUrl = View::getSection('login_url') ?? config('adminlte.login_url', 'login');

    if (config('adminlte.use_route_url', false)) {
        $passEmailUrl = $passEmailUrl ? route($passEmailUrl) : '';
        $loginUrl = $loginUrl ? route($loginUrl) : '';
    } else {
        $passEmailUrl = $passEmailUrl ? url($passEmailUrl) : '';
        $loginUrl = $loginUrl ? url($loginUrl) : '';
    }
@endphp

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@stop

@section('classes_body', 'login-page')

@section('body')
    <div class="login-wrapper">

        <div class="login-side login-side-left">
            <img src="{{ asset('img/logos/gobierno.png') }}"
                 alt="Gobierno de México">
        </div>

        <div class="login-card">

            <div class="login-header">
                <div class="login-brand">
                    <img class="login-brand-icon"
                         src="{{ asset('img/logos/logoAlimentacionBienestar1.png') }}"
                         alt="Alimentación para el Bienestar">
                    <img class="login-brand-text"
                         src="{{ asset('img/logos/letrasAlimentacionBienestar.png') }}"
                         alt="Alimentación para el Bienestar">
                </div>
            </div>

            <div class="login-title">
                RESTABLECER CONTRASEÑA
            </div>

            <div class="login-body">

                @if(session('status'))
                    <div class="alert alert-success" style="background:rgba(255,255,255,0.15); color:#fff; border:none; border-radius:12px; font-size:0.85rem; padding:12px 16px; margin-bottom:20px;">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{ $passEmailUrl }}" method="post">
                    @csrf

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </span>
                            </div>
                            <input type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}"
                                   placeholder="Correo electrónico"
                                   autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn-login" style="width:100%;">
                        <i class="fas fa-share-square"></i>
                        Enviar enlace
                    </button>
                </form>
            </div>

            <div class="login-footer">
                <p class="my-0">
                    <a href="{{ $loginUrl }}">
                        <i class="fas fa-arrow-left"></i>
                        Volver al inicio de sesión
                    </a>
                </p>

                <div class="gobierno-branding">
                    Gobierno de México
                </div>
            </div>

        </div>

        <div class="login-side login-side-right">
            <img src="{{ asset('img/logos/logoAgricultura.png') }}"
                 alt="Secretaría de Agricultura y Desarrollo Rural">
        </div>

    </div>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
@stop
