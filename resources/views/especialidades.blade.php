<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
<x-app-layout>
    <!-- Modal -->
    <div class="modal fade" id="addExamenModal" tabindex="-1" aria-labelledby="addExamenModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="addExamenModalLabel">
                        <i class="fas fa-file-medical me-2"></i>Agregar nuevo examen
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('examen.store') }}" method="POST" id="addModal">
                        @csrf
                        <input type="hidden" id="especialidadId" name="especialidad_id" value="">
                        <div class="mb-4">
                            <label for="addNombre" class="form-label text-dark fw-bold">Nombre del examen:</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-stethoscope text-dark"></i>
                                </span>
                                <input type="text" class="form-control border-start-0" id="addNombre"
                                    name="addNombre" required placeholder="Ingrese el nombre del examen">
                            </div>
                        </div>
                        @error('addNombre')
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <div>
                                    {{ $message }}
                                </div>
                            </div>
                        @enderror
                    </form>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" form="addModal" class="btn btn-dark">
                        <i class="fas fa-plus me-1"></i>Agregar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-transparent  overflow-hidden sm:rounded-lg">
                @if ($errors->any())
                    <div class="alert-danger" style="text-align: center">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert-success">
                        <p style="padding: 0.3%; text-align: center">{{ session('success') }}</p>
                    </div>
                @endif
                @if (session('warning'))
                    <div class="alert-warning">
                        <p style="padding: 0.3%; text-align: center">{{ session('warning') }}</p>
                    </div>
                @endif
                <div class="p-3 rounded">
                    <div class="container mx-auto p-4">
                        <div class="mb-4 flex flex-col gap-1">
                            <form action="{{ route('especialidad.store') }}" method="POST">
                                <h2 class="text-lg font-bold mb-2 text-gray-800">Agregar Especialidad:</h2>
                                @csrf
                                <div class="flex flex-col sm:flex-row gap-2">
                                    <input type="text" id="addNombre" placeholder="Nombre de la especialidad"
                                        class="border border-gray-300 rounded-lg p-2 flex-grow sm:max-w-60 max-w-full"
                                        name="addNombre" required>
                                    <button type="submit"
                                        class="bg-gray-800 text-white px-4 py-2 rounded-lg transition duration-300 flex items-center justify-center">
                                        <i class="ri-add-line mr-2 max-w-auto"></i> Agregar
                                    </button>
                                </div>
                            </form>
                        </div>
                        <h2 class="text-lg font-bold mb-2 text-gray-800" style="margin-top: -2%">Especialidades:</h2>
                        <div id="listaEspecialidades" class="grid gap-3 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 mt-3">
                            @foreach ($especialidades as $especialidad)
                                <div class="bg-white p-4 rounded-lg shadow flex flex-col">
                                    <h2 class="text-lg font-bold mb-2 text-gray-800">{{ $especialidad->nombre }}</h2>
                                    <div class="flex flex-col mb-4" style="gap: 4px; margin: 0;" id="listaExamenes">
                                        <!-- Aumentar el gap -->
                                        @php
                                            // Filtrar los tipos de examen por la especialidad actual
                                            $examenesEspecialidad = $tiposExamen->filter(function ($tipoExamen) use (
                                                $especialidad,
                                            ) {
                                                return $tipoExamen->especialidad_id == $especialidad->id;
                                            });
                                        @endphp

                                        @if ($examenesEspecialidad->isEmpty())
                                            <p class="bg-gray-100 p-2 rounded-lg text-center">No hay tipos de examen
                                                disponibles para esta especialidad.</p>
                                        @else
                                            @foreach ($examenesEspecialidad as $tipoExamen)
                                                <form action="{{ route('examen.alter') }}" method="POST"
                                                    style="margin: 0;">
                                                    @csrf
                                                    <div
                                                        class="flex justify-between items-center text-gray-600 py-1 px-1 rounded-2xl hover:bg-gray-100">
                                                        @if ($tipoExamen->borrado_logico == 0)
                                                            <!-- Examen no borrado -->
                                                            {{ $tipoExamen->nombre }}
                                                            <input type="hidden" id="examen_id" name="examen_id"
                                                                value="{{ $tipoExamen->id }}">
                                                            <button type="submit"
                                                                class="text-gray-600 hover:text-gray-800 transition duration-300"
                                                                aria-label="Eliminar {{ $tipoExamen->nombre }}">
                                                                <i class="fa-solid fa-ban"></i>
                                                            </button>
                                                        @else
                                                            <!-- Examen borrado lógicamente -->
                                                            <s>{{ $tipoExamen->nombre }}</s>
                                                            <input type="hidden" id="examen_id" name="examen_id"
                                                                value="{{ $tipoExamen->id }}">
                                                            <button type="submit"
                                                                class="text-gray-600 hover:text-gray-800 transition duration-300"
                                                                aria-label="Reactivar {{ $tipoExamen->nombre }}">
                                                                <i class="fa-solid fa-check"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </form>
                                            @endforeach
                                        @endif

                                    </div>
                                    <button type="button"
                                        class="bg-gray-800 text-white py-2 rounded-lg transition duration-300 w-full flex items-center justify-center mt-auto"
                                        data-id="{{ $especialidad->id }}" data-bs-toggle="modal"
                                        data-bs-target="#addExamenModal">
                                        <i class="ri-add-line mr-2"></i> Agregar Examen
                                    </button>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>


</x-app-layout>

<script>
    const addExamenModal = document.getElementById('addExamenModal');
    addExamenModal.addEventListener('show.bs.modal', function(event) {
        // Botón que activó el modal
        const button = event.relatedTarget;
        // Extrae el data-id del botón
        const especialidadId = button.getAttribute('data-id');
        // Asigna el valor al campo oculto en el modal
        const inputEspecialidadId = document.getElementById('especialidadId');
        inputEspecialidadId.value = especialidadId;
    });
</script>
