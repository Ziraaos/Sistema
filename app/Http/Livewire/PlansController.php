<?php

namespace App\Http\Livewire;

use App\Models\Plan;
use Livewire\Component;
use Livewire\WithPagination;

class PlansController extends Component
{
    use WithPagination;

    public $name, $search, $selected_id, $pageTitle, $componentName;
    private $pagination = 10;
    protected $paginationTheme = 'bootstrap';

    // Para inicializar propiedades que se van a renderizar en la vista principal del componente
    // es el primer metodo que se ejecuta en los componentes de livewire
    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Planes';
    }
    public function render()
    {
        if (strlen($this->search) > 0) {
            $data = Plan::where('name', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        } else {
            $data = Plan::orderBy('id', 'desc')->paginate($this->pagination);
        }
        return view('livewire.plan.plans', ['plans' => $data])
            ->extends('layouts.theme.app')
            ->section('content');;
    }

    public function Edit($id){
        $record = Plan::find($id, ['id','name']);
        $this->name = $record->name;
        $this->selected_id = $record->id;

        $this->emit('show-modal', 'show modal!');
    }

    public function Store(){
        $rules = [
            'name' => 'required|unique:categories|min:3'
        ];
        $messages = [
            'name.required' => 'Nombre del plan es requerido',
            'name.unique' => 'Ya existe el nombre del plan',
            'name.min' => 'El nombre del plan debe tener al menos 3 caracteres',
        ];
        $this->validate($rules, $messages);

        $plan = Plan::create([
            'name' => $this->name
        ]);

        $this->resetUI(); // Limpiar las cajas de texto del formulario
        $this->emit('plan-added','Plan Registrado');
    }

    public function Update(){
        $rules = [
            'name' => "required|min:3|unique:categories,name,{$this->selected_id}"
        ];
        $messages = [
            'name.required' => 'Nombre de plan requerido',
            'name.min' => 'El nombre del plan debe tener al menos 3 caracteres',
            'name.unique' => 'El Nombre del plan ya existe!',
        ];
        $this->validate($rules, $messages);

        $plan = Plan::find($this->selected_id);
        $plan->update([
            'name' => $this->name
        ]);

        // Limpiar las cajas de texto
        $this->resetUI();
        $this->emit('plan-updated','Plan Actualizada');
    }

    // Para escuchar los eventos desde el frontend
    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    public function Destroy(Plan $plan){
        // $plan = Plan::find($id);
        // dd($plan);
        $plan->delete();
        $this->resetUI();
        $this->emit('plan-deleted','Plan Eliminado');
    }


    // Para poder cerrar la ventana modal
    public function resetUI(){
        $this->name = '';
        $this->search = '';
        $this->selected_id = 0;
    }
}
