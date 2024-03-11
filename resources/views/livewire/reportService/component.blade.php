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
                            <h6>Elige la ubicación del servicio</h6>
                            <div class="form-group">
                                <select wire:model="locationid" class="form-control">
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
                                    <option value="0">Todos</option>
                                    <option value="1">Sin deuda</option>
                                    <option value="2">1 mes de deuda</option>
                                    <option value="3">2 meses de deuda</option>
                                    <option value="4">3 o más meses de deuda</option>
                                </select>
                            </div>
                        </div>
                        {{-- <div class="col-sm-12 mt-2">
                            <h6>Fecha desde</h6>
                            <div class="form-group">
                                <input type="text" wire:model="dateFrom" class="form-control flatpickr"
                                    placeholder="Click para elegir">
                            </div>
                        </div>
                        <div class="col-sm-12 mt-2">
                            <h6>Fecha hasta</h6>
                            <div class="form-group">
                                <input type="text" wire:model="dateTo" class="form-control flatpickr"
                                    placeholder="Click para elegir">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <button wire:click="$refresh" class="btn btn-dark btn-block">
                                Consultar
                            </button>

                            <a class="btn btn-dark btn-block {{ count($data) < 1 ? 'disabled' : '' }}"
                                href="{{ url('report/pdf' . '/' . $userId . '/' . $reportType . '/' . $dateFrom . '/' . $dateTo) }}"
                                target="_blank">Generar PDF</a>

                            <a class="btn btn-dark btn-block {{ count($data) < 1 ? 'disabled' : '' }}"
                                href="{{ url('report/excel' . '/' . $userId . '/' . $reportType . '/' . $dateFrom . '/' . $dateTo) }}"
                                target="_blank">Exportar a Excel</a>
                        </div> --}}
                        <div class="col-sm-12">
                            <button wire:click="PaymentsByLocation({{1}})" class="btn btn-dark btn-block">
                                Consultar
                            </button>
                            <a class="btn btn-dark btn-block {{ count($data) < 1 ? 'disabled' : '' }}"
                                href="{{ url('reportService/pdf' . '/' . $locationid . '/' . $reportType) }}"
                                target="_blank">Generar PDF</a>

                            <a class="btn btn-dark btn-block {{ count($data) < 1 ? 'disabled' : '' }}"
                                href="{{ url('reportService/excel' . '/' . $userId . '/' . $locationid . '/' . $dateFrom . '/' . $dateTo) }}"
                                target="_blank">Exportar a Excel</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-9">
                    <!--TABLAE-->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">id</th>
                                    <th class="text-center">Nombres</th>
                                    <th class="text-center">Apellidos</th>
                                    <th class="text-center">Deuda total</th>
                                    <th class="text-center">Meses de deuda</th>
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
                                            <h6>{{ $d->customer_id }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6>{{ $d->first_name }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6>{{ $d->last_name }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6>Bs.{{ number_format($d->deuda_total, 2) }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6>{{ $d->meses_deuda }}</h6>
                                        </td>
                                        {{-- <td class="text-center">
                                            <h6>
                                                {{ \Carbon\Carbon::parse($d->created_at)->format('d-m-Y') }}
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
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- @include('livewire.reports.sales-detail') --}}
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr(document.getElementsByClassName('flatpickr'), {
            enableTime: false,
            dateFormat: 'Y-m-d',
            locale: {
                firstDayofWeek: 1,
                weekdays: {
                    shorthand: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
                    longhand: [
                        "Domingo",
                        "Lunes",
                        "Martes",
                        "Miércoles",
                        "Jueves",
                        "Viernes",
                        "Sábado",
                    ],
                },
                months: {
                    shorthand: [
                        "Ene",
                        "Feb",
                        "Mar",
                        "Abr",
                        "May",
                        "Jun",
                        "Jul",
                        "Ago",
                        "Sep",
                        "Oct",
                        "Nov",
                        "Dic",
                    ],
                    longhand: [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre",
                    ],
                },

            }

        })


        //eventos
        window.livewire.on('show-modal', Msg => {
            $('#modalDetails').modal('show')
        })
    })

    /* function rePrint(saleId) {
        window.open("print://" + saleId, '_self').close()
    } */
</script>
