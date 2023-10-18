<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Service;
use Livewire\WithPagination;

class ServicesController extends Component
{
    use WithPagination;

    public $name, $price, $dwn_spd, $up_spd, $search, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;
    protected $paginationTheme = 'bootstrap';

    public function mount(){
        $this->pageTitle = 'Listado';
        $this->componentName = 'Servicios / Planes';
   }

    public function render()
    {
        if(strlen($this->search) > 0){
            $data = Service::where('name', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        }else{
            $data = Service::orderBy('id', 'desc')->paginate($this->pagination);
        }

        return view('livewire.service.services', ['services' => $data])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function Edit($id){
        $record = Service::find($id, ['id','name','price','dwn_spd','up_spd']);
        $this->name = $record->name;
        $this->selected_id = $record->id;
        $this->price = $record->price;
        $this->dwn_spd = $record->dwn_spd;
        $this->up_spd = $record->up_spd;

        $this->emit('show-modal', 'show modal!');
    }

    public function Store(){
        $rules = [
            'name' => 'required|unique:services|min:3',
            'price' => 'required',
        ];
        $messages = [
            'name.required' => 'Nombre del plan es requerido',
            'name.unique' => 'Ya existe el nombre del plan',
            'name.min' => 'El nombre del plan debe tener al menos 3 caracteres',
            'price.required' => 'Precio es requerido',
        ];
        $this->validate($rules, $messages);

        $service = Service::create([
            'name' => $this->name,
            'price' => $this->price,
            'dwn_spd' => $this->dwn_spd,
            'up_spd' => $this->up_spd,
        ]);
        /* dd($service); */
        $service->save();

        $this->resetUI(); // Limpiar las cajas de texto del formulario
        $this->emit('service-added','Servicio/Plan Registrada');
    }

    public function Update(){
        $rules = [
            'name' => "required|min:3|unique:services,name,{$this->selected_id}",
            'price' => 'required',
        ];
        $messages = [
            'name.required' => 'Nombre del plan requerido',
            'name.min' => 'El nombre del plan debe tener al menos 3 caracteres',
            'name.unique' => 'El Nombre del plan ya existe!',
            'price.required' => 'Precio es requerido',
        ];
        $this->validate($rules, $messages);

        $service = Service::find($this->selected_id);
        $service->update([
            'name' => $this->name,
            'price' => $this->price,
            'dwn_spd' => $this->dwn_spd,
            'up_spd' => $this->up_spd,
        ]);

        $service->save();

        // Limpiar las cajas de texto
        $this->resetUI();
        $this->emit('service-updated','Servicio/Plan Actualizada');
    }

    // Para escuchar los eventos desde el frontend
    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    public function Destroy(Service $service){
        // $service = Service::find($id);
        // dd($service);
        $service->delete();
        $this->resetUI();
        $this->emit('service-deleted','Servicio/Plan Eliminada');
    }


    // Para poder cerrar la ventana modal
    public function resetUI(){
        $this->name = '';
        $this->price = '';
        $this->dwn_spd = '';
        $this->up_spd = '';
        $this->search = '';
        $this->selected_id = 0;
    }
}
