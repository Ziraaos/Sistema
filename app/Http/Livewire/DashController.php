<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\Location;
use App\Models\Sale;
use App\Models\SaleDetail;
use Carbon\Carbon;
use DateTime;
use Livewire\Component;
use DB;

class DashController extends Component
{
    public $paymentsByMonth_Data = [], $salesByMonth_Data = [], $top5Data = [], $weekSales_Data = [], $year, $customersWithoutDebt = [], $customerDetails = [], $usuariosConMora = [];

    public function mount()
    {
        $this->year = date('Y');
        /* $this->year = 2023; */
    }

    public function render()
    {
        $this->getWeekSales();
        $this->getTop5();
        $this->getSalesMonth();
        $this->getPromptPayers();
        $this->getCustomers();
        $this->getPaymentsMonth();
        $this->getMoras();
        $this->checkPendingPaymentsReminder();
        return view('livewire.dashboard.component', [
            'data' => $this->customerDetails,
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function getTop5()
    {
        $this->top5Data = SaleDetail::join('products as p', 'sale_details.product_id', 'p.id')
            ->select(
                DB::raw("p.name as product, sum(sale_details.quantity * sale_details.price)as total")
            )->whereYear("sale_details.created_at", $this->year)
            ->groupBy('p.name')
            ->orderBy(DB::raw("sum(sale_details.quantity * sale_details.price)"), 'desc')
            ->get()->take(5)->toArray();

        $contDif = (5 - count($this->top5Data));
        if ($contDif > 0) {
            for ($i = 1; $i <= $contDif; $i++) {
                array_push($this->top5Data, ["product" => '-', "total" => 0]);
            }
        }
    }

    public function getWeekSales()
    {
        $dt = new DateTime(); // 2023-12-16 12:26:40.830580
        $startDate = null;
        $finishDate = null;

        for ($d = 1; $d <= 7; $d++) {

            // norma ISO 8601 year/mes/dia  =>  (año, semana, dia de la semana)

            $dt->setISODate($dt->format('o'), $dt->format('W'), $d);

            $startDate = $dt->format('Y-m-d') . ' 00:00:00';
            $finishDate = $dt->format('Y-m-d') . ' 23:59:59';
            $wsale = Sale::whereBetween('created_at', [$startDate, $finishDate])->sum('total');

            array_push($this->weekSales_Data, $wsale);
        }
    }

    public function getSalesMonth()
    {
        /* $this->sales = []; */
        $salesByMonth = DB::select(
            DB::raw("SELECT coalesce(total,0) as total
            FROM (
                SELECT 'january' AS month
                UNION SELECT 'february' AS month
                UNION SELECT 'march' AS month
                UNION SELECT 'april' AS month
                UNION SELECT 'may' AS month
                UNION SELECT 'june' AS month
                UNION SELECT 'july' AS month
                UNION SELECT 'august' AS month
                UNION SELECT 'september' AS month
                UNION SELECT 'october' AS month
                UNION SELECT 'november' AS month
                UNION SELECT 'december' AS month
            ) m
            LEFT JOIN (
                SELECT MONTHNAME(created_at) AS MONTH, COUNT(*) AS orders, SUM(total) AS total
                FROM sales
                WHERE YEAR(created_at) = $this->year
                GROUP BY MONTHNAME(created_at), MONTH(created_at)
                ORDER BY MONTH(created_at)
            ) c ON m.MONTH = c.MONTH;")
        );

        foreach ($salesByMonth as $sale) {
            array_push($this->salesByMonth_Data, $sale->total);
        }
    }

    public function getPromptPayers()
    {

        $this->customersWithoutDebt = Customer::leftJoin('payments', function ($join) {
            $join->on('customers.id', '=', 'payments.customer_id')
                ->where('payments.total', '>', 0);
        })
            ->whereNull('payments.customer_id')
            ->select('customers.*')
            ->get();
    }

    public function getMoras()
    {
        //contador de meses y datos de la deuda
        $this->usuariosConMora = DB::table('payments')
            ->join('customers', 'payments.customer_id', '=', 'customers.id')
            ->select('payments.customer_id', 'customers.first_name', 'customers.last_name', DB::raw('SUM(total) as deuda_total'), DB::raw('COUNT(DISTINCT MONTH(date_serv)) as meses_deuda'))
            ->where('payments.status', 'PENDING') // Ajusta según tu necesidad
            ->groupBy('payments.customer_id', 'customers.first_name', 'customers.last_name')
            ->havingRaw('meses_deuda >= ?', [2])
            ->get();

        /* dump($this->usuariosConMora); */
    }

    public function getCustomers()
    {
        $this->customerDetails = DB::table('customers')
            ->join('locations', 'customers.location_id', '=', 'locations.id')
            ->select(
                'locations.name as location_name',
                DB::raw('COUNT(customers.id) as total_customers'),
                DB::raw('SUM(customers.status = "Active") as active_count'),
                DB::raw('SUM(customers.status = "Inactive") as inactive_count'),
                DB::raw('ROUND(SUM(customers.status = "Active") / COUNT(customers.id) * 100, 2) as active_percentage')
            )
            ->groupBy('locations.name')
            ->get();

        /* dd($this->customerDetails); */
    }

    public function getPaymentsMonth()
    {
        /* $this->sales = []; */
        $paymentsByMonth = DB::select(
            DB::raw("SELECT coalesce(total,0) as total
            FROM (
                SELECT 'january' AS month
                UNION SELECT 'february' AS month
                UNION SELECT 'march' AS month
                UNION SELECT 'april' AS month
                UNION SELECT 'may' AS month
                UNION SELECT 'june' AS month
                UNION SELECT 'july' AS month
                UNION SELECT 'august' AS month
                UNION SELECT 'september' AS month
                UNION SELECT 'october' AS month
                UNION SELECT 'november' AS month
                UNION SELECT 'december' AS month
            ) m
            LEFT JOIN (
                SELECT MONTHNAME(created_at) AS MONTH, COUNT(*) AS orders, SUM(price) AS total
                FROM payment_details
                WHERE YEAR(created_at) = $this->year
                GROUP BY MONTHNAME(created_at), MONTH(created_at)
                ORDER BY MONTH(created_at)
            ) c ON m.MONTH = c.MONTH;")
        );

        foreach ($paymentsByMonth as $payment) {
            array_push($this->paymentsByMonth_Data, $payment->total);
        }
        /* dd($salesByMonth); */
    }

    public function checkPendingPaymentsReminder()
    {
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');

        $locations = Location::all();

        foreach ($locations as $location) {
            $existingPayments = DB::table('payments')
                ->join('customers', 'payments.customer_id', '=', 'customers.id')
                ->where('customers.location_id', $location->id)
                ->whereYear('payments.date_serv', $year)
                ->whereMonth('payments.date_serv', $month)
                ->count();

            if ($existingPayments > 0) {
                $message = '¡Recordatorio! Hay pagos pendientes para el mes actual en la ubicación ' . $location->name;
                // Puedes emitir un evento, enviar una notificación, o utilizar cualquier otro mecanismo para mostrar el mensaje en el dashboard.
                $this->emit('payment-reminder', $message);
            } else {
                $message = 'No hay registros de pagos para el mes actual en la ubicación ' . $location->name;
                // Puedes emitir un evento, enviar una notificación, o utilizar cualquier otro mecanismo para mostrar el mensaje en el dashboard.
                $this->emit('no-payment-reminder', $message);
            }
        }
        /* dump($message); */
    }
}
