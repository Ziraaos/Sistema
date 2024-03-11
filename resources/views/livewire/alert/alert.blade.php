<script>
    document.addEventListener('livewire:load', function() {
        // Verificar si hay datos para el mensaje de 2 meses
        if (@this.twoName) {
            Swal.fire({
                title: 'Clientes con 2 meses en mora',
                text: @this.twoName,
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Cerrar',
                cancelButtonColor: '#fff',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#3B3F5C'
            }).then(function() {
                // Llamada a la segunda alerta solo si hay datos para el mensaje de 3 meses
                if (@this.threeName) {
                    return Swal.fire({
                        title: 'Clientes con 3 o más meses en mora',
                        text: @this.threeName,
                        type: 'error',
                        showCancelButton: true,
                        cancelButtonText: 'Cerrar',
                        cancelButtonColor: '#fff',
                        confirmButtonText: 'Aceptar',
                        confirmButtonColor: '#3B3F5C'
                    }).then(function(secondResult) {
                        // Verificar si se hizo clic en "Aceptar" en la segunda alerta
                        if (secondResult.isConfirmed) {
                            // Tu lógica condicional después de confirmar la segunda alerta
                            window.location.href = '{{ route('payments') }}';
                        }
                    });
                }
            });
        }
        else {
            if (@this.threeName) {
            Swal.fire({
                title: 'Clientes con 3 o más meses en mora',
                text: @this.threeName,
                type: 'error',
                showCancelButton: true,
                cancelButtonText: 'Cerrar',
                cancelButtonColor: '#fff',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#3B3F5C'
            }).then(function(secondResult) {
                // Verificar si se hizo clic en "Aceptar" en la segunda alerta
                if (secondResult.isConfirmed) {
                    // Tu lógica condicional después de confirmar la segunda alerta
                    window.location.href = '{{ route('payments') }}';
                }
            });
        }
        }
    });
</script>
