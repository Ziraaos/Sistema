<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\Location;
use App\Models\Service;
use App\Models\PaymentDetail;
use App\Models\PaymentMethod;
use Livewire\Component;
use Livewire\WithPagination;

class ReportCustomerController extends Component
{
    use WithPagination;

    public $search, $selected_id, $paymentDetails, $namec, $localidad, $details, $sumDetails, $cid;
    private $pagination = 10;
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->paymentDetails = [];
        $this->details = [];
        $this->pageTitle = 'Listado';
        $this->componentName = 'Clientes';
        $this->locationid = 'Elegir';
        $this->serviceid = 'Elegir';
        $this->status = 'Active';
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            $data = Customer::join('locations as l', 'l.id', 'customers.location_id')
                ->join('services as s', 's.id', 'customers.service_id')
                ->select('customers.*', 'l.name as location', 's.name as service')
                ->where('customers.first_name', 'like', '%' . $this->search . '%')
                ->orWhere('customers.last_name', 'like', '%' . $this->search . '%')
                ->orWhere('customers.ci', 'like', '%' . $this->search . '%')
                ->orWhere('l.name', 'like', '%' . $this->search . '%')
                ->orderBy('customers.first_name', 'asc')
                ->paginate($this->pagination);
        } else {
            $data = Customer::join('locations as l', 'l.id', 'customers.location_id')
                ->join('services as s', 's.id', 'customers.service_id')
                ->select('customers.*', 'l.name as location', 's.name as service')
                ->orderBy('customers.first_name', 'asc')
                ->paginate($this->pagination);
        }

        return view('livewire.reportCustomer.report-customer', [
            'customers' => $data,
            'locations' => Location::orderBy('name', 'asc')->get(),
            'services' => Service::orderBy('name', 'asc')->get(),
            /* 'methods' => PaymentMethod::orderBy('name', 'asc')->get() */])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function getDetails($customerId)
    {
        $customer = Customer::find($customerId);
        $this->cid = $customerId;
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
        $sumap = $this->paymentDetails->sum(function ($price) {
            return $price->price;
        });

        $this->sumDetails = $suma;
        /* $this->customerId = $customerId; */
        /* dd($this->details,$this->paymentDetails,$this->sumDetails); */
        $this->emit('show-modal-detail', 'details loaded');
    }
}
