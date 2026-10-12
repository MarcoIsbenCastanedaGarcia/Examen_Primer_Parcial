<div class="container alerts-container">

    @if(session('success'))

        <div class="alert alert-success">

            <svg viewBox="0 0 24 24">
                <path
                    d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17Z"
                />
            </svg>

            <span>
                {{ session('success') }}
            </span>

            <button
                type="button"
                class="alert-close"
                data-alert-close
            >
                ×
            </button>

        </div>

    @endif

    @if($errors->any())

        <div class="alert alert-error">

            <svg viewBox="0 0 24 24">
                <path
                    d="M12 2 1 21h22L12 2Zm0 5 6.92 12H5.08L12 7Zm-1 3v5h2v-5h-2Zm0 6v2h2v-2h-2Z"
                />
            </svg>

            <div>

                <strong>
                    Revisa la información:
                </strong>

                <ul>

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

            <button
                type="button"
                class="alert-close"
                data-alert-close
            >
                ×
            </button>

        </div>

    @endif

</div>