<?php
use App\Models\EspecialidadModel;

$especialidades = EspecialidadModel::all();
?>

<!-- Agregar Bootstrap y Font Awesome -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

<script src="https://cdn.tailwindcss.com"></script>

<x-guest-layout>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Apellido y Nombre')" />
            <x-text-input id="name" class="block mt-1 w-full h-10 p-2 border" type="text" name="name"
                :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="sexo" :value="__('Sexo')" />
            <select id="sexo" name="sexo" required
                class="mt-1 bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black-500 focus:border-black-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected disabled>Seleccione un sexo</option>
                <option value="M">Masculino</option>
                <option value="F">Femenino</option>
            </select>
            <x-input-error :messages="$errors->get('sexo')" class="mt-2" />
        </div>

        <!-- Rol -->
        <div class="mt-4">
            <x-input-label for="rol" :value="__('Rol')" />
            <select id="rol" name="rol" required
                class="mt-1 bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black-500 focus:border-black-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                onchange="toggleProfessionalFields()">
                <option selected disabled>Seleccione un rol</option>
                <option value="2">Administrativo</option>
                <option value="3">Profesional</option>
            </select>
            <x-input-error :messages="$errors->get('rol')" class="mt-2" />
        </div>

        <!-- Matricula -->
        <div id="matricula-container" class="mt-4 hidden">
            <div class="flex">
                <x-input-label for="matricula" :value="__('Matricula')" />
                <button type="button" class="ml-1" style="margin-top: -2%" data-toggle="modal" data-target="#matriculaModal">
                    <i class="fa-solid fa-circle-info"></i>
                </button>
            </div>
            <div class="input-group flex">
                <x-text-input id="matricula" class="block w-full h-10 p-2 border" type="text" name="matricula"
                    :value="old('matricula')" required autocomplete="username" />
            </div>

            <x-input-error :messages="$errors->get('matricula')" class="mt-2" />
        </div>

        <!-- Especialidad -->
        <div id="especialidad-container" class="mt-4 hidden">
            <x-input-label for="especialidad" :value="__('Especialidad')" />
            <select id="especialidad" name="especialidad" required
                class="mt-1 bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-black-500 focus:border-black-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option selected disabled>Seleccione una especialidad</option>
                @foreach ($especialidades as $especialidad)
                    <option value="{{ $especialidad->id }}">{{ $especialidad->nombre }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('especialidad')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full h-10 p-2 border" type="email" name="email"
                :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" class="block mt-1 w-full h-10 p-2 border" type="password" name="password"
                required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full h-10 p-2 border" type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Ya esta registrado?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Registrarse') }}
            </x-primary-button>
        </div>
    </form>

    <div class="modal fade" id="matriculaModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 8px !important">
                <div class="modal-header border-transparent">
                </div>
                <div class="modal-body border-transparent">
                    <div class="py-2 px-3 text-yellow-600 d-flex align-items-center" role="alert"
                        style="border: solid #efc144; border-radius: 8px; border-width: 1px; margin-top:-5%">
                        <i class="fa-solid fa-triangle-exclamation mr-2" style="color:#efc144"></i>
                        <div>La matrícula es necesaria para la generación de pedidos médicos firmados electrónicamente.
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-transparent">
                    <button type="button" class="btn close text-base p-1" data-dismiss="modal" aria-label="Close"
                        style="border: solid gray; border-radius: 8px; border-width: 1px;"
                        data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

</x-guest-layout>

<script>
    function toggleProfessionalFields() {
        const rol = document.getElementById('rol').value;
        const matriculaContainer = document.getElementById('matricula-container');
        const especialidadContainer = document.getElementById('especialidad-container');

        if (rol === '3') {
            matriculaContainer.classList.remove('hidden');
            especialidadContainer.classList.remove('hidden');
            document.getElementById('matricula').setAttribute('required', true);
            document.getElementById('especialidad').setAttribute('required', true);
        } else {
            matriculaContainer.classList.add('hidden');
            especialidadContainer.classList.add('hidden');
            document.getElementById('matricula').removeAttribute('required');
            document.getElementById('especialidad').removeAttribute('required');
        }
    }
</script>
