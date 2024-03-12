<div class="card">
    <div class="card-header">{{ $componentName }} | {{ $pageTitle }}
        <div class="card-action">
            <div class="dropdown">
                {{-- <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
                    <i class="icon-options"></i>
                </a> --}}
            </div>
        </div>
    </div>

    <div class="card-body">
        {{-- @can('Customer_Search') --}}
        @include('common.searchbox')
        {{-- @endcan --}}
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Nombres</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">NIT/C.I.</th>
                        <th scope="col">Celular</th>
                        <th scope="col">ubicación servicio</th>
                        <th scope="col">Servicio / Plan</th>
                        <th scope="col">Deuda</th>
                        <th scope="col">Imágen</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                        <tr>
                            <td>{{ $customer->first_name }}</td>
                            <td>{{ $customer->last_name }}</td>
                            <td>{{ $customer->ci }}</td>
                            <td><a href="{{'https://wa.me/+591'.$customer->phone }}" style="color:#54ff6b;" target="_blank">{{ $customer->phone }}</td>
                            <td>{{ $customer->location }}</td>
                            <td>{{ $customer->service }}</td>
                            <td>{{ $customer->total_debt }}</td>
                            <td>
                                <span>
                                    <img src="{{ asset('storage/' . $customer->imagen) }}" height="70"
                                        width="80" class="rounded" alt="no-image">
                                </span>
                            </td>
                            <td>
                                <span
                                    class="badge {{ $customer->status == 'Active' ? 'badge-success' : 'badge-danger' }} text-uppercase">{{ $customer->status }}</span>
                            </td>
                            <td>
                                <button wire:click.prevent="getDetails({{ $customer->id }})" class="btn btn-dark">
                                    <i class="fas fa-list"></i>
                                </button>
                                {{-- <button type="button" onclick="rePrint({{ $d->id }})"
                                    class="btn btn-dark btn-sm">
                                    <i class="fas fa-print"></i>
                                </button> --}}
                                <button class="btn btn-dark"
                                    {{ $customer->total_debt > 0 || $customer->total_debt !== null ? '' : 'disabled' }}
                                    onclick="window.open('{{ url('reportCustomer/pdf' . '/' . $customer->first_name . ' '. $customer->last_name . '/' . $customer->id . '/' . $customer->location) }}', '_blank')">
                                    <i class="fas fa-print"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $customers->links() }}
        </div>
    </div>
    @include('livewire.reportCustomer.detail')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('payment-added', msg => {
            $('#theModal').modal('hide');
            noty(msg)
        });
        window.livewire.on('payment-not-added', msg => {
            $('#theModal').modal('hide');
            noty(msg)
        });
        window.livewire.on('payment-updated', msg => {
            $('#theModal').modal('hide');
            noty(msg)
        });
        window.livewire.on('payment-deleted', msg => {
            noty(msg)
        });
        window.livewire.on('hide-modal', msg => {
            $('#theModal').modal('hide');
        });
        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show');
        });
        window.livewire.on('hidden.bs.modal', msg => {
            $('.er').css('display', 'none');
        });

        function resetInputFile() {
            $('input[type=file]').val('');
        }

        //eventos
        window.livewire.on('show-modal-detail', Msg => {
            $('#modalDetails').modal('show')
        })

    });

    function resetInputFile() {
        $('input[type=file]').val('');
    }

    function Confirm(id, products) {
        if (products > 0) {
            swal('NO SE PUEDE ELIMINAR EL DESCUENTO PORQUE TIENE CLIENTES RELACIONADOS')
            return;
        }
        swal({
            title: 'CONFIRMAR',
            text: '¿CONFIRMAS ELIMINAR EL REGISTRO?',
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            /* cancelButtonColor: '#fff', */
            confirmButtonText: 'Aceptar',
            /* confirmButtonColor: '#3B3F5C' */
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('deleteRow', id)
                swal.close()
            }
        })
    }
</script>


<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&callback=iniciarMapa" async defer>
</script>

<script>
    function iniciarMapa() {
        var latitud = -20.4867123;
        var longitud = -66.8700932;
        coordenadas = {
            lng: longitud,
            lat: latitud
        }

        generarMapa(coordenadas);

    }

    function generarMapa(coordenadas) {
        var mapa = new google.maps.Map(document.getElementById('mapa'), {
            zoom: 12,
            center: new google.maps.LatLng(coordenadas.lat, coordenadas.lng)
        });

        marcador = new google.maps.Marker({
            map: mapa,
            draggable: true,
            position: new google.maps.LatLng(coordenadas.lat, coordenadas.lng)
        });

        marcador.addListener('dragend', function(event) {
            /* document.getElementById("address").value = this.getPosition().lat()+","+this.getPosition().lng(); */
            @this.set('address', this.getPosition().lat() + "," + this.getPosition().lng());
        });
    }
</script>
