<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mobile Hub | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/admin') }}/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('assets/admin') }}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('assets/admin') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('assets/admin') }}/plugins/jqvmap/jqvmap.min.css">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="{{ asset('assets/admin') }}/plugins/dropzone/min/dropzone.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/admin') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="{{ asset('assets/admin') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('assets/admin') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/admin') }}/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('assets/admin') }}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets/admin') }}/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('assets/admin') }}/plugins/summernote/summernote-bs4.min.css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('assets/admin') }}/dist/img/AdminLTELogo.png"
                alt="AdminLTELogo" height="60" width="60">
        </div>

        <!-- Navbar -->
        @include('admin.partials.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('admin.partials.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Footer -->
        @include('admin.partials.footer')

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!--  CORRECT JAVASCRIPT LOADING ORDER -->
    
    <!-- 1. jQuery FIRST (ONLY ONCE) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- 2. jQuery UI -->
    <script src="{{ asset('assets/admin') }}/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>
    
    <!-- 3. Bootstrap 4 -->
    <script src="{{ asset('assets/admin') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    
    <!-- 4. Other AdminLTE Plugins -->
    <script src="{{ asset('assets/admin') }}/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <script src="{{ asset('assets/admin') }}/plugins/chart.js/Chart.min.js"></script>
    <script src="{{ asset('assets/admin') }}/plugins/sparklines/sparkline.js"></script>
    <script src="{{ asset('assets/admin') }}/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="{{ asset('assets/admin') }}/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <script src="{{ asset('assets/admin') }}/plugins/jquery-knob/jquery.knob.min.js"></script>
    <script src="{{ asset('assets/admin') }}/plugins/moment/moment.min.js"></script>
    <script src="{{ asset('assets/admin') }}/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="{{ asset('assets/admin') }}/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    
    <!-- 5. DataTables -->
    <script src="{{ asset('assets/admin') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('assets/admin') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('assets/admin') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('assets/admin') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ asset('assets/admin') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('assets/admin') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('assets/admin') }}/plugins/jszip/jszip.min.js"></script>
    <script src="{{ asset('assets/admin') }}/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="{{ asset('assets/admin') }}/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="{{ asset('assets/admin') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('assets/admin') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('assets/admin') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    
    <!-- 6. Other Plugins -->
    <script src="{{ asset('assets/admin') }}/plugins/dropzone/min/dropzone.min.js"></script>
    <script src="{{ asset('assets/admin') }}/plugins/summernote/summernote-bs4.min.js"></script>
    <script src="{{ asset('assets/admin') }}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    
    <!-- 7. Toastr  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <!-- 8. SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- 9. AdminLTE Core -->
    <script src="{{ asset('assets/admin') }}/dist/js/adminlte.js"></script>
    
    <!-- 10. Demo Scripts  -->
    <script src="{{ asset('assets/admin') }}/dist/js/demo.js"></script>
    <script src="{{ asset('assets/admin') }}/dist/js/pages/dashboard.js"></script>

    <!-- Toastr Configuration -->
    <script>
        // Toastr configuration - SAFE CHECK
        if (typeof toastr !== 'undefined') {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
        } else {
            console.warn('Toastr not loaded');
        }
    </script>

    <!-- Blade page specific JS -->
    @stack('scripts')
</body>

</html>