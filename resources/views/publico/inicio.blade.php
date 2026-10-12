@extends('layouts.app')

@section('title', 'Inicio | Sistema de Préstamos')

@section('content')

<section class="hero-section">

    <div class="container hero-grid">

        <div class="hero-content">

            <span class="eyebrow">
                Gestión institucional de equipos
            </span>

            <h1>
                Sistema de préstamos y control de equipo escolar
            </h1>

            <p>
                Consulta la disponibilidad de laptops, proyectores y
                otros recursos institucionales, solicita préstamos y
                reporta incidencias desde un solo lugar.
            </p>

            <div class="hero-actions">

                <a
                    href="{{ route('login') }}"
                    class="button button-primary button-large"
                >
                    Iniciar sesión
                </a>

                <a
                    href="#reglas"
                    class="button button-secondary button-large"
                >
                    Consultar reglas
                </a>

            </div>

        </div>

        <div class="hero-card">

            <div class="hero-device">

                <svg viewBox="0 0 120 90">
                    <rect
                        x="20"
                        y="12"
                        width="80"
                        height="53"
                        rx="5"
                    />

                    <rect
                        x="27"
                        y="19"
                        width="66"
                        height="39"
                        rx="2"
                        class="svg-secondary"
                    />

                    <path
                        d="M12 70h96l-8 8H20l-8-8Z"
                    />
                </svg>

            </div>

            <div class="hero-stats">

                <article>
                    <strong>
                        Inventario
                    </strong>

                    <span>
                        Consulta disponibilidad y estado.
                    </span>
                </article>

                <article>
                    <strong>
                        Préstamos
                    </strong>

                    <span>
                        Solicitudes y seguimiento.
                    </span>
                </article>

                <article>
                    <strong>
                        Incidencias
                    </strong>

                    <span>
                        Reportes de daños y fallas.
                    </span>
                </article>

            </div>

        </div>

    </div>

</section>

<section
    id="informacion"
    class="section"
>

    <div class="container">

        <div class="section-heading">

            <span class="eyebrow">
                Información
            </span>

            <h2>
                Una forma organizada de administrar los recursos institucionales
            </h2>

            <p>
                El sistema permite centralizar el inventario de equipos,
                conocer su disponibilidad y mantener un registro de los
                préstamos realizados.
            </p>

        </div>

        <div class="information-grid">

            <article class="info-card">

                <div class="card-icon">

                    <svg viewBox="0 0 24 24">
                        <path
                            d="M4 4h16v4H4V4Zm0 6h16v10H4V10Zm2 2v6h12v-6H6Z"
                        />
                    </svg>

                </div>

                <h3>
                    Control centralizado
                </h3>

                <p>
                    Los equipos se organizan por categoría, disponibilidad,
                    estado físico y ubicación.
                </p>

            </article>

            <article class="info-card">

                <div class="card-icon">

                    <svg viewBox="0 0 24 24">
                        <path
                            d="M7 2v2H5a2 2 0 0 0-2 2v14h18V6a2 2 0 0 0-2-2h-2V2h-2v2H9V2H7Zm12 7H5V6h14v3Zm0 9H5v-7h14v7Z"
                        />
                    </svg>

                </div>

                <h3>
                    Seguimiento de préstamos
                </h3>

                <p>
                    Las solicitudes pueden ser revisadas, aprobadas,
                    rechazadas, entregadas y posteriormente devueltas.
                </p>

            </article>

            <article class="info-card">

                <div class="card-icon">

                    <svg viewBox="0 0 24 24">
                        <path
                            d="M12 2 1 21h22L12 2Zm0 5 6.92 12H5.08L12 7Zm-1 3v5h2v-5h-2Zm0 6v2h2v-2h-2Z"
                        />
                    </svg>

                </div>

                <h3>
                    Registro de incidencias
                </h3>

                <p>
                    Los usuarios pueden informar daños o fallas para evitar
                    que un equipo con problemas continúe disponible.
                </p>

            </article>

        </div>

    </div>

</section>

<section
    id="funciones"
    class="section section-muted"
>

    <div class="container">

        <div class="section-heading">

            <span class="eyebrow">
                Funciones
            </span>

            <h2>
                Herramientas principales del sistema
            </h2>

        </div>

        <div class="feature-grid">

            <div class="feature-list">

                <article class="feature-item">

                    <span class="feature-number">
                        01
                    </span>

                    <div>
                        <h3>
                            Consulta de inventario
                        </h3>

                        <p>
                            Visualiza equipos, categorías, condición y
                            disponibilidad actual.
                        </p>
                    </div>

                </article>

                <article class="feature-item">

                    <span class="feature-number">
                        02
                    </span>

                    <div>
                        <h3>
                            Solicitud de préstamos
                        </h3>

                        <p>
                            Selecciona los equipos requeridos e indica
                            fecha, horario y motivo de uso.
                        </p>
                    </div>

                </article>

                <article class="feature-item">

                    <span class="feature-number">
                        03
                    </span>

                    <div>
                        <h3>
                            Consulta mediante calendario
                        </h3>

                        <p>
                            Revisa préstamos aprobados y equipos que se
                            encuentran programados.
                        </p>
                    </div>

                </article>

                <article class="feature-item">

                    <span class="feature-number">
                        04
                    </span>

                    <div>
                        <h3>
                            Reporte de incidencias
                        </h3>

                        <p>
                            Informa cualquier daño, falla, pérdida o
                            comportamiento irregular de los equipos.
                        </p>
                    </div>

                </article>

            </div>

            <div class="function-panel">

                <svg viewBox="0 0 24 24">
                    <path
                        d="M3 5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-6v2h3v2H8v-2h3v-2H5a2 2 0 0 1-2-2V5Zm2 0v10h14V5H5Z"
                    />
                </svg>

                <h3>
                    Acceso según el rol
                </h3>

                <p>
                    Los solicitantes pueden consultar, solicitar y reportar.
                    Los encargados cuentan además con herramientas
                    administrativas para gestionar todo el sistema.
                </p>

            </div>

        </div>

    </div>

</section>

<section
    id="reglas"
    class="section"
>

    <div class="container">

        <div class="section-heading">

            <span class="eyebrow">
                Reglas de préstamo
            </span>

            <h2>
                Condiciones básicas para solicitar equipos
            </h2>

        </div>

        <div class="rules-grid">

            <article class="rule-card">
                <span>1</span>

                <h3>
                    Solicitud previa
                </h3>

                <p>
                    Todo equipo deberá solicitarse mediante el sistema
                    antes de ser retirado.
                </p>
            </article>

            <article class="rule-card">
                <span>2</span>

                <h3>
                    Uso responsable
                </h3>

                <p>
                    El solicitante será responsable del cuidado del
                    equipo durante el periodo autorizado.
                </p>
            </article>

            <article class="rule-card">
                <span>3</span>

                <h3>
                    Entrega puntual
                </h3>

                <p>
                    El equipo deberá devolverse en la fecha y horario
                    establecidos en la solicitud.
                </p>
            </article>

            <article class="rule-card">
                <span>4</span>

                <h3>
                    Reporte de daños
                </h3>

                <p>
                    Cualquier falla o daño deberá reportarse mediante
                    el módulo de incidencias.
                </p>
            </article>

        </div>

    </div>

</section>

<section
    id="contacto"
    class="section contact-section"
>

    <div class="container contact-grid">

        <div>

            <span class="eyebrow">
                Contacto
            </span>

            <h2>
                ¿Necesitas apoyo?
            </h2>

            <p>
                Comunícate con el área encargada del inventario y
                préstamo de equipos.
            </p>

        </div>

        <div class="contact-card">

            <p>
                <strong>
                    Correo:
                </strong>

                soporte@institucion.edu
            </p>

            <p>
                <strong>
                    Teléfono:
                </strong>

                55 0000 0000
            </p>

            <p>
                <strong>
                    Horario:
                </strong>

                Lunes a viernes de 08:00 a 18:00
            </p>

            <p>
                <strong>
                    Sede:
                </strong>

                Área de Recursos Tecnológicos
            </p>

        </div>

    </div>

</section>

@endsection