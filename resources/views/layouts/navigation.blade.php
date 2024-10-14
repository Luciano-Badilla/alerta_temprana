<style>
    .hu_icon {
        width: 20%;
    }

    /* Personaliza los enlaces en la barra de navegación */
    .nav-link {
        text-decoration: none;
        /* Elimina el subrayado */
        color: inherit;
        /* Mantiene el color del texto del elemento contenedor */
        transition: color 0.3s;
        /* Añade una transición suave para el cambio de color */
    }

    .nav-link:hover {
        color: #007bff;
        /* Cambia el color al pasar el cursor, puedes usar cualquier color */
        text-decoration: none;
        /* Asegura que no haya subrayado al pasar el cursor */
    }

    .nav-link.active {
        font-weight: bold;
        /* Opcional: resalta el enlace activo con negrita */
    }

    /* Media query para pantallas de tablets */
    @media (min-width: 768px) and (max-width: 1024px) {
        .hu_icon {
            width: 40%;
            /* Ajusta este valor según tus necesidades */
        }
    }

    /* Media query para pantallas pequeñas, como teléfonos móviles */
    @media (max-width: 768px) {
        .hu_icon {
            width: 50%;
        }
    }
</style>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center hu_icon" style="margin-top: -1%">
                    <a href="{{ route('alerts') }}">
                        <x-application-logo class="block h-8 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:space-x-8 sm:-my-px sm:ms-10 no-underline">
                    <x-nav-link :href="route('alerts')" :active="request()->routeIs('alerts')">
                        {{ __('Alertas') }}
                    </x-nav-link>

                    <x-nav-link :href="route('alert.create')" :active="request()->routeIs('alert.create')">
                        {{ __('Nueva alerta') }}
                    </x-nav-link>
                    <x-nav-link :href="route('especialidad.create')" :active="request()->routeIs('especialidad.create')">
                        {{ __('Especialidades') }}
                    </x-nav-link>
                </div>
            </div>

            

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <div class="dropdown">
                    <button
                        class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150 dropdown-toggle"
                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div>{{ Auth::user()->name }}</div>
                    </button>
                    <ul class="dropdown-menu">
                        <x-dropdown-link :href="route('profile.edit')"
                            class="no-underline block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100">
                            {{ __('Perfil') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="no-underline block px-4 py-1 text-sm text-gray-700 hover:bg-gray-100">
                                {{ __('Cerrar Sesion') }}
                            </x-dropdown-link>
                        </form>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="sm:hidden" x-show="open" @click.away="open = false" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <x-nav-link :href="route('alerts')" :active="request()->routeIs('alerts')"
                class="block px-3 py-2 text-base text-gray-700 hover:bg-gray-100">
                {{ __('Alertas') }}
            </x-nav-link>
            <x-nav-link :href="route('alert.create')" :active="request()->routeIs('alert.create')"
                class="block px-3 py-2 text-base text-gray-700 hover:bg-gray-100">
                {{ __('Nueva alerta') }}
            </x-nav-link>
            <x-nav-link :href="route('especialidad.create')" :active="request()->routeIs('especialidad.create')"
                class="block px-3 py-2 text-base text-gray-700 hover:bg-gray-100">
                {{ __('Especialidades') }}
            </x-nav-link>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
