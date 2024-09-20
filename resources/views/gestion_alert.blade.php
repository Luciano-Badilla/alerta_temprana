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

<style>
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

    .estado {
        color: white;
        font-size: 12px;
        margin: 0;
        /* Elimina cualquier margen */
        padding: 0px;
        text-align: center;
        /* Centra el texto horizontalmente */
        display: flex;
        align-items: center;
        /* Centra verticalmente el texto dentro del contenedor */
    }

    .estado_background {
        background-color: #343A40;
        border-radius: 0.375rem;
        display: flex;
        justify-content: center;
        align-items: center;
        /* Centra el contenido dentro del div vertical y horizontalmente */
        padding: 10px;
        /* Ajusta el relleno según sea necesario */
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
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="overflow-hidden shadow-sm sm:rounded-lg" style="background-color: white">
                <div id="alert_state_success" class="alert-success" style="display: none; text-align: center; padding:2px;">
                    Estado agregado correctamente
                </div>
                <div id="alert_state_exist" class="alert-warning" style="display: none; text-align: center; padding:2px;">
                    El estado ya esta agregado
                </div>
                <div id="alert_state_error" class="alert-danger" style="display: none; text-align: center; padding:2px;">
                    Hubo un error al agregar el estado
                </div>

                <form id="outer-form" action="{{ route('alert.edit_store') }}" method="POST">
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

                                <div>
                                    <label for="editDetalle" class="form-label">Detalle:</label>
                                    <p style="color: #495057; text-align: justify;">{{ $alert->detalle }}</p>

                                </div>
                            </div>
                        </div>
                        <div class="form-section">
                            <label class="form-check-label" for="en-uso" style="font-size: 20px"><b>Informacion del
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
                                            {{ \Carbon\Carbon::parse($persona->fecha_nacimiento)->format('d/m/y') }}</p>
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
                                        <div class="estado_background">
                                            <p class="estado" data-id="{{ $estado->estado_id }}">
                                                {{ EstadoModel::find($estado->estado_id)->nombre ?? '' }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="buttons_div">
                            <button type="button" class="btn btn-dark" data-estado="Sin contactar">Sin
                                contactar</button>
                            <button type="button" class="btn btn-dark" data-estado="Contactado">Contactado</button>
                            <button type="button" class="btn btn-dark" data-estado="Confirmado">Confirmado</button>
                            <button type="button" class="btn btn-dark" data-estado="Rechazado">Rechazado</button>
                            <button type="button" class="btn btn-success" data-estado="Completada">Completada</button>
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

        buttons.forEach(button => {
            button.addEventListener('click', function() {
                const estadoText = this.dataset.estado.trim();
                const estadoId = estadoIds[estadoText];
                const alertId = document.querySelector('#editAlertId').value;

                // Si el botón es "Completada", no hacer nada
                if (estadoId === 4) return;

                // Verificar si el estado ya está presente en el Set (en memoria)
                if (estadosPresentes.has(String(estadoId))) {
                    alerts('alert_state_exist');// Puedes usar una alerta o manejarlo de otra forma
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
                        const estadoDiv = document.createElement('div');
                        estadoDiv.className = 'estado_background';
                        estadoDiv.innerHTML =
                            `<p class="estado" data-id="${estadoId}">${estadoText}</p>`;
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
                            estadosDiv.removeChild(state
                                .parentElement); // Eliminar el div contenedor
                            estadosPresentes.delete(String(
                                estadoIdToRemove)); // Eliminar el estado del Set
                        }
                    });
                }
            });
        }

        function alerts(alertaId){
            $('#alert_state_success').hide();
            $('#alert_state_exist').hide();
            $('#alert_state_error').hide();

            $('#' + alertaId).show();
        }
    });
</script>