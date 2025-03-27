{{-- ------------------------------------- *jobsheet 05* ------------------------------------- --}}
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{-- <title>AdminLTE 3 | Blank Page</title> --}}
            {{-- JS5 - P1(9) --}}
        <title>{{ config('app.name', 'PWL Laravel Starter Code') }}</title>
        {{-- JS5 - P3(6) --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">   <!-- untuk mengirimkan token laravel CSRF pada setiap request ajax -->

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        
        <!-- Font Awesome -->
        {{-- <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css"> --}}
        {{-- JS5 - P1(9) --}}
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">

        {{-- JS5 - P3(6) --}}
        {{-- Data Tables --}}
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

        <!-- Theme style -->
        {{-- <link rel="stylesheet" href="../../dist/css/adminlte.min.css"> --}}
        {{-- JS5 - P1(9) --}}
        <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
        {{-- JS5 - P3(6) --}}
        @stack('css') <!-- Digunakan untuk memanggil custom css dari perintah push('css') pada masing-masing view -->
    </head>

    <body class="hold-transition sidebar-mini">
        <!-- Site wrapper -->
        <div class="wrapper">
            {{-- JS5 - P1(10) --}}
            <!-- Navbar -->
            @include('layouts.header')
            <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            {{-- <a href="../../index3.html" class="brand-link"> --}}
            {{-- JS5 - P(11)) --}}
            <a href="{{ url('/') }}" class="brand-link">
            {{-- <img src="../../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
                {{-- JS5 - P(11)) --}}
                <img src="{{ asset('adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">PWL - Starter Code</span>
            </a>

            {{-- JS5 - P1(12) --}}
            <!-- Sidebar -->
            @include('layouts.sidebar')
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            {{-- JS5 - P1(16) --}}
            <!-- Content Header (Page header) -->
            @include('layouts.breadcrumb')

            <!-- Main content -->
            <section class="content">
                {{-- JS5 - P1(18) --}}
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        {{-- JS5 - P1(13) --}}
        @include('layouts.footer')
        </div>
        <!-- ./wrapper -->

        <!-- jQuery -->
        {{-- JS5 - P1(14) --}}
        {{-- <script src="../../plugins/jquery/jquery.min.js"></script> --}}
        <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
        <!-- Bootstrap 4 -->
        {{-- <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script> --}}
        <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        
        {{-- JS5 - P3(6) --}}
        <!-- DataTables & Plugins -->
        <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('adminlte/plugins/jszip/jszip.min.js') }}"></script>
        <script src="{{ asset('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
        <script src="{{ asset('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
        <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.colvis.min.js') }}"></script>
        
        <!-- AdminLTE App -->
        {{-- <script src="../../dist/js/adminlte.min.js"></script> --}}
        <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
        
        {{-- JS5 - P3(6) --}}
        <script>
            // Untuk mengirimkan token Laravel CSRF pada setiap request ajax
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }});
        </script>
        
        @stack('js') <!-- Digunakan untuk memanggil custom js dari perintah push('js') pada masing-masing view -->
    </body>
</html>