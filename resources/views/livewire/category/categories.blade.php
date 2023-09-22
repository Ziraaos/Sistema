<div class="card">
    {{-- @include('livewire.category.form') --}} {{-- Obs. sacar afuera del div --}}
    <div class="card-header">{{$componentName}} | {{$pageTitle}}
        <div class="card-action">
            <div class="dropdown">
                {{-- <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
                    <i class="icon-options"></i>
                </a> --}}
                    <li>
                        <a href="javascript:void(0)" class="tabmenu btn bg-primary" data-toggle="modal" data-target="#theModal">Agregar</a>
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
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                    <tr>
                        <th scope="row">{{$category->id}}</th>
                        <td>{{$category->name}}</td>
                        <td>
                            <span>
                                <img src="{{ asset('storage/categories/' .$category->image) }}" alt="">
                            </span>
                        </td>
                        <td>
                            <a href="javascript:void(0)" wire:click="Edit('{{$category->id}}')" class="btn btn-info" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="javascript:void(0)" onclick="Confirm('{{$category->id}}')" class="btn btn-danger" title="Delete">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{$categories->links()}}
        </div>
    </div>
    @include('livewire.category.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        window.livewire.on('category-added', msg =>{
            $('#theModal').modal('hide');
            noty(msg)
        });
        window.livewire.on('category-updated', msg =>{
            $('#theModal').modal('hide');
            noty(msg)
        });
        window.livewire.on('category-deleted', msg =>{
            noty(msg)
        });
        window.livewire.on('hide-modal', msg =>{
            $('#theModal').modal('hide');
        });
        window.livewire.on('show-modal', msg =>{
            $('#theModal').modal('show');
        });
        window.livewire.on('hidden.bs.modal', msg =>{
            $('.er').css('display','none');
        });
    });

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
