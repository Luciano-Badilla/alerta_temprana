@php
    use App\Models\PersonaAlephooModel;
    use App\Models\PersonaLocalModel;
    use App\Models\EstadoModel;
    use App\Models\DatoPersonaModel;
    use App\Models\EspecialidadModel;
    use App\Models\TipoModel;
@endphp

<style>
    .responsive-container {
        padding: 1rem;
        background-color: white;
        border: 1px solid #e5e7eb;
        /* border-gray-200 */
        border-radius: 0.5rem;
        /* rounded-lg */
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        /* shadow-md */
        display: flex;
        flex-direction: column;
        /* Apilar verticalmente en móviles */
        gap: 1.25rem;
        /* gap-5 */
        margin: 5px;
    }

    .responsive-container .item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        /* gap-4 */
    }

    .responsive-container .item i {
        font-size: 25px;
        /* text-blue-600 */
    }

    .responsive-container .item div {
        margin-left: 1%;
    }

    .responsive-container .flex-1 {
        flex: 1;
    }

    #filter-div-responsive {
        display: flex;
        flex-direction: row;
        /* Filtros en fila por defecto */
        flex-wrap: wrap;
        /* Permite que los filtros se ajusten en varias filas si es necesario */
        gap: 15px;
        /* Espacio entre filtros */
    }

    #deleteFilters {
        align-self: flex-start;
    }

    #date-filters {
        margin-top: -5.5%;
        /* Margen superior para pantallas grandes */
        display: flex;
        flex-direction: row;
        gap: 10px;
        /* Espacio entre filtros */
    }

    #range-filters {
        display: none;
        /* Ocultar por defecto */
        flex-direction: row;
        gap: 10px;
        /* Espacio entre filtros */
    }

    .search_and_filters_div {
        display: flex;
        flex-direction: row;
    }


    @media (min-width: 640px) {
        .responsive-container {
            flex-direction: row;
            /* Cambiar a fila en pantallas grandes */
            gap: 1.25rem;
            /* gap-5 */
        }

        .search_and_filters_div {
            display: flex;
            flex-direction: row;
        }
    }

    /*pantallas grandes*/
    @media (min-width: 768px) {
        #filterButton {
            max-width: 8%;
            margin-top: -10px;
        }

        #deleteFilters {
            margin-left: 10px;
        }

        .responsive-container .item i {
            margin-top: 1.5%;
        }

        #range-filters {
            flex-direction: row;
            /* Filtros en fila en pantallas grandes */
            margin-top: -5.8%;
            /* Ajuste del margen superior para pantallas grandes */
        }

        .search_and_filters_div {
            display: flex;
            flex-direction: row;
        }

    }

    /* Estilos para pantallas pequeñas (móviles) */
    @media (max-width: 767px) {

        #filterButton,
        #deleteFilters {
            width: auto;
            margin-top: -20px;
        }

        .responsive-container .item i {
            margin-top: 5%;
        }

        #filter-div-responsive {
            flex-direction: column;
            width: 100%
                /* Filtros en columna en pantallas pequeñas */
        }

        #deleteFilters {
            align-self: center;
        }

        #date-filters {
            flex-direction: row;
            /* Filtros en columna en pantallas pequeñas */
            margin-top: -7%;
            /* Ajustar el margen superior en móviles */
        }

        .search_and_filters_div {
            display: flex;
            flex-direction: column;
        }

        .search_input_div {
            margin-top: 2%;
        }

        .search_input_div input {
            max-width: none;
            margin-left: 2%;
            /* Elimina el límite de ancho máximo */
            width: 96%;
        }

    }

    .text-lg {
        font-size: 1.125rem;
    }

    .text-sm {
        font-size: 0.875rem;
    }

    .text-m {
        font-size: 1rem;
    }

    .font-semibold {
        font-weight: 600;
    }

    .font-medium {
        font-weight: 500;
    }

    .font-normal {
        font-weight: 400;
    }

    .text-gray-900 {
        color: #111827;
    }

    .text-gray-600 {
        color: #4b5563;
    }

    .text-gray-800 {
        color: #1f2937;
    }

    .text-gray-100 {
        color: #f3f4f6;
    }

    .text-gray-300 {
        color: #d1d5db;
    }

    .text-gray-200 {
        color: #e5e7eb;
    }

    .dark .text-blue-400 {
        color: #93c5fd;
    }

    .dark .text-gray-800 {
        color: #d1d5db;
    }

    .dark .text-gray-100 {
        color: #f9fafb;
    }
</style>

<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background-color: white">
                @if (session('success'))
                    <div class="alert-success">
                        <p style="padding: 0.3%; text-align: center">{{ session('success') }}</p>
                    </div>
                @endif
                <div class="d-flex justify-content-left p-3 bg-light rounded shadow-sm">
                    <div class="container mt-4">
                        <div class="justify-between search_and_filters_div">
                            <div class="row mb-3" style="display: flex; flex-direction: column">
                                <div style="display: flex; flex-wrap: wrap; align-items: center;">
                                    <button id="filterButton" class="btn btn-dark" style="max-width: 100%;">
                                        <i class="fa-solid fa-filter"></i> Filtros
                                    </button>
                                    <button id="deleteFilters" style="margin-left: 10px; display: none;">
                                        <i class="fa-solid fa-circle-xmark"></i>
                                    </button>
                                </div>
                                <div id="filter-div" style="display: none">
                                    <div id="filter-div-responsive" style="margin-top: 1%; gap:15px">
                                        <div>
                                            <label for="filtro-especialidad">Especialidad:</label>
                                            <select id="filtro-especialidad" class="form-control">
                                                <option value="">Todas las especialidades</option>
                                                @foreach ($especialidades as $especialidad)
                                                    <option value="{{ $especialidad->nombre }}">
                                                        {{ $especialidad->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <label for="filtro-estado">Estado:</label>
                                            <select id="filtro-estado" class="form-control">
                                                <option value="">Todos los estados</option>
                                                @foreach ($estados as $estado)
                                                    <option value="{{ $estado->nombre }}">
                                                        {{ $estado->nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Filtro por Fecha -->
                                        <div style="display: flex; flex-direction: column; gap: 15px;">
                                            <div style="display: flex; flex-direction: row; gap: 15px;">
                                                <label>Fecha de alerta:</label>
                                            </div>

                                            <div id="date-filters">
                                                <select class="form-control" id="month"
                                                    style="margin-top: 5px; border: 1px solid #ced4da; border-radius: 0.25rem; padding: 0.375rem 0.75rem;">
                                                    <option value="">Selecciona el mes</option>
                                                    <option value="01">Enero</option>
                                                    <option value="02">Febrero</option>
                                                    <option value="03">Marzo</option>
                                                    <option value="04">Abril</option>
                                                    <option value="05">Mayo</option>
                                                    <option value="06">Junio</option>
                                                    <option value="07">Julio</option>
                                                    <option value="08">Agosto</option>
                                                    <option value="09">Septiembre</option>
                                                    <option value="10">Octubre</option>
                                                    <option value="11">Noviembre</option>
                                                    <option value="12">Diciembre</option>
                                                </select>

                                                <input type="number" class="form-control" id="year"
                                                    style="margin-top: 5px; border: 1px solid #ced4da; border-radius: 0.25rem; padding: 0.375rem 0.75rem;"
                                                    placeholder="año">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="search_input_div">
                                <input type="text" id="search_input"
                                    class="form-input rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                                    placeholder="Busqueda general" style="margin-top: -5%;">
                            </div>
                        </div>

                        @foreach ($alerts->sortByDesc('fecha_objetivo') as $alert)
                            @php
                                if ($alert->is_in_alephoo == 1) {
                                    $response = PersonaAlephooModel::getPersonalDataById($alert->persona_id);
                                    $persona = json_decode($response->getContent());
                                } else {
                                    $persona = PersonaLocalModel::find($alert->persona_id);
                                }
                            @endphp

                            <div class="responsive-container alerta">
                                <div class="item">
                                    <i class="fa-solid fa-bell bell_icon" style="color: #1F2D3D"></i>
                                    <div>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100 especialidad">
                                            {{ EspecialidadModel::find($alert->especialidad_id)->nombre }}
                                        </p>
                                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 estado">
                                            Estado:
                                        </p>
                                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400 estado">
                                            {{ EstadoModel::find($alert->estado_id)->nombre }}</p>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-m font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $persona->apellidos }} {{ $persona->nombres }}
                                    </p>
                                    <div class="mt-2">
                                        <p class="text-sm font-normal text-gray-600 dark:text-gray-500">
                                            DNI: {{ $persona->documento }}
                                        </p>
                                        <p class="text-sm font-normal text-gray-600 dark:text-gray-500">
                                            Fecha de nacimiento:
                                            {{ \Carbon\Carbon::parse($persona->fecha_nacimiento)->format('d/m/Y') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-m font-semibold text-gray-900 dark:text-gray-100">
                                        Comunicacion
                                    </p>
                                    <div class="mt-2">
                                        <p class="text-sm font-normal text-gray-600 dark:text-gray-500">
                                            Celular:
                                            @php
                                                $celularLocal =
                                                    DatoPersonaModel::where('persona_id', $persona->id)
                                                        ->where('tipo_dato', 'celular')
                                                        ->first()->dato ?? null;
                                                $emailLocal =
                                                    DatoPersonaModel::where('persona_id', $persona->id)
                                                        ->where('tipo_dato', 'email')
                                                        ->first()->dato ?? null;
                                            @endphp
                                            {{ $celularLocal !== null && $celularLocal !== '+' ? $celularLocal : $persona->celular ?? 'Celular no encontrado' }}
                                        </p>
                                        <p class="text-sm font-normal text-gray-600 dark:text-gray-500">
                                            Email:
                                            {{ $emailLocal !== null && $emailLocal !== '+' ? $emailLocal : $persona->email ?? 'Email no encontrado' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-m font-semibold text-gray-900 dark:text-gray-100">
                                        Detalle de la alerta
                                    </p>
                                    <div class="mt-2">
                                        <p class="text-sm font-normal text-gray-600 dark:text-gray-500">
                                            {{ $alert->detalle }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-m font-semibold text-gray-900 dark:text-gray-100">
                                        Fecha de Alerta
                                    </p>
                                    <div class="mt-2">
                                        <p class="text-sm font-normal text-gray-900 dark:text-gray-100">
                                            {{ \Carbon\Carbon::parse($alert->fecha_objetivo)->format('d/m/Y') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <p class="text-m font-semibold text-gray-900 dark:text-gray-100">
                                        Repetición de la alerta
                                    </p>
                                    <div class="mt-2">
                                        <p class="text-sm font-normal text-gray-900 dark:text-gray-100">
                                            {{ TipoModel::find($alert->tipo_id)->nombre . ' (' . $alert->frecuencia . ' ' . $alert->tipo_frecuencia . ')' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="" style="align-content: end;">
                                    <button class="btn btn-dark w-8 h-10"><i class="fa-solid fa-clipboard"></i></button>
                                    <button class="btn btn-dark w-8 h-10"><i
                                            class="fa-solid fa-pen-to-square"></i></button>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

            </div>
        </div>

    </div>

</x-app-layout>

<script>
    $(document).ready(function() {

        $('#filter-range').on('change', function() {
            if ($(this).is(':checked')) {
                // Si está marcado, ocultar el filtro de fecha única y mostrar el rango
                $('#date-filters').hide();
                $('#range-filters').css('display', 'flex');
                // Limpiar el campo de fecha única cuando se habilita el rango
                $('#date').val('');
                // Aplicar el filtro sin fecha
                applyFilters();
            } else {
                // Si no está marcado, mostrar el filtro de fecha única y ocultar el rango
                $('#range-filters').css('display', 'none');
                $('#date-filters').show();
                // Limpiar los campos de rango cuando se habilita el filtro de fecha única
                $('#start-date').val('');
                $('#end-date').val('');
                // Aplicar el filtro sin rango
                applyFilters();
            }
        });

        $("#table_alerts").DataTable({
            initComplete: function() {
                var api = this.api();
                // Añadir el botón después de que DataTables se haya inicializado
                $('.dataTables_length').prepend(
                    '<div>' +
                    '<a href="{{ route('alert.create') }}" class="btn btn-dark" style="margin-top:3%">' +
                    '<i class="fas fa-plus"></i> Nueva alerta' +
                    '</a>' +
                    '</div>'
                );
            },
            "responsive": true,
            "lengthChange": true,
            "autoWidth": true,
            "language": {
                "decimal": "",
                "emptyTable": "No hay datos disponibles en la tabla",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
                "infoFiltered": "(filtrado de _MAX_ entradas totales)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": " _MENU_ ",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "No se encontraron registros coincidentes",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "aria": {
                    "sortAscending": ": activar para ordenar la columna ascendente",
                    "sortDescending": ": activar para ordenar la columna descendente"
                }
            }
        });

        $(document).on('click', '#newAlert', function() {
            window.location.href = "{{ route('gest.alerts') }}";
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search_input');
        const filterButton = document.getElementById('filterButton');
        const deleteFiltersButton = document.getElementById('deleteFilters');
        const filterDiv = document.getElementById('filter-div');
        const monthSelect = document.getElementById('month');
        const yearInput = document.getElementById('year');

        function applyFilters() {
            const especialidad = document.getElementById('filtro-especialidad').value.toLowerCase();
            const estado = document.getElementById('filtro-estado').value.toLowerCase();
            const searchQuery = searchInput.value.toLowerCase();
            const selectedMonth = monthSelect.value;
            const selectedYear = yearInput.value;

            document.querySelectorAll('.alerta').forEach(alert => {
                const alertEspecialidad = alert.querySelector('.especialidad').textContent
                    .toLowerCase();
                const alertEstado = alert.querySelector('.estado').textContent.toLowerCase();
                const alertDate = alert.querySelector(
                        '.flex-1 p.text-sm.font-normal.text-gray-900.dark\\:text-gray-100').textContent
                    .trim();

                // Convertir alertDate a formato comparable (asumiendo dd/mm/yyyy)
                const alertDateFormatted = new Date(alertDate.split('/').reverse().join('-'));
                let isVisible = true;

                // Filtrar por especialidad
                if (especialidad && !alertEspecialidad.includes(especialidad)) {
                    isVisible = false;
                }

                // Filtrar por estado
                if (estado && !alertEstado.includes(estado)) {
                    isVisible = false;
                }

                // Filtrar por búsqueda
                const alertText = alert.textContent.toLowerCase();
                if (searchQuery && !alertText.includes(searchQuery)) {
                    isVisible = false;
                }

                // Filtrar por mes
                if (selectedMonth && (alertDateFormatted.getMonth() + 1).toString().padStart(2, '0') !==
                    selectedMonth) {
                    isVisible = false;
                }

                // Filtrar por año
                if (selectedYear && alertDateFormatted.getFullYear().toString() !== selectedYear) {
                    isVisible = false;
                }

                alert.style.display = isVisible ? 'flex' : 'none';
            });
        }

        // Mostrar/Ocultar filtros
        filterButton.addEventListener('click', function() {
            filterDiv.style.display = filterDiv.style.display === 'none' ? 'flex' : 'none';
            deleteFiltersButton.style.display = deleteFiltersButton.style.display === 'none' ? 'flex' :
                'none';
        });

        // Eliminar filtros
        deleteFiltersButton.addEventListener('click', function() {
            document.getElementById('filtro-especialidad').value = '';
            document.getElementById('filtro-estado').value = '';
            searchInput.value = '';
            monthSelect.value = '';
            yearInput.value = '';
            applyFilters();
        });

        // Aplicar filtros cuando cambian el input de año y el select de mes
        monthSelect.addEventListener('change', applyFilters);
        yearInput.addEventListener('input', applyFilters);

        // Aplicar filtros cuando cambian otros inputs o selects
        document.querySelectorAll('#filter-div input, #filter-div select').forEach(input => {
            input.addEventListener('change', applyFilters);
        });

        // Aplicar filtros al escribir en el campo de búsqueda
        searchInput.addEventListener('input', applyFilters);
    });
</script>
