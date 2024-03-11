<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reporte de Servicios</title>

    <!-- cargar a través de la url del sistema -->

    {{-- <link rel="stylesheet" href="{{ asset('css/custom_pdf.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom_page.css') }}"> --}}

    <!-- ruta física relativa OS -->
    <link rel="stylesheet" href="{{ public_path('css/custom_pdf.css') }}">
    <link rel="stylesheet" href="{{ public_path('css/custom_page.css') }}">

</head>

<body>

    <section class="header" style="top: -287px;">
        <table cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td colspan="2" class="text-center">
                    <span style="font-size: 25px; font-weight: bold;">ONEMAX</span>
                </td>
            </tr>
            <tr>
                <td width="30%" style="vertical-align: top; padding-top: 10px; position: relative">
                    <img src="{{ asset('assets/images/O.png') }}" alt="" class="invoice-logo">
                </td>

                <td width="70%" class="text-left text-company" style="vertical-align: top; padding-top: 10px">
                    @if ($reportType == 0)
                        <span style="font-size: 16px"><strong>Reporte de todos los clientes</strong></span>
                    @elseif ($reportType == 1)
                        <span style="font-size: 16px"><strong>Reporte de clientes sin deudas</strong></span>
                    @elseif ($reportType == 2)
                        <span style="font-size: 16px"><strong>Reporte de clientes con 1 mes de deuda</strong></span>
                    @elseif ($reportType == 3)
                        <span style="font-size: 16px"><strong>Reporte de clientes con 2 meses de deuda</strong></span>
                    @elseif ($reportType == 4)
                        <span style="font-size: 16px"><strong>Reporte de clientes con 3 o más meses de deuda</strong></span>
                    @endif
                    <br>
                    @if ($locationid != 0)
                        <span style="font-size: 16px"><strong>Lugar de servicio: {{ $nombre ?? ' ' }}</strong></span>
                    @else
                        <span style="font-size: 16px"><strong>Lugar de servicio: TODOS</strong></span>
                    @endif
                    <br>
                </td>
            </tr>
        </table>
    </section>


    <section style="margin-top: -110px">
        <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
            <thead>
                <tr>
                    <th width="10%">FOLIO</th>
                    <th width="25%">NOMBRES</th>
                    <th width="25%">APELLIDOS</th>
                    <th width="12%">MESES DE DEUDA</th>
                    <th width="28%">TOTAL DEUDA</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td align="center">{{ $item->customer_id }}</td>
                        <td align="center">{{ $item->first_name }}</td>
                        <td align="center">{{ $item->last_name }}</td>
                        <td align="center">{{ $item->meses_deuda }}</td>
                        <td align="center">Bs. {{ number_format($item->deuda_total, 2) }}</td>
                        {{-- <td align="center">{{ $item->user }}</td> --}}
                        {{-- <td align="center">
                            {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y H:m A') }}</td> --}}
                        {{-- <td align="center">{{ \Carbon\Carbon::parse($item->created_at)->isoFormat('dddd D [de] MMMM [de] YYYY') }}</td> --}}
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-center">
                        <span><b>TOTALES</b></span>
                    </td>
                    <td class="text-center">
                        {{ $data->sum('meses_deuda') }}
                    </td>
                    <td class="text-center">
                        <span><strong>Bs. {{ number_format($data->sum('deuda_total'), 2) }}</strong></span>
                    </td>
                </tr>
            </tfoot>
        </table>
    </section>


    <section class="footer">

        <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
            <tr>
                <td width="20%">
                    <span>Sistema ONEMAX v1</span>
                </td>
                <td width="60%" class="text-center">
                    by Franz Ramos
                </td>
                <td class="text-center" width="20%">
                    página <span class="pagenum"></span>
                </td>

            </tr>
        </table>
    </section>

</body>

</html>
