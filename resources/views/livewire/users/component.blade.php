<div class="card">
    {{-- @include('livewire.category.form') --}} {{-- Obs. sacar afuera del div --}}
    <div class="card-header">{{ $componentName }} | {{ $pageTitle }}
        <div class="card-action">
            <div class="dropdown">
                {{-- <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
                    <i class="icon-options"></i>
                </a> --}}
                <li>
                    <a href="javascript:void(0)" class="tabmenu btn bg-primary" data-toggle="modal"
                        data-target="#theModal">Agregar</a>
                </li>
            </div>
        </div>

    </div>

    <div class="card-body">
        @include('common.searchbox')
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Email</th>
                        <th scope="col">Status</th>
                        <th scope="col">Perfil</th>
                        <th scope="col">Imágen</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $r)
                        <tr>
                            <th scope="row">{{ $r->id }}</th>
                            <td>{{ $r->name }}</td>
                            <td>{{ $r->phone }}</td>
                            <td>{{ $r->email }}</td>
                            <td>
                                <span class="badge {{ $r->status == 'Active' ? 'badge-success' : 'badge-danger' }} text-uppercase">{{ $r->status }}</span>
                            </td>
                            <td class="text-uppercase">
                                {{ $r->profile }}
                                <small><b>Roles:</b>{{ implode(',', $r->getRoleNames()->toArray()) }}</small>
                            </td>
                            <td>
                                <span>
                                    @if ($r->image != null)
                                        <img class="card-img-top img-fluid"
                                            src="{{ asset('storage/users/' . $r->image) }}" height="70" width="80" class="rounded">
                                    @endif
                                </span>
                            </td>
                            <td>
                                <a href="javascript:void(0)" wire:click="edit('{{ $r->id }}')"
                                    class="btn btn-info" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                {{-- @if (Auth()->user()->id != $r->id) --}}
                                    <a href="javascript:void(0)" onclick="Confirm('{{ $r->id }}')"
                                        class="btn btn-dark" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                {{-- @endif --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $data->links() }}
        </div>
    </div>
    @include('livewire.users.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('user-added', Msg => {
            $('#theModal').modal('hide')
            resetInputFile()
            noty(Msg)
        })
        window.livewire.on('user-updated', Msg => {
            $('#theModal').modal('hide')
            resetInputFile()
            noty(Msg)
        })
        window.livewire.on('user-deleted', Msg => {
            noty(Msg)
        })
        window.livewire.on('hide-modal', Msg => {
            $('#theModal').modal('hide')
        })
        window.livewire.on('show-modal', Msg => {
            $('#theModal').modal('show')
        })
        window.livewire.on('user-withsales', Msg => {
            noty(Msg)
        })

    })

    function resetInputFile() {
        $('input[type=file]').val('');
    }


    function Confirm(id) {

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
            if (result.value) {
                window.livewire.emit('deleteRow', id)
                swal.close()
            }

        })
    }
</script>
