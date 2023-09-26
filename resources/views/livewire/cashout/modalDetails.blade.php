<div wire:ignore.self id="modal-details" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content card">
            <div class="modal-header bg-primary bg-gradient">
                <h5 class="modal-title text-white">
                    <b>Detalle de Ventas</b>
                </h5>
                <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                    <span class="text-white">&times;</span>
                </button>
            </div>

            <div class="modal-body bg-gradient" style="background-color:#6f42c1">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead style="background: #3B3F5C">
                            <tr>
                                <th class="text-center">PRODUCTO</th>
                                <th class="text-center">CANT</th>
                                <th class="text-center">PRECIO</th>
                                <th class="text-center">IMPORTE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($details as $d)
                                <tr>
                                    <td class="text-center">{{ $d->product }}</td>
                                    <td class="text-center">{{ $d->quantity }}</td>
                                    <td class="text-center">Bs.{{ number_format($d->price, 2) }}</td>
                                    <td class="text-center">Bs.{{ number_format($d->quantity * $d->price, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <td class="text-right">
                                <h5 class="text-info">TOTALES:</h5>
                            </td>
                            <td class="text-center">
                                @if ($details)
                                    <h5 class="text-info">{{ $details->sum('quantity') }}</h5>
                                @endif
                            </td>
                            @if ($details)
                                @php $mytotal =0; @endphp
                                @foreach ($details as $d)
                                    @php
                                        $mytotal += $d->quantity * $d->price;
                                    @endphp
                                @endforeach
                                <td></td>
                                <td class="text-center">
                                    <h5 class="text-info">Bs.{{ number_format($mytotal, 2) }}</h5>
                                </td>
                            @endif
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
