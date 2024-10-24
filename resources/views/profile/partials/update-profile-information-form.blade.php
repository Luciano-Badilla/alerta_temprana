@php
    use App\Models\EspecialidadModel;
    $especialidades = EspecialidadModel::all();
    $especialidadPrincipal = Auth::user()->especialidad_id;
@endphp

<style>
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
</style>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Información del perfil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Actualice la información del perfil y la dirección de correo electrónico de su cuenta.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nombre y Apellido')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full h-10 p-2"
                :value="old('name', $user->name)" required autofocus autocomplete="name" readonly />
            <p class="mt-1 text-sm text-gray-600">
                {{ __('Para cambiar el Nombre y Apellido comuniquese con un administrador con el motivo.') }}
            </p>
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="text" class="mt-1 block w-full h-10 p-2"
                :value="old('email', $user->email)" required autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
        @if (Auth::user()->rol_id == 3)
            <div>
                <x-input-label for="especialidad" :value="__('Especialidad')" />
                <select type="text" class="form-select" id="editEspecialidad" name="editEspecialidad" required>
                    @foreach ($especialidades as $especialidad)
                        <option value="{{ $especialidad->id }}">{{ $especialidad->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <x-input-label for="matricula" :value="__('Matricula')" />
            <x-text-input id="matricula" name="matricula" type="text" class="mt-1 block w-full h-10 p-2"
                value="{{ Auth::user()->rol_id == 3 }}" :value="old('matricula', $user->matricula)" required autocomplete="matricula" />
            <x-input-error class="mt-2" :messages="$errors->get('matricula')" />
        @endif


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Guardar') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#editEspecialidad').val("{{ $especialidadPrincipal }}");
        $('#editEspecialidad').select2({
            placeholder: 'Seleccione una especialidad',
            allowClear: true
        });
    });
</script>
