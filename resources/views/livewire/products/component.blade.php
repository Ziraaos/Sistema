<div class="card">
    {{-- @include('livewire.category.form') --}} {{-- Obs. sacar afuera del div --}}
    <div class="card-header">{{$componentName}} | {{$pageTitle}}
        <div class="card-action">
            <div class="dropdown">
                {{-- <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
                    <i class="icon-options"></i>
                </a> --}}
                @can('Products_Create')
                    <li>
                        <a href="javascript:void(0)" class="tabmenu btn bg-primary" data-toggle="modal" data-target="#theModal">Agregar</a>
                    </li>
                @endcan
            </div>
        </div>

    </div>

    <div class="card-body">
        @can('Products_Search')
            @include('common.searchbox')
        @endcan
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th style="width:50px">Descripción</th>
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
                        <td class="nombre-columna">{{ $product->name }}</td>
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
                            @can('Products_Update')
                                <a href="javascript:void(0)" wire:click="Edit('{{$product->id}}')" class="btn btn-info" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @endcan
                            {{-- @if($category->products->count() < 1) --}}
                            @can('Products_Destroy')
                                <a href="javascript:void(0)" onclick="Confirm('{{$product->id}}')" class="btn btn-danger" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </a>
                            @endcan
                            @can('Products_Shop')
                                <button type="button" wire:click.prevent="ScanCode('{{$product->barcode}}')" class="btn btn-dark"><i class="fas fa-shopping-cart"></i>
                                </button>
                            @endcan
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
<style>
    .nombre-columna {
        max-width: 250px; /* Puedes ajustar el valor según tus necesidades */
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>

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

    function resetInputFile() {
        $('input[type=file]').val('');
    }

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
