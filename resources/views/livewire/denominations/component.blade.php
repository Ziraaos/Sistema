<div class="card">
    <div class="card-header">{{$componentName}} | {{$pageTitle}}
        <div class="card-action">
            <div class="dropdown">
                {{-- <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
                    <i class="icon-options"></i>
                </a> --}}
                @can('Denomination_Create')
                    <li>
                        <a href="javascript:void(0)" class="tabmenu btn bg-primary" data-toggle="modal" data-target="#theModal">Agregar</a>
                    </li>
                @endcan
            </div>
        </div>

    </div>

    <div class="card-body">
        @can('Denomination_Search')
            @include('common.searchbox')
        @endcan
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $coin)
                    <tr>
                        <th scope="row">{{$coin->id}}</th>
                        <td>{{ $coin->type }}</td>
                        <td>Bs. {{ number_format($coin->value, 2) }}</td>
                        <td>
                            <span>
                                <img src="{{ asset('storage/' .$coin->imagen) }}" height="70" width="80" class="rounded" alt="no-image">
                            </span>
                        </td>
                        <td>
                            @can('Denomination_Update')
                                <a href="javascript:void(0)" wire:click="Edit('{{$coin->id}}')" class="btn btn-info" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @endcan
                            @can('Denomination_Destroy')
                                <a href="javascript:void(0)" onclick="Confirm('{{$coin->id}}')" class="btn btn-danger" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </a>
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{$data->links()}}
        </div>
    </div>
    @include('livewire.denominations.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        //events

        window.livewire.on('item-added', msg =>{
            $('#theModal').modal('hide');
            noty(msg)
        });
        window.livewire.on('item-updated', msg =>{
            $('#theModal').modal('hide');
            noty(msg)
        });
        window.livewire.on('item-deleted', msg =>{
            noty(msg)
        });

        window.livewire.on('show-modal', msg =>{
            $('#theModal').modal('show');
        });
        window.livewire.on('modal-hide', msg =>{
            $('#theModal').modal('hide');
        });

        //Cuando demos boton cerrar ocultamos todos los errores que se hayan mostrado en ventana modal
        $('#theModal').on('hidden.bs.modal', function (e) {
            $('.er').css('display','none');
        });

    })

    function Confirm(id, products){
        if(products > 0){
            swal('NO SE PUEDE ELIMINAR LA CATEGORIA PORQUE TIENE PRODUCTOS RELACIONADOS')
            return;
        }
        swal({
            title: 'CONFIRMAR',
            text: '¿CONFIRMAS ELIMINAR EL REGISTRO?',
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#fff',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#3B3F5C'
        }).then(function(result){
            if(result.value){
                window.livewire.emit('deleteRow', id)
                swal.close()
            }
        })
    }
</script>
