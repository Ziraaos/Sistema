<?php

namespace App\Http\Controllers;

use App\Exports\SalesExport;
use App\Models\Location;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use App\Models\Customer;
use App\Models\PaymentDetail;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class ExportController extends Controller
{
    public function reportPDF($userId, $reportType, $dateFrom = null, $dateTo = null)
    {
        $data = [];
        Carbon::setLocale('es');

        if ($reportType == 0) // ventas del dia
        {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d')   . ' 23:59:59';
        } else {
            $from = Carbon::parse($dateFrom)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($dateTo)->format('Y-m-d')     . ' 23:59:59';
        }


        if ($userId == 0) {
            $data = Sale::join('users as u', 'u.id', 'sales.user_id')
                ->select('sales.*', 'u.name as user')
                ->whereBetween('sales.created_at', [$from, $to])
                ->get();
        } else {
            $data = Sale::join('users as u', 'u.id', 'sales.user_id')
                ->select('sales.*', 'u.name as user')
                ->whereBetween('sales.created_at', [$from, $to])
                ->where('user_id', $userId)
                ->get();
        }

        $user = $userId == 0 ? 'Todos' : User::find($userId)->name;
        $pdf = PDF::loadView('pdf.reporte', compact('data', 'reportType', 'user', 'dateFrom', 'dateTo'));

        /*
        $pdf = new DOMPDF();
        $pdf->setBasePath(realpath(APPLICATION_PATH . '/css/'));
        $pdf->loadHtml($html);
        $pdf->render();
        */
        /*
        $pdf->set_protocol(WWW_ROOT);
        $pdf->set_base_path('/');
        */

        return $pdf->stream('salesReport.pdf'); // visualizar
        //$customReportName = 'salesReport_'.Carbon::now()->format('Y-m-d').'.pdf';
        //return $pdf->download($customReportName); //descargar

    }

    public function reportServicePDF($locationid, $reportType)
    {
        $data = [];
        Carbon::setLocale('es');

        $nombre = '';

        if ($reportType == 0) //
        {
            if ($locationid == 0) {
                $data = DB::table('payments')
                    ->join('customers', 'payments.customer_id', '=', 'customers.id')
                    ->select(
                        'payments.customer_id',
                        'customers.first_name',
                        'customers.last_name',
                        DB::raw('SUM(total) as deuda_total'),
                        DB::raw('COUNT(DISTINCT CASE WHEN payments.status = "PENDING" THEN MONTH(date_serv) END) as meses_deuda'))
                    /* ->where('payments.status', 'PENDING') */ // Ajusta según tu necesidad
                    ->groupBy('payments.customer_id', 'customers.first_name', 'customers.last_name')
                    ->havingRaw('meses_deuda >= ?', [0])
                    ->get();
            } else {

                $data = DB::table('payments')
                    ->join('customers', 'payments.customer_id', '=', 'customers.id')
                    ->select(
                        'customers.location_id',
                        'payments.customer_id',
                        'customers.first_name',
                        'customers.last_name',
                        DB::raw('SUM(total) as deuda_total'),
                        DB::raw('COUNT(DISTINCT CASE WHEN payments.status = "PENDING" THEN MONTH(date_serv) END) as meses_deuda')
                    )
                    ->when($locationid, function ($query, $locationid) {
                        return $query->where('customers.location_id', $locationid);
                    })
                    ->groupBy('customers.location_id', 'payments.customer_id', 'customers.first_name', 'customers.last_name')
                    ->havingRaw('meses_deuda >= ?', [0])
                    ->get();
            }
        } elseif ($reportType == 4) {
            $location = Location::find($locationid);
            $nombre = $location->name;
            if ($locationid == 0) {
                $data = DB::table('payments')
                    ->join('customers', 'payments.customer_id', '=', 'customers.id')
                    ->select(
                        'payments.customer_id',
                        'customers.first_name',
                        'customers.last_name',
                        DB::raw('SUM(total) as deuda_total'),
                        DB::raw('COUNT(DISTINCT CASE WHEN payments.status = "PENDING" THEN MONTH(date_serv) END) as meses_deuda'))
                    /* ->where('payments.status', 'PENDING') */ // Ajusta según tu necesidad
                    ->groupBy('payments.customer_id', 'customers.first_name', 'customers.last_name')
                    ->havingRaw('meses_deuda >= ?', [$reportType - 1])
                    ->get();
            } else {

                $data = DB::table('payments')
                    ->join('customers', 'payments.customer_id', '=', 'customers.id')
                    ->select(
                        'customers.location_id',
                        'payments.customer_id',
                        'customers.first_name',
                        'customers.last_name',
                        DB::raw('SUM(total) as deuda_total'),
                        DB::raw('COUNT(DISTINCT CASE WHEN payments.status = "PENDING" THEN MONTH(date_serv) END) as meses_deuda')
                    )
                    ->when($locationid, function ($query, $locationid) {
                        return $query->where('customers.location_id', $locationid);
                    })
                    ->groupBy('customers.location_id', 'payments.customer_id', 'customers.first_name', 'customers.last_name')
                    ->havingRaw('meses_deuda >= ?', [$reportType - 1])
                    ->get();
            }
        } else {
            $location = Location::find($locationid);
            $nombre = $location->name;
            if ($locationid == 0) {
                $data = DB::table('payments')
                    ->join('customers', 'payments.customer_id', '=', 'customers.id')
                    ->select(
                        'payments.customer_id',
                        'customers.first_name',
                        'customers.last_name',
                        DB::raw('SUM(total) as deuda_total'),
                        DB::raw('COUNT(DISTINCT CASE WHEN payments.status = "PENDING" THEN MONTH(date_serv) END) as meses_deuda'))
                    /* ->where('payments.status', 'PENDING') */ // Ajusta según tu necesidad
                    ->groupBy('payments.customer_id', 'customers.first_name', 'customers.last_name')
                    ->havingRaw('meses_deuda = ?', [$reportType - 1])
                    ->get();
            } else {

                $data = DB::table('payments')
                    ->join('customers', 'payments.customer_id', '=', 'customers.id')
                    ->select(
                        'customers.location_id',
                        'payments.customer_id',
                        'customers.first_name',
                        'customers.last_name',
                        DB::raw('SUM(total) as deuda_total'),
                        DB::raw('COUNT(DISTINCT CASE WHEN payments.status = "PENDING" THEN MONTH(date_serv) END) as meses_deuda')
                    )
                    ->when($locationid, function ($query, $locationid) {
                        return $query->where('customers.location_id', $locationid);
                    })
                    ->groupBy('customers.location_id', 'payments.customer_id', 'customers.first_name', 'customers.last_name')
                    ->havingRaw('meses_deuda = ?', [$reportType - 1])
                    ->get();
            }
        }

        /* dd($data, $nombre); */
        $pdf = PDF::loadView('pdf.reporteService', compact('data', 'nombre', 'locationid', 'reportType'));

        /*
        $pdf = new DOMPDF();
        $pdf->setBasePath(realpath(APPLICATION_PATH . '/css/'));
        $pdf->loadHtml($html);
        $pdf->render();
        */
        /*
        $pdf->set_protocol(WWW_ROOT);
        $pdf->set_base_path('/');
        */

        return $pdf->stream('servicesReport.pdf'); // visualizar
        //$customReportName = 'salesReport_'.Carbon::now()->format('Y-m-d').'.pdf';
        //return $pdf->download($customReportName); //descargar

    }

    public function reportCustomerPDF($namec, $cid, $location)
    {
        $data = [];
        Carbon::setLocale('es');

        /* dd($namec, $cid, $location); */
        $customer = Customer::find($cid);
        $data = Customer::join('locations', 'customers.location_id', '=', 'locations.id')
            ->join('payments', 'customers.id', '=', 'payments.customer_id')
            ->where('customers.id', $cid)
            ->select(
                'locations.name as location_name',
                'payments.date_serv',
                'payments.total',
                'payments.debt',
                'payments.status'
            )
            ->get();

        $paymentDetails = PaymentDetail::with('paymentMethod')
            ->where('customer_id', $cid)
            ->get();

        $namec = $customer->first_name . ' ' . $customer->last_name;
        $localidad = $customer->location->name;
        $suma = $data->sum(function ($item) {
            return $item->total;
        });
        $sumap = $paymentDetails->sum(function ($price) {
            return $price->price;
        });

        /* dd($data, $namec, $location, $suma, $this->paymentDetails); */
        /* $user = $userId == 0 ? 'Todos' : User::find($userId)->name; */
        $pdf = PDF::loadView('pdf.reporteCustomer', compact('data', 'paymentDetails', 'customer', 'namec', 'location', 'suma', 'sumap'));

        /*
        $pdf = new DOMPDF();
        $pdf->setBasePath(realpath(APPLICATION_PATH . '/css/'));
        $pdf->loadHtml($html);
        $pdf->render();
        */
        /*
        $pdf->set_protocol(WWW_ROOT);
        $pdf->set_base_path('/');
        */

        return $pdf->stream('customerReport.pdf'); // visualizar
        //$customReportName = 'salesReport_'.Carbon::now()->format('Y-m-d').'.pdf';
        //return $pdf->download($customReportName); //descargar

    }

    public function reporteExcel($userId, $reportType, $dateFrom = null, $dateTo = null)
    {
        $reportName = 'Reporte de Ventas_' . uniqid() . '.xlsx';

        return Excel::download(new SalesExport($userId, $reportType, $dateFrom, $dateTo), $reportName);
    }
}
