<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? '' }}</title>
    <!-- Favicon -->
    <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
    <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <!-- Argon CSS -->
    <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
    <!-- Datatable -->
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/datatables/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    {{-- <link rel="stylesheet"
        href="{{ asset('assets/vendor/datatables/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/datatables/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}"> --}}
    <!-- Style -->
    <!-- X-editable -->
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css"
        rel="stylesheet" />
    <!-- my style -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="{{ $class ?? '' }}">
    @auth()
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    @include('layouts.navbars.sidebar')
    @endauth

    <div class="main-content">
        @include('layouts.navbars.navbar')
        @yield('content')
    </div>

    @guest()
    @include('layouts.footers.guest')
    @endguest

    <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('argon') }}/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

    <!-- DataTables -->
    {{-- <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script> --}}
    <script src="{{ asset('assets/vendor/datatables/datatables.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/vendor/datatables/datatables.net/js/jquery.dataTables.min.js') }}"></script> --}}
    <script src="{{ asset('assets/vendor/datatables/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    {{-- <script src="{{ asset('vendor/datatables/datatables.net-buttons/js/dataTables.buttons.min.js') }} ">
    </script>
    {<script src="{{ asset('vendor/datatables/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }} ">
    </script>
    <script src="{{ asset('vendor/datatables/datatables.net-buttons/js/buttons.html5.min.js') }} "></script>
    <script src="{{ asset('vendor/datatables/datatables.net-buttons/js/buttons.flash.min.js') }} "></script>
    <script src="{{ asset('vendor/datatables/datatables.net-buttons/js/buttons.print.min.js') }} "></script>
    <script src="{{ asset('vendor/datatables/datatables.net-select/js/dataTables.select.min.js') }}"></script> --}}

    <!-- Javascript untuk AJAX -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    {{-- <script src="https://cdn.datatables.net/plug-ins/1.10.21/dataRender/datetime.js"></script> --}}

    @stack('scripts')
    @stack('js')

    <!-- Argon JS -->
    <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>
</body>

</html>