<div class="card">
    <div class="card-header">{{ $componentName }} | {{ $pageTitle }}
        <div class="card-action">
            <div class="dropdown">
                @can('Permiso_Create')
                <li>
                    <a href="javascript:void(0)" class="tabmenu btn bg-primary" data-toggle="modal"
                        data-target="#theModal">Agregar</a>
                </li>
                @endcan
            </div>
        </div>
    </div>
    <div class="card-body">
        @can('Permiso_Search')
            @include('common.searchbox')
        @endcan
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permisos as $permiso)
                        <tr>
                            <th scope="row">{{ $permiso->id }}</th>
                            <td>{{ $permiso->name }}</td>
                            <td>
                                @can('Permiso_Update')
                                    <a href="javascript:void(0)" wire:click="Edit('{{ $permiso->id }}')"
                                        class="btn btn-info" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan
                                @can('Permiso_Destroy')
                                    <a href="javascript:void(0)" onclick="Confirm('{{ $permiso->id }}')"
                                        class="btn btn-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $permisos->links() }}
        </div>
    </div>
    @include('livewire.permisos.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function(){
        window.livewire.on('permiso-added', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('permiso-updated', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('permiso-deleted', Msg => {
            noty(Msg)
        })
        window.livewire.on('permiso-exists', Msg => {
            noty(Msg)
        })
        window.livewire.on('permiso-error', Msg => {
            noty(Msg)
        })
        window.livewire.on('hide-modal', Msg => {
            $('#theModal').modal('hide')
        })
        window.livewire.on('show-modal', Msg => {
            $('#theModal').modal('show')
        })
    });

    function Confirm(id)
    {

        swal({
            title: 'CONFIRMAR',
            text: '¿CONFIRMAS ELIMINAR EL REGISTRO?',
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#fff',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if(result.value){
                window.livewire.emit('destroy', id)
                swal.close()
            }

        })
    }



</script>
