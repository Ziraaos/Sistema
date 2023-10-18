<?php

namespace App\Http\Livewire;

use App\Models\Discount;
use Livewire\Component;
use Livewire\WithPagination;

class DiscountsController extends Component
{
    use WithPagination;

    public $name, $days_dwntm, $search, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;
    protected $paginationTheme = 'bootstrap';

    public function mount(){
        $this->pageTitle = 'Listado';
        $this->componentName = 'Descuentos';
   }

    public function render()
    {
        if(strlen($this->search) > 0){
            $data = Discount::where('name', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        }else{
            $data = Discount::orderBy('id', 'desc')->paginate($this->pagination);
        }

        return view('livewire.discount.discounts', ['discounts' => $data])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function Edit($id){
        $record = Discount::find($id, ['id','name','days_dwntm']);
        $this->name = $record->name;
        $this->selected_id = $record->id;
        $this->days_dwntm = $record->days_dwntm;

        $this->emit('show-modal', 'show modal!');
    }

    public function Store(){
        $rules = [
            'name' => 'required|unique:discounts|min:3',
            'days_dwntm' => 'required',
        ];
        $messages = [
            'name.required' => 'Nombre del descuento es requerido',
            'name.unique' => 'Ya existe el nombre del descuento',
            'name.min' => 'El nombre del descuento debe tener al menos 3 caracteres',
            'days_dwntm.required' => 'Los días sin servicio son requeridos',
        ];
        $this->validate($rules, $messages);

        $discount = Discount::create([
            'name' => $this->name,
            'days_dwntm' => $this->days_dwntm,
        ]);
        /* dd($discount); */
        $discount->save();

        $this->resetUI(); // Limpiar las cajas de texto del formulario
        $this->emit('discount-added','Descuento Registrado');
    }

    public function Update(){
        $rules = [
            'name' => "required|min:3|unique:discounts,name,{$this->selected_id}",
            'days_dwntm' => 'required',
        ];
        $messages = [
            'name.required' => 'Nombre del descuento requerido',
            'name.min' => 'El nombre del descuento debe tener al menos 3 caracteres',
            'name.unique' => 'El Nombre del descuento ya existe!',
            'days_dwntm.required' => 'Los días sin servicio son requeridos',
        ];
        $this->validate($rules, $messages);

        $discount = Discount::find($this->selected_id);
        $discount->update([
            'name' => $this->name,
            'days_dwntm' => $this->days_dwntm,
        ]);

        $discount->save();

        // Limpiar las cajas de texto
        $this->resetUI();
        $this->emit('discount-updated','Descuento Actualizado');
    }

    // Para escuchar los eventos desde el frontend
    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    public function Destroy(Discount $discount){
        // $discount = Discount::find($id);
        // dd($discount);
        $discount->delete();
        $this->resetUI();
        $this->emit('discount-deleted','Descuento Eliminado');
    }


    // Para poder cerrar la ventana modal
    public function resetUI(){
        $this->name = '';
        $this->days_dwntm = '';
        $this->search = '';
        $this->selected_id = 0;
    }
}
