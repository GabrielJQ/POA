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
        html, body.login-page {
            height: 100% !important;
        }

        .login-page {
            background: #13322B !important;
            background: linear-gradient(135deg, #13322B 0%, #0a1f1a 100%) !important;
            background-color: #13322B !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            min-height: 100vh !important;
            padding: 20px !important;
            position: relative;
        }

        .login-wrapper {
            position: relative;
            width: 100%;
            max-width: 1100px;
            min-height: 80vh;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: loginFadeIn 0.6s ease-out;
        }

        @keyframes loginFadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-side {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1;
        }

        .login-side img {
            height: auto;
            width: auto;
            object-fit: contain;
            filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.2));
        }

        .login-side-left {
            left: 0;
        }

        .login-side-left img {
            max-height: 150px;
            max-width: 160px;
        }

        .login-side-right {
            right: 0;
        }

        .login-side-right img {
            max-height: 130px;
            max-width: 200px;
        }

        .login-card {
            background: #691C32;
            border-radius: 24px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.4);
            overflow: hidden;
            padding: 45px 40px 35px;
            width: 100%;
            max-width: 480px;
            flex-shrink: 0;
        }

        .login-header {
            text-align: center;
            margin-bottom: 8px;
        }

        .login-brand {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .login-brand-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            background: white;
            padding: 4px;
        }

        .login-brand-text {
            height: 32px;
            width: auto;
            object-fit: contain;
            filter: brightness(0) invert(1);
        }

        .login-title {
            text-align: center;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            color: #ffffff;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 25px;
            position: relative;
        }

        .login-title::after {
            content: '';
            display: block;
            width: 50px;
            height: 3px;
            background: #988256;
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
            background: rgba(255, 255, 255, 0.95);
            border: none;
            border-radius: 12px 0 0 12px;
            color: #691C32;
            padding: 0.65rem 1rem;
        }

        .login-body .form-control {
            background: rgba(255, 255, 255, 0.95);
            border: none;
            border-left: none;
            border-radius: 0 12px 12px 0;
            padding: 0.65rem 1rem 0.65rem 0;
            height: auto;
            font-size: 0.9rem;
            color: #333;
            transition: all 0.3s;
        }

        .login-body .form-control:focus {
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(152, 130, 86, 0.25);
        }

        .login-body .input-group:focus-within .input-group-text {
            background: #ffffff;
        }

        .login-body .form-control::placeholder {
            color: #999;
            font-weight: 400;
        }

        .login-body .invalid-feedback {
            color: #ffc107;
            font-weight: 600;
            font-size: 0.78rem;
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
            accent-color: #988256;
            cursor: pointer;
            border-radius: 4px;
        }

        .login-body .custom-checkbox label {
            font-weight: 500;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.85);
            margin: 0;
            cursor: pointer;
            padding-left: 0;
        }

        .login-body .btn-login {
            background: linear-gradient(135deg, #988256 0%, #7a6a44 100%);
            border: none;
            border-radius: 12px;
            padding: 0.75rem 2rem;
            font-weight: 700;
            font-size: 0.9rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #fff;
            box-shadow: 0 4px 20px rgba(152, 130, 86, 0.4);
            transition: all 0.3s;
            cursor: pointer;
            white-space: nowrap;
        }

        .login-body .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(152, 130, 86, 0.5);
            filter: brightness(1.1);
        }

        .login-body .btn-login i {
            margin-right: 8px;
        }

        .login-footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
        }

        .login-footer a {
            color: rgba(255, 255, 255, 0.75);
            font-weight: 500;
            font-size: 0.82rem;
            text-decoration: none;
            transition: color 0.3s;
        }

        .login-footer a:hover {
            color: #ffffff;
            text-decoration: underline;
        }

        .login-footer .gobierno-branding {
            margin-top: 15px;
            font-size: 0.65rem;
            color: rgba(255, 255, 255, 0.4);
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        @media (max-width: 820px) {
            .login-side-left img {
                max-height: 100px;
                max-width: 120px;
            }

            .login-side-right img {
                max-height: 80px;
                max-width: 140px;
            }
        }

        @media (max-width: 640px) {
            .login-side {
                display: none;
            }

            .login-card {
                max-width: 100%;
                padding: 35px 25px 30px;
            }
        }
    </style>
@stop

@section('classes_body')login-page@stop

@section('body')
    <div class="login-wrapper">

        {{-- Logo izquierdo: Gobierno de México --}}
        <div class="login-side login-side-left">
            <img src="{{ asset('img/logos/gobierno.png') }}"
                 alt="Gobierno de México">
        </div>

        {{-- Card --}}
        <div class="login-card">

            {{-- Logo corporativo --}}
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

            {{-- Título --}}
            <div class="login-title">
                INICIAR SESIÓN
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
                                   placeholder="Correo electrónico"
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
                                   placeholder="Contraseña">
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
                                 title="Mantenerme conectado">
                                <input type="checkbox" name="remember" id="remember"
                                       {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember">
                                    Recordar mis datos
                                </label>
                            </div>
                        </div>
                        <div class="col-5 text-right">
                            <button type="submit" class="btn-login">
                                <i class="fas fa-sign-in-alt"></i>
                                Ingresar
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
                            ¿Olvidaste tu contraseña?
                        </a>
                    </p>
                @endif

                <div class="gobierno-branding">
                    Gobierno de México
                </div>
            </div>

        </div>

        {{-- Logo derecho: Agricultura --}}
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
