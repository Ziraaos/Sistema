<div>
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="card">
                <div class="card-header">Clientes
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush table-borderless">
                        <thead>
                            <tr>
                                <th>Lugar</th>
                                <th style="text-align: center">Cantidad clientes</th>
                                <th style="text-align: center">Clientes activos</th>
                                <th style="text-align: center">Clientes inactivos</th>
                                <th style="text-align: center">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $info)
                                <tr>
                                    <td>{{ $info->location_name }}</td>
                                    <td style="text-align: center">{{ $info->total_customers }}</td>
                                    <td style="text-align: center">{{ $info->active_count }}</td>
                                    <td style="text-align: center">{{ $info->inactive_count }}</td>
                                    <td style="text-align: center">
                                        <div class="progress shadow" style="height: 3px;">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $info->active_percentage }}%"></div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div><!--End Row-->
    <div class="row">
        <div class="col-sm-12 card">
            <div class="widget-chart-one">
                <h4 class="p-3 text-center text-theme-1 font-bold"> PAGOS AÑO: {{ $year }}</h4>
                <div id="chartPaymentMonth">
                </div>
            </div>
        </div>
    </div>

    <div class="row pt-6">
        <div class="col-lg-6 card">
            <div class="whidget widget-chart one">
                <h4 class="p-3 text-center text-theme-1 font-bold">TOP 5 MAS VENDIDOS</h4>
                <div id="chartTop5">
                </div>
            </div>
        </div>
        <div class="col-lg-6 card">
            <div class="">
                <h4 class="p-3 text-center text-theme-1 font-bold">VENTAS DE LA SEMANA</h4>
                <div id="areaChart">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 card">
            <div class="widget-chart-one">
                <h4 class="p-3 text-center text-theme-1 font-bold"> VENTAS AÑO: {{ $year }}</h4>
                <div id="chartMonth">
                </div>
            </div>
        </div>
    </div>
    @include('livewire.dashboard.script')
</div>
