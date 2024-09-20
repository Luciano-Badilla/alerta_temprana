@php
    use App\Models\PersonaAlephooModel;
    use App\Models\PersonaLocalModel;
    use App\Models\EstadoModel;
    use App\Models\DatoPersonaModel;
    use App\Models\EspecialidadModel;
    use App\Models\EstadoAlertaModel;
    use App\Models\TipoModel;
    use Carbon\Carbon;
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
        max-width: 25%;
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

    .div-estados {
        display: flex;
        flex-direction: column;
        gap: 5px;
        /* Espacio entre los elementos */
        justify-content: flex-start;
        /* Centra el contenedor horizontalmente */
        max-height: 100px;
        overflow: auto;
    }

    .estado {
        /* Centra horizontalmente (opcional) */
        color: white;
        text-align: center;
        font-size: 10px;
        /* Asegúrate de que no se exceda del 50% */
        height: auto;
        padding: 5px;
        /* Ajusta la altura para centrar el contenido verticalmente */
    }

    .estado_background {
        background-color: #343A40;
        border-radius: 0.375rem;
    }

    .custom-scrollbar {
        max-height: 70px;
    }

    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
        /* Ancho de la barra de desplazamiento */
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.2);
        /* Color del pulgar de la barra de desplazamiento */
        border-radius: 10px;
        /* Radio de esquina del pulgar */
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
        /* Color de la pista de la barra de desplazamiento */
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

        #filter_this_month,
        #filter_scheduled,
        #filter_expired,
        #filterButton {
            max-width: auto;
            margin-top: -10px;
        }

        #deleteFilters {
            margin-left: 10px;
        }

        .responsive-container .item i {
            margin-top: 2%;
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

        .custom-scrollbar {
            max-height: 100px;
            overflow: auto;
            text-align: start;

        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            /* Ancho de la barra de desplazamiento */
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.2);
            /* Color del pulgar de la barra de desplazamiento */
            border-radius: 10px;
            /* Radio de esquina del pulgar */
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
            /* Color de la pista de la barra de desplazamiento */
        }

    }

    /* Estilos para pantallas pequeñas (móviles) */
    @media (max-width: 767px) {

        #filterButton,
        #filter_this_month,
        #filter_scheduled,
        #filter_expired,
        #deleteFilters {
            width: auto;
        }

        .responsive-container .item i {
            margin-top: 5%;
        }

        .responsive-container .item {
            max-width: 120%;
            height: 150%;
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

        .custom-scrollbar {
            max-height: 200px;
            overflow: auto;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            /* Ancho de la barra de desplazamiento */
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.2);
            /* Color del pulgar de la barra de desplazamiento */
            border-radius: 10px;
            /* Radio de esquina del pulgar */
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
            /* Color de la pista de la barra de desplazamiento */
        }

        .div-estados {
            display: flex;
            flex-direction: row;
            /* Dirección en la que los elementos se colocan */
            flex-wrap: wrap;
            /* Permite que los elementos se envuelvan en varias líneas */
            gap: 5px;
            /* Espacio entre los elementos */
            justify-content: flex-start;
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

@php

    $mesActual = ucfirst(Carbon::now()->locale('es')->translatedFormat('F'));
    $añoActual = Carbon::now()->format('Y');

@endphp

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
                                <div style="display: flex; align-items: center; gap: 10px" class="flex-wrap">
                                    <button id="filterButton" class="btn btn-dark">
                                        <i class="fa-solid fa-filter"></i> Filtros
                                    </button>
                                    <button id="filter_this_month" class="btn btn-dark">
                                        <i class="fa-solid fa-calendar"></i> Este mes
                                    </button>
                                    <button id="filter_scheduled" class="btn btn-dark">
                                        <i class="fa-solid fa-clock"></i> Programadas
                                    </button>
                                    <button id="filter_expired" class="btn btn-dark">
                                        <i class="fa-solid fa-clock"></i> Vencidas
                                    </button>

                                    <button id="deleteFilters" style="display: none;">
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

                            <div>
                                <div class="responsive-container alerta">
                                    <div class="item">
                                        <i class="fa-solid fa-heart-pulse"></i>
                                        <div>
                                            <p
                                                class="text-lg font-semibold text-gray-900 dark:text-gray-100 especialidad">
                                                {{ EspecialidadModel::find($alert->especialidad_id)->nombre ?? '' }}
                                            </p>
                                            <div class="mt-2">
                                                <p
                                                    class="text-sm font-normal text-gray-600 dark:text-gray-500 custom-scrollbar">
                                                    {{ $alert->detalle }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-1" style="min-width: 135px">
                                        <p class="text-base font-semibold text-gray-900 dark:text-gray-100">
                                            Paciente
                                        </p>
                                        <div class="mt-2">
                                            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $persona->apellidos }} {{ $persona->nombres }}
                                            </p>
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
                                    <!--<div class="flex-1">
                                    <p class="text-m font-semibold text-gray-900 dark:text-gray-100">
                                        Detalle de la alerta
                                    </p>
                                    <div class="mt-2">
                                        <p
                                            class="text-sm font-normal text-gray-600 dark:text-gray-500 custom-scrollbar">
                                            {{ $alert->detalle }}
                                        </p>
                                    </div>
                                </div>-->
                                    <div class="flex-1">
                                        <p class="text-m font-semibold text-gray-900 dark:text-gray-100">
                                            Fecha
                                        </p>
                                        <div class="mt-2">
                                            <p class="text-sm font-normal text-gray-900 dark:text-gray-100">
                                                {{ ucfirst(\Carbon\Carbon::parse($alert->fecha_objetivo)->locale('es')->translatedFormat('F Y')) }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-m font-semibold text-gray-900 dark:text-gray-100">
                                            Repetición
                                        </p>
                                        <div class="mt-2">
                                            <p class="text-sm font-normal text-gray-900 dark:text-gray-100">
                                                @if (TipoModel::find($alert->tipo_id)->nombre === 'Una vez')
                                                    {{ TipoModel::find($alert->tipo_id)->nombre }}
                                                @else
                                                    {{ TipoModel::find($alert->tipo_id)->nombre . ' (cada ' . $alert->frecuencia . ' ' . $alert->tipo_frecuencia . ')' }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-m font-semibold text-gray-900 dark:text-gray-100">
                                            Estados
                                        </p>
                                        @php
                                            $estados = EstadoAlertaModel::getEstadosById($alert->id);
                                        @endphp
                                        <div class="div-estados custom-scrollbar">
                                            @foreach ($estados as $estado)
                                                <div class="estado_background">
                                                    <p class="estado">
                                                        {{ EstadoModel::find($estado->estado_id)->nombre ?? '' }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <a href="{{ route('alert.gest', ['id' => $alert->id]) }}"
                                            style="margin-top:auto" class="btn btn-dark">
                                            <i class="fa-solid fa-clipboard"></i>
                                        </a>
                                        <a href="{{ route('alert.edit', ['id' => $alert->id]) }}"
                                            class="btn btn-dark">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                    </div>

                                </div>

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
        scheduled();
        this_month();

        $('#filter_this_month').on('click', function() {
            if ($('#filter_this_month').hasClass('btn-dark')) {
                this_month();
            } else {
                document.getElementById('month').value = "";
                document.getElementById('year').value = "";
                document.getElementById('year').dispatchEvent(new Event('change'));
                document.getElementById('month').dispatchEvent(new Event('change'));
                $('#filter_this_month').removeClass('btn-success');
                $('#filter_this_month').addClass('btn-dark');
            }
        });

        $('#filter_scheduled').on('click', function() {
            if ($('#filter_scheduled').hasClass('btn-dark')) {
                scheduled();
            } else {
                document.getElementById('filtro-estado').value = "";
                document.getElementById('filtro-estado').dispatchEvent(new Event('change'));
                $('#filter_scheduled').removeClass('btn-success');
                $('#filter_scheduled').addClass('btn-dark');
            }
        });

        $('#filter_expired').on('click', function() {
            if ($('#filter_expired').hasClass('btn-dark')) {
                expired();
            } else {
                document.getElementById('filtro-estado').value = "";
                document.getElementById('filtro-estado').dispatchEvent(new Event('change'));
                $('#filter_expired').removeClass('btn-success');
                $('#filter_expired').addClass('btn-dark');
            }
        });

        $(document).on('click', '#newAlert', function() {
            window.location.href = "{{ route('alerts') }}";
        });

        function this_month() {
            document.getElementById('month').value = "{{ Carbon::now()->format('m') }}";
            document.getElementById('year').value = "{{ $añoActual }}";
            document.getElementById('year').dispatchEvent(new Event('change'));
            document.getElementById('month').dispatchEvent(new Event('change'));
            $('#filter_this_month').removeClass('btn-dark');
            $('#filter_this_month').addClass('btn-success');
        }

        function scheduled() {
            document.getElementById('filtro-estado').value = "Programada";
            document.getElementById('filtro-estado').dispatchEvent(new Event('change'));
            $('#filter_scheduled ').removeClass('btn-dark');
            $('#filter_scheduled ').addClass('btn-primary');
            $('#filter_expired ').removeClass('btn-primary');
            $('#filter_expired ').addClass('btn-dark');
        }

        function expired() {
            document.getElementById('filtro-estado').value = "Vencida";
            document.getElementById('filtro-estado').dispatchEvent(new Event('change'));
            $('#filter_expired ').removeClass('btn-dark');
            $('#filter_expired ').addClass('btn-primary');
            $('#filter_scheduled ').removeClass('btn-primary');
            $('#filter_scheduled ').addClass('btn-dark');
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search_input');
        const filterButton = document.getElementById('filterButton');
        const deleteFiltersButton = document.getElementById('deleteFilters');
        const filterDiv = document.getElementById('filter-div');
        const monthSelect = document.getElementById('month');
        const yearInput = document.getElementById('year');

        function applyFilters() {
            $('#filter_this_month').removeClass('btn-success');
            $('#filter_this_month').addClass('btn-dark');
            $('#filter_expired ').removeClass('btn-primary');
            $('#filter_expired ').addClass('btn-dark');
            $('#filter_scheduled ').removeClass('btn-primary');
            $('#filter_scheduled ').addClass('btn-dark');
            const especialidad = document.getElementById('filtro-especialidad').value
            const estado = document.getElementById('filtro-estado').value;
            const searchQuery = searchInput.value.toLowerCase();
            const selectedMonth = monthSelect.value;
            const selectedYear = yearInput.value;

            if (estado == 'Programada') {
                $('#filter_scheduled ').removeClass('btn-dark');
                $('#filter_scheduled ').addClass('btn-primary');
            } else if (estado == 'Vencida') {
                $('#filter_expired ').removeClass('btn-dark');
                $('#filter_expired ').addClass('btn-primary');
            }
            if (selectedMonth == "{{ Carbon::now()->format('m') }}") {
                $('#filter_this_month ').removeClass('btn-dark');
                $('#filter_this_month ').addClass('btn-success');
            }

            document.querySelectorAll('.alerta').forEach(alert => {
                const alertEspecialidad = alert.querySelector('.especialidad').textContent;
                const alertEstado = alert.querySelector('.estado').textContent;
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
