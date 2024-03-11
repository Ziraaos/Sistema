<div class="card">
    <div class="card-header">{{ $componentName }} | {{ $pageTitle }}
        <div class="card-action">
            <div class="dropdown">
                {{-- <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
                    <i class="icon-options"></i>
                </a> --}}
                @can('Location_Create')
                    <li>
                        <a href="javascript:void(0)" class="tabmenu btn bg-primary" data-toggle="modal"
                            data-target="#theModal">Agregar</a>
                    </li>
                @endcan
            </div>
        </div>
    </div>

    <div class="card-body">
        @can('Location_Search')
            @include('common.searchbox')
        @endcan
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Departamento</th>
                        <th scope="col">Ciudad/Comunidad</th>
                        <th scope="col">Notas</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($locations as $location)
                        <tr>
                            <th scope="row">{{ $location->id }}</th>
                            <td>{{ $location->name }}</td>
                            <td>{{ $location->state }}</td>
                            <td>{{ $location->city }}</td>
                            <td>{{ $location->note }}</td>
                            <td>
                                @can('Location_Update')
                                    <a href="javascript:void(0)" wire:click="Edit('{{ $location->id }}')"
                                        class="btn btn-info" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan
                                @can('Location_Destroy')
                                    {{-- @if ($location->products->count() < 1) --}}
                                    <a href="javascript:void(0)"
                                        {{-- onclick="Confirm('{{ $location->id }}' , '{{ $location->products->count() }}')" --}}
                                        onclick="Confirm('{{ $location->id }}')"
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
            {{ $locations->links() }}
        </div>
    </div>
    @include('livewire.location.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('location-added', msg => {
            $('#theModal').modal('hide');
            noty(msg)
        });
        window.livewire.on('location-updated', msg => {
            $('#theModal').modal('hide');
            noty(msg)
        });
        window.livewire.on('location-deleted', msg => {
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
