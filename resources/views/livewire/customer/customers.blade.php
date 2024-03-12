<div class="card">
    <div class="card-header">{{ $componentName }} | {{ $pageTitle }}
        <div class="card-action">
            <div class="dropdown">
                {{-- <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
                    <i class="icon-options"></i>
                </a> --}}
                @can('Customer_Create')
                <li>
                    <a href="javascript:void(0)" class="tabmenu btn bg-primary" data-toggle="modal"
                        data-target="#theModal">Agregar</a>
                </li>
                @endcan
            </div>
        </div>
    </div>

    <div class="card-body">
        @can('Customer_Search')
        @include('common.searchbox')
        @endcan
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">Nombres</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">NIT/C.I.</th>
                        <th scope="col">Email</th>
                        <th scope="col">Celular</th>
                        <th scope="col">ubicación servicio</th>
                        <th scope="col">Servicio / Plan</th>
                        <th scope="col">Descuento</th>
                        <th scope="col">Dirección</th>
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
                            <td>{{ $customer->email }}</td>
                            <td><a href="{{'https://wa.me/+591'.$customer->phone }}" style="color:#54ff6b;" target="_blank"> {{ $customer->phone }} </a></td>
                            <td>{{ $customer->location }}</td>
                            <td>{{ $customer->service }}</td>
                            <td>
                                <span
                                    class="badge {{ $customer->disc == 'YES' ? 'badge-success' : 'badge-danger' }} text-uppercase">{{ $customer->disc }}</span>
                            </td>
                            <td>
                                {{-- {{ $customer->address }} --}}
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $customer->address }}&zoom=10"
                                    target="_blank"><img height="25px" src="assets/images/Google_Maps_icon.png" /></a>
                            </td>
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
                                @can('Customer_Update')
                                <a href="javascript:void(0)" wire:click="Edit('{{ $customer->id }}')"
                                    class="btn btn-info" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @endcan
                                @can('Customer_Destroy')
                                {{-- @if ($customer->products->count() < 1) --}}
                                <a href="javascript:void(0)" {{-- onclick="Confirm('{{ $customer->id }}' , '{{ $customer->products->count() }}')" --}}
                                    onclick="Confirm('{{ $customer->id }}')" class="btn btn-danger" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </a>
                                {{-- @endif --}}
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $customers->links() }}
        </div>
    </div>
    @include('livewire.customer.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('customer-added', msg => {
            $('#theModal').modal('hide');
            noty(msg)
        });
        window.livewire.on('customer-updated', msg => {
            $('#theModal').modal('hide');
            noty(msg)
        });
        window.livewire.on('customer-deleted', msg => {
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
