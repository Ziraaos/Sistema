<div wire:ignore.self class="modal fade" id="modalDetails" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content card">
            <div class="modal-header bg-primary bg-gradient">
                <h5 class="modal-title text-white">
                    <b>Detalle de Venta # {{ $saleId }}</b>
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body bg-gradient" style="background-color:#6f42c1">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="text-center">FOLIO</th>
                                <th class="text-center">PRODUCTO</th>
                                <th class="text-center">PRECIO</th>
                                <th class="text-center">CANT</th>
                                <th class="text-center">IMPORTE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($details as $d)
                                <tr>
                                    <td class='text-center'>
                                        <h6>{{ $d->id }}</h6>
                                    </td>
                                    <td class='text-center'>
                                        <h6>{{ $d->product }}</h6>
                                    </td>
                                    <td class='text-center'>
                                        <h6>{{ number_format($d->price, 2) }}</h6>
                                    </td>
                                    <td class='text-center'>
                                        <h6>{{ number_format($d->quantity, 0) }}</h6>
                                    </td>
                                    <td class='text-center'>
                                        <h6>{{ number_format($d->price * $d->quantity, 2) }}</h6>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">
                                    <h5 class="text-center font-weight-bold">TOTALES</h5>
                                </td>
                                <td>
                                    <h5 class="text-center">{{ $countDetails }}</h5>
                                </td>
                                <td>
                                    <h5 class="text-center">
                                        Bs.{{ number_format($sumDetails, 2) }}
                                    </h5>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-primary bg-gradient">
                <button type="button" class="btn btn-dark close-btn text-info" data-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </div>
</div>
