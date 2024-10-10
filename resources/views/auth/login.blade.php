<title>Alerta Temprana</title>
<link rel="icon" href="{{ asset('images/hu_icon.png') }}" type="image/x-icon">
<script src="https://cdn.tailwindcss.com"></script>
<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            <br>
            <x-input-label for="email" :value="__('Usuario')" />
            <x-text-input id="email" class="block mt-1 w-full h-10 p-2 shadow-sm border" type="text" name="email"
                :value="old('email')" required autofocus autocomplete="username" />
        </div>

        <!-- contraseña -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />

            <x-text-input id="password" class="block mt-1 w-full h-10 p-2 shadow-sm border" type="password"
                name="password" required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Recuerdame') }}</span>
            </label>

        </div>  
        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Olvidaste tu contraseña?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Iniciar sesion') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
