@extends('layouts.app')

@section('title', 'Carga masiva')

@section('content')

<section class="page-section">

    <div class="container container-narrow">

        <div class="page-heading">

            <div>

                <span class="eyebrow">
                    Inventario
                </span>

                <h1>
                    Carga masiva
                </h1>

                <p>
                    Importa varios equipos mediante un archivo TXT
                    que contenga información en formato JSON.
                </p>

            </div>

        </div>

        <div class="form-card">

            <form
                method="POST"
                action="{{ route('equipment.import.store') }}"
                enctype="multipart/form-data"
            >

                @csrf

                <div class="upload-area">

                    <svg viewBox="0 0 24 24">
                        <path
                            d="M11 16V7.83L8.41 10.41 7 9l5-5 5 5-1.41 1.41L13 7.83V16h-2ZM5 20a2 2 0 0 1-2-2v-4h2v4h14v-4h2v4a2 2 0 0 1-2 2H5Z"
                        />
                    </svg>

                    <label for="archivo">
                        Seleccionar archivo TXT o JSON
                    </label>

                    <input
                        type="file"
                        id="archivo"
                        name="archivo"
                        accept=".txt,.json"
                        required
                    >

                    <p>
                        Tamaño máximo: 5 MB
                    </p>

                </div>

                <div class="code-example">

                    <strong>
                        Ejemplo del contenido:
                    </strong>

<pre>[
    {
        "codigo_inventario": "LAP-010",
        "nombre": "Laptop Lenovo ThinkPad",
        "categoria": "Laptops",
        "marca": "Lenovo",
        "modelo": "ThinkPad E14",
        "numero_serie": "LN-E14-010",
        "descripcion": "Laptop para actividades escolares",
        "disponibilidad": "disponible",
        "estado": "bueno",
        "ubicacion": "Almacén principal",
        "notas": null
    }
]</pre>

                </div>

                <div class="form-actions">

                    <a
                        href="{{ route('inventory.index') }}"
                        class="button button-secondary"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="button button-primary"
                    >
                        Importar equipos
                    </button>

                </div>

            </form>

        </div>

    </div>

</section>

@endsection