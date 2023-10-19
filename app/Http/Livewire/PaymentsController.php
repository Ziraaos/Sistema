<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\Location;
use App\Models\Payment;
use App\Models\PaymentDetail;
use Illuminate\Support\Carbon;
use Livewire\Component;

class PaymentsController extends Component
{
    public $componentName,$selected_id, $data, $details, $sumDetails, $countDetails, $reportType, $customerId, $locationId, $dateFrom, $dateTo, $date, $month, $year, $paymentId, $days_g, $date_serv, $userId;

    public function mount()
    {
        $this->componentName = 'Pagos clientes servicios';
        $this->data = [];
        $this->details = [];
        $this->sumDetails = 0;
        $this->countDetails = 0;
        $this->reportType = 0;
        $this->customerId = 0;
        $this->locationId = 0;
        $this->paymentId = 0;
    }

    public function render()
    {

        $this->PaymentsByMonth();

        return view('livewire.payment.payments', [
            'locations' => Location::orderBy('name', 'asc')->get(),
            /* 'customers' => Customer::orderBy('first_name', 'asc')->get() */
        ])->extends('layouts.theme.app')
            ->section('content');
    }

    public function PaymentsByMonth()
    {
        if ($this->reportType == 0) // pagos del mes
        {
            $month = Carbon::parse(Carbon::now())->format('m');
            $year = Carbon::parse(Carbon::now())->format('Y');
        } else {
            $month = Carbon::parse($this->date)->format('m');
            $year = Carbon::parse($this->date)->format('Y');
        }

        if ($this->reportType == 1 && ($this->date == '')) {
            return;
        }

        if ($this->locationId == 0) {
            $this->data = Payment::join('customers as c', 'c.id', 'payments.customer_id')
                ->join('locations as l', 'l.id', '=', 'c.location_id')
                ->select('payments.*', 'c.first_name', 'c.last_name', 'c.location_id', 'l.name as name')
                ->whereMonth('payments.date_serv', '=', $month)
                ->whereYear('payments.date_serv', '=', $year)
                ->get();
        } else {
            $this->data = Payment::join('customers as c', 'c.id', 'payments.customer_id')
                ->join('locations as l', 'l.id', '=', 'c.location_id')
                ->select('payments.*', 'c.first_name', 'c.last_name', 'c.location_id', 'l.name')
                ->whereMonth('payments.date_serv', '=', $month)
                ->whereYear('payments.date_serv', '=', $year)
                ->where('customer_id', $this->locationId)
                ->get();
        }
        /* dd($month, $year); */
    }


    public function getDetails($paymentId)
    {
        $this->details = PaymentDetail::join('services as s', 's.id', 'payment_details.services_id')
            ->select('payment_details.id', 'payment_details.price', 'payment_details.quantity', 'payment_details.date_pay', 's.name as service')
            ->where('payment_details.sale_id', $paymentId)
            ->get();


        //
        $suma = $this->details->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $this->sumDetails = $suma;
        $this->countDetails = $this->details->sum('quantity');
        $this->paymentId = $paymentId;

        $this->emit('show-modal', 'details loaded');
    }

    public function Store()
   {
        $rules = [
            'locationId' => 'required|not_in:Elegir',
            'days_g' => 'required',
            'date_serv' => 'required',
        ];
        $messages = [
            'locationId.not_in' => 'Elige un nombre de categoría diferente de Elegir',
            'days_g.required' => 'Dias de descuento es requerido',
            'date_serv.required' => 'El mes a generar es requerido es requerido',
        ];
        $this->validate($rules, $messages);

        $payds = Customer::all();
        foreach ($payds as $payd) {
            if($payd->disc = 'YES'){
                dd($payd->userId, $payd->date_serv, 'DESCUENTO');
            }
            else {
                dd('NO');
            }
            /* Payment::create([
                'total' => $payd->total,
                'date_serv' => $payd->date_serv,
                'user_id' => $payd->userId,
                'customer_id' => $payds->id
            ]); */
            //update stock
            /* $product = Product::find($item->id);
            $product->stock = $product->stock - $item->quantity;
            $product->save(); */
        }

        /* if ($this->role != 'Elegir') {
            foreach ($permisos as $permiso) {
                $role = Role::find($this->role);
                $tienePermiso = $role->hasPermissionTo($permiso->name);
                if ($tienePermiso) {
                    $permiso->checked = 1;
                }
            }
        } */

        /* $payment = Payment::create([
            'total' => $this->cleanValue($this->total),
            'date_serv' => $this->date_serv,
            'user_id' => $this->userId,
            'customer_id' => $this->customerId,
        ]);
        $payment->save(); */

        $this->resetUI(); // Limpiar las cajas de texto del formulario
        $this->emit('product-added','Producto Registrado');
   }

   public function resetUI(){
    $this->days_g = '';
    $this->date_serv = '';
    $this->locationId = '';
    $this->selected_id = 0;
}
}
