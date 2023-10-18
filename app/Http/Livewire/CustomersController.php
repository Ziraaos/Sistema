<?php

namespace App\Http\Livewire;

use App\Models\Customer;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class CustomersController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $first_name, $last_name, $email, $phone, $disc, $address, $image, $search, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;
    protected $paginationTheme = 'bootstrap';

    public function mount(){
        $this->pageTitle = 'Listado';
        $this->componentName = 'Clientes';
   }

    public function render()
    {
        if(strlen($this->search) > 0){
            $data = Customer::where('first_name', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        }else{
            $data = Customer::orderBy('id', 'desc')->paginate($this->pagination);
        }

        return view('livewire.customer.customers', ['customers' => $data])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function Edit($id){
        $record = Customer::find($id, ['id','first_name','last_name','email','phone','disc','address']);
        $this->first_name = $record->first_name;
        $this->selected_id = $record->id;
        $this->last_name = $record->last_name;
        $this->email = $record->email;
        $this->phone = $record->phone;
        $this->disc = $record->disc;
        $this->address = $record->address;

        $this->emit('show-modal', 'show modal!');
    }

    public function Store(){
        $rules = [
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'phone' => 'required',
            'address' => 'required',
        ];
        $messages = [
            'first_name.required' => 'Nombre del cliente es requerido',
            'first_name.min' => 'El nombre del cliente debe tener al menos 3 caracteres',
            'last_name.required' => 'Apellido del cliente es requerido',
            'last_name.min' => 'El apellido del cliente debe tener al menos 3 caracteres',
            'phone.required' => 'El num. de telefono es requerido',
            'address.required' => 'La dirección es requerida',
        ];
        $this->validate($rules, $messages);

        $customer = Customer::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'disc' => $this->disc,
            'address' => $this->address,
        ]);

        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/customers', $customFileName);
            $customer->image = $customFileName;
            $customer->save();
        }

        $this->resetUI(); // Limpiar las cajas de texto del formulario
        $this->emit('customer-added','Cliente Registrado');
    }

    public function Update(){
        $rules = [
            'first_name' => "required|min:3,first_name,{$this->selected_id}",
            'last_name' => 'required|min:3',
            'phone' => 'required',
            'address' => 'required',
        ];
        $messages = [
            'first_name.required' => 'Nombre del cliente es requerido',
            'first_name.min' => 'El nombre del cliente debe tener al menos 3 caracteres',
            'last_name.required' => 'Apellido del cliente es requerido',
            'last_name.min' => 'El apellido del cliente debe tener al menos 3 caracteres',
            'phone.required' => 'El num. de telefono es requerido',
            'address.required' => 'La dirección es requerida',
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
        $this->emit('customer-updated','Cliente Actualizado');
    }

    // Para escuchar los eventos desde el frontend
    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    public function Destroy(Customer $customer){
        $imageTemp = $customer->image; // imagen temporal
        $customer->delete();
        if ($imageTemp != null) {
            if (file_exists('storage/customers' . $imageTemp)) {
                unlink('storage/customers' . $imageTemp);
            }
        }
        $this->resetUI();
        $this->emit('customer-deleted','Cliente Eliminado');
    }


    // Para poder cerrar la ventana modal
    public function resetUI(){
        $this->first_name = '';
        $this->last_name = '';
        $this->email = '';
        $this->phone = '';
        $this->disc = '';
        $this->last_name = '';
        $this->address = '';
        $this->selected_id = 0;
    }
}
