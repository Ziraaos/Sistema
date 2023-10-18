<div class="card">
    <div class="card-header">{{ $componentName }} | {{ $pageTitle }}
        <div class="card-action">
            <div class="dropdown">
                {{-- <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
                    <i class="icon-options"></i>
                </a> --}}
                {{-- @can('Service_Create') --}}
                    <li>
                        <a href="javascript:void(0)" class="tabmenu btn bg-primary" data-toggle="modal"
                            data-target="#theModal">Agregar</a>
                    </li>
                {{-- @endcan --}}
            </div>
        </div>
    </div>

    <div class="card-body">
        {{-- @can('Service_Search') --}}
            @include('common.searchbox')
        {{-- @endcan --}}
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Días sin servicio</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($discounts as $discount)
                        <tr>
                            <th scope="row">{{ $discount->id }}</th>
                            <td>{{ $discount->name }}</td>
                            <td>{{ $discount->days_dwntm }}</td>
                            <td>
                                {{-- @can('Service_Update') --}}
                                    <a href="javascript:void(0)" wire:click="Edit('{{ $discount->id }}')"
                                        class="btn btn-info" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                {{-- @endcan
                                @can('Service_Destroy') --}}
                                    {{-- @if ($discount->products->count() < 1) --}}
                                    <a href="javascript:void(0)"
                                        {{-- onclick="Confirm('{{ $discount->id }}' , '{{ $discount->products->count() }}')" --}}
                                        onclick="Confirm('{{ $discount->id }}')"
                                        class="btn btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    {{-- @endif --}}
                                {{-- @endcan --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $discounts->links() }}
        </div>
    </div>
    @include('livewire.discount.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('discount-added', msg => {
            $('#theModal').modal('hide');
            noty(msg)
        });
        window.livewire.on('discount-updated', msg => {
            $('#theModal').modal('hide');
            noty(msg)
        });
        window.livewire.on('discount-deleted', msg => {
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
