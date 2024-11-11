@php
    use App\Models\PersonaAlephooModel;
    use App\Models\PersonaLocalModel;
    use App\Models\EstadoModel;
    use App\Models\DatoPersonaModel;
    use App\Models\EspecialidadModel;
    use App\Models\TipoModel;
    use App\Models\EstadoAlertaModel;
    use App\Models\ExamenModel;
    use App\Models\User;
    use Carbon\Carbon;
@endphp
<script src="https://cdn.tailwindcss.com"></script>
<style>
    /* Personaliza la posición del popover */
    .popover {
        margin-top: 10px;
        /* Ajusta este valor para que el popover se vea mejor */
    }

    .container {
        width: 100%;
        max-width: 1000px;
        /* Ajuste para el formato apaisado */
        margin: 0 auto;
        padding: 10px;
    }

    .header {
        text-align: center;
        margin-bottom: 10px;
    }

    .logo {
        width: 60%;
        margin-bottom: 10px;
    }

    .patient-info,
    .prescription {
        border: 1px solid #000;
        border-radius: 8px;
        padding: 10px;
        margin-bottom: 15px;
    }

    .patient-info p,
    .prescription p {
        margin: 3px 0;
    }

    .prescription {
        min-height: 390px;
        height: auto;
    }

    .footer {
        text-align: center;
        font-size: 10px;
        color: #666;
        margin-top: 20px;
        padding-top: 10px;
        border-top: 1px solid #ddd;
    }

    /* Estilos personalizados */
    .custom-scrollbar {
        max-height: auto;
        overflow: auto;
        text-align: start;
    }

    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    /* Remover espacios desaprovechados en los costados */
    .form-div {
        padding: 0.75rem
            /* Elimina el padding lateral */
    }

    .buttons_div {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: center;
        gap: 1rem;
    }


    /* Estilos para Select2 (si se usa) */
    .select2-container .select2-selection--single {
        height: 38px !important;
        line-height: 36px !important;
    }

    .select2-container .select2-selection--multiple {
        min-height: 38px !important;
    }

    .select2-container {
        font-size: 16px !important;
    }

    /* Media queries para responsividad */
    @media (max-width: 768px) {

        .buttons_div button {
            width: calc(50% - 0.5rem);
            /* Cada botón ocupa la mitad del espacio con un pequeño margen */
        }
    }

    @media (max-width: 648px) {
        .form-div {
            padding: 0;
            /* Elimina el padding lateral */
        }
    }

    /* Ocultar elemento personalizado */
    #personalizadoMeses {
        @apply hidden;
    }
</style>


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 leading-tight">
            {{ __('Gestión alerta Nº ' . $alert->id) }}
        </h2>
    </x-slot>
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 8px !important">
                <div class="modal-header border-transparent">
                    <div class="flex flex-col">
                        <h5 class="modal-title" id="exampleModalLabel">¿Completar alerta?</h5>
                        <p class="text-muted">Esta acción marcará la alerta médica como completada.</p>
                    </div>
                    <button type="button" class="btn-close text-sm" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body border-transparent">
                    <div class="py-2 px-3 text-red-600 d-flex align-items-center" role="alert"
                        style="border: solid #EF4444; border-radius: 8px; border-width: 1px; margin-top:-5%">
                        <i class="fa-solid fa-triangle-exclamation mr-2" style="color:#EF4444"></i>
                        <div>Al completar la alerta se marcará como completada y ya no se podrá gestionar.</div>
                    </div>
                </div>
                <div class="modal-footer border-transparent">
                    <button type="button" class="btn"
                        style="border: solid gray; border-radius: 8px; border-width: 1px;"
                        data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="submit_form" class="btn btn-danger"
                        style="border-radius: 8px !important">Completar alerta</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="postponeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 8px !important">
                <div class="modal-header border-transparent">
                    <div class="flex flex-col">
                        <h5 class="modal-title" id="exampleModalLabel">Posponer alerta</h5>
                        <p class="text-muted">Esta acción aplazara la fecha de la alerta.</p>
                    </div>
                    <button type="button" class="btn-close text-sm" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body border-transparent">
                    <div class="py-2 px-3 text-blue-600 d-flex align-items-center" role="alert"
                        style="border: solid #447aef; border-radius: 8px; border-width: 1px; margin-top:-5%">
                        <i class="fa-solid fa-triangle-exclamation mr-2" style="color:#447aef"></i>
                        <div>Serás redirigido a la pantalla de edición de la alerta.</div>
                    </div>
                </div>
                <div class="modal-footer border-transparent">
                    <button type="button" class="btn"
                        style="border: solid gray; border-radius: 8px; border-width: 1px;"
                        data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="postpone_form" class="btn btn-primary"
                        style="border-radius: 8px !important">Ir</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="generarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 8px !important">
                <div class="modal-header border-transparent">
                    <div class="flex flex-col">
                        <h5 class="modal-title" id="exampleModalLabel">Generar pedido médico</h5>
                        <p class="text-muted">Esta acción aplazara la fecha de la alerta.</p>
                    </div>
                    <button type="button" class="btn-close text-sm" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div Class="px-2" style="margin-top: -3%;">
                    <input type="text" name="nombrePedido" id="nombrePedido" class="form-control rounded-lg"
                        placeholder="Nombre del pedido" required>

                </div>
                <div class="modal-body border-transparent">

                    <div class="container">
                        <div class="header flex justify-center">
                            <img src="{{ asset('storage/images/hu_logo.jpg') }}" alt="Logo UNCuyo" class="logo">
                        </div>

                        <div class="patient-info">
                            <p><strong>Paciente:</strong> {{ $persona->apellidos . ' ' . $persona->nombres }}</p>
                            <p><strong>Documento:</strong> {{ $persona->documento }}</p>
                            <p><strong>Obra social:</strong>
                                {{ DatoPersonaModel::where('tipo_dato', 'obra_social')->where('persona_id', $persona->id)->first()->dato ??($persona->obra_social ?? null) }}
                            </p>
                            <p><strong>Fecha:</strong>
                                {{ $alert->pedido_medico_created_at ? \Carbon\Carbon::parse($alert->pedido_medico_created_at)->format('d/m/Y') : \Carbon\Carbon::now()->format('d/m/Y') }}

                            </p>
                        </div>

                        <div class="prescription">
                            <h5 style="margin: 0;">Rp/</h5>
                            <div style="margin-left: 20px;">
                                <h6 style="margin: 0; margin-top:5%;">STO:</h6>
                                <div>
                                    <div class="flex flex-col">
                                        @foreach ($tiposExamenSelected as $examen)
                                            <!-- Contenedor para cada elemento con hover en conjunto -->
                                            <div class="flex items-center hover:bg-gray-200 rounded-xl cursor-pointer transition duration-200 examen-item"
                                                style="line-height: 1.2;">
                                                <!-- Nombre del examen -->
                                                <p class="text-sm flex-1 ml-2 examen-text">
                                                    - {{ ExamenModel::find($examen->tipo_examen_id)->nombre }}
                                                </p>

                                                <!-- Ícono -->
                                                <i class="fa-solid fa-ban text-sm ml-2 mr-1 examen-ban-icon"></i>
                                            </div>
                                        @endforeach
                                    </div>

                                </div>
                                <h6 style="margin: 0; margin-top:1%;">Diagnóstico:</h6>
                                <p style="margin-left: 10px;" class="text-sm">{{ $alert->detalle }}</p>
                            </div>
                        </div>

                        <div class="footer">
                            <p>Firmado electrónicamente por
                                {{ User::find($alert->created_by)->sexo === 'M' ? 'el Dr.' : 'la Dra.' }}
                                {{ User::find($alert->created_by)->name ?? '' }} - Matrícula:
                                {{ User::find($alert->created_by)->matricula ?? '' }} - Información confidencial -
                                Secreto médico -
                                Alcances del art. 156 del Código Penal. Validado en el sistema HIS-Alephoo según el art.
                                5 de la Ley
                                25.506 "Firma Electrónica".
                                <br> Paso de los Andes 3051 - Ciudad de Mendoza.
                            </p>
                            <p>Teléfonos (0261) 4135011 / (0261) 4135021 - info@hospital.uncu.edu.ar -
                                www.hospital.uncu.edu.ar </p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-transparent">
                    <button type="button" class="btn"
                        style="border: solid gray; border-radius: 8px; border-width: 1px;"
                        data-bs-dismiss="modal">Cancelar</button>
                    <a id="generate-pdf-btn"
                        class="btn btn-success px-3 py-2 bg-green-600 text-white hover:bg-green-700 transition-colors"
                        style="border-radius: 8px;" data-estado="Completada">
                        <i class="fa-solid fa-file-pdf mr-1"></i> Generar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto rounded-lg">

            <div class="shadow-sm rounded-lg" style="background-color: white">
                <!-- Alerta de completado -->
                <div id="alert_state_completed" class="alert-success"
                    style="display: none; text-align: center; padding:2px;">
                    Esta alerta está completada
                </div>
                <!-- Otras alertas -->
                <div id="alert_state_success" class="alert-success"
                    style="display: none; text-align: center; padding:2px;">
                    Estado agregado correctamente
                </div>
                <div id="alert_state_exist" class="alert-warning"
                    style="display: none; text-align: center; padding:2px;">
                    El estado ya está agregado
                </div>
                <div id="alert_state_date_disabled" class="alert-warning"
                    style="display: none; text-align: center; padding:2px;">
                    Esta alerta se activará en
                    {{ ucfirst(\Carbon\Carbon::parse($alert->fecha_objetivo)->locale('es')->translatedFormat('F Y')) }}
                </div>
                <div id="alert_state_error" class="alert-danger"
                    style="display: none; text-align: center; padding:2px;">
                    Hubo un error al agregar el estado
                </div>

                <!-- Formulario -->
                <form id="outer-form" action="{{ route('alert.completed') }}" method="POST" class="form-div">
                    @csrf
                    <div class="">
                        <!-- Información de la alerta -->
                        <div class="form-section bg-gray-50 p-4 rounded-lg">
                            <h2 class="text-xl font-bold mb-4">Información de la alerta</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                <div>
                                    <label for="editEspecialidad"
                                        class="block text-sm font-medium text-gray-700">Especialidad:</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ EspecialidadModel::find($alert->especialidad_id)->nombre }}</p>
                                </div>
                                <div class="flex flex-col md:flex-row gap-2">
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">Fecha de creación:</p>
                                        <p class="mt-1 text-sm text-gray-900">
                                            {{ ucfirst(\Carbon\Carbon::parse($alert->created_at)->locale('es')->translatedFormat('F Y')) }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">Fecha de la alerta:</p>
                                        <p class="mt-1 text-sm text-gray-900">
                                            {{ ucfirst(\Carbon\Carbon::parse($alert->fecha_objetivo)->locale('es')->translatedFormat('F Y')) }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Detalle -->
                            <div class="mt-4">
                                <div class="flex flex-col md:flex-row md:space-x-4">
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-gray-700">Examenes:</label>
                                        <div class="div-examenes flex flex-row flex-wrap">
                                            @foreach ($tiposExamenSelected as $tipoExamen)
                                                <div>
                                                    <span
                                                        class="estado inline-block px-2 py-1 text-xs font-medium rounded-full mr-2 mb-2 text-white"
                                                        style="background-color: #343a40">
                                                        {{ $tipoExamen->tipoExamen->nombre }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="flex-1 mt-4 md:mt-0">
                                        <label class="block text-sm font-medium text-gray-700">Estados:</label>
                                        <div class="div-estados flex flex-row flex-wrap">
                                            @php
                                                $estados = EstadoAlertaModel::getEstadosById($alert->id);
                                            @endphp
                                            @foreach ($estados as $estado)
                                                <div>
                                                    <span
                                                        class="estado inline-block px-2 py-1 text-xs font-medium rounded-full mr-2 mb-2 {{ match ($estado->estado_id) {
                                                            1, 4, 6, 7, 9, 11 => 'bg-green-100 text-green-800',
                                                            2, 3, 5, 8, 10 => 'bg-red-100 text-red-800',
                                                            default => 'bg-gray-100 text-gray-800',
                                                        } }}"
                                                        data-id="{{ $estado->estado_id }}">
                                                        {{ EstadoModel::find($estado->estado_id)->nombre ?? '' }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <label for="editDetalle"
                                    class="block text-sm font-medium text-gray-700 mt-4">Diagnóstico:</label>
                                <div class="mt-1 p-2 bg-white border border-gray-300 rounded-md">
                                    <p class="text-sm text-gray-900">{{ $alert->detalle }}</p>
                                </div>
                            </div>

                        </div>

                        <!-- Información del paciente -->
                        <div class="form-section bg-gray-50 p-4 rounded-lg">
                            <h2 class="text-xl font-bold mb-4">Información del paciente</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                <input type="hidden" id="editAlertId" name="editAlertId"
                                    value="{{ $alert->id }}" required>
                                <input type="hidden" id="editId" name="editId"
                                    value="{{ $alert->persona_id }}" required>

                                <div>
                                    <label for="editDNI" class="block text-sm font-medium text-gray-700">DNI:</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $persona->documento }}</p>
                                </div>
                                <div>
                                    <label for="editFechaNac" class="block text-sm font-medium text-gray-700">Fecha de
                                        nacimiento:</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ \Carbon\Carbon::parse($persona->fecha_nacimiento)->format('d/m/y') }}</p>
                                </div>
                                <div>
                                    <label for="editApellido"
                                        class="block text-sm font-medium text-gray-700">Apellido/s y Nombre/s:</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ $persona->apellidos . ' ' . $persona->nombres }}</p>
                                </div>




                                <!-- Información de contacto -->
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
                                <div>
                                    <label for="editCelular"
                                        class="block text-sm font-medium text-gray-700">Celular:</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ $celularLocal !== null && $celularLocal !== '+' ? $celularLocal : $persona->celular ?? 'Celular no encontrado' }}
                                    </p>
                                </div>
                                <div>
                                    <label for="editObraSocial" class="block text-sm font-medium text-gray-700">Obra
                                        social:</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $persona->obra_social }}</p>
                                </div>
                                <div>
                                    <label for="editEmail"
                                        class="block text-sm font-medium text-gray-700">Email:</label>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ $emailLocal !== null && $emailLocal !== '+' ? $emailLocal : $persona->email ?? 'Email no encontrado' }}
                                    </p>
                                </div>
                                <input type="hidden" id="is_in_alephoo" name="is_in_alephoo"
                                    value="{{ $alert->is_in_alephoo }}" required>
                            </div>
                            <label class="block text-sm font-medium text-gray-700 mt-4">Observaciones:</label>
                            <textarea
                                class="text-sm text-gray-900 mt-1 p-2 bg-white border border-gray-300 rounded-md w-full resize-none custom-scrollbar"
                                rows="1" oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'" id="observaciones">{{ $alert->observacion }}</textarea>


                        </div>
                        <div class="form-section bg-gray-50 p-4 rounded-lg">

                            <h2 class="text-xl font-bold mb-4">Pedidos medicos</h2>
                            @foreach ($pedidos_medicos as $pedido_medico)
                                <a href="{{ route('ver.pdf', ['pedido_medico_id' => $pedido_medico->id]) }}"
                                    class="btn btn-success px-2 text-center text-8xl py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors"
                                    data-bs-toggle="popover" data-bs-placement="bottom"
                                    title="{{ $pedido_medico->nombre }}" data-bs-trigger="hover"
                                    data-estado="Completada">
                                    <i class="fa-solid fa-file-pdf"></i>
                                </a>
                            @endforeach


                            @if ($estados->contains('estado_id', 4))
                                <button type="button" id="generateButton"
                                    class="btn btn-success px-2 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors"
                                    data-estado="Completada" data-bs-toggle="modal" data-bs-target="#generarModal"><i
                                        class="fa-solid fa-file-medical"></i>
                                </button>
                            @endif

                            @if (session('error'))
                                <div class=" text-red mt-2">
                                    {{ session('error') }}
                                </div>
                            @endif

                        </div>


                        <!-- Botones -->
                        <div
                            class="buttons_div md:flex-wrap justify-center gap-2 mt-6 whitespace-nowrap text-sm text-center p-3">
                            @if (!$estados->contains('estado_id', 4))
                                <button type="button"
                                    class="btn btn-dark px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition-colors"
                                    data-estado="Sin contactar">
                                    <i class="fa-solid fa-phone-slash mr-2"></i> Sin contactar
                                </button>
                                <button type="button"
                                    class="btn btn-dark px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition-colors"
                                    data-estado="Contactado">
                                    <i class="fa-solid fa-phone-flip mr-2"></i> Contactado
                                </button>
                                <button type="button"
                                    class="btn btn-dark px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition-colors"
                                    data-estado="Confirmado">
                                    <i class="fa-solid fa-calendar-check mr-2"></i> Confirmado
                                </button>
                                <button type="button"
                                    class="btn btn-dark px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-700 transition-colors"
                                    data-estado="Rechazado">
                                    <i class="fa-solid fa-calendar-xmark mr-2"></i> Rechazado
                                </button>
                                <button type="button"
                                    class="btn btn-primary px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors"
                                    data-estado="Completada" data-bs-toggle="modal" data-bs-target="#postponeModal">
                                    <i class="fa-solid fa-clock-rotate-left"></i> Posponer
                                </button>
                                <button type="button"
                                    class="btn btn-success px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition-colors"
                                    data-estado="Completada" data-bs-toggle="modal" data-bs-target="#infoModal">
                                    <i class="fa-solid fa-check mr-2"></i> Completar
                                </button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


</x-app-layout>


<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script>
    // Inicializa el array con todos los exámenes no tachados
    let examenesNoTachados = [];

    // Rellenar el array con todos los exámenes al inicio
    document.querySelectorAll('.examen-text').forEach((examenText) => {
        const examenNombre = examenText.textContent.trim();
        examenesNoTachados.push(examenNombre);
    });

    // Selecciona todos los íconos de ban y agrega un listener de clic
    document.querySelectorAll('.examen-ban-icon').forEach((icono) => {
        icono.addEventListener('click', (event) => {
            const examenItem = event.target.closest('.examen-item');
            const examenText = examenItem.querySelector('.examen-text');
            const examenNombre = examenText.textContent.trim();

            // Marcar el texto como tachado o deshacer el tache
            examenText.style.textDecoration = examenText.style.textDecoration === 'line-through' ?
                'none' : 'line-through';

            // Agregar o quitar el examen del array dependiendo de si está tachado
            if (examenText.style.textDecoration !== 'line-through') {
                // Si el texto no está tachado, agregarlo al array (si no está ya)
                if (!examenesNoTachados.includes(examenNombre)) {
                    examenesNoTachados.push(examenNombre);
                }
            } else {
                // Si el texto está tachado, eliminarlo del array
                examenesNoTachados = examenesNoTachados.filter(item => item !== examenNombre);
            }

            // Mostrar el array actualizado en la consola (para depuración)
            console.log(examenesNoTachados);
        });
    });

    // Función para obtener los exámenes no tachados
    function obtenerExamenesNoTachados() {
        return examenesNoTachados; // Aquí usamos el array previamente generado
    }

    // Manejar el clic en el enlace de generación del PDF
    document.getElementById('generate-pdf-btn').addEventListener('click', function(event) {
        event.preventDefault(); // Evitar el comportamiento por defecto del enlace

        // Obtener los exámenes no tachados
        const examenes = obtenerExamenesNoTachados();

        // Obtener el valor de nombrePedido (suponiendo que ya tienes esta variable disponible en tu contexto)
        const nombrePedido = $('#nombrePedido').val(); // Este valor debería venir de tu entorno de Laravel

        // Construir los parámetros de la URL con los exámenes no tachados y el nombrePedido
        const url = new URL("{{ route('generate.pdf', ['id' => $alert->id]) }}", window.location.origin);

        // Añadir el nombrePedido a la URL
        url.searchParams.append('nombrePedido', nombrePedido);

        // Añadir los exámenes a la URL
        examenes.forEach((examen, index) => {
            url.searchParams.append(`examenes[${index}]`, examen); // Añadir cada examen como parámetro
        });

        // Redirigir a la ruta generada con los parámetros
        window.location.href = url.toString();
    });


    document.addEventListener('DOMContentLoaded', function() {

        // Inicializa todos los popovers de la página
        var popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]');
        var popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(
            popoverTriggerEl));


        const textarea = document.getElementById("observaciones");

        // Ajusta la altura inicial del textarea
        textarea.style.height = textarea.scrollHeight + 'px';

        // Detecta cuando el usuario deja de escribir y envía el valor
        textarea.addEventListener("focusout", function() {
            autoSaveObservacion();
        });

        function autoSaveObservacion() {
            const observacion = textarea.value;
            const url = "{{ route('guardar.observacion') }}";
            // Llamada AJAX usando fetch
            fetch(url, { // Cambia esta ruta según tu configuración
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Token CSRF para Laravel
                    },
                    body: JSON.stringify({
                        observacion: observacion,
                        alert_id: {{ $alert->id }}
                    }) // Enviar ID para identificar el alert
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Observación guardada automáticamente');
                    } else {
                        console.error('Error al guardar la observación');
                    }
                })
                .catch(error => console.error('Error en la solicitud:', error));
        }
    });
    document.addEventListener('DOMContentLoaded', function() {

        const buttons = document.querySelectorAll('.buttons_div button');
        const estadosDiv = document.querySelector('.div-estados');

        // Mapa de estados con sus IDs correspondientes
        const estadoIds = {
            'Programada': 1,
            'Vencida': 2,
            'Sin contactar': 3,
            'Completada': 4,
            'Cancelada': 5,
            'Confirmado': 6,
            'Contactado': 7,
            'Rechazado': 8,
            'Informado por mail': 9
        };

        // Mapa para eliminar estados específicos
        const estadosToRemove = {
            6: 8, // Confirmada elimina Rechazado
            8: 6, // Rechazado elimina Confirmada
            7: 3, // Contactado elimina Sin contactar
            3: 7 // Sin contactar elimina Contactado
        };

        // Set para almacenar los estados ya presentes en el DOM
        const estadosPresentes = new Set();

        // Al cargar la página, añadimos los estados presentes al Set
        estadosDiv.querySelectorAll('.estado').forEach(state => {
            const estadoId = state.dataset.id;
            estadosPresentes.add(estadoId);
        });

        const fechaObjetivo = '{{ $alert->fecha_objetivo }}'; // Formato: YYYY-MM-DD

        const today = new Date();
        const todayYear = today.getFullYear();
        const todayMonth = today.getMonth() + 1; // Los meses en JavaScript van de 0 a 11
        const fechaObjetivoParts = fechaObjetivo.split('-');
        const fechaObjetivoYear = parseInt(fechaObjetivoParts[0], 10);
        const fechaObjetivoMonth = parseInt(fechaObjetivoParts[1], 10); // El mes está en la posición 1

        // Comprobar si estamos antes de la fecha objetivo (mes y año)
        const isBeforeAlertDate = (fechaObjetivoYear > todayYear) ||
            (fechaObjetivoYear === todayYear && fechaObjetivoMonth > todayMonth);

        // Solo desactivar si la alerta está completada (estado 4) o estamos antes de la fecha objetivo
        if (isBeforeAlertDate || estadosPresentes.has(String(4))) {
            if (estadosPresentes.has(String(4))) {
                alerts('alert_state_completed'); // Mostrar alerta de estado completado
            } else if (isBeforeAlertDate) {
                alerts(
                    'alert_state_date_disabled'
                ); // Mostrar alerta porque aún no hemos llegado al mes y año de la fecha objetivo
            }

            // Desactivar los botones
            const buttonsDiv = document.querySelector('.buttons_div');
            const buttons = buttonsDiv.children;

            Array.from(buttons).forEach(button => {
                button.setAttribute('disabled', 'true'); // Desactivar todos los botones
            });
            document.getElementById('generateButton').removeAttribute('disabled');


            return; // Salir de la función
        }

        buttons.forEach(button => {
            button.addEventListener('click', function() {
                const estadoText = this.dataset.estado.trim();
                const estadoId = estadoIds[estadoText];
                const alertId = document.querySelector('#editAlertId').value;

                // Si el botón es "Completada", no hacer nada
                if (estadoId === 4) return;

                // Verificar si el estado ya está presente en el Set (en memoria)
                if (estadosPresentes.has(String(estadoId))) {
                    alerts(
                        'alert_state_exist'
                    ); // Puedes usar una alerta o manejarlo de otra forma
                    return;
                }

                // Eliminar el estado que debe ser reemplazado
                if (estadosToRemove[estadoId]) {
                    removeState(estadosToRemove[estadoId]);
                }

                // Añadir el nuevo estado al servidor y al DOM
                $.post('{{ route('estado.agregar') }}', {
                    _token: '{{ csrf_token() }}',
                    alertId: alertId,
                    estadoId: estadoId
                }, function(response) {
                    if (response.success) {
                        const estadoClass = (estadoId) => {
                            switch (estadoId) {
                                case 1:
                                case 4:
                                case 6:
                                case 7:
                                case 9:
                                    return 'bg-green-100 text-green-800';
                                case 2:
                                case 3:
                                case 5:
                                case 8:
                                case 10:
                                    return 'bg-red-100 text-red-800';
                                default:
                                    return 'bg-gray-100 text-gray-800';
                            }
                        };
                        const estadoDiv = document.createElement('div');
                        estadoDiv.innerHTML = `
            <span class="estado inline-block px-2 py-1 text-xs font-medium rounded-full mr-2 mb-2 ${estadoClass(estadoId)}" data-id="${estadoId}">
                ${estadoText}
            </span>`;

                        estadosDiv.appendChild(estadoDiv);

                        // Añadir el nuevo estado al Set para evitar duplicados
                        estadosPresentes.add(String(estadoId));

                        alerts('alert_state_success');
                    }
                });

            });
        });

        // Función para eliminar un estado específico
        function removeState(estadoIdToRemove) {
            $.post('{{ route('estado.eliminar') }}', {
                _token: '{{ csrf_token() }}',
                alertId: document.querySelector('#editAlertId').value,
                estadoId: estadoIdToRemove
            }, function(response) {
                if (response.success) {
                    const states = estadosDiv.querySelectorAll('.estado');
                    states.forEach(state => {
                        if (state.dataset.id == estadoIdToRemove) {
                            state.parentNode
                                .remove(); // Eliminar el elemento 'span' directamente
                            estadosPresentes.delete(String(
                                estadoIdToRemove)); // Eliminar el estado del Set
                        }
                    });
                }
            });
        }


        function alerts(alertaId) {
            $('#alert_state_success').hide();
            $('#alert_state_exist').hide();
            $('#alert_state_error').hide();
            $('#alert_state_completed').hide();
            $('#alert_state_date_disabled').hide();

            $('#' + alertaId).show();
        }

        function completed() {
            $('#outer-form').submit();
        }

        function postponed() {
            const url = @json(route('alert.edit', ['id' => $alert->id, 'edit_time' => true]));
            window.location.href = url;
        }

        $('#submit_form').on('click', completed);
        $('#postpone_form').on('click', postponed);

    });
</script>
