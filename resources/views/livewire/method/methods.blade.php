<div class="card">
    <div class="card-header">{{ $componentName }} | {{ $pageTitle }}
        <div class="card-action">
            <div class="dropdown">
                {{-- <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
                    <i class="icon-options"></i>
                </a> --}}
                @can('Method_Create')
                    <li>
                        <a href="javascript:void(0)" class="tabmenu btn bg-primary" data-toggle="modal"
                            data-target="#theModal">Agregar</a>
                    </li>
                @endcan
            </div>
        </div>
    </div>

    <div class="card-body">
        @can('Method_Search')
            @include('common.searchbox')
        @endcan
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Entidad Financiera</th>
                        <th scope="col">Numero de cuenta</th>
                        <th scope="col">Beneficiario</th>
                        <th scope="col">C.I.</th>
                        <th scope="col">Notas</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($methods as $method)
                        <tr>
                            <th scope="row">{{ $method->id }}</th>
                            <td>{{ $method->name }}</td>
                            <td>{{ $method->financial_entity }}</td>
                            <td>{{ $method->account_number }}</td>
                            <td>{{ $method->beneficiary }}</td>
                            <td>{{ $method->ci }}</td>
                            <td>{{ $method->note }}</td>
                            <td>
                                @can('Method_Update')
                                    <a href="javascript:void(0)" wire:click="Edit('{{ $method->id }}')"
                                        class="btn btn-info" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan
                                @can('Method_Destroy')
                                    {{-- @if ($method->products->count() < 1) --}}
                                    <a href="javascript:void(0)"
                                        {{-- onclick="Confirm('{{ $method->id }}' , '{{ $method->products->count() }}')" --}}
                                        onclick="Confirm('{{ $method->id }}')"
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
            {{ $methods->links() }}
        </div>
    </div>
    @include('livewire.method.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('method-added', msg => {
            $('#theModal').modal('hide');
            noty(msg)
        });
        window.livewire.on('method-updated', msg => {
            $('#theModal').modal('hide');
            noty(msg)
        });
        window.livewire.on('method-deleted', msg => {
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
            swal('NO SE PUEDE ELIMINAR EL METODO DE PAGO PORQUE TIENE PAGOS RELACIONADOS')
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
