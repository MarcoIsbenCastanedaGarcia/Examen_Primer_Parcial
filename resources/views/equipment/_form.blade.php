<div class="form-grid">

    <div class="form-group">

        <label for="inventory_code">
            Código de inventario
        </label>

        <input
            type="text"
            id="inventory_code"
            name="inventory_code"
            value="{{ old('inventory_code', $equipment->inventory_code ?? '') }}"
            required
        >

    </div>

    <div class="form-group">

        <label for="name">
            Nombre del equipo
        </label>

        <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name', $equipment->name ?? '') }}"
            required
        >

    </div>

    <div class="form-group">

        <label for="category_id">
            Categoría
        </label>

        <select
            id="category_id"
            name="category_id"
            required
        >

            <option value="">
                Selecciona una categoría
            </option>

            @foreach($categories as $category)

                <option
                    value="{{ $category->id }}"
                    @selected(
                        old(
                            'category_id',
                            $equipment->category_id ?? ''
                        ) == $category->id
                    )
                >
                    {{ $category->name }}
                </option>

            @endforeach

        </select>

    </div>

    <div class="form-group">

        <label for="brand">
            Marca
        </label>

        <input
            type="text"
            id="brand"
            name="brand"
            value="{{ old('brand', $equipment->brand ?? '') }}"
        >

    </div>

    <div class="form-group">

        <label for="model">
            Modelo
        </label>

        <input
            type="text"
            id="model"
            name="model"
            value="{{ old('model', $equipment->model ?? '') }}"
        >

    </div>

    <div class="form-group">

        <label for="serial_number">
            Número de serie
        </label>

        <input
            type="text"
            id="serial_number"
            name="serial_number"
            value="{{ old('serial_number', $equipment->serial_number ?? '') }}"
        >

    </div>

    <div class="form-group">

        <label for="availability_status">
            Disponibilidad
        </label>

        <select
            id="availability_status"
            name="availability_status"
            required
        >

            @php
                $availability = old(
                    'availability_status',
                    $equipment->availability_status ?? 'disponible'
                );
            @endphp

            <option
                value="disponible"
                @selected($availability === 'disponible')
            >
                Disponible
            </option>

            <option
                value="reservado"
                @selected($availability === 'reservado')
            >
                Reservado
            </option>

            <option
                value="prestado"
                @selected($availability === 'prestado')
            >
                Prestado
            </option>

            <option
                value="no_disponible"
                @selected($availability === 'no_disponible')
            >
                No disponible
            </option>

        </select>

    </div>

    <div class="form-group">

        <label for="physical_state">
            Estado físico
        </label>

        @php
            $physicalState = old(
                'physical_state',
                $equipment->physical_state ?? 'bueno'
            );
        @endphp

        <select
            id="physical_state"
            name="physical_state"
            required
        >

            <option
                value="bueno"
                @selected($physicalState === 'bueno')
            >
                Bueno
            </option>

            <option
                value="regular"
                @selected($physicalState === 'regular')
            >
                Regular
            </option>

            <option
                value="danado"
                @selected($physicalState === 'danado')
            >
                Dañado
            </option>

            <option
                value="mantenimiento"
                @selected($physicalState === 'mantenimiento')
            >
                Mantenimiento
            </option>

            <option
                value="baja"
                @selected($physicalState === 'baja')
            >
                Baja
            </option>

        </select>

    </div>

    <div class="form-group">

        <label for="location">
            Ubicación
        </label>

        <input
            type="text"
            id="location"
            name="location"
            value="{{ old('location', $equipment->location ?? '') }}"
        >

    </div>

    <div class="form-group form-group-full">

        <label for="description">
            Descripción
        </label>

        <textarea
            id="description"
            name="description"
            rows="4"
        >{{ old('description', $equipment->description ?? '') }}</textarea>

    </div>

    <div class="form-group form-group-full">

        <label for="notes">
            Notas
        </label>

        <textarea
            id="notes"
            name="notes"
            rows="4"
        >{{ old('notes', $equipment->notes ?? '') }}</textarea>

    </div>

</div>