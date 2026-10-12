@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')

<section class="auth-section">

    <div class="auth-card">

        <div class="auth-heading">

            <div class="auth-icon">

                <svg viewBox="0 0 24 24">
                    <path
                        d="M12 2a5 5 0 1 1 0 10 5 5 0 0 1 0-10Zm0 12c5.33 0 8 2.67 8 5v2H4v-2c0-2.33 2.67-5 8-5Z"
                    />
                </svg>

            </div>

            <h1>
                Inicio de sesión
            </h1>

            <p>
                Ingresa con tu cuenta institucional.
            </p>

        </div>

        <form
            method="POST"
            action="{{ route('login.post') }}"
            class="form-stack"
        >

            @csrf

            <div class="form-group">

                <label for="email">
                    Correo electrónico
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="usuario@institucion.edu"
                    required
                    autofocus
                >

            </div>

            <div class="form-group">

                <label for="password">
                    Contraseña
                </label>

                <div class="password-wrapper">

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Ingresa tu contraseña"
                        required
                        data-password-input
                    >

                    <button
                        type="button"
                        class="password-toggle"
                        data-password-toggle
                        aria-label="Mostrar u ocultar contraseña"
                    >

                        <svg viewBox="0 0 24 24">
                            <path
                                d="M12 5c5.5 0 9.5 4.5 10.7 6.2a1.3 1.3 0 0 1 0 1.6C21.5 14.5 17.5 19 12 19S2.5 14.5 1.3 12.8a1.3 1.3 0 0 1 0-1.6C2.5 9.5 6.5 5 12 5Zm0 2c-4 0-7.15 3.04-8.64 5C4.85 13.96 8 17 12 17s7.15-3.04 8.64-5C19.15 10.04 16 7 12 7Zm0 2.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5Z"
                            />
                        </svg>

                    </button>

                </div>

            </div>

            <button
                type="submit"
                class="button button-primary button-full"
            >
                Entrar
            </button>

        </form>

        <div class="auth-back">

            <a href="{{ route('home') }}">
                Volver a la página principal
            </a>

        </div>

    </div>

</section>

@endsection