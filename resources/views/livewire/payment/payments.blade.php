<div class="card">
    <div class="card-content">
        <div class="card-header">
            <h4 class="card-title text-center"><b>{{ $componentName }}</b></h4>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-md-3">
                    <div class="row">
                        <div class="col-sm-12">
                            <h6>Elige la ubicación</h6>
                            <div class="form-group">
                                <select wire:model="locationId" class="form-control">
                                    <option value="0">Todos</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}">{{ $location->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <h6>Elige el tipo de reporte</h6>
                            <div class="form-group">
                                <select wire:model="reportType" class="form-control">
                                    <option value="0">Pagos del mes</option>
                                    <option value="1">Pagos por fecha</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 mt-2">
                            <h6>Fecha mes</h6>
                            <div class="form-group">
                                <input type="month" wire:model="date" class="form-control">
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <button wire:click="$refresh" class="btn btn-dark btn-block">
                                Consultar
                            </button>

                            {{-- <a class="btn btn-dark btn-block {{ count($data) < 1 ? 'disabled' : '' }}"
                                href="{{ url('report/pdf' . '/' . $userId . '/' . $reportType . '/' . $dateFrom . '/' . $dateTo) }}"
                                target="_blank">Generar PDF</a>

                            <a class="btn btn-dark btn-block {{ count($data) < 1 ? 'disabled' : '' }}"
                                href="{{ url('report/excel' . '/' . $userId . '/' . $reportType . '/' . $dateFrom . '/' . $dateTo) }}"
                                target="_blank">Exportar a Excel</a> --}}

                            <li>
                                <a href="javascript:void(0)" class="btn btn-dark" data-toggle="modal"
                                    data-target="#theModal">Generar pagos por mes</a>
                            </li>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-9">
                    <!--TABLAE-->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Nombres</th>
                                    <th class="text-center">Apellidos</th>
                                    <th class="text-center">Items</th>
                                    <th class="text-center">Estado</th>
                                    <th class="text-center">Lugar</th>
                                    <th class="text-center">Mes</th>
                                    {{-- <th class="text-center" width="50px"></th> --}}
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($data) < 1)
                                    <tr>
                                        <td colspan="7">
                                            <h5>Sin Resultados</h5>
                                        </td>
                                    </tr>
                                @endif
                                @foreach ($data as $d)
                                    <tr>
                                        <td class="text-center">
                                            <h6>{{ $d->id }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6>{{ $d->first_name }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6>{{ $d->last_name }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6>{{ $d->items }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge {{ $d->status == 'PAID' ? 'badge-success' : 'badge-danger' }} text-uppercase">{{ $d->status }}</span>
                                        </td>
                                        <td class="text-center">
                                            <h6>{{ $d->name }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6>
                                                {{ \Carbon\Carbon::parse($d->date_serv)->format('m-Y') }}
                                            </h6>
                                        </td>
                                        <td class="text-center">
                                            <button wire:click.prevent="getDetails({{ $d->id }})"
                                                class="btn btn-dark btn-sm">
                                                <i class="fas fa-list"></i>
                                            </button>
                                            <button type="button" onclick="rePrint({{ $d->id }})"
                                                class="btn btn-dark btn-sm">
                                                <i class="fas fa-print"></i>
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
    </div>
    @include('livewire.payment.payment-detail')
    @include('livewire.payment.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('payment-added', msg => {
            $('#theModal').modal('hide');
            noty(msg)
        });
        window.livewire.on('payment-updated', msg => {
            $('#theModal').modal('hide');
            noty(msg)
        });
        window.livewire.on('payment-deleted', msg => {
            noty(msg)
        });
        window.livewire.on('hide-modal', msg => {
            $('#theModal').modal('hide');
        });
        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show');
        });
        window.livewire.on('hidden.bs.modal', msg => {
            $('.er').css('display', 'none');
        });


        //eventos
        window.livewire.on('show-modal', Msg => {
            $('#modalDetails').modal('show')
        })
    })

    function rePrint(saleId) {
        window.open("print://" + saleId, '_self').close()
    }
</script>
