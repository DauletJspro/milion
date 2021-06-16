<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="{{asset("dashboard/schedule/css/style.css")}}">
    <!-- Scripts -->

    <!-- Styles -->

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset("dashboard/plugins/fontawesome-free/css/all.min.css")}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
          href="{{ asset("dashboard/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css") }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset("dashboard/plugins/icheck-bootstrap/icheck-bootstrap.min.css") }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset("dashboard/plugins/jqvmap/jqvmap.min.css") }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset("dashboard/dist/css/adminlte.min.css") }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset("dashboard/plugins/overlayScrollbars/css/OverlayScrollbars.min.css") }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset("dashboard/plugins/daterangepicker/daterangepicker.css") }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset("dashboard/plugins/summernote/summernote-bs4.min.css") }}">
    <!-- CodeMirror -->
    <link rel="stylesheet" href="{{asset("dashboard/plugins/codemirror/codemirror.css")}}">
    <link rel=" stylesheet" href="{{asset("dashboard/plugins/codemirror/theme/monokai.css")}}">
    <!-- SimpleMDE -->
    <link rel="stylesheet" href="{{asset("dashboard/plugins/simplemde/simplemde.min.css")}}">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="{{ asset("dashboard/plugins/bs-stepper/css/bs-stepper.min.css")}}">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="{{ asset("dashboard/plugins/dropzone/min/dropzone.min.css")}}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset("dashboard/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css")}}">
    <link rel="stylesheet"
          href="{{asset("dashboard/plugins/datatables-responsive/css/responsive.bootstrap4.min.css")}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset("dashboard/plugins/select2/css/select2.min.css")}}">
    <link rel="stylesheet" href="{{asset("dashboard/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css")}}">

</head>
<body class="hold-transition sidebar-mini layout-fixed">
@yield('content')


<!-- jQuery -->
<script src="{{asset("dashboard/plugins/jquery/jquery.min.js")}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset("dashboard/plugins/jquery-ui/jquery-ui.min.js")}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Boostrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 4 -->
<script src="{{asset("dashboard/plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
<!-- ChartJS -->
<script src="{{asset("dashboard/plugins/chart.js/Chart.min.js")}}"></script>
<!-- Sparkline -->
<script src="{{asset("dashboard/plugins/sparklines/sparkline.js")}}"></script>
<!-- JQVMap -->
<script src="{{asset("dashboard/plugins/jqvmap/jquery.vmap.min.js")}}"></script>
<script src="{{asset("dashboard/plugins/jqvmap/maps/jquery.vmap.usa.js")}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset("dashboard/plugins/jquery-knob/jquery.knob.min.js")}}"></script>
<!-- InputMask -->
<script src="{{asset("dashboard/plugins/inputmask/jquery.inputmask.min.js")}}"></script>
<!-- daterangepicker -->
<script src="{{asset("dashboard/plugins/moment/moment.min.js")}}"></script>
<script src="{{asset("dashboard/plugins/daterangepicker/daterangepicker.js")}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset("dashboard/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js")}}"></script>
<!-- Summernote -->
<script src="{{asset("dashboard/plugins/summernote/summernote-bs4.min.js")}}"></script>

<!-- overlayScrollbars -->
<script src="{{asset("dashboard/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js")}}"></script>
<!-- AdminLTE App -->
<script src="{{asset("dashboard/dist/js/adminlte.js")}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset("dashboard/dist/js/demo.js")}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset("dashboard/dist/js/pages/dashboard.js")}}"></script>
<!-- Notify JS -->
<script src="{{asset("dashboard/dist/js/notify/notify.min.js")}}"></script>


@yield('js')


</body>
</html>
