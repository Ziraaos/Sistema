<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait AlertTrait
{
    public $twoName = [], $threeName = [];
    public function Moras()
    {
        $this->two = DB::table('payments')
            ->join('customers', 'payments.customer_id', '=', 'customers.id')
            ->select(
                'payments.customer_id',
                'customers.first_name',
                'customers.last_name',
                DB::raw('SUM(total) as deuda_total'),
                DB::raw('COUNT(DISTINCT CASE WHEN payments.status = "PENDING" THEN MONTH(date_serv) END) as meses_deuda')
            )
            /* ->where('payments.status', 'PENDING') */ // Ajusta según tu necesidad
            ->groupBy('payments.customer_id', 'customers.first_name', 'customers.last_name')
            ->havingRaw('meses_deuda = ?', [2])
            ->get();

        foreach ($this->two as $mo) {
            array_push($this->twoName, ' '.$mo->first_name.' '.$mo->last_name,);
        }

        $this->three = DB::table('payments')
            ->join('customers', 'payments.customer_id', '=', 'customers.id')
            ->select(
                'payments.customer_id',
                'customers.first_name',
                'customers.last_name',
                DB::raw('SUM(total) as deuda_total'),
                DB::raw('COUNT(DISTINCT CASE WHEN payments.status = "PENDING" THEN MONTH(date_serv) END) as meses_deuda')
            )
            /* ->where('payments.status', 'PENDING') */ // Ajusta según tu necesidad
            ->groupBy('payments.customer_id', 'customers.first_name', 'customers.last_name')
            ->havingRaw('meses_deuda >= ?', [3])
            ->get();

        foreach ($this->three as $mor) {
            array_push($this->threeName, ' '.$mor->first_name.' '.$mor->last_name,);
        }
        $this->emit('Alert');
    }
}
