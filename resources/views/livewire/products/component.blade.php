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
                        <th scope="col">Descripción</th>
                        <th scope="col">Barcode</th>
                        <th scope="col">Categoría</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Inv. min</th>
                        <th scope="col">Imagen</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $product)
                    <tr>
                        <th scope="row">{{$product->id}}</th>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->barcode }}</td>
                        <td>{{ $product->category }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ $product->alerts }}</td>
                        <td>
                            <span>
                                <img src="{{ asset('storage/' .$product->imagen) }}" height="70" width="80" class="rounded" alt="no-image">
                            </span>
                        </td>
                        <td>
                            <a href="javascript:void(0)" wire:click="Edit('{{$product->id}}')" class="btn btn-info" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            {{-- @if($category->products->count() < 1) --}}
                            <a href="javascript:void(0)" onclick="Confirm('{{$product->id}}')" class="btn btn-danger" title="Delete">
                                <i class="fas fa-trash"></i>
                            </a>
                            {{-- @endif --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{$data->links()}}
        </div>
    </div>
    @include('livewire.products.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        //events

        window.livewire.on('product-added', msg =>{
            $('#theModal').modal('hide');
            noty(msg)
        });
        window.livewire.on('product-updated', msg =>{
            $('#theModal').modal('hide');
            noty(msg)
        });
        window.livewire.on('product-deleted', msg =>{
            noty(msg)
        });

        window.livewire.on('modal-show', msg =>{
            $('#theModal').modal('show');
        });
        window.livewire.on('modal-hide', msg =>{
            $('#theModal').modal('hide');
        });

        window.livewire.on('hidden.bs.modal', msg =>{
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
