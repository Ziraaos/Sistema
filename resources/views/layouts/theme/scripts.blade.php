<!-- Bootstrap core JavaScript-->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

<!-- simplebar js -->
<script src="{{ asset('assets/plugins/simplebar/js/simplebar.js') }}"></script>
<!-- sidebar-menu js -->
<script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
<!-- loader scripts -->
{{-- <script src="{{ asset('assets/js/jquery.loading-indicator.js') }}"></script> --}}
<!-- Custom scripts -->
<script src="{{ asset('assets/js/app-script.js') }}"></script>
<!-- Chart js -->

<script src="{{ asset('assets/plugins/Chart.js/Chart.min.js') }}"></script>

<!-- Index js -->
{{-- <script src="{{ asset('assets/js/index.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/js/app.js') }}"></script>
<script>
    $(document).ready(function() {
        App.init();
    });
</script>
<script src="{{ asset('assets/js/custom.js') }}"></script> --}}

<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/notification/snackbar/snackbar.min.js') }}"></script>
<script src="{{ asset('plugins/nicescroll/nicescroll.js') }}"></script>
<script src="{{ asset('plugins/currency/currency.js') }}"></script>
<script src="{{ asset('js/lightbox.js') }}"></script>
<script src="{{ asset('js/apexcharts.js') }}"></script>

<script>
    function noty(msg, option = 1)
    {
        Snackbar.show({
            text: msg.toUpperCase(),
            actionText: 'CERRAR',
            actionTextColor: '#fff',
            backgroundColor: option == 1 ? '#3b3f5c' : '#e7515a',
            pos: 'top-right'
        });
    }
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('global-msg', msg => {
            noty(msg)
        });
    })
</script>

<script src="{{ asset('plugins/flatpickr/flatpickr.js')}}"></script>

@livewireScripts
