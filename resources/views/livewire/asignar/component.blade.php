<div class="card">
    <div class="card-header">{{ $componentName }}
    </div>
    @can('Asign_Index')
    <div class="card-body">
        <div class="form-inline">
            <div class="form-group mr-5">
                <select wire:model="role" class="form-control">
                    <option value="Elegir" selected>== Selecciona el Rol ==</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <button wire:click.prevent="SyncAll()" type="button" class="btn btn-dark mbmobile inblock mr-5">Sincronizar
                Todos</button>

            <button onclick="Revocar()" type="button" class="btn btn-dark mbmobile mr-5">Revocar Todos</button>
        </div>
        <div class="row mt-3">
            <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Permiso</th>
                                <th scope="col">Roles con el permiso</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permisos as $permiso)
                                <tr>
                                    <th scope="row">{{ $permiso->id }}</th>
                                    <td>
                                        <div class="n-check">
                                            <label class="new-control new-checkbox checkbox-primary">
                                                <input type="checkbox"
                                                    wire:change="syncPermiso($('#p' + {{ $permiso->id }}).is(':checked'), '{{ $permiso->name }}' )"
                                                    id="p{{ $permiso->id }}" value="{{ $permiso->id }}"
                                                    class="new-control-input"
                                                    {{ $permiso->checked == 1 ? 'checked' : '' }}>
                                                <span class="new-control-indicator"></span>
                                                <h6>{{ $permiso->name }}</h6>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        {{ \App\Models\User::permission($permiso->name)->count() }}{{--  NO SE PUEDE VISUALIZAR EL CONTEO REVISAR --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $permisos->links() }}
                </div>
            </div>
        </div>
    </div>
    @endcan
    {{-- @include('livewire.permisos.form') --}}
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('sync-error', Msg => {
            noty(Msg)
        })
        window.livewire.on('permi', Msg => {
            noty(Msg)
        })
        window.livewire.on('syncall', Msg => {
            noty(Msg)
        })
        window.livewire.on('removeall', Msg => {
            noty(Msg)
        })
    });

    function Revocar() {

        swal({
            title: 'CONFIRMAR',
            text: '¿CONFIRMAS REVOCAR TODOS LOS PERMISOS?',
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#fff',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('revokeall')
                swal.close()
            }

        })
    }
</script>
