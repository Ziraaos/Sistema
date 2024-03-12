<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\Location;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ReportServiceController extends Component
{
    public $componentName, $data, $locationid;

    public function mount()
    {
        $this->componentName = 'Reportes pago servicios';
        $this->data = [];
        $this->locationid = 0;
    }

    public function render()
    {

        $this->ServicesByLocation();

        return view('livewire.reportService.component', [
            'locations' => Location::orderBy('name', 'asc')->get(),
            'services' => $this->data
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function ServicesByLocation()
    {
        if ($this->locationid == 0) {
            $this->data = DB::table('locations')
                ->leftJoin('customers', 'locations.id', '=', 'customers.location_id')
                ->leftJoin('services', 'customers.service_id', '=', 'services.id')
                ->leftJoin('plans', 'services.plan_id', '=', 'plans.id')
                ->select(
                    'locations.id as location_id',
                    'locations.name as location_name',
                    'services.name as service_name',
                    DB::raw('COUNT(services.id) as services_count'),
                    'plans.name as plan_name',
                    'services.price'
                )
                ->groupBy('locations.id', 'locations.name', 'services.name', 'plans.name', 'services.price')
                ->get();
        } else {
            $this->data = DB::table('locations')
                ->leftJoin('customers', 'locations.id', '=', 'customers.location_id')
                ->leftJoin('services', 'customers.service_id', '=', 'services.id')
                ->leftJoin('plans', 'services.plan_id', '=', 'plans.id')
                ->select(
                    'locations.id as location_id',
                    'locations.name as location_name',
                    'services.name as service_name',
                    DB::raw('COUNT(services.id) as services_count'),
                    'plans.name as plan_name',
                    'services.price'
                )
                ->where('locations.id', $this->locationid)
                ->groupBy('locations.id', 'locations.name', 'services.name', 'plans.name', 'services.price')
                ->get();
        }
    }
}
