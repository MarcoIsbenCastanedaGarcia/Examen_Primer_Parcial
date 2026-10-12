<header class="private-header">

    <div class="container private-header-top">

        <a
            href="{{ route('inventory.index') }}"
            class="brand"
        >

            <span class="brand-icon">

                <svg viewBox="0 0 24 24">
                    <path
                        d="M4 5.5A2.5 2.5 0 0 1 6.5 3h11A2.5 2.5 0 0 1 20 5.5v8A2.5 2.5 0 0 1 17.5 16h-11A2.5 2.5 0 0 1 4 13.5v-8ZM2.5 18h19a.5.5 0 0 1 .45.72A3 3 0 0 1 19.26 20H4.74a3 3 0 0 1-2.69-1.28A.5.5 0 0 1 2.5 18Z"
                    />
                </svg>

            </span>

            <span>
                Control de Equipos
            </span>

        </a>

        <div class="session-area">

            <div class="session-user">

                <span class="session-user-name">
                    {{ auth()->user()->name }}
                </span>

                <span class="role-badge">
                    {{ ucfirst(auth()->user()->role) }}
                </span>

            </div>

            <button
                type="button"
                class="theme-button"
                data-theme-toggle
                aria-label="Cambiar modo de color"
            >
                <svg viewBox="0 0 24 24">
                    <path
                        d="M12 4V2h1v2h-1Zm0 18v-2h1v2h-1ZM4.22 5.64 2.8 4.22l.71-.71 1.42 1.42-.71.71Zm15.56 12.72-1.42-1.42.71-.71 1.42 1.42-.71.71ZM4 11v1H2v-1h2Zm18 0v1h-2v-1h2ZM4.93 18.36 3.51 19.78l-.71-.71 1.42-1.42.71.71ZM20.49 4.93l-1.42 1.42-.71-.71 1.42-1.42.71.71ZM12.5 7A4.5 4.5 0 1 1 8 11.5 4.5 4.5 0 0 1 12.5 7Z"
                    />
                </svg>
            </button>

            <form
                method="POST"
                action="{{ route('logout') }}"
                class="logout-form"
                data-logout-form
            >

                @csrf

                <button
                    type="submit"
                    class="button button-danger-outline"
                >

                    <svg
                        class="button-icon"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M10 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h5v-2H5V5h5V3Zm5.59 4.59L14.17 9 16.17 11H8v2h8.17l-2 2 1.42 1.41L20 12l-4.41-4.41Z"
                        />
                    </svg>

                    Cerrar sesión

                </button>

            </form>

        </div>

    </div>

    <div class="private-navigation-wrapper">

        <div class="container">

            <button
                class="mobile-menu-button private-menu-button"
                type="button"
                data-menu-toggle
            >
                <svg viewBox="0 0 24 24">
                    <path
                        d="M4 6h16v2H4V6Zm0 5h16v2H4v-2Zm0 5h16v2H4v-2Z"
                    />
                </svg>

                Menú
            </button>

            <nav
                class="private-navigation"
                data-menu
            >

                <a
                    href="{{ route('loans.create') }}"
                    class="{{ request()->routeIs('loans.create') ? 'active' : '' }}"
                >
                    Solicitar préstamo
                </a>

                <a
                    href="{{ route('inventory.index') }}"
                    class="{{ request()->routeIs('inventory.*', 'equipment.*') ? 'active' : '' }}"
                >
                    Inventario
                </a>

                <a
                    href="{{ route('incidents.index') }}"
                    class="{{ request()->routeIs('incidents.*') ? 'active' : '' }}"
                >
                    Incidencias
                </a>

                <a
                    href="{{ route('calendar.index') }}"
                    class="{{ request()->routeIs('calendar.*') ? 'active' : '' }}"
                >
                    Calendario
                </a>

                @if(auth()->user()->isEncargado())

                    <a
                        href="{{ route('loans.index') }}"
                        class="{{ request()->routeIs('loans.index') ? 'active' : '' }}"
                    >
                        Solicitudes
                    </a>

                    <a
                        href="{{ route('categories.index') }}"
                        class="{{ request()->routeIs('categories.*') ? 'active' : '' }}"
                    >
                        Categorías
                    </a>

                @else

                    <a
                        href="{{ route('loans.mine') }}"
                        class="{{ request()->routeIs('loans.mine') ? 'active' : '' }}"
                    >
                        Mis préstamos
                    </a>

                @endif

            </nav>

        </div>

    </div>

</header>