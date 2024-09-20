@php
    use App\Models\PersonaAlephooModel;
    use App\Models\PersonaLocalModel;
    use App\Models\EstadoModel;
    use App\Models\DatoPersonaModel;
    use App\Models\EspecialidadModel;
    use App\Models\TipoModel;
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
        gap: 10px;
    }

    .input-wrapper {
        display: flex;
        align-items: center;
        gap: 5px;
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
                <div id="alert_paciente" class="alert-danger" style="display: none; text-align: center; padding:2px;">
                    El paciente no se encuentra ingresado en Alephoo ni en la base de datos local, deberá ser cargado
                    manualmente.
                </div>
                <div id="alert2_paciente" class="alert-danger" style="display: none; text-align: center; padding:2px;">
                    El paciente no se encuentra ingresado en Alephoo, estos datos fueros extraidos de la base de datos
                    local, puede que esten desactualizados.
                </div>
                <div id="alert3_paciente" class="alert-danger" style="display: none; text-align: center; padding:2px;">
                    El paciente se encuentra ingresado en Alephoo, pero algunos datos no estan cargados.
                </div>
                <div id="alert4_paciente" class="alert-danger" style="display: none; text-align: center; padding:2px;">
                    El paciente se encuentra ingresado en Alephoo, algunos datos no estan cargados, pero se encontraron
                    en
                    la base de datos local.
                </div>

                <form id="outer-form" action="{{ route('alert.edit_store') }}" method="POST">
                    @csrf
                    <div class="container">
                        <div class="form-section">
                            <label class="form-check-label" for="en-uso"
                                style="font-size: 20px"><b>Paciente:</b></label>
                            <div class="input-group">
                                <div>
                                    <input type="hidden" id="editAlertId" name="editAlertId"
                                        value="{{ $alert->id }}" required>
                                    <input type="hidden" id="editId" name="editId" value="{{ $alert->persona_id }}"
                                        required>
                                    <label for="editDNI" class="form-label">DNI:</label>
                                    <div class="input-wrapper">
                                        <input type="text" class="form-control" id="editDNI" name="editDNI"
                                            value="{{ $persona->documento }}" placeholder="Numero de DNI" required>
                                        <button type="button" class="btn btn-dark" id="searchByDni">
                                            <i id="search_icon" class="fa-solid fa-magnifying-glass"
                                                style="display: block"></i>
                                            <div id="loading_icon" class="spinner-border spinner-border-sm"
                                                role="status" style="display: none;">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </button>
                                    </div>
                                    <div id="input0_not_found" class="error-message">DNI no encontrado.</div>
                                </div>

                                <div>
                                    <label for="editApellido" class="form-label">Apellido/s:</label>
                                    <input type="text" class="form-control" id="editApellido" name="editApellido"
                                        value="{{ $persona->apellidos }}" placeholder="Apellido/s" readonly>
                                    <div id="input1_not_found" class="error-message">Apellido no encontrado.</div>
                                    <div id="input1_1_not_found" class="error-message">Puede que el apellido este
                                        desactualizado.</div>
                                </div>

                                <div>
                                    <label for="editNombre" class="form-label">Nombre/s:</label>
                                    <input type="text" class="form-control" id="editNombre" name="editNombre"
                                        value="{{ $persona->nombres }}" placeholder="Nombre/s" readonly>
                                    <div id="input2_not_found" class="error-message">Nombre no encontrado.</div>
                                    <div id="input2_2_not_found" class="error-message">Puede que el nombre este
                                        desactualizado.</div>
                                </div>

                                <div>
                                    <label for="editFechaNac" class="form-label">Fecha de nacimiento:</label>
                                    <input type="date" class="form-control" id="editFechaNac" name="editFechaNac"
                                        value="{{ \Carbon\Carbon::parse($persona->fecha_nacimiento)->format('Y-m-d') }}"
                                        placeholder="Fecha de nacimiento" readonly>

                                    <div id="input3_not_found" class="error-message">Fecha de nacimiento no encontrada.
                                    </div>
                                    <div id="input3_3_not_found" class="error-message">Puede que la fecha de nacimiento
                                        este desactualizada.
                                    </div>
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
                                <div>
                                    <label for="editCelular" class="form-label">Celular:</label>
                                    <input type="text" class="form-control" id="editCelular" name="editCelular"
                                        value="{{ $celularLocal !== null && $celularLocal !== '+' ? $celularLocal : $persona->celular ?? 'Celular no encontrado' }}"
                                        placeholder="Celular">
                                    <div id="input4_not_found" class="error-message">Número de celular no encontrado.
                                    </div>
                                    <div id="input4_4_not_found" class="error-message">Puede que el celular este
                                        desactualizado.
                                    </div>
                                </div>

                                <div>
                                    <label for="editEmail" class="form-label">Email:</label>
                                    <input type="email" class="form-control" id="editEmail" name="editEmail"
                                        value="{{ $emailLocal !== null && $emailLocal !== '+' ? $emailLocal : $persona->email ?? 'Email no encontrado' }}"
                                        placeholder="Email">
                                    <div id="input5_not_found" class="error-message">Email no encontrado.</div>
                                </div>
                                <div id="input5_5_not_found" class="error-message">Puede que el email este
                                    desactualizado.</div>

                                <input type="hidden" id="is_in_alephoo" name="is_in_alephoo"
                                    value="{{ $alert->is_in_alephoo }}" required>
                            </div>
                        </div>

                        <div class="form-section">
                            <label class="form-check-label" for="en-uso" style="font-size: 20px"><b>Información de
                                    la
                                    alerta:</b></label>
                            <div class="input-group">
                                <div>
                                    <label for="editEspecialidad" class="form-label">Especialidad:</label>
                                    <select type="text" class="form-control" id="editEspecialidad"
                                        name="editEspecialidad" required>
                                        <option value="">Seleccione una especialidad</option>
                                        @foreach ($especialidades as $especialidad)
                                            <option value="{{ $especialidad->id }}">{{ $especialidad->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="editDetalle" class="form-label">Detalle:</label>
                                    <textarea class="form-control" id="editDetalle" name="editDetalle" placeholder="Detalle"
                                        style="resize: none; overflow: hidden;"
                                        oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'" required>{{ $alert->detalle }}</textarea>
                                </div>


                                <div class="p-2">
                                    <div class="flex gap-2">
                                        <p><strong>Fecha de creación:</strong>
                                            {{ ucfirst(\Carbon\Carbon::parse($alert->created_at)->locale('es')->translatedFormat('F Y')) }}
                                        <p><strong>Fecha de la alerta:</strong>
                                            {{ ucfirst(\Carbon\Carbon::parse($alert->fecha_objetivo)->locale('es')->translatedFormat('F Y')) }}
                                    </div>
                                    <p class="alert alert-danger">Al editar la fecha de la alerta se contara desde la
                                        fecha de creacion.</p>
                                    <label for="editFechaAlert" class="form-label">Fecha de la alerta: (dentro
                                        de...)</label>



                                    <div class="radio-container ml-1">
                                        <div class="form-check radio-item">
                                            <input class="form-check-input" type="radio" name="fecha_alert"
                                                id="6meses" value="6meses" checked>
                                            <label class="form-check-label" for="6meses">6 meses</label>
                                        </div>

                                        <div class="form-check radio-item">
                                            <input class="form-check-input" type="radio" name="fecha_alert"
                                                id="1anio" value="1anio">
                                            <label class="form-check-label" for="1anio">1 año</label>
                                        </div>

                                        <div class="form-check radio-item">
                                            <input class="form-check-input" type="radio" name="fecha_alert"
                                                id="2anios" value="2anios">
                                            <label class="form-check-label" for="2anios">2 años</label>
                                        </div>

                                        <div class="form-check radio-item">
                                            <input class="form-check-input" type="radio" name="fecha_alert"
                                                id="5anios" value="5anios">
                                            <label class="form-check-label" for="5anios">5 años</label>
                                        </div>

                                        <div class="form-check radio-item">
                                            <input class="form-check-input" type="radio" name="fecha_alert"
                                                id="personalizado" value="personalizado">
                                            <label class="form-check-label" for="personalizado">Especificar</label>
                                        </div>
                                    </div>

                                    <!-- Campo personalizado con opción de unidad -->
                                    <div id="personalizadoMeses" class="mt-2">
                                        <input type="number" class="form-control" id="numPersonalizado"
                                            name="numPersonalizado" placeholder="Número" min="1">

                                        <!-- Opciones para especificar unidad -->
                                        <div class="ml-2 mt-1">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="unidadPersonalizado" id="meses" value="meses" checked>
                                                <label class="form-check-label" for="meses">Meses</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                    name="unidadPersonalizado" id="anios" value="anios">
                                                <label class="form-check-label" for="anios">Años</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 ml-1 flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="tipo_alerta"
                                                id="una_sola_vez" value="1" checked>
                                            <label class="form-check-label" for="una_sola_vez">Una sola vez</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="tipo_alerta"
                                                id="siempre" value="2">
                                            <label class="form-check-label" for="siempre">Siempre</label>
                                        </div>
                                    </div>
                                </div>
                                


                            </div>
                            <div style="text-align: right;">
                                <button type="submit" class="btn btn-dark">Editar alerta</button>
                            </div>

                        </div>
                    </div>

                </form>
            </div>
        </div>

</x-app-layout>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script>
    tipo = "{{ $alert->tipo_id }}";
    tipo_frecuencia = "{{ $alert->tipo_frecuencia }}";
    frecuencia = "{{ $alert->frecuencia }}";
    $('#editEspecialidad').val("{{ $alert->especialidad_id }}");
    $('#editEspecialidad').select2();
    if (frecuencia == 6 && tipo_frecuencia == 'meses') {
        $('#6meses').prop('checked', true);
    } else if (frecuencia == 1 && tipo_frecuencia == 'anios') {
        $('#1anio').prop('checked', true);
    } else if (frecuencia == 2 && tipo_frecuencia == 'anios') {
        $('#2anios').prop('checked', true);
    } else if (frecuencia == 5 && tipo_frecuencia == 'anios') {
        $('#5anios').prop('checked', true);
    } else {
        $('#personalizado').prop('checked', true).trigger('change');
        const personalizadoInput = document.getElementById('personalizadoMeses');
        personalizadoInput.style.display = 'block';

        $('#numPersonalizado').val(frecuencia);

        if (tipo_frecuencia == 'meses') {
            $('#meses').prop('checked', true);
        } else {
            $('#anios').prop('checked', true);
        }


    }

    if (tipo == 1) {
        $('#una_sola_vez').prop('checked', true);
    } else {
        $('#siempre').prop('checked', true);
    }
    document.querySelectorAll('input[name="fecha_alert"]').forEach((radio) => {
        radio.addEventListener('change', function() {
            const personalizadoInput = document.getElementById('personalizadoMeses');

            if (this.id === 'personalizado') {
                personalizadoInput.style.display = 'block';
            } else {
                personalizadoInput.style.display = 'none';
                personalizadoInput.value = ''; // Limpiar el campo si se selecciona otra opción
            }
        });
    });

    document.getElementById('editDNI').addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            // Evita que el formulario se envíe
            event.preventDefault();
            // Ejecuta la función de búsqueda
            document.getElementById('searchByDni').click();
        }
    });


    $(document).ready(function() {

        // Ajuste de altura después de un pequeño retraso
        setTimeout(function() {
            $('.select2-container').css('height', 'auto');
        }, 100); // Ajusta el tiempo si es necesario

        $('#outer-form').on('submit', function(e) {
            e.preventDefault(); // Prevenimos el envío tradicional del formulario

            // Creamos un objeto para almacenar los campos que no son readonly
            let personalInfo = {};

            // Recorremos cada input dentro del formulario
            $('#outer-form').find('input, textarea').each(function() {
                // Si el campo no tiene el atributo readonly y tiene valor, lo añadimos al objeto
                if (!$(this).prop('readonly') && $(this).val() !== '') {
                    personalInfo[$(this).attr('name')] = $(this).val();
                }
            });

            var Url = '{{ route('alert.store2') }}';
            // Enviar solo los campos que no son readonly al servidor
            $.ajax({
                url: Url, // Ruta de tu controlador
                method: 'POST',
                data: {
                    _token: $('input[name="_token"]').val(), // Agregar token CSRF
                    personalInfo: personalInfo // Datos filtrados
                },
                success: function(response) {
                    // Manejar el éxito
                    $('#outer-form')[0].submit();
                },
                error: function(xhr, status, error) {
                    // Manejar errores
                    alert('Hubo un error al crear la alerta');
                }
            });
        });


        $('#searchByDni').on('click', function() {

            $('#search_icon').css('display', 'none');
            $('#loading_icon').css('display', 'block');

            var dni = $('#editDNI').val();

            var Url = '{{ route('get_data') }}';

            $.ajax({
                url: Url,
                type: 'POST',
                data: {
                    documento: dni,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    var data = response.original;
                    $('#editNombre').val(null);
                    $('#editApellido').val(null);
                    $('#editFechaNac').val(null);
                    $('#editCelular').val(null);
                    $('#editEmail').val(null);
                    $('#editId').val(null);
                    $('#input1_1_not_found').css('display', 'none');
                    $('#input2_2_not_found').css('display', 'none');
                    $('#input3_3_not_found').css('display', 'none');
                    $('#input4_4_not_found').css('display', 'none');
                    $('#input5_5_not_found').css('display', 'none');
                    if (data.nombres || data.apellidos || data.fecha_nacimiento || data
                        .email || !data.celular === '+' || data.id) {
                        $('#alert_paciente').css('display', 'none')
                        $('#alert2_paciente').css('display', 'none')
                        $('#alert3_paciente').css('display', 'none')
                        $('#alert4_paciente').css('display', 'none')
                        $('#is_in_alephoo').val("1");

                        if (data.id) {
                            $('#editId').val(data.id);
                        }
                        if (data.nombres) {
                            $('#editNombre').val(data.nombres);
                            $('#editNombre').attr("readonly", true);
                            $('#editNombre').attr("required", false);
                            $('#input1_not_found').css('display', 'none');
                        } else {
                            $('#editNombre').removeAttr("readonly");
                            $('#editNombre').attr("required", true);
                            $('#input1_not_found').css('display', 'block');
                        }
                        if (data.apellidos) {
                            $('#editApellido').val(data.apellidos);
                            $('#editApellido').attr("readonly", true);
                            $('#editApellido').attr("required", false);
                            $('#input2_not_found').css('display', 'none');

                        } else {
                            $('#editApellido').removeAttr("readonly");
                            $('#editApellido').attr("required", true);
                            $('#input2_not_found').css('display', 'block');
                        }
                        if (data.fecha_nacimiento) {
                            $('#editFechaNac').val(data.fecha_nacimiento);
                            $('#editFechaNac').attr("readonly", true);
                            $('#editFechaNac').attr("required", false);
                            $('#input3_not_found').css('display', 'none');
                        } else {
                            $('#editFechaNac').removeAttr("readonly");
                            $('#editFechaNac').attr("required", true);
                            $('#input3_not_found').css('display', 'block');
                        }
                        if (data.celular != '+') {
                            $('#editCelular').val(data.celular);
                            $('#editCelular').attr("required", false);
                            $('#input4_not_found').css('display', 'none');
                        } else {
                            $('#editCelular').attr("required", true);
                            $('#input4_not_found').css('display', 'block');
                        }
                        if (data.email) {
                            $('#editEmail').val(data.email || '');
                            $('#editEmail').attr("required", false);
                            $('#input5_not_found').css('display', 'none');
                        } else {
                            $('#editEmail').attr("required", true);
                            $('#input5_not_found').css('display', 'block');
                        }

                        if ($('#editNombre').val() == "" || $('#editApellido').val() ==
                            "" ||
                            $('#editFechaNac').val() == "" || $('#editCelular').val() ==
                            "" ||
                            $('#editEmail').val() == "") {
                            $('#alert3_paciente').css('display', 'block');
                        }
                        searchLocalDataEmptyInputs()
                    } else {
                        $('#editNombre').removeAttr("readonly");
                        $('#editApellido').removeAttr("readonly");
                        $('#editFechaNac').removeAttr("readonly");
                        $('#is_in_alephoo').val("0");
                        searchLocalData();
                    }
                    $('#search_icon').css('display', 'block');
                    $('#loading_icon').css('display', 'none');
                },
                error: function(xhr) {
                    if (xhr.status === 404) {
                        alert('No se encontró el registro');
                    } else {
                        alert('Ocurrió un error al buscar los datos');
                    }
                }
            });
        });

        function searchLocalData() {
            var dni = $('#editDNI').val();

            var Url = '{{ route('get_data_local') }}';

            $.ajax({
                url: Url,
                type: 'POST',
                data: {
                    documento: dni,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    var data = response.original;
                    $('#editNombre').val(null);
                    $('#editApellido').val(null);
                    $('#editFechaNac').val(null);
                    $('#editCelular').val(null);
                    $('#editEmail').val(null);
                    $('#editId').val(null);
                    $('#alert2_paciente').css('display', 'none')
                    if (data.nombres || data.apellidos || data.fecha_nacimiento || data
                        .email || !data.celular === '+' || data.id) {
                        $('#alert_paciente').css('display', 'none')
                        $('#alert2_paciente').css('display', 'none')
                        $('#alert3_paciente').css('display', 'none')
                        $('#alert4_paciente').css('display', 'none')
                        $('#is_in_alephoo').val("0");

                        if (data.id) {
                            $('#editId').val(data.id);
                            $('#alert2_paciente').css('display', 'block')
                        }
                        if (data.nombres) {
                            $('#editNombre').val(data.nombres);
                            $('#editNombre').attr("required", true);
                            $('#input1_not_found').css('display', 'none');
                        } else {
                            $('#editNombre').removeAttr("readonly");
                            $('#editNombre').attr("required", true);
                            $('#input1_not_found').css('display', 'block');
                        }
                        if (data.apellidos) {
                            $('#editApellido').val(data.apellidos);
                            $('#editApellido').attr("required", true);
                            $('#input2_not_found').css('display', 'none');

                        } else {
                            $('#editApellido').removeAttr("readonly");
                            $('#editApellido').attr("required", true);
                            $('#input2_not_found').css('display', 'block');
                        }
                        if (data.fecha_nacimiento) {
                            $('#editFechaNac').val(data.fecha_nacimiento);
                            $('#editFechaNac').attr("required", true);
                            $('#input3_not_found').css('display', 'none');
                        } else {
                            $('#editFechaNac').removeAttr("readonly");
                            $('#editFechaNac').attr("required", true);
                            $('#input3_not_found').css('display', 'block');
                        }
                        if (data.celular != '+') {
                            $('#editCelular').val(data.celular);
                            $('#editCelular').attr("required", true);
                            $('#input4_not_found').css('display', 'none');
                        } else {
                            $('#editCelular').attr("required", true);
                            $('#input4_not_found').css('display', 'block');
                        }
                        if (data.email) {
                            $('#editEmail').val(data.email || '');
                            $('#editEmail').attr("required", true);
                            $('#input5_not_found').css('display', 'none');
                        } else {
                            $('#editEmail').attr("required", true);
                            $('#input5_not_found').css('display', 'block');
                        }
                    } else {
                        $('#alert_paciente').css('display', 'block')
                        $('#editNombre').removeAttr("readonly");
                        $('#editApellido').removeAttr("readonly");
                        $('#editFechaNac').removeAttr("readonly");
                        $('#is_in_alephoo').val("0");
                    }

                    $('#search_icon').css('display', 'block');
                    $('#loading_icon').css('display', 'none');
                },
                error: function(xhr) {
                    if (xhr.status === 404) {
                        alert('No se encontró el registro');
                    } else {
                        alert('Ocurrió un error al buscar los datos');
                    }
                }
            });

        }

        function searchLocalDataEmptyInputs() {

            var dni = $('#editDNI').val();
            var id = $('#editId').val();

            var Url = '{{ route('get_data_local_empty_inputs') }}';

            $.ajax({
                url: Url,
                type: 'POST',
                data: {
                    id: id,
                    documento: dni,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    var datas = response.original;

                    // Iteramos sobre cada elemento del array "datas"
                    datas.forEach(function(data) {
                        console.log(data.tipo_dato);
                        if (data.dato || data.tipo_dato || data.persona_id) {
                            $('#alert_paciente').css('display', 'none')
                            $('#alert2_paciente').css('display', 'none')
                            $('#alert3_paciente').css('display', 'none')
                            $('#alert4_paciente').css('display', 'none')
                            $('#alert4_paciente').css('display', 'block');
                            if (data.dato && data.tipo_dato == 'nombre' && $('#editNombre')
                                .val() == "") {
                                $('#editNombre').val(data.dato);
                                $('#editNombre').attr("required", true);
                                $('#input1_not_found').css('display', 'none');
                                $('#input1_1_not_found').css('display', 'block');
                            }
                            if (data.dato && data.tipo_dato == 'apellido' && $(
                                    '#editApellido').val() == "") {
                                $('#editApellido').val(data.dato);
                                $('#editApellido').attr("required", true);
                                $('#input2_not_found').css('display', 'none');
                                $('#input2_2_not_found').css('display', 'block');
                            }
                            if (data.dato && data.tipo_dato == 'fecha_nac' && $(
                                    '#editFechaNac').val() == "") {
                                $('#editFechaNac').val(data.dato);
                                $('#editFechaNac').attr("required", true);
                                $('#input3_not_found').css('display', 'none');
                                $('#input3_3_not_found').css('display', 'block');
                            }
                            if (data.dato && data.tipo_dato == 'celular' && data.celular !==
                                '+') {
                                $('#editCelular').val(data.dato);
                                $('#editCelular').attr("required", true);
                                $('#input4_not_found').css('display', 'none');
                                $('#input4_4_not_found').css('display', 'block');
                            }
                            if (data.dato && data.tipo_dato == 'email' && $('#editEmail')
                                .val() == "") {
                                $('#editEmail').val(data.dato || '');
                                $('#editEmail').attr("required", true);
                                $('#input5_not_found').css('display', 'none');
                                $('#input5_5_not_found').css('display', 'block');
                            }
                        }
                    });
                    $('#search_icon').css('display', 'block');
                    $('#loading_icon').css('display', 'none');
                },
                error: function(xhr) {
                    if (xhr.status === 404) {
                        alert('No se encontró el registro');
                    } else {
                        alert('Ocurrió un error al buscar los datos');
                    }
                }
            });

        }
    });
</script>
