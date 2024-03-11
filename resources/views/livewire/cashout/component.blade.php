<div class="card">
    <div class="card-content">
        <div class="card-header">
            <h4 class="card-title text-center"><b>Arqueo de Caja</b></h4>
        </div>
        @can('Cashout_Index')
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <label>Usuario</label>
                        <select wire:model="userid" class="form-control">
                            <option value="0" disabled>Elegir</option>
                            @foreach ($users as $u)
                                <option value="{{ $u->id }}">{{ $u->name }}</option>
                            @endforeach
                        </select>
                        @error('userid')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <label>Fecha inicial</label>
                        <input type="date" wire:model.lazy="fromDate" class="form-control">
                        @error('fromDate')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <label>Fecha final</label>
                        <input type="date" wire:model.lazy="toDate" class="form-control">
                        @error('toDate')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="col-sm-12 col-md-3 align-self-center d-flex justify-content-around">
                    @if ($userid > 0 && $fromDate != null && $toDate != null)
                        <button wire:click.prevent="Consultar" type="button" class="btn btn-dark">Consultar</button>
                    @endif

                    {{-- @if ($total > 0)
                        <button wire:click.prevent="Print()" type="button" class="btn btn-dark">Imprimir</button>
                    @endif --}}
                </div>
            </div>
        </div>

        <div class="row row-group mt-5">
            <div class="col-sm-12 col-md-4 mbmobile">
                <div class="card-body">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-white">Ventas Totales: Bs.{{ number_format($total, 2) }}</h5>
                            <h5 class="text-white">Artículos: {{ $items }}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-8">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">FOLIO</th>
                                    <th scope="col">TOTAL</th>
                                    <th scope="col">ITEMS</th>
                                    <th scope="col">FECHA</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($total <= 0)
                                    <tr>
                                        <td colspan="5">
                                            <h6 class="text-center">No hay ventas en la fecha seleccionada</h6>
                                        </td>
                                    </tr>
                                @endif

                                @foreach ($sales as $row)
                                    <tr>
                                        <td>
                                            <h6>{{ $row->id }}</h6>
                                        </td>
                                        <td>
                                            <h6>Bs.{{ number_format($row->total, 2) }}</h6>
                                        </td>
                                        <td>
                                            <h6>{{ $row->items }}</h6>
                                        </td>
                                        <td>
                                            <h6>{{ $row->created_at }}</h6>
                                        </td>
                                        <td>
                                            <button wire:click.prevent="viewDetails({{ $row }})"
                                                class="btn btn-dark btn-sm">
                                                <i class="fas fa-list"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endcan
    </div>
    @include('livewire.cashout.modalDetails')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('show-modal', Msg => {
            $('#modal-details').modal('show')
        })
    })
</script>
