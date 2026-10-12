<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        @yield('title', 'Sistema de Préstamos de Equipos')
    </title>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Faustina:ital,wght@0,300..800;1,300..800&family=Libre+Baskerville:ital,wght@0,400..700;1,400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
        rel="stylesheet"
    >

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body>

    <div class="site-wrapper">

        @auth
            @include('partials.private-nav')
        @else
            @include('partials.public-nav')
        @endauth

        @include('partials.alerts')

        <main class="main-content">
            @yield('content')
        </main>

        <footer class="site-footer">
            <div class="container footer-content">

                <div>
                    <strong>
                        Sistema de Préstamos y Control de Equipos
                    </strong>

                    <p>
                        Plataforma institucional para la administración,
                        préstamo y seguimiento de equipos.
                    </p>
                </div>

                <div>
                    <p>
                        Contacto institucional
                    </p>

                    <p>
                        soporte@institucion.edu
                    </p>
                </div>

            </div>
        </footer>

    </div>

</body>
</html>