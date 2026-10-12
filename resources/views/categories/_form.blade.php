<div class="form-grid">

    <div class="form-group form-group-full">

        <label for="name">
            Nombre de la categoría
        </label>

        <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name', $category->name ?? '') }}"
            required
        >

    </div>

    <div class="form-group form-group-full">

        <label for="description">
            Descripción
        </label>

        <textarea
            id="description"
            name="description"
            rows="5"
        >{{ old('description', $category->description ?? '') }}</textarea>

    </div>

    <div class="form-group form-group-full">

        <label class="checkbox-field">

            <input
                type="checkbox"
                name="active"
                value="1"
                @checked(old('active', $category->active ?? true))
            >

            <span>
                Categoría activa
            </span>

        </label>

    </div>

</div>