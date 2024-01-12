<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use App\Models\Location;
use App\Models\Service;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CustomersController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $first_name, $last_name, $email, $phone, $disc, $address, $image, $status, $locationid, $serviceid, $search, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
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

        return view('livewire.customer.customers', [
            'customers' => $data,
            'locations' => Location::orderBy('name', 'asc')->get(),
            'services' => Service::orderBy('name', 'asc')->get()])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function Edit(Customer $customer)
    {
        $this->first_name = $customer->first_name;
        $this->selected_id = $customer->id;
        $this->last_name = $customer->last_name;
        $this->email = $customer->email;
        $this->phone = $customer->phone;
        $this->disc = $customer->disc;
        $this->address = $customer->address;
        $this->status = $customer->status;
        $this->image = null;
        $this->locationid = $customer->location_id;
        $this->serviceid = $customer->service_id;

        $this->emit('show-modal', 'show modal!');
    }

    public function Store()
    {
        $rules = [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'phone' => 'required',
            'address' => 'required',
            'locationid' => 'required|not_in:Elegir',
            'disc' => 'required|not_in:Elegir',
        ];
        $messages = [
            'first_name.required' => 'Nombre del cliente es requerido',
            'first_name.min' => 'El nombre del cliente debe tener al menos 3 caracteres',
            'last_name.required' => 'Apellido del cliente es requerido',
            'last_name.min' => 'El apellido del cliente debe tener al menos 3 caracteres',
            'phone.required' => 'El num. de telefono es requerido',
            'address.required' => 'La dirección es requerida',
            'locationid.not_in' => 'Elige un nombre de ubicación diferente de Elegir',
            'disc.required' => 'Selecciona el estatus del usuario',
            'disc.not_in' => 'Selecciona el estatus',
        ];
        $this->validate($rules, $messages);
        $customer = Customer::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'disc' => $this->disc,
            'address' => $this->address,
            'status' => $this->status,
            'location_id' => $this->locationid,
            'service_id' => $this->serviceid,
        ]);

        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/customers', $customFileName);
            $customer->image = $customFileName;
            $customer->save();
        }

        $this->resetUI(); // Limpiar las cajas de texto del formulario
        $this->emit('customer-added', 'Cliente Registrado');
    }

    public function Update()
    {
        $rules = [
            'first_name' => "required|min:3,first_name,{$this->selected_id}",
            'last_name' => 'required|min:3',
            'phone' => 'required',
            'address' => 'required',
            'locationid' => 'required|not_in:Elegir',
            'status' => 'required|not_in:Elegir',
        ];
        $messages = [
            'first_name.required' => 'Nombre del cliente es requerido',
            'first_name.min' => 'El nombre del cliente debe tener al menos 3 caracteres',
            'last_name.required' => 'Apellido del cliente es requerido',
            'last_name.min' => 'El apellido del cliente debe tener al menos 3 caracteres',
            'phone.required' => 'El num. de telefono es requerido',
            'address.required' => 'La dirección es requerida',
            'locationid.not_in' => 'Elige un nombre de ubicación diferente de Elegir',
            'status.required' => 'Selecciona el estatus del usuario',
            'status.not_in' => 'Selecciona el estatus',
        ];
        $this->validate($rules, $messages);

        $customer = Customer::find($this->selected_id);
        $customer->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'disc' => $this->disc,
            'address' => $this->address,
            'status' => $this->status,
            'location_id' => $this->locationid,
            'service_id' => $this->serviceid,
        ]);

        if ($this->image) {
            $customFileName = uniqid() . ' _.' . $this->image->extension();
            $this->image->storeAs('public/customers', $customFileName);
            $imageTemp = $customer->image;

            $customer->image = $customFileName;
            $customer->save();

            if ($imageTemp != null) {
                if (file_exists('storage/customers/' . $imageTemp)) {
                    unlink('storage/customers/' . $imageTemp);
                }
            }
        }


        // Limpiar las cajas de texto
        $this->resetUI();
        $this->emit('customer-updated', 'Cliente Actualizado');
    }

    // Para escuchar los eventos desde el frontend
    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    public function Destroy(Customer $customer)
    {
        $imageTemp = $customer->image; // imagen temporal
        $customer->delete();
        if ($imageTemp != null) {
            if (file_exists('storage/customers' . $imageTemp)) {
                unlink('storage/customers' . $imageTemp);
            }
        }
        $this->resetUI();
        $this->emit('customer-deleted', 'Cliente Eliminado');
    }


    // Para poder cerrar la ventana modal
    public function resetUI()
    {
        $this->first_name = '';
        $this->last_name = '';
        $this->email = '';
        $this->phone = '';
        $this->disc = '';
        $this->last_name = '';
        $this->address = '';
        $this->image = null;
        $this->locationid = 'Elegir';
        $this->serviceid = 'Elegir';
        $this->status = 'Active';
        $this->selected_id = 0;
    }
}
