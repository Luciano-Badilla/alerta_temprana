<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
<x-app-layout>
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">especialidades</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Aqui debes agregar los especialidades donde se encuentran las PCs.
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar nueva especialidad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('especialidad.store') }}" method="POST" id="addModal"
                        style="display: flex; flex-direction: row; gap: 20px;">
                        @csrf
                        <!-- Mostrar errores de validación generales -->
                        <div class="mb-3" style="flex: 1;">
                            <label for="addNombre" class="form-label">Especialidad:</label>
                            <input type="text" id="addNombre" name="addNombre" required
                                class="block w-full px-2 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500 @error('addNombre') border-red-500 @enderror">

                        </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark">Agregar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar especialidad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('especialidad.edit') }}" method="POST" id="addModal">
                        @method('PATCH')
                        @csrf
                        <!-- Mostrar errores de validación generales -->

                        <div class="mb-3" style="flex: 1;">
                            <input type="hidden" id="editId" name="editId">
                            <label for="editNombre" class="form-label">especialidad:</label>
                            <input type="text" class="form-control @error('editNombre') is-invalid @enderror"
                                id="editNombre" name="editNombre" style="border: 1px solid gray; border-radius: 5px;"
                                required>
                        </div>
                        <div class="mb-3" style="flex: 1;">
                            <label for="editMotivo" class="form-label">Motivo:</label>
                            <input type="text" class="form-control @error('editMotivo') is-invalid @enderror"
                                id="editMotivo" name="editMotivo" style="border: 1px solid gray; border-radius: 5px;"
                                required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-dark">Editar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">¿Seguro?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('especialidad.delete') }}" method="POST" id="addModal">
                        @csrf
                        <!-- Mostrar errores de validación generales -->

                        <div class="mb-3">
                            <input type="hidden" id="deleteId" name="deleteId">
                            <label for="removeMotivo" class="form-label">Motivo:</label>
                            <input type="text" class="form-control @error('removeMotivo') is-invalid @enderror"
                                id="removeMotivo" name="removeMotivo"
                                style="border: 1px solid gray; border-radius:5px" required>
                        </div>
                        <p
                            style="color: #d9534f; background-color: #f9e2e2; border: 1px solid #d43f3a; padding: 10px; border-radius: 5px;">
                            Todos los componentes asociados a este especialidad se desvincularan del mismo.
                        </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal"
                        aria-label="Close">No</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white  overflow-hidden sm:rounded-lg">
                @error('addNombre')
                    <div class="alert-danger" style="text-align: center">
                        {{ $message }}
                    </div>
                @enderror
                @if (session('success'))
                    <div class="alert-success">
                        <p style="padding: 0.3%; text-align: center">{{ session('success') }}</p>
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
                                        name="addNombre">
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
                                    <ul class="list-none pl-0 mb-4 flex-grow" id="listaExamenes">
                                        @foreach ($tiposExamen as $tipoExamen)
                                            @if ($tipoExamen->especialidad_id == $especialidad->id)
                                                <li class="flex justify-between items-center text-gray-600 py-1">
                                                    {{ $tipoExamen->nombre }}
                                                    <button onclick=""
                                                        class="text-gray-600 hover:text-gray-800 transition duration-300"
                                                        aria-label="Eliminar {{ $tipoExamen->nombre }}">
                                                        <i class="ri-close-line"></i>
                                                    </button>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    <button type="submit"
                                        class="bg-gray-800 text-white py-2 rounded-lg transition duration-300 w-full flex items-center justify-center mt-auto">
                                        <i class="ri-add-line mr-2"></i> Agregar Examen
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div id="modalAgregarExamen"
                        class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center">
                        <div class="bg-white p-4 rounded-lg shadow-lg w-11/12 sm:w-96">
                            <h2 id="modalTitle" class="text-lg font-bold mb-4 text-gray-800">Agregar Examen</h2>
                            <input type="text" id="nuevoExamen" placeholder="Nuevo examen"
                                class="border border-gray-300 rounded-lg px-2 py-1 mb-4 w-full">
                            <div class="flex justify-end gap-2">
                                <button onclick="cerrarModal()"
                                    class="bg-gray-300 text-gray-700 px-4 py-1 rounded hover:bg-gray-400 transition duration-300">Cancelar</button>
                                <button onclick="agregarExamen()"
                                    class="bg-gray-800 text-white px-4 py-1 rounded hover:bg-gray-700 transition duration-300 flex items-center">
                                    <i class="ri-add-line mr-2"></i> Agregar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


</x-app-layout>

<script>
    /*document.getElementById('tableSearch').addEventListener('keyup', function() {
        var searchText = this.value.toLowerCase();
        var tableRows = document.querySelectorAll('#tableBody tr');

        tableRows.forEach(function(row) {
            var rowText = row.textContent.toLowerCase();
            row.style.display = rowText.includes(searchText) ? '' : 'none';
        });
    });*/
</script>
