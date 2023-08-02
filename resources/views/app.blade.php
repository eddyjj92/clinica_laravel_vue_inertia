<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laboratorio Clínico y Patológico</title>
    @vite('resources/js/app.js')
    @inertiaHead
    <link rel="stylesheet" href="{{asset('vendor/fontawesome/css/all.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/bootstrap-icons/bootstrap-icons.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
    <!--Datatables-->
    <link href="{{asset('vendor/datatables/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('vendor/datatables/buttons.dataTables.min.css')}}" rel="stylesheet">

</head>
<body>
    @inertia
    <script src="{{asset('vendor/fontawesome/js/all.js')}}"></script>
    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('vendor/axios/axios.min.js')}}"></script>
    <script src="{{asset('vendor/sweetalert2/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!--Datatables-->
    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/buttons.html5.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/buttons.print.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/jszip.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/pdfmake.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/buttons.colVis.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/buttons.print.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/dataTables.rowGroup.min.js')}}"></script>
</body>
</html>
