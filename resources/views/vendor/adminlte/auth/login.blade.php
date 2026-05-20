@extends('adminlte::master')

@php
    $loginUrl = View::getSection('login_url') ?? config('adminlte.login_url', 'login');
    $registerUrl = View::getSection('register_url') ?? config('adminlte.register_url', 'register');
    $passResetUrl = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset');
    $dashboardUrl = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home');

    if (config('adminlte.use_route_url', false)) {
        $loginUrl = $loginUrl ? route($loginUrl) : '';
        $registerUrl = $registerUrl ? route($registerUrl) : '';
        $passResetUrl = $passResetUrl ? route($passResetUrl) : '';
        $dashboardUrl = $dashboardUrl ? route($dashboardUrl) : '';
    } else {
        $loginUrl = $loginUrl ? url($loginUrl) : '';
        $registerUrl = $registerUrl ? url($registerUrl) : '';
        $passResetUrl = $passResetUrl ? url($passResetUrl) : '';
        $dashboardUrl = $dashboardUrl ? url($dashboardUrl) : '';
    }
@endphp

@section('adminlte_css_pre')
    <style>
        /* === LOGIN PAGE === */
        .login-page {
            background: linear-gradient(135deg, #13322B 0%, #0a1f1a 100%) !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-height: 100vh !important;
            padding: 20px !important;
        }

        .login-wrapper {
            width: 100%;
            max-width: 520px;
            margin: 0 auto;
            animation: loginFadeIn 0.6s ease-out;
        }

        @keyframes loginFadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.4);
            overflow: hidden;
            padding: 45px 40px 35px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 10px;
        }

        .login-gobierno {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 24px;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f0f0f0;
        }

        .login-gobierno img {
            height: 55px;
            width: auto;
            object-fit: contain;
        }

        .login-gobierno .divider {
            width: 1px;
            height: 40px;
            background: #e0e0e0;
        }

        .login-brand {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
        }

        .login-brand-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 4px 15px rgba(19, 50, 43, 0.15);
        }

        .login-brand-text {
            height: 32px;
            width: auto;
            object-fit: contain;
        }

        .login-title {
            text-align: center;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            color: var(--gob-verde, #13322B);
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 25px;
            position: relative;
        }

        .login-title::after {
            content: '';
            display: block;
            width: 50px;
            height: 3px;
            background: var(--gob-oro, #988256);
            margin: 10px auto 0;
            border-radius: 2px;
        }

        .login-body .form-group {
            margin-bottom: 1.25rem;
        }

        .login-body .input-group {
            margin-bottom: 0;
        }

        .login-body .input-group-text {
            background: transparent;
            border: 1.5px solid #e2e8f0;
            border-right: none;
            border-radius: 10px 0 0 10px;
            color: var(--gob-verde, #13322B);
        }

        .login-body .form-control {
            border: 1.5px solid #e2e8f0;
            border-left: none;
            border-radius: 0 10px 10px 0;
            padding: 0.65rem 1rem;
            height: auto;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .login-body .form-control:focus {
            border-color: var(--gob-oro, #988256);
            box-shadow: 0 0 0 4px rgba(152, 130, 86, 0.15);
        }

        .login-body .input-group:focus-within .input-group-text {
            border-color: var(--gob-oro, #988256);
        }

        .login-body .custom-checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 4px;
            cursor: pointer;
        }

        .login-body .custom-checkbox input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--gob-verde, #13322B);
            cursor: pointer;
            border-radius: 4px;
        }

        .login-body .custom-checkbox label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #4D4D4D;
            margin: 0;
            cursor: pointer;
            padding-left: 0;
        }

        .login-body .btn-login {
            background: linear-gradient(135deg, #13322B 0%, #0d241f 100%);
            border: none;
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: 700;
            font-size: 0.95rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #fff;
            box-shadow: 0 4px 15px rgba(19, 50, 43, 0.3);
            transition: all 0.3s;
            width: 100%;
            cursor: pointer;
        }

        .login-body .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(19, 50, 43, 0.4);
            filter: brightness(1.1);
        }

        .login-body .btn-login i {
            margin-right: 8px;
        }

        .login-footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #f0f0f0;
        }

        .login-footer a {
            color: var(--gob-oro, #988256);
            font-weight: 600;
            font-size: 0.85rem;
            text-decoration: none;
            transition: color 0.3s;
        }

        .login-footer a:hover {
            color: #6b5a3a;
            text-decoration: underline;
        }

        .login-footer .gobierno-footer {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            margin-top: 15px;
            font-size: 0.7rem;
            color: #999;
            font-weight: 500;
        }

        .login-footer .gobierno-footer img {
            height: 24px;
            opacity: 0.6;
        }
    </style>
@stop

@section('classes_body')login-page@stop

@section('body')
    <div class="login-wrapper">
        <div class="login-card">

            {{-- Logos gubernamentales --}}
            <div class="login-header">
                <div class="login-gobierno">
                    <img src="{{ asset('img/logos/gobierno.png') }}"
                         alt="Gobierno de México">
                    <div class="divider"></div>
                    <img src="{{ asset('img/logos/logoAgricultura.png') }}"
                         alt="Secretaría de Agricultura y Desarrollo Rural">
                </div>

                <div class="login-brand">
                    <img class="login-brand-icon"
                         src="{{ asset('img/logos/logoAlimentacionBienestar1.png') }}"
                         alt="Alimentación para el Bienestar">
                    <img class="login-brand-text"
                         src="{{ asset('img/logos/letrasAlimentacionBienestar.png') }}"
                         alt="Alimentación para el Bienestar">
                </div>
            </div>

            {{-- Título --}}
            <div class="login-title">
                {{ __('adminlte::adminlte.login_message') }}
            </div>

            {{-- Formulario --}}
            <div class="login-body">
                <form action="{{ $loginUrl }}" method="post">
                    @csrf

                    {{-- Email --}}
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
                                   placeholder="{{ __('adminlte::adminlte.email') }}"
                                   autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </span>
                            </div>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="{{ __('adminlte::adminlte.password') }}">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Remember + Submit --}}
                    <div class="row align-items-center">
                        <div class="col-7">
                            <div class="custom-checkbox"
                                 title="{{ __('adminlte::adminlte.remember_me_hint') }}">
                                <input type="checkbox" name="remember" id="remember"
                                       {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember">
                                    {{ __('adminlte::adminlte.remember_me') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-5 text-right">
                            <button type="submit" class="btn-login">
                                <i class="fas fa-sign-in-alt"></i>
                                {{ __('adminlte::adminlte.sign_in') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Footer --}}
            <div class="login-footer">
                @if($passResetUrl)
                    <p class="my-0">
                        <a href="{{ $passResetUrl }}">
                            <i class="fas fa-question-circle"></i>
                            {{ __('adminlte::adminlte.i_forgot_my_password') }}
                        </a>
                    </p>
                @endif

                <div class="gobierno-footer">
                    <img src="{{ asset('img/logos/gobierno.png') }}" alt="">
                    <span>Gobierno de México</span>
                </div>
            </div>

        </div>
    </div>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
@stop
