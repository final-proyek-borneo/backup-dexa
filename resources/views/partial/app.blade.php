<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">
    <meta name="robots" content="nofollow">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>DEXA &mdash; DISTIBUTOR PARTNER</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/public_page/images/dexa.png')}}"sizes="48x48">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/modules/prism/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/jquery-selectric/selectric.css') }}">
    <link rel="stylesheet" href="{{asset('assets/modules/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> -->
    {{-- <link rel="stylesheet" href="{{asset('assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}"> --}}

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custome.css') }}">

    <style>

        @media (min-width: 768px) {
            .modal-xl {
                width: 90%;
                max-width:1200px;
            }

            .modal-xl .modal-body {
                max-height: calc(100vh - 210px);
                max-width: 100% !important;
                overflow-y: auto;
                overflow-x: hidden;
            }
        }

        .table tbody td {
            vertical-align: middle;
        }

        .table tbody th {
            vertical-align: middle;
        }

        .table thead tr {
            background-color: #0a9447;
        }


        .table:not(.table-sm) thead th {
            color: #fff;
        }

        .red-border{
            border: 1px solid #dc3545 !important;
        }

        .modal-xl{
            max-width: 1140px;
        }

        </style>

    @yield('css')

    <meta name="csrf-token" content="{{ csrf_token() }}" />

</head>

<body>
    <div id="app">
        <div class="main-wrapper">
        <div class="navbar-bg"></div>
        @include('partial.header')
        <!-- Main Content -->
        <div class="main-content">

            <section class="section">
                <div class="section-header">
                    <h1>@yield('title')</h1>
                </div>
                @yield('content')
            </section>

            @yield('modal')
            @yield('alert')
            @yield('loading')

            <!-- Modal Load-->
            <div class="modal fade" role="dialog" id="modal_loading" data-keyboard="false" data-backdrop="static">
                <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body pt-0" style="background-color: #FAFAF8; border-radius: 6px;">
                        <div class="text-center">
                            <img style="border-radius: 4px; height: 140px;" src="{{ asset('assets/img/project/icon/loader.gif') }}" alt="Loading">
                            <h6 style="position: absolute; bottom: 10%; left: 37%;" class="pb-2">Mohon Tunggu..</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset('assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script> -->
    

    <!-- JS Libraies -->
    <script src="{{ asset('assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('assets/modules/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{asset('assets/modules/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="https://kit.fontawesome.com/499d56f37a.js" crossorigin="anonymous"></script>
    {{-- <script src="{{asset('assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script> --}}

    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/modules/prism/prism.js') }}"></script>
    <link rel="stylesheet" href="{{asset('assets/modules/izitoast/css/iziToast.min.css')}}">


    <!-- Page Specific JS File -->
    <script src="{{ asset('assets/js/page/components-table.js') }}"></script>
    <script src="{{ asset('assets/js/page/bootstrap-modal.js') }}"></script>
    <script src="{{asset('assets/modules/izitoast/js/iziToast.min.js')}}"></script>

    @include('scriptjs')
    <script type="text/javascript">
        $(document).ready(function() {
            $(".datepicker").datepicker({
                autoclose: true,
                format: "yyyy-mm-dd",
                todayHighlight: true,
                orientation: "top auto",
                todayBtn: true
            });

            $(".datepicker-years").datepicker({
                autoclose: true,
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years"
            });

            $(".datepicker-time").datepicker({
                autoclose: true,
                format: "HH:mm",
            });
        });

        function formatTimestamp(timestamp) {

            if(timestamp == '0000-00-00 00:00:00'){
                return '00-00-0000';
            }

            var date = new Date(timestamp);
            var day = date.getDate();
            var month = date.getMonth() + 1;
            var year = date.getFullYear();
            return day + '-' + month + '-' + year;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                // 'Authorization': '{{session()->get('token_jwt')}}',
            }
        });
    </script>

    @yield('js')
    

</body>
</html>
