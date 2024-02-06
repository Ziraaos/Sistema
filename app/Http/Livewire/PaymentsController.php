<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\Location;
use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\PaymentMethod;
use App\Models\Service;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class PaymentsController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $componentName, $selected_id, $data, $details, $sumDetails, $countDetails, $reportType, $locationid, $locationId, $date, $month, $year, $customerId, $days_g, $date_serv, $paids, $customer, $total, $deudas = [], $payid, $lastPayment, $remainingChange, $otid, $ttotal, $namec, $image, $localidad, $method;

    public $clientId;
    public $debtData = [];
    public $amountPaid = 0;
    public $remainingDebt = 0;
    public $showModal = false;
    public $paymentDetails;
    public function mount()
    {
        $this->componentName = 'Pagos clientes servicios';
        $this->data = [];
        $this->details = [];
        $this->paymentDetails = [];
        $this->sumDetails = 0;
        $this->countDetails = 0;
        $this->reportType = 0;
        $this->days_g = 0;
        $this->customerId = 0;
        $this->paids = [];
        $this->deudas = [];
        $this->otid = 0;
        $this->ttotal = 0;
        $this->lastPayment = 0;
        /* $this->customer = ''; */
    }

    public function render()
    {
        $this->PaymentsByMonth();

        return view('livewire.payment.payments', [
            'locations' => Location::orderBy('name', 'asc')->get(),
            'services' => Service::orderBy('name', 'asc')->get(),
            'methods' => PaymentMethod::orderBy('name', 'asc')->get(),
            'debtData' => $this->debtData,
            'amountPaid' => $this->amountPaid,
            'remainingDebt' => $this->remainingDebt,
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

        if ($this->locationid == 0) {
            $this->data = Customer::select(
                'customers.id',
                'customers.first_name',
                'customers.last_name',
                'locations.name as name',
                'payments.date_serv',
                'latest_payment.status as status'
            )
                ->addSelect(DB::raw('SUM(payments.total) as total'))
                ->leftJoin('payments', 'customers.id', '=', 'payments.customer_id')
                ->leftJoin('locations', 'customers.location_id', '=', 'locations.id')
                ->leftJoin(DB::raw('(SELECT customer_id, MAX(status) as status FROM payments GROUP BY customer_id) as latest_payment'), 'customers.id', '=', 'latest_payment.customer_id')
                ->groupBy('customers.id', 'customers.first_name', 'customers.last_name', 'payments.date_serv', 'latest_payment.status')
                ->whereMonth('payments.date_serv', '=', $month)
                ->whereYear('payments.date_serv', '=', $year)
                ->get();
        }
        /* elseif ($this->locationid == 0 && $this->reportType == 1) {
            # code...
        } */ else {
            $this->data = Customer::select(
                'customers.id',
                'customers.first_name',
                'customers.last_name',
                'locations.name as name',
                'payments.date_serv'
            )
                ->addSelect(DB::raw('SUM(payments.total) as total'))
                ->addSelect(DB::raw('MAX(payments.status) as status'))
                ->leftJoin('payments', 'customers.id', '=', 'payments.customer_id')
                ->leftJoin('locations', 'customers.location_id', '=', 'locations.id')
                ->groupBy('customers.id', 'customers.first_name', 'customers.last_name', 'payments.date_serv')
                ->where('customers.location_id', $this->locationid)
                ->whereMonth('payments.date_serv', '=', $month)
                ->whereYear('payments.date_serv', '=', $year)
                ->get();
        }
        /* dd($month, $year); */
    }


    public function getDetails($customerId)
    {
        $customer = Customer::find($customerId);
        $this->details = Customer::join('locations', 'customers.location_id', '=', 'locations.id')
            ->join('payments', 'customers.id', '=', 'payments.customer_id')
            ->where('customers.id', $customerId)
            ->select(
                'locations.name as location_name',
                'payments.date_serv',
                'payments.total',
                'payments.debt',
                'payments.status'
            )
            ->get();

        $this->paymentDetails = PaymentDetail::with('paymentMethod')
            ->where('customer_id', $customerId)
            ->get();

        $this->namec = $customer->first_name . ' ' . $customer->last_name;
        $this->localidad = $customer->location->name;
        $suma = $this->details->sum(function ($item) {
            return $item->total;
        });

        $this->sumDetails = $suma;
        /* $this->customerId = $customerId; */

        $this->emit('show-modal-detail', 'details loaded');
    }

    public function Paid($clientId)
    {
        $this->clientId = $clientId;

        // Consulta los datos de montos pendientes por mes para el cliente $this->clientId
        $payments = Payment::join('customers as c', 'c.id', 'payments.customer_id')
            ->select('payments.date_serv', 'payments.total', 'payments.id', 'payments.change', 'c.first_name', 'c.last_name')
            ->where('customer_id', $this->clientId)
            ->get();
        $this->debtData = [];

        foreach ($payments as $payment) {
            if ($payment->total != 0 || $payment->change != 0) {
                $this->debtData[] = [
                    'mes' => $payment->date_serv,
                    'monto' => $payment->total,
                ];
                $this->payid = $payment->id;
                if ($payment->change > 0 && $payment->id != $this->otid) {
                    $this->lastPayment = $payment->change;
                    $this->otid = $payment->id;
                }
            }
            $this->namec = $payment->first_name . ' ' . $payment->last_name;
        }
        $this->amountPaid = $this->lastPayment;

        $this->calculateRemainingDebt();

        $this->emit('show-modal-paid', 'paids loaded');
    }

    public function calculateRemainingDebt()
    {
        $totalDebt = array_sum(array_column($this->debtData, 'monto')); // Calcula el total de la deuda

        $this->ttotal = $totalDebt;

        // Comprueba si el monto pagado es mayor o igual que la deuda total
        if ($this->amountPaid >= $totalDebt) {
            $this->remainingDebt = 0; // La deuda se ha pagado por completo
        } else {
            $this->remainingDebt = $totalDebt - $this->amountPaid; // Calcula el restante de la deuda
            /* dd($this->remainingDebt); */
        }
    }

    public function makePayment()
    {
        // Primero, asegúrate de que $this->amountPaid sea mayor que cero y que haya datos en $this->debtData

        if ($this->amountPaid > 0 && !empty($this->debtData)) {
            // Crea un nuevo registro en la tabla payment_detail
            $totalPayment = $this->amountPaid;
            $paymentDetail = new PaymentDetail();
            $paymentDetail->price = $totalPayment;
            $paymentDetail->date_pay = now();
            $paymentDetail->customer_id = $this->clientId;
            $paymentDetail->payment_method_id = $this->method;
            $paymentDetail->user_id = Auth()->user()->id;
            if ($this->image) {
                $customFileName = uniqid() . '_.' . $this->image->extension();
                $this->image->storeAs('public/payments', $customFileName);
                $paymentDetail->image = $customFileName;

            }
            $paymentDetail->save();
            // Actualiza el campo `cash` y el estado `status` en la tabla `payments`
            if ($this->lastPayment > 0) {
                /* dd($totalPayment, $this->ttotal, $this->otid); */
                Payment::where('id', $this->otid)
                    ->update(['change' => 0]);
            }
            // Realiza modificaciones en la tabla `payments`
            foreach ($this->debtData as $debt) {
                if ($totalPayment <= $debt['monto']) {
                    $debtPayment = $totalPayment;
                    $totalPayment = 0;
                } else {
                    $debtPayment = $debt['monto'];
                    $totalPayment -= $debtPayment;
                }


                Payment::where('customer_id', $this->clientId)
                    ->whereRaw('YEAR(date_serv) = YEAR(?) AND MONTH(date_serv) = MONTH(?)', [$debt['mes'], $debt['mes']])
                    ->update([
                        'total' => \DB::raw('total - ' . $debtPayment),
                    ]);

                // Si el monto pagado cubre la deuda, actualiza el estado a 'PAID'
                if ($debtPayment >= $debt['monto']) {
                    Payment::where('customer_id', $this->clientId)
                        ->whereRaw('YEAR(date_serv) = YEAR(?) AND MONTH(date_serv) = MONTH(?)', [$debt['mes'], $debt['mes']])
                        ->update(['status' => 'PAID']);
                }
            }
            Payment::where('customer_id', $this->clientId)
                ->whereRaw('YEAR(date_serv) = YEAR(?) AND MONTH(date_serv) = MONTH(?)', [$debt['mes'], $debt['mes']])
                ->update([
                    'change' => $totalPayment,
                ]);
        } else {
            $this->emit('hide-modal-paid', 'No se puede realizar el pago');
            return;
        }


        $this->resetUI(); // Limpiar las cajas de texto del formulario
        $this->emit('hide-modal-paid', 'Pago guardado');
    }

    public function Store()
    {
        $rules = [
            'locationId' => 'required|not_in:Elegir',
            'days_g' => 'required',
            'date_serv' => 'required',
        ];
        $messages = [
            'locationId.required' => 'La ubicación es requerido',
            'locationId.not_in' => 'Elige una ubicación diferente de Elegir',
            'days_g.required' => 'Dias de descuento es requerido',
            'date_serv.required' => 'El mes a generar es requerido',
        ];
        $this->validate($rules, $messages);
        $count = 0;

        $month = Carbon::parse($this->date_serv)->format('m');
        $year = Carbon::parse($this->date_serv)->format('Y');

        $customers = Customer::all();
        if ($customers) {
            foreach ($customers as $customer) {
                $existingPayment = DB::table('payments')
                    ->where('customer_id', $customer->id)
                    ->whereYear('date_serv', $year)
                    ->whereMonth('date_serv', $month)
                    ->first();

                $payments = Customer::join('services as s', 's.id', 'customers.service_id')
                    ->select('customers.*', 's.*')
                    ->where('s.id', $customer->service_id)
                    ->first();

                if ($existingPayment) {
                    $this->emit('payment-not-added', 'El pago del cliente' . $customer->first_name . ' ya se encontraba registrado');
                } else {
                    $location = Location::find($this->locationId);
                    if ($location->id == $customer->location_id) {   //verificamos la ubicacion del servicio
                        if ($customer->disc == 'YES') {               //verificamos si tiene descuento habilitado
                            $desc = (30 - $this->days_g);
                            $total = ($payments->price / 30) * $desc;

                            Payment::create([
                                'total' => ceil($total),
                                'debt' => ceil($total),
                                'changue' => 0,
                                'date_serv' => Carbon::parse($this->date_serv)->format('Y-m-d'),
                                'user_id' => Auth()->user()->id,
                                'customer_id' => $customer->id
                            ]);
                            $count = $count + 1;
                        } else {
                            Payment::create([
                                'total' => $payments->price,
                                'debt' => $payments->price,
                                'changue' => 0,
                                'date_serv' => Carbon::parse($this->date_serv)->format('Y-m-d'),
                                'user_id' => Auth()->user()->id,
                                'customer_id' => $customer->id
                            ]);
                            $count = $count + 1;
                        }
                    } else {
                        $this->emit('payment-not_location', 'No existe clientes en la ubicación seleccionada');
                    }
                }
            }
        }
        $this->resetUI(); // Limpiar las cajas de texto del formulario
        $this->emit('payment-added', 'Se añadieron ' . $count . ' pagos pendientes');
    }

    public function resetUI()
    {
        $this->days_g = 0;
        $this->method = 'Elegir';
        $this->date_serv = '';
        $this->locationId = '';
        $this->selected_id = 0;
        $this->id = null;
        $this->image = null;
        $this->date_serv = null;
        $this->total = null;
        $this->deudas = [];
    }
}
