<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Alerta Temprana</title>
    <link rel="icon" href="{{ asset('images/hu_icon.png') }}" type="image/x-icon">

    <!-- Fonts -->

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">

    <!-- Additional CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqvmap/1.5.1/jqvmap.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/daterangepicker/3.1.0/daterangepicker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Custom Styles -->
    <style>
        /* Estilo para el campo de búsqueda */
        a {
            text-decoration: none !important;
            /* Esto afectaría a todos los enlaces */
        }

        .dropdown-menu {
            border-radius: 0.5rem !important;
            /* Ajusta el valor según tus necesidades */
        }

        .search_input {
            margin-left: 5% !important;
            border: 1px solid gray !important;
            border-radius: 8px !important;
            padding: 0.375rem 0.75rem !important;
            font-size: 1rem !important;
            background-color: #F8F9FA;
        }

        .dataTables_filter {
            margin-left: 53% !important;
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .dataTables_filter input {
            border: 1px solid gray !important;
            border-radius: 10px !important;
            padding: 0.375rem 0.75rem !important;
            font-size: 1rem !important;
        }

        /* Estilo para el botón de agregar */
        #addButton {
            font-size: 14px !important;
            /* Ajusta el tamaño del texto según sea necesario */
            margin-right: 10px !important;
            /* Espacio a la derecha del botón si es necesario */
        }

        /* Ajusta el margen entre los botones de paginación */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            margin: 0 0px !important;
            padding: 0 0px !important;
            /* Cambia el valor para ajustar la separación */
        }

        /* Opcional: Ajusta el espaciado interno del contenedor de paginación */
        .dataTables_wrapper .dataTables_paginate {
            margin-top: 0px !important;
            /* Cambia el valor para ajustar el espaciado superior */
        }

        /* Estilo para el hover de los botones de paginación */
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            border: 1px solid #007bff !important;
            /* Cambia el color del borde en hover */
            background-color: #f8f9fa !important;
            /* Cambia el color de fondo en hover */
        }

        /* Estilo para el control lengthChange */
        .dataTables_length {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            /* Alinea los elementos en la fila */
        }

        /* Oculta el control de longitud específico dentro de lengthChange */
        .dataTables_length select {
            display: none !important;
            /* Oculta el selector del número de registros por página */
        }

        /* Asegura que el botón esté alineado en el contenedor de la tabla */
        .dataTables_wrapper .row {
            margin-bottom: 20px !important;
            /* Ajusta el espaciado entre el botón y la tabla */
        }

        /* Estilo para el contenedor del botón */
        .dataTables_wrapper .col-md-6 {
            display: flex !important;
            justify-content: flex-start !important;
            /* Alinea el botón al principio del contenedor */
        }

        /* Estilo para cuando pasas el mouse por encima de las filas */
        .dataTables_wrapper tbody tr:hover {
            background-color: #adabab !important;
            /* Cambia el color de fondo al pasar el mouse */
            cursor: pointer !important;
            /* Cambia el cursor a una mano al pasar el mouse */
        }

        /* Opcional: Agrega bordes a las celdas */
        .dataTables_wrapper table {
            border: none !important;
        }

        table.dataTable tbody td {
            /* Color de fondo blanco */
            color: #000000 !important;
            /* Color del texto negro */
            border: none !important;
            /* Quita el borde de las celdas */
        }

        table.dataTable thead th {
            background-color: #ffffff !important;
            /* Color de fondo blanco para los encabezados */
            color: #000000 !important;
            /* Color del texto negro para los encabezados */
            border: none !important;
            /* Quita el borde de los encabezados */
        }

        table.dataTable {
            border: none !important;
            /* Elimina los espacios entre los bordes de las celdas */
        }

        /* Excepción para mostrar encabezados en #table_historias */
        #table_historias thead {
            display: table-header-group !important;
        }

        /* Excepción para mostrar encabezados en #historyPcModal */
        #table_historias_pc thead {
            display: table-header-group !important;
        }

        .form-group .input-group {
            max-width: 165px;
            /* Ajusta el ancho máximo del input */
        }

        .form-group input {
            border: 1px solid gray;
            border-top-left-radius: 5px;
            /* Bordes redondeados superior izquierdo */
            border-bottom-left-radius: 5px;
            /* Bordes redondeados inferior izquierdo */
        }

        .input-group-append {
            border-top-right-radius: 5px;
            /* Bordes redondeados superior derecho */
            border-bottom-right-radius: 5px;
            /* Bordes redondeados inferior derecho */
        }


        body {
            --background-color: #18181B;
            --text-color: #A1A1AA;

            --card-background-color: #343A40;
            --card-border-color: rgba(255, 255, 255, 0.1);
            --card-box-shadow-1: rgba(0, 0, 0, 0.05);
            --card-box-shadow-1-y: 3px;
            --card-box-shadow-1-blur: 6px;
            --card-box-shadow-2: rgba(0, 0, 0, 0.1);
            --card-box-shadow-2-y: 8px;
            --card-box-shadow-2-blur: 15px;
            --card-label-color: #FFFFFF;
            --card-icon-color: #D4D4D8;
            --card-icon-background-color: rgba(255, 255, 255, 0.08);
            --card-icon-border-color: rgba(255, 255, 255, 0.12);
            --card-shine-opacity: .1;
            --card-shine-gradient: conic-gradient(from 205deg at 50% 50%, rgba(16, 185, 129, 0) 0deg, #10B981 25deg, rgba(52, 211, 153, 0.18) 295deg, rgba(16, 185, 129, 0) 360deg);
            --card-tile-color: rgba(16, 185, 129, 0.05);

            --card-hover-border-color: rgba(255, 255, 255, 0.2);
            --card-hover-box-shadow-1: rgba(0, 0, 0, 0.04);
            --card-hover-box-shadow-1-y: 5px;
            --card-hover-box-shadow-1-blur: 10px;
            --card-hover-box-shadow-2: rgba(0, 0, 0, 0.3);
            --card-hover-box-shadow-2-y: 15px;
            --card-hover-box-shadow-2-blur: 25px;
            --card-hover-icon-color: #ffffff;
            --card-hover-icon-background-color: rgba(0, 17, 11, 0.1);
            --card-hover-icon-border-color: rgba(255, 255, 255, 0.2);

            --blur-opacity: .01;

            &.light {
                --background-color: #FAFAFA;
                --text-color: #52525B;

                --card-background-color: transparent;
                --card-border-color: rgba(24, 24, 27, 0.08);
                --card-box-shadow-1: rgba(24, 24, 27, 0.02);
                --card-box-shadow-1-y: 3px;
                --card-box-shadow-1-blur: 6px;
                --card-box-shadow-2: rgba(24, 24, 27, 0.04);
                --card-box-shadow-2-y: 2px;
                --card-box-shadow-2-blur: 7px;
                --card-label-color: #18181B;
                --card-icon-color: #18181B;
                --card-icon-background-color: rgba(24, 24, 27, 0.04);
                --card-icon-border-color: rgba(24, 24, 27, 0.1);
                --card-shine-opacity: .3;
                --card-shine-gradient: conic-gradient(from 225deg at 50% 50%, rgba(16, 185, 129, 0) 0deg, #10B981 25deg, #EDFAF6 285deg, #FFFFFF 345deg, rgba(16, 185, 129, 0) 360deg);
                --card-line-color: #E9E9E7;
                --card-tile-color: rgba(16, 185, 129, 0.08);

                --card-hover-border-color: rgba(24, 24, 27, 0.15);
                --card-hover-box-shadow-1: rgba(24, 24, 27, 0.05);
                --card-hover-box-shadow-1-y: 3px;
                --card-hover-box-shadow-1-blur: 6px;
                --card-hover-box-shadow-2: rgba(24, 24, 27, 0.1);
                --card-hover-box-shadow-2-y: 8px;
                --card-hover-box-shadow-2-blur: 15px;
                --card-hover-icon-color: #18181B;
                --card-hover-icon-background-color: rgba(24, 24, 27, 0.04);
                --card-hover-icon-border-color: rgba(24, 24, 27, 0.34);

                --blur-opacity: .1;
            }

            &.toggle .grid * {
                transition-duration: 0s !important;
            }
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, 240px);
            grid-gap: 32px;
            position: relative;
            z-index: 1;
        }

        .card {
            background-color: var(--background-color);
            box-shadow: 0px var(--card-box-shadow-1-y) var(--card-box-shadow-1-blur) var(--card-box-shadow-1), 0px var(--card-box-shadow-2-y) var(--card-box-shadow-2-blur) var(--card-box-shadow-2), 0 0 0 1px var(--card-border-color);
            padding: 16px;
            border-radius: 15px;
            position: relative;
            transition: box-shadow .25s;
            cursor: pointer;

            &::before {
                content: '';
                position: absolute;
                inset: 0;
                border-radius: 15px;
                background-color: var(--card-background-color);
            }

            .icon {
                z-index: 2;
                position: relative;
                display: table;
                padding: 8px;
                width: 35%;
            }

            .iconHome {
                z-index: 2;
                position: relative;
                display: table;
                padding: 8px;
                width: 40%;
            }

            h4 {
                z-index: 2;
                position: relative;
                margin: 12px 0 4px 0;
                font-family: inherit;
                font-weight: 600;
                font-size: 14px;
                line-height: 2;
                color: var(--card-label-color);
            }

            p {
                z-index: 2;
                position: relative;
                margin: 0;
                font-size: 14px;
                line-height: 1.7;
                color: var(--text-color);
            }

            .shine {
                border-radius: inherit;
                position: absolute;
                inset: 0;
                z-index: 1;
                overflow: hidden;
                opacity: 0;
                transition: opacity .5s;

                &:before {
                    content: '';
                    width: 150%;
                    padding-bottom: 150%;
                    border-radius: 50%;
                    position: absolute;
                    left: 50%;
                    bottom: 55%;
                    filter: blur(35px);
                    opacity: var(--card-shine-opacity);
                    transform: translateX(-50%);
                    background-image: var(--card-shine-gradient);
                }
            }

            .background {
                border-radius: inherit;
                position: absolute;
                inset: 0;
                overflow: hidden;
                -webkit-mask-image: radial-gradient(circle at 60% 5%, black 0%, black 15%, transparent 60%);
                mask-image: radial-gradient(circle at 60% 5%, black 0%, black 15%, transparent 60%);

                .tiles {
                    opacity: 0;
                    transition: opacity .25s;

                    .tile {
                        position: absolute;
                        background-color: var(--card-tile-color);
                        animation-duration: 8s;
                        animation-iteration-count: infinite;
                        opacity: 0;

                        &.tile-4,
                        &.tile-6,
                        &.tile-10 {
                            animation-delay: -2s;
                        }

                        &.tile-3,
                        &.tile-5,
                        &.tile-8 {
                            animation-delay: -4s;
                        }

                        &.tile-2,
                        &.tile-9 {
                            animation-delay: -6s;
                        }

                        &.tile-1 {
                            top: 0;
                            left: 0;
                            height: 10%;
                            width: 22.5%;
                        }

                        &.tile-2 {
                            top: 0;
                            left: 22.5%;
                            height: 10%;
                            width: 27.5%;
                        }

                        &.tile-3 {
                            top: 0;
                            left: 50%;
                            height: 10%;
                            width: 27.5%;
                        }

                        &.tile-4 {
                            top: 0;
                            left: 77.5%;
                            height: 10%;
                            width: 22.5%;
                        }

                        &.tile-5 {
                            top: 10%;
                            left: 0;
                            height: 22.5%;
                            width: 22.5%;
                        }

                        &.tile-6 {
                            top: 10%;
                            left: 22.5%;
                            height: 22.5%;
                            width: 27.5%;
                        }

                        &.tile-7 {
                            top: 10%;
                            left: 50%;
                            height: 22.5%;
                            width: 27.5%;
                        }

                        &.tile-8 {
                            top: 10%;
                            left: 77.5%;
                            height: 22.5%;
                            width: 22.5%;
                        }

                        &.tile-9 {
                            top: 32.5%;
                            left: 50%;
                            height: 22.5%;
                            width: 27.5%;
                        }

                        &.tile-10 {
                            top: 32.5%;
                            left: 77.5%;
                            height: 22.5%;
                            width: 22.5%;
                        }
                    }
                }

                @keyframes tile {

                    0%,
                    12.5%,
                    100% {
                        opacity: 1;
                    }

                    25%,
                    82.5% {
                        opacity: 0;
                    }
                }

                .line {
                    position: absolute;
                    inset: 0;
                    opacity: 0;
                    transition: opacity .35s;

                    &:before,
                    &:after {
                        content: '';
                        position: absolute;
                        background-color: var(--card-line-color);
                        transition: transform .35s;
                    }

                    &:before {
                        left: 0;
                        right: 0;
                        height: 1px;
                        transform-origin: 0 50%;
                        transform: scaleX(0);
                    }

                    &:after {
                        top: 0;
                        bottom: 0;
                        width: 1px;
                        transform-origin: 50% 0;
                        transform: scaleY(0);
                    }

                    &.line-1 {
                        &:before {
                            top: 10%;
                        }

                        &:after {
                            left: 22.5%;
                        }

                        &:before,
                        &:after {
                            transition-delay: .3s;
                        }
                    }

                    &.line-2 {
                        &:before {
                            top: 32.5%;
                        }

                        &:after {
                            left: 50%;
                        }

                        &:before,
                        &:after {
                            transition-delay: .15s;
                        }
                    }

                    &.line-3 {
                        &:before {
                            top: 55%;
                        }

                        &:after {
                            right: 22.5%;
                        }
                    }
                }
            }

            &:hover {
                box-shadow: 0px 3px 6px var(--card-hover-box-shadow-1), 0px var(--card-hover-box-shadow-2-y) var(--card-hover-box-shadow-2-blur) var(--card-hover-box-shadow-2), 0 0 0 1px var(--card-hover-border-color);


                .icon {
                    &::after {
                        background-color: var(--card-hover-icon-background-color);
                        border-color: var(--card-hover-icon-border-color);
                    }

                    svg {
                        color: var(--card-hover-icon-color);
                    }
                }

                .shine {
                    opacity: 1;
                    transition-duration: .5s;
                    transition-delay: 0s;
                }

                .background {

                    .tiles {
                        opacity: 1;
                        transition-delay: .25s;

                        .tile {
                            animation-name: tile;
                        }
                    }

                    .line {
                        opacity: 1;
                        transition-duration: .15s;

                        &:before {
                            transform: scaleX(1);
                        }

                        &:after {
                            transform: scaleY(1);
                        }

                        &.line-1 {

                            &:before,
                            &:after {
                                transition-delay: .0s;
                            }
                        }

                        &.line-2 {

                            &:before,
                            &:after {
                                transition-delay: .15s;
                            }
                        }

                        &.line-3 {

                            &:before,
                            &:after {
                                transition-delay: .3s;
                            }
                        }
                    }
                }
            }
        }

        .day-night {
            cursor: pointer;
            position: absolute;
            right: 20px;
            top: 20px;
            opacity: .3;

            input {
                display: none;

                &+div {
                    border-radius: 50%;
                    width: 20px;
                    height: 20px;
                    position: relative;
                    box-shadow: inset 8px -8px 0 0 var(--text-color);
                    transform: scale(1) rotate(-2deg);
                    transition: box-shadow .5s ease 0s, transform .4s ease .1s;

                    &:before {
                        content: '';
                        width: inherit;
                        height: inherit;
                        border-radius: inherit;
                        position: absolute;
                        left: 0;
                        top: 0;
                        transition: background-color .3s ease;
                    }

                    &:after {
                        content: '';
                        width: 6px;
                        height: 6px;
                        border-radius: 50%;
                        margin: -3px 0 0 -3px;
                        position: absolute;
                        top: 50%;
                        left: 50%;
                        box-shadow: 0 -23px 0 var(--text-color), 0 23px 0 var(--text-color), 23px 0 0 var(--text-color), -23px 0 0 var(--text-color), 15px 15px 0 var(--text-color), -15px 15px 0 var(--text-color), 15px -15px 0 var(--text-color), -15px -15px 0 var(--text-color);
                        transform: scale(0);
                        transition: all .3s ease;
                    }
                }

                &:checked+div {
                    box-shadow: inset 20px -20px 0 0 var(--text-color);
                    transform: scale(.5) rotate(0deg);
                    transition: transform .3s ease .1s, box-shadow .2s ease 0s;

                    &:before {
                        background: var(--text-color);
                        transition: background-color .3s ease .1s;
                    }

                    &:after {
                        transform: scale(1);
                        transition: transform .5s ease .15s;
                    }
                }
            }
        }

        html {
            box-sizing: border-box;
            -webkit-font-smoothing: antialiased;
        }

        * {
            box-sizing: inherit;

            &:before,
            &:after {
                box-sizing: inherit;
            }
        }

        // Center
        body {
            min-height: 100vh;
            display: flex;
            font-family: 'Inter', Arial;
            justify-content: center;
            align-items: center;
            background-color: var(--background-color);
            overflow: hidden;

            &:before {
                content: '';
                position: absolute;
                inset: 0 -60% 65% -60%;
                background-image: radial-gradient(ellipse at top, #10B981 0%, var(--background-color) 50%);
                opacity: var(--blur-opacity);
            }

        }

        .custom-export-btn {
            margin-bottom: 1%;
            margin-left: 1%;
            /* Elimina márgenes */
        }

        #table-historias th,
        #table-historias td {
            min-width: 100px;
            /* Establece un ancho mínimo para las columnas */
            word-wrap: break-word;
            /* Asegura que el contenido se ajuste dentro del ancho */
            table-layout: fixed;
        }
    </style>


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-gray-100 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap 4 y 5 (Elige una versión, usualmente no se usan ambas juntas) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- jQuery UI -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <!-- ChartJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>

    <!-- Sparkline -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sparklines/0.4.1/sparkline.js"></script>

    <!-- JQVMap -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqvmap/1.5.1/jquery.vmap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqvmap/1.5.1/maps/jquery.vmap.usa.js"></script>

    <!-- jQuery Knob Chart -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-knob/1.2.13/jquery.knob.min.js"></script>

    <!-- Daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/daterangepicker/3.1.0/daterangepicker.js"></script>

    <!-- Tempusdominus Bootstrap 4 -->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js">
    </script>

    <!-- Summernote -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>

    <!-- overlayScrollbars -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/js/jquery.overlayScrollbars.min.js">
    </script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

    <!-- List.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>

    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>

    <!-- JSZip (Necesario para la exportación a Excel) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>


    <footer>
        <script>
            $(document).ready(function() {

            });
        </script>
    </footer>
</body>

</html>
