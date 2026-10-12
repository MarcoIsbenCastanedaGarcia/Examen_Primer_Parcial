<header class="public-header">

    <div class="container navbar">

        <a
            href="{{ route('home') }}"
            class="brand"
        >

            <span class="brand-icon">
                <svg
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                >
                    <path
                        d="M4 5.5A2.5 2.5 0 0 1 6.5 3h11A2.5 2.5 0 0 1 20 5.5v8A2.5 2.5 0 0 1 17.5 16h-11A2.5 2.5 0 0 1 4 13.5v-8ZM2.5 18h19a.5.5 0 0 1 .45.72A3 3 0 0 1 19.26 20H4.74a3 3 0 0 1-2.69-1.28A.5.5 0 0 1 2.5 18Z"
                    />
                </svg>
            </span>

            <span>
                Préstamo de Equipos
            </span>

        </a>

        <button
            class="mobile-menu-button"
            type="button"
            data-menu-toggle
            aria-label="Abrir navegación"
        >
            <svg viewBox="0 0 24 24">
                <path
                    d="M4 6h16v2H4V6Zm0 5h16v2H4v-2Zm0 5h16v2H4v-2Z"
                />
            </svg>
        </button>

        <nav
            class="public-navigation"
            data-menu
        >

            <a href="{{ route('home') }}#informacion">
                Información
            </a>

            <a href="{{ route('home') }}#funciones">
                Funciones
            </a>

            <a href="{{ route('home') }}#reglas">
                Reglas de préstamo
            </a>

            <a href="{{ route('home') }}#contacto">
                Contacto
            </a>

            <button
                type="button"
                class="theme-button"
                data-theme-toggle
                aria-label="Cambiar modo de color"
            >

                <svg
                    class="theme-icon-light"
                    viewBox="0 0 24 24"
                >
                    <path
                        d="M12 4V2h1v2h-1Zm0 18v-2h1v2h-1ZM4.22 5.64 2.8 4.22l.71-.71 1.42 1.42-.71.71Zm15.56 12.72-1.42-1.42.71-.71 1.42 1.42-.71.71ZM4 11v1H2v-1h2Zm18 0v1h-2v-1h2ZM4.93 18.36 3.51 19.78l-.71-.71 1.42-1.42.71.71ZM20.49 4.93l-1.42 1.42-.71-.71 1.42-1.42.71.71ZM12.5 7A4.5 4.5 0 1 1 8 11.5 4.5 4.5 0 0 1 12.5 7Z"
                    />
                </svg>

            </button>

            <a
                href="{{ route('login') }}"
                class="button button-primary"
            >
                Iniciar sesión
            </a>

        </nav>

    </div>

</header>