<div wire:ignore.self class="modal fade" id="modalDetails" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content card">
            <div class="modal-header bg-primary bg-gradient">
                <h5>
                    <b>Detalle del servicio </b>
                </h5>
                <table>
                    <tr>
                        <th class="text-right">Cliente: </th>
                        <th>{{ $namec }}</th>
                        {{-- <b>Cliente: {{$namec}}</b><br> --}}
                    </tr>
                    <tr>
                        <th class="text-right">Ubicacion del servicio:</th>
                        <th>{{ $localidad }}</th>
                    </tr>
                </table>

                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body bg-gradient" style="background-color:#6f42c1">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="text-center">Mes</th>
                                <th class="text-center">Monto</th>
                                <th class="text-center">Deuda</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Localidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($details as $d)
                                <tr>
                                    <td class='text-center'>
                                        <h6>{{ \Carbon\Carbon::parse($d->date_serv)->format('m-Y') }}</h6>
                                    </td>
                                    <td class='text-center'>
                                        <h6>{{ number_format($d->debt, 2) }}</h6>
                                    </td>
                                    <td class='text-center'>
                                        <h6>{{ number_format($d->total, 2) }}</h6>
                                    </td>
                                    <td class='text-center'>
                                        <span
                                            class="badge {{ $d->status == 'PAID' ? 'badge-success' : 'badge-danger' }} text-uppercase">
                                            @if ($d->status == 'PAID')
                                                PAGADO
                                            @elseif ($d->status == 'PENDING')
                                                PENDIENTE
                                            @else
                                                {{ $d->status }}
                                            @endif
                                        </span>
                                    </td>
                                    <td class='text-center'>
                                        <h6>{{ $d->location_name }}</h6>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2">
                                    <h5 class="text-center font-weight-bold">TOTAL DEUDA:</h5>
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
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Monto</th>
                                <th class="text-center">Fecha</th>
                                <th class="text-center">Cuenta</th>
                                <th class="text-center">Comprobante</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($paymentDetails as $p)
                                <tr>
                                    <td class='text-center'>
                                        <h6>{{ $p->id }}</h6>
                                    </td>
                                    <td class='text-center'>
                                        <h6>{{ $p->price }}</h6>
                                    </td>
                                    <td class='text-center'>
                                        <h6>{{ \Carbon\Carbon::parse($p->date_serv)->format('d-m-Y') }}</h6>
                                    </td>
                                    <td class='text-center'>
                                        <h6>{{ $p->paymentMethod->name }}</h6>
                                    </td>
                                    <td class='text-center'>
                                        <span>
                                            <img src="{{ asset('storage/payments/' . $p->image) }}" height="70"
                                                width="80" class="rounded" alt="no-image">
                                        </span>
                                        <a href="{{ asset('storage/payments/' . $p->image) }}" data-lightbox="roadtrip">Ver</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2">
                                    <h5 class="text-center font-weight-bold">TOTAL DEUDA:</h5>
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
