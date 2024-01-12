<!-- loader-->
{{-- <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />
<script src="{{ asset('assets/js/pace.min.js') }}"></script> --}}
<!--favicon-->
<link rel="icon" href="{{ asset('assets/images/favicon.ico') }}" type="image/x-icon">
<!-- Vector CSS -->
{{-- <link href="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" /> --}}
<!-- simplebar CSS-->
<link href="{{ asset('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
<!-- Bootstrap core CSS-->
<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
<!-- animate CSS-->
<link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet" type="text/css" />
<!-- Icons CSS-->
<link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
<!-- Sidebar CSS-->
<link href="{{ asset('assets/css/sidebar-menu.css') }}" rel="stylesheet" />
<!-- Custom Style-->
<link href="{{ asset('assets/css/app-style.css') }}" rel="stylesheet" />

<link href="{{ asset('plugins/font-icons/fontawesome/css/fontawesome.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/fontawesome.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/css/elements/avatar.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ asset('plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('plugins/notification/snackbar/snackbar.min.css') }}" rel="stylesheet" type="text/css" />

<link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/widgets/modules-widgets.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/theme-checkbox-radio.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/lightbox.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/apexcharts.css') }}">

{{-- por agregar para cuadro pos --}}
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/apps/scrumboard.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/apps/notes.css') }}"> --}}


<style>
    aside {
        display: none !important;
    }

    .page-item.active .page-link {
        z-index: 3;
        color: #fff;
        background-color: #3b3f5c;
        border-color: #3b3f5c;
    }

    @media (max-width: 480px) {
        .mtmobile {
            margin-bottom: 20px!important;
        }

        .mbmobile {
            margin-bottom: 10px!important;
        }

        .hideonsm {
            display: none!important;
        }

        .inblock {
            display: block;
        }
    }
</style>

<link href="{{ asset('plugins/flatpickr/flatpickr.dark.css') }}" rel="stylesheet" type="text/css" />

@livewireStyles
