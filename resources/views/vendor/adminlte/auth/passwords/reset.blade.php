@extends('adminlte::master')

@php
    $passResetUrl = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset');
    $loginUrl = View::getSection('login_url') ?? config('adminlte.login_url', 'login');

    if (config('adminlte.use_route_url', false)) {
        $passResetUrl = $passResetUrl ? route($passResetUrl) : '';
        $loginUrl = $loginUrl ? route($loginUrl) : '';
    } else {
        $passResetUrl = $passResetUrl ? url($passResetUrl) : '';
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
                NUEVA CONTRASEÑA
            </div>

            <div class="login-body">
                <form action="{{ $passResetUrl }}" method="post">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

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

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </span>
                            </div>
                            <input type="password" name="password" id="reset-password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Nueva contraseña">
                            <div class="input-group-append">
                                <span class="input-group-text toggle-password"
                                      style="cursor:pointer; border-left:none; border-radius:0 12px 12px 0; background:rgba(255,255,255,0.95); color:#691C32; padding:0.65rem 1rem;">
                                    <span class="fas fa-eye"></span>
                                </span>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </span>
                            </div>
                            <input type="password" name="password_confirmation"
                                   class="form-control @error('password_confirmation') is-invalid @enderror"
                                   placeholder="Confirmar contraseña">
                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn-login" style="width:100%;">
                        <i class="fas fa-sync-alt"></i>
                        Restablecer
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
                 alt="Secretaría de Agricultura y Desarrollo Social">
        </div>

    </div>

    <script>
        document.querySelectorAll('.toggle-password').forEach(function (btn) {
            btn.addEventListener('click', function () {
                var input = document.getElementById('reset-password');
                var icon = this.querySelector('.fas');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    </script>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
@stop
