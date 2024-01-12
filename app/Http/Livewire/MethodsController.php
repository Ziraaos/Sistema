<?php

namespace App\Http\Livewire;

use App\Models\PaymentMethod;
use Livewire\Component;
use Livewire\WithPagination;

class MethodsController extends Component
{
    use WithPagination;

    public $name, $financial_entity, $account_number, $beneficiary, $ci, $note, $search, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;
    protected $paginationTheme = 'bootstrap';

    public function mount(){
        $this->pageTitle = 'Listado';
        $this->componentName = 'Metodos de pago';
   }

    public function render()
    {
        if(strlen($this->search) > 0){
            $data = PaymentMethod::where('name', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        }else{
            $data = PaymentMethod::orderBy('id', 'desc')->paginate($this->pagination);
        }

        return view('livewire.method.methods', ['methods' => $data])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function Edit($id){
        $record = PaymentMethod::find($id, ['id','name']);
        $this->name = $record->name;
        $this->selected_id = $record->id;
        $this->financial_entity = $record->financial_entity;
        $this->account_number = $record->account_number;
        $this->beneficiary = $record->beneficiary;
        $this->ci = $record->ci;
        $this->note = $record->note;

        $this->emit('show-modal', 'show modal!');
    }

    public function Store(){
        $rules = [
            'name' => 'required|unique:payment_methods|min:3',
        ];
        $messages = [
            'name.required' => 'Nombre del metodo de pago es requerido',
            'name.unique' => 'Ya existe el nombre del metodo de pago',
            'name.min' => 'El nombre del metodo de pago debe tener al menos 3 caracteres',
        ];
        $this->validate($rules, $messages);

        $method = PaymentMethod::create([
            'name' => $this->name,
            'financial_entity' => $this->financial_entity,
            'account_number' => $this->account_number,
            'beneficiary' => $this->beneficiary,
            'ci' => $this->ci,
            'note' => $this->note,
        ]);
        /* dd($method); */
        $method->save();

        $this->resetUI(); // Limpiar las cajas de texto del formulario
        $this->emit('method-added','Metodo de pago Registrado');
    }

    public function Update(){
        $rules = [
            'name' => "required|min:3|unique:payment_methods,name,{$this->selected_id}",
        ];
        $messages = [
            'name.required' => 'Nombre del metodo de pago es requerido',
            'name.unique' => 'Ya existe el nombre del metodo de pago',
            'name.min' => 'El nombre del metodo de pago debe tener al menos 3 caracteres',
        ];
        $this->validate($rules, $messages);

        $method = PaymentMethod::find($this->selected_id);
        $method->update([
            'name' => $this->name,
            'financial_entity' => $this->financial_entity,
            'account_number' => $this->account_number,
            'beneficiary' => $this->beneficiary,
            'ci' => $this->ci,
            'note' => $this->note,
        ]);

        $method->save();

        // Limpiar las cajas de texto
        $this->resetUI();
        $this->emit('method-updated','Metodo de pago Actualizado');
    }

    // Para escuchar los eventos desde el frontend
    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    public function Destroy(PaymentMethod $method){
        // $method = PaymentMethod::find($id);
        // dd($method);
        $method->delete();
        $this->resetUI();
        $this->emit('method-deleted','Metodo de pago Eliminado');
    }


    // Para poder cerrar la ventana modal
    public function resetUI(){
        $this->name = '';
        $this->financial_entity = '';
        $this->account_number = '';
        $this->beneficiary = '';
        $this->ci = '';
        $this->note = '';
        $this->search = '';
        $this->selected_id = 0;
    }
}
