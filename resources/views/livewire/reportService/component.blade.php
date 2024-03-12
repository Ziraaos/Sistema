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
                            <a class="btn btn-dark btn-block {{ count($data) < 1 ? 'disabled' : '' }}"
                                href="{{ url('reportService/pdf' . '/' . $locationid) }}"
                                target="_blank">Generar PDF</a>

                            <a class="btn btn-dark btn-block {{ count($data) < 1 ? 'disabled' : '' }}"
                                href="{{ url('reportService/excel' . '/' . $locationid) }}"
                                target="_blank">Exportar a Excel</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-9">
                    <!--TABLA-->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">Nombre del lugar</th>
                                    <th class="text-center">Cantidad de clientes</th>
                                    <th class="text-center">Plan</th>
                                    <th class="text-center">Nombre del servicio</th>
                                    <th class="text-center">Precio</th>
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
                                            <h6>{{ $d->location_name }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6>{{ $d->services_count }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6>{{ $d->plan_name }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6>{{ $d->service_name }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6>Bs.{{ number_format($d->price, 2) }}</h6>
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
    {{-- @include('livewire.reports.sales-detail') --}}
</div>

