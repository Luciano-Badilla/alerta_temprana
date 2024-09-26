@php
    use App\Models\PersonaAlephooModel;
    use App\Models\PersonaLocalModel;
    use App\Models\EstadoModel;
    use App\Models\DatoPersonaModel;
    use App\Models\EspecialidadModel;
    use App\Models\TipoModel;
    use App\Models\EstadoAlertaModel;
    use Carbon\Carbon;
@endphp
<script src="https://cdn.tailwindcss.com"></script>
<style>
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

    .container {
        padding: 1%;
        display: flex;
        flex-direction: row;
        justify-content: space-evenly;
        flex-wrap: wrap;
        /* Para que los elementos se ajusten en pantallas pequeñas */
    }

    .form-section {
        display: flex;
        flex-direction: column;
        gap: 20px;
        padding: 10px;
        flex: 1;
        /* Para que ambos divs ocupen el mismo espacio */
        max-width: 48%;
        /* Ajusta el ancho de cada sección */
        box-sizing: border-box;
    }

    .input-group {
        display: flex;
        flex-direction: column;
        gap: 0px;
    }

    .input-wrapper {
        display: flex;
        align-items: center;
        gap: 0px;
    }

    .input-wrapper button {
        width: auto;
        padding: 10px;
    }

    .error-message {
        display: none;
        color: red;
        margin: 2px;
    }

    /* Ajusta la altura y el tamaño del contenedor de Select2 */
    .select2-container .select2-selection--single {
        height: 38px !important;
        /* Ajusta según tus necesidades */
        line-height: 36px !important;
    }

    .select2-container .select2-selection--multiple {
        min-height: 38px !important;
        /* Para selects múltiples */
    }

    .select2-container {
        font-size: 16px !important;
    }

    .buttons_div {
        display: flex;
        flex-direction: column;
        gap: 5px;
        margin-top: 1%;
        margin-left: 5%;
    }

    .div-estados {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        gap: 5px;
        justify-content: flex-start;
    }

    .buttons_div {
        display: flex;
        flex-direction: row;
        /* O 'column' si prefieres los botones en columna */
        flex-wrap: wrap;
        /* Permite que los botones se envuelvan si hay falta de espacio */
        gap: 10px;
        /* Espacio entre los botones, ajusta según sea necesario */
        justify-content: space-between;
        /* Distribuye los botones uniformemente */
    }

    .btn,
    .btn-dark,
    .btn-success {
        /* Asegura que todos los botones se expandan para ocupar el mismo espacio */
        text-align: center;
        /* Centra el texto dentro del botón */
        white-space: nowrap;
        /* Previene que el texto se rompa en varias líneas */
        min-width: 150px;
        /* Establece un ancho mínimo para los botones, ajusta según sea necesario */
    }


    /* Media query para pantallas pequeñas */
    @media (max-width: 768px) {
        .container {
            flex-direction: column;
            /* Cambia la dirección a columna en pantallas pequeñas */
        }

        .form-section {
            max-width: 100%;
            /* Haz que los divs ocupen el 100% del ancho en móviles */
        }

        .radio-container {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            /* Espacio entre los elementos */
        }

        .radio-item {
            width: 100%;
        }

        #personalizadoMeses {
            max-width: 100%;
        }

        .buttons_div {
            display: flex;
            flex-direction: row;
            gap: 5px;
            margin-top: 1%;
            flex-wrap: wrap
        }

        .btn,
        .btn-dark,
        .btn-success {
            flex: 1;
            /* Asegura que todos los botones se expandan para ocupar el mismo espacio */
            text-align: center;
            /* Centra el texto dentro del botón */
            white-space: nowrap;
            /* Previene que el texto se rompa en varias líneas */
            min-width: 150px;
            /* Establece un ancho mínimo para los botones, ajusta según sea necesario */
        }
    }

    @media (min-width: 768px) {
        .radio-container {
            display: flex;
            flex-direction: row;
            gap: 1rem;
            /* Espacio entre los elementos */
        }

        .radio-item {
            flex: 1;
        }

        #personalizadoMeses {
            max-width: 50%;
        }
    }

    #personalizadoMeses {
        display: none;
    }
</style>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 leading-tight">
            {{ __('Gestion alerta Nº ' . $alert->id) }}
        </h2>
    </x-slot>
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">¿Completar alerta?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="flex flex-col gap-2">
                        <p class="alert alert-danger">Al completar la alerta se marcara como completada y ya no se podra
                            gestionar.</p>
                        <button type="button" id="submit_form" class="btn btn-success">Completar alerta</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background-color: white">
                <div id="alert_state_completed" class="alert-success"
                    style="display: none; text-align: center; padding:2px;">
                    Esta alerta esta completada
                </div>
                <div id="alert_state_success" class="alert-success"
                    style="display: none; text-align: center; padding:2px;">
                    Estado agregado correctamente
                </div>
                <div id="alert_state_exist" class="alert-warning"
                    style="display: none; text-align: center; padding:2px;">
                    El estado ya esta agregado
                </div>
                <div id="alert_state_date_disabled" class="alert-warning"
                    style="display: none; text-align: center; padding:2px;">
                    Esta alerta se activara en
                    {{ ucfirst(\Carbon\Carbon::parse($alert->fecha_objetivo)->locale('es')->translatedFormat('F Y')) }}
                </div>
                <div id="alert_state_error" class="alert-danger"
                    style="display: none; text-align: center; padding:2px;">
                    Hubo un error al agregar el estado
                </div>

                <form id="outer-form" action="{{ route('alert.completed') }}" method="POST">
                    @csrf
                    <div class="container">

                        <div class="form-section">
                            <label class="form-check-label" for="en-uso" style="font-size: 20px"><b>Información de
                                    la
                                    alerta:</b></label>
                            <div class="input-group">
                                <div>
                                    <label for="editEspecialidad" class="form-label">Especialidad:</label>
                                    <p style="color: #495057">
                                        {{ EspecialidadModel::find($alert->especialidad_id)->nombre }}</p>
                                </div>
                                <div class="flex gap-2">
                                    <p><strong>Fecha de creación:</strong>
                                        {{ ucfirst(\Carbon\Carbon::parse($alert->created_at)->locale('es')->translatedFormat('F Y')) }}
                                    <p><strong>Fecha de la alerta:</strong>
                                        {{ ucfirst(\Carbon\Carbon::parse($alert->fecha_objetivo)->locale('es')->translatedFormat('F Y')) }}
                                </div>
                                <div>
                                    <label for="editDetalle" class="form-label">Detalle:</label>
                                    <div class="h-24 overflow-y-auto p-2 bg-gray-50 rounded-md custom-scrollbar">
                                        <p class="text-sm text-gray-600">{{ $alert->detalle }}</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="form-section">
                            <label class="form-check-label" for="en-uso" style="font-size: 20px"><b>Información del
                                    paciente:</b></label>
                            <div class="input-group">
                                <div class="flex flex-row flex-wrap">
                                    <div style="flex: 1 1 100%;">
                                        <input type="hidden" id="editAlertId" name="editAlertId"
                                            value="{{ $alert->id }}" required>
                                        <input type="hidden" id="editId" name="editId"
                                            value="{{ $alert->persona_id }}" required>
                                        <label for="editDNI" class="form-label">DNI:</label>
                                        <p style="color: #495057">{{ $persona->documento }}</p>
                                    </div>
                                    <div style="flex: 1 1 100%;">
                                        <label for="editFechaNac" class="form-label">Fecha de nacimiento:</label>
                                        <p style="color: #495057">
                                            {{ \Carbon\Carbon::parse($persona->fecha_nacimiento)->format('d/m/y') }}
                                        </p>
                                    </div>

                                    <div style="flex: 1 1 50%;">
                                        <label for="editApellido" class="form-label">Apellido/s:</label>
                                        <p style="color: #495057">{{ $persona->apellidos }}</p>
                                    </div>

                                    <div style="flex: 1 1 50%; margin-left:-40%">
                                        <label for="editNombre" class="form-label">Nombre/s:</label>
                                        <p style="color: #495057">{{ $persona->nombres }}</p>
                                    </div>


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
                                    <div style="flex: 1 1 50%;">
                                        <label for="editCelular" class="form-label">Celular:</label>
                                        <p style="color: #495057">
                                            {{ $celularLocal !== null && $celularLocal !== '+' ? $celularLocal : $persona->celular ?? 'Celular no encontrado' }}
                                        </p>
                                    </div>

                                    <div style="flex: 1 1 50%; margin-left:-40%">
                                        <label for="editEmail" class="form-label">Email:</label>
                                        <p style="color: #495057">
                                            {{ $emailLocal !== null && $emailLocal !== '+' ? $emailLocal : $persona->email ?? 'Email no encontrado' }}
                                        </p>
                                    </div>

                                    <input type="hidden" id="is_in_alephoo" name="is_in_alephoo"
                                        value="{{ $alert->is_in_alephoo }}" required>
                                </div>

                            </div>
                        </div>
                        <div class="form-section">

                            <label class="form-check-label" for="en-uso" style="font-size: 20px"><b>Estados de la
                                    alerta:</b></label>
                            <div class="input-group">
                                @php
                                    $estados = EstadoAlertaModel::getEstadosById($alert->id);
                                @endphp
                                <div class="div-estados custom-scrollbar">
                                    @foreach ($estados as $estado)
                                        <div class="flex">
                                            <span
                                                class="estado px-2 py-1 text-xs font-medium rounded-full {{ match ($estado->estado_id) {
                                                    1, 4, 6, 7, 9 => 'bg-green-100 text-green-800',
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

                        <div class="buttons_div">
                            <button type="button" class="btn btn-dark" data-estado="Sin contactar"><i
                                    class="fa-solid fa-phone-slash"></i> Sin
                                contactar</button>
                            <button type="button" class="btn btn-dark" data-estado="Contactado"><i
                                    class="fa-solid fa-phone-flip"></i> Contactado</button>
                            <button type="button" class="btn btn-dark" data-estado="Confirmado"><i
                                    class="fa-solid fa-calendar-check"></i> Confirmado</button>
                            <button type="button" class="btn btn-dark" data-estado="Rechazado"><i
                                    class="fa-solid fa-calendar-xmark"></i> Rechazado</button>
                            <button type="button" class="btn btn-success" data-estado="Completada"
                                data-bs-toggle="modal" data-bs-target="#infoModal"><i class="fa-solid fa-check"></i>
                                Completar</button>
                        </div>


                    </div>

                </form>
            </div>
        </div>

</x-app-layout>


<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script>
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

        const alertDate = new Date(
            '{{ $alert->fecha_objetivo }}'); // Asegúrate de que esto tenga el formato correcto
        const currentDate = new Date();

        // Comprobar si la fecha ha pasado
        const hasPassed = alertDate < currentDate;

        // Verificar si el estado presente incluye el estado 4
        /*if (estadosPresentes.has(String(4))) {
            alerts('alert_state_completed');
            const buttonsDiv = document.querySelector('.buttons_div');

            // Obtiene todos los hijos directos del div y los desactiva
            const buttons = buttonsDiv.children;
            Array.from(buttons).forEach(button => {
                button.setAttribute('disabled', 'true');
            });
            return;
        }*/

        if (estadosPresentes.has(String(4)) || !hasPassed) {
            if (estadosPresentes.has(String(4))) {
                alerts('alert_state_completed');
            } else {
                alerts('alert_state_date_disabled');
            }
            const buttonsDiv = document.querySelector('.buttons_div');

            // Obtiene todos los hijos directos del div y los desactiva
            const buttons = buttonsDiv.children;
            Array.from(buttons).forEach(button => {
                button.setAttribute('disabled', 'true');
            });
            return;
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
                                    return 'bg-red-100 text-red-800';
                                default:
                                    return 'bg-gray-100 text-gray-800';
                            }
                        };
                        const estadoDiv = document.createElement('div');
                        estadoDiv.className = 'flex';
                        estadoDiv.innerHTML = `
            <span class="estado px-2 py-1 text-xs font-medium rounded-full ${estadoClass(estadoId)}" data-id="${estadoId}">
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

        $('#submit_form').on('click', completed);



    });
</script>
