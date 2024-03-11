<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\Location;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ReportServiceController extends Component
{
    public $componentName, $data, $details, $sumDetails, $countDetails, $reportType, $userId, $dateFrom, $dateTo, $months, $locationid;

    public function mount()
    {
        $this->componentName = 'Reportes pago servicios';
        $this->data = [];
        $this->details = [];
        $this->sumDetails = 0;
        $this->countDetails = 0;
        $this->reportType = 0;
        $this->locationid = 0;
        $this->userId = 0;
        $this->months = 0;
    }

    public function render()
    {

        $this->PaymentsByLocation($this->months);

        return view('livewire.reportService.component', [
            'locations' => Location::orderBy('name', 'asc')->get()
        ])->extends('layouts.theme.app')
            ->section('content');
    }

    public function PaymentsByLocation()
    {
        if ($this->reportType == 0) //
        {
            if ($this->locationid == 0) {
                $this->data = DB::table('payments')
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

                $this->data = DB::table('payments')
                    ->join('customers', 'payments.customer_id', '=', 'customers.id')
                    ->select(
                        'customers.location_id',
                        'payments.customer_id',
                        'customers.first_name',
                        'customers.last_name',
                        DB::raw('SUM(total) as deuda_total'),
                        DB::raw('COUNT(DISTINCT CASE WHEN payments.status = "PENDING" THEN MONTH(date_serv) END) as meses_deuda')
                    )
                    ->when($this->locationid, function ($query, $locationid) {
                        return $query->where('customers.location_id', $locationid);
                    })
                    ->groupBy('customers.location_id', 'payments.customer_id', 'customers.first_name', 'customers.last_name')
                    ->havingRaw('meses_deuda >= ?', [0])
                    ->get();
            }
        } elseif ($this->reportType == 4) {
            if ($this->locationid == 0) {
                $this->data = DB::table('payments')
                    ->join('customers', 'payments.customer_id', '=', 'customers.id')
                    ->select(
                        'payments.customer_id',
                        'customers.first_name',
                        'customers.last_name',
                        DB::raw('SUM(total) as deuda_total'),
                        DB::raw('COUNT(DISTINCT CASE WHEN payments.status = "PENDING" THEN MONTH(date_serv) END) as meses_deuda'))
                    /* ->where('payments.status', 'PENDING') */ // Ajusta según tu necesidad
                    ->groupBy('payments.customer_id', 'customers.first_name', 'customers.last_name')
                    ->havingRaw('meses_deuda >= ?', [$this->reportType - 1])
                    ->get();
            } else {

                $this->data = DB::table('payments')
                    ->join('customers', 'payments.customer_id', '=', 'customers.id')
                    ->select(
                        'customers.location_id',
                        'payments.customer_id',
                        'customers.first_name',
                        'customers.last_name',
                        DB::raw('SUM(total) as deuda_total'),
                        DB::raw('COUNT(DISTINCT CASE WHEN payments.status = "PENDING" THEN MONTH(date_serv) END) as meses_deuda')
                    )
                    ->when($this->locationid, function ($query, $locationid) {
                        return $query->where('customers.location_id', $locationid);
                    })
                    ->groupBy('customers.location_id', 'payments.customer_id', 'customers.first_name', 'customers.last_name')
                    ->havingRaw('meses_deuda >= ?', [$this->reportType - 1])
                    ->get();
            }
        } else {
            if ($this->locationid == 0) {
                $this->data = DB::table('payments')
                    ->join('customers', 'payments.customer_id', '=', 'customers.id')
                    ->select(
                        'payments.customer_id',
                        'customers.first_name',
                        'customers.last_name',
                        DB::raw('SUM(total) as deuda_total'),
                        DB::raw('COUNT(DISTINCT CASE WHEN payments.status = "PENDING" THEN MONTH(date_serv) END) as meses_deuda'))
                    /* ->where('payments.status', 'PENDING') */ // Ajusta según tu necesidad
                    ->groupBy('payments.customer_id', 'customers.first_name', 'customers.last_name')
                    ->havingRaw('meses_deuda = ?', [$this->reportType - 1])
                    ->get();
            } else {

                $this->data = DB::table('payments')
                    ->join('customers', 'payments.customer_id', '=', 'customers.id')
                    ->select(
                        'customers.location_id',
                        'payments.customer_id',
                        'customers.first_name',
                        'customers.last_name',
                        DB::raw('SUM(total) as deuda_total'),
                        DB::raw('COUNT(DISTINCT CASE WHEN payments.status = "PENDING" THEN MONTH(date_serv) END) as meses_deuda')
                    )
                    ->when($this->locationid, function ($query, $locationid) {
                        return $query->where('customers.location_id', $locationid);
                    })
                    ->groupBy('customers.location_id', 'payments.customer_id', 'customers.first_name', 'customers.last_name')
                    ->havingRaw('meses_deuda = ?', [$this->reportType - 1])
                    ->get();
            }
        }

        if ($this->reportType == 1 && ($this->dateFrom == '' || $this->dateTo == '')) {
            return;
        }


        /* if ($this->locationid == 0) {
            $this->data = DB::table('payments')
                ->join('customers', 'payments.customer_id', '=', 'customers.id')
                ->select(
                    'payments.customer_id',
                    'customers.first_name',
                    'customers.last_name',
                    DB::raw('SUM(total) as deuda_total'),
                    DB::raw('COUNT(DISTINCT CASE WHEN payments.status = "PENDING" THEN MONTH(date_serv) END) as meses_deuda'))
                ->groupBy('payments.customer_id', 'customers.first_name', 'customers.last_name')
                ->havingRaw('meses_deuda >= ?', [$this->months])
                ->get();
        }
        else {

            $this->data = DB::table('payments')
                ->join('customers', 'payments.customer_id', '=', 'customers.id')
                ->select(
                    'customers.location_id',
                    'payments.customer_id',
                    'customers.first_name',
                    'customers.last_name',
                    DB::raw('SUM(total) as deuda_total'),
                    DB::raw('COUNT(DISTINCT CASE WHEN payments.status = "PENDING" THEN MONTH(date_serv) END) as meses_deuda')
                )
                ->when($this->locationid, function ($query, $locationid) {
                    return $query->where('customers.location_id', $locationid);
                })
                ->groupBy('customers.location_id', 'payments.customer_id', 'customers.first_name', 'customers.last_name')
                ->havingRaw('meses_deuda >= ?', [$this->months])
                ->get();
        } */
        /* dump($this->data); */
    }


    /* public function getDetails($saleId)
    {
        $this->details = SaleDetail::join('products as p', 'p.id', 'sale_details.product_id')
            ->select('sale_details.id', 'sale_details.price', 'sale_details.quantity', 'p.name as product')
            ->where('sale_details.sale_id', $saleId)
            ->get();


        //
        $suma = $this->details->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $this->sumDetails = $suma;
        $this->countDetails = $this->details->sum('quantity');
        $this->saleId = $saleId;

        $this->emit('show-modal', 'details loaded');
    } */
}
