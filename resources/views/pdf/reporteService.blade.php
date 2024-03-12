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
                    <span style="font-size: 16px"><strong>Lugar de servicio: TODOS</strong></span>
                    <br>
                </td>
            </tr>
        </table>
    </section>


    <section style="margin-top: -110px">
        <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
            <thead>
                <tr>
                    <th width="25%">NOMBRE DEL LUGAR</th>
                    <th width="25%">PLAN</th>
                    <th width="25%">NOMBRE DEL SERVICIO</th>
                    <th width="15%">PRECIO</th>
                    <th width="10%">CANTIDAD DE CLIENTES</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td align="center">{{ $item->location_name }}</td>
                        <td align="center">{{ $item->plan_name }}</td>
                        <td align="center">{{ $item->service_name }}</td>
                        <td align="center">Bs. {{ number_format($item->price, 2) }}</td>
                        <td align="center">{{ $item->services_count }}</td>
                        {{-- <td align="center">{{ $item->user }}</td> --}}
                        {{-- <td align="center">
                            {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y H:m A') }}</td> --}}
                        {{-- <td align="center">{{ \Carbon\Carbon::parse($item->created_at)->isoFormat('dddd D [de] MMMM [de] YYYY') }}</td> --}}
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right">
                        <span><b>TOTAL CLIENTES</b></span>
                    </td>
                    <td class="text-center">
                        <span><strong>{{ $data->sum('services_count') }}</strong></span>
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
