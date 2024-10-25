<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alerta Temprana</title>
    <link rel="icon" href="{{ asset('images/hu_icon.png') }}" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        crossorigin="anonymous">
</head>

<body>
    <x-guest-layout>
        <!-- Session Status -->
        @if (session('success'))
            <div class="alert-success">
                <p style="padding: 0.3%; text-align: center">{{ session('success') }}</p>
            </div>
        @endif
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                <br>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full h-10 p-2 shadow-sm border" type="email"
                    name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <!-- Contraseña -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Contraseña')" />
                <x-text-input id="password" class="block mt-1 w-full h-10 p-2 shadow-sm border" type="password"
                    name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <!-- Botón para solicitar cambio de contraseña -->
            @if ($errors->any())
                <div class="mt-1 text-left">
                    <button type="button"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        data-bs-toggle="modal" data-bs-target="#addEmailModal">
                        Solicitar cambio de contraseña
                    </button>
                </div>
            @endif

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-gray-600">{{ __('Recuerdame') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('register'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route('register') }}">
                        {{ __('Registrarse') }}
                    </a>
                @endif

                <x-primary-button class="ms-3">
                    {{ __('Iniciar sesión') }}
                </x-primary-button>
            </div>

        </form>

        <!-- Modal -->
        <div class="modal fade" id="addEmailModal" tabindex="-1" aria-labelledby="addEmailModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title" id="addEmailModalLabel">Solicitar cambio de contraseña</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('usuarios.requestPassword') }}" method="POST" id="addModal">
                            @csrf
                            <div class="mb-4">
                                <label for="addEmail" class="form-label text-dark fw-bold">Email:</label>

                                <input type="email" class="form-control" id="addEmail" name="addEmail" required>

                            </div>
                            @error('addEmail')
                                <div class="alert alert-danger d-flex align-items-center" role="alert">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <div>{{ $message }}</div>
                                </div>
                            @enderror
                        </form>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancelar
                        </button>
                        <button type="submit" form="addModal" class="btn btn-dark">
                            <i class="fa-solid fa-rotate me-1"></i>Solicitar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </x-guest-layout>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
