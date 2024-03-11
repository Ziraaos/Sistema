<div class="card">
    <div class="card-header">{{ $componentName }} | {{ $pageTitle }}
        <div class="card-action">
            <div class="dropdown">
                {{-- <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
                    <i class="icon-options"></i>
                </a> --}}
                @can('Service_Create')
                    <li>
                        <a href="javascript:void(0)" class="tabmenu btn bg-primary" data-toggle="modal"
                            data-target="#theModal">Agregar</a>
                    </li>
                @endcan
            </div>
        </div>
    </div>

    <div class="card-body">
        @can('Service_Search')
            @include('common.searchbox')
        @endcan
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Velocidad bajada</th>
                        <th scope="col">Velocidad subida</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($services as $service)
                        <tr>
                            <th scope="row">{{ $service->id }}</th>
                            <td>{{ $service->name }}</td>
                            <td>{{ $service->price }}</td>
                            <td>{{ $service->dwn_spd }}</td>
                            <td>{{ $service->up_spd }}</td>
                            <td>
                                @can('Service_Update')
                                    <a href="javascript:void(0)" wire:click="Edit('{{ $service->id }}')"
                                        class="btn btn-info" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan
                                @can('Service_Destroy')
                                    {{-- @if ($service->products->count() < 1) --}}
                                    <a href="javascript:void(0)"
                                        {{-- onclick="Confirm('{{ $service->id }}' , '{{ $service->products->count() }}')" --}}
                                        onclick="Confirm('{{ $service->id }}')"
                                        class="btn btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    {{-- @endif --}}
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $services->links() }}
        </div>
    </div>
    @include('livewire.service.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('service-added', msg => {
            $('#theModal').modal('hide');
            noty(msg)
        });
        window.livewire.on('service-updated', msg => {
            $('#theModal').modal('hide');
            noty(msg)
        });
        window.livewire.on('service-deleted', msg => {
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

    function Confirm(id, products) {
        if (products > 0) {
            swal('NO SE PUEDE ELIMINAR EL PLAN PORQUE TIENE CLIENTES RELACIONADOS')
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
