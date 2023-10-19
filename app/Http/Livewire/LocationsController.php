<?php

namespace App\Http\Livewire;

use App\Models\Location;
use Livewire\Component;
use Livewire\WithPagination;

class LocationsController extends Component
{
    use WithPagination;

    public $name, $state, $city, $note, $search, $selected_id, $pageTitle, $componentName;
    private $pagination = 5;
    protected $paginationTheme = 'bootstrap';

    public function mount(){
        $this->pageTitle = 'Listado';
        $this->componentName = 'Descuentos';
   }

    public function render()
    {
        if(strlen($this->search) > 0){
            $data = Location::where('name', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        }else{
            $data = Location::orderBy('id', 'desc')->paginate($this->pagination);
        }

        return view('livewire.location.locations', ['locations' => $data])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function Edit($id){
        $record = Location::find($id, ['id','name']);
        $this->name = $record->name;
        $this->selected_id = $record->id;
        $this->state = $record->state;
        $this->city = $record->city;
        $this->note = $record->note;

        $this->emit('show-modal', 'show modal!');
    }

    public function Store(){
        $rules = [
            'name' => 'required|unique:locations|min:3',
            'state' => 'required',
            'city' => 'required',
        ];
        $messages = [
            'name.required' => 'Nombre de la ubicación es requerido',
            'name.unique' => 'Ya existe el nombre de la ubicación',
            'name.min' => 'El nombre de la ubicación debe tener al menos 3 caracteres',
            'state.required' => 'El departamento es requerido',
            'city.required' => 'La ciudad o comunidad es requerida',
        ];
        $this->validate($rules, $messages);

        $location = Location::create([
            'name' => $this->name,
            'state' => $this->state,
            'city' => $this->city,
            'note' => $this->note,
        ]);
        /* dd($location); */
        $location->save();

        $this->resetUI(); // Limpiar las cajas de texto del formulario
        $this->emit('location-added','Ubicación Registrada');
    }

    public function Update(){
        $rules = [
            'name' => "required|min:3|unique:locations,name,{$this->selected_id}",
            'state' => 'required',
            'city' => 'required',
        ];
        $messages = [
            'name.required' => 'Nombre de la ubicación es requerido',
            'name.unique' => 'Ya existe el nombre de la ubicación',
            'name.min' => 'El nombre de la ubicación debe tener al menos 3 caracteres',
            'state.required' => 'El departamento es requerido',
            'city.required' => 'La ciudad o comunidad es requerida',
        ];
        $this->validate($rules, $messages);

        $location = Location::find($this->selected_id);
        $location->update([
            'name' => $this->name,
            'state' => $this->state,
            'city' => $this->city,
            'note' => $this->note,
        ]);

        $location->save();

        // Limpiar las cajas de texto
        $this->resetUI();
        $this->emit('location-updated','Ubicación Actualizada');
    }

    // Para escuchar los eventos desde el frontend
    protected $listeners = [
        'deleteRow' => 'Destroy'
    ];

    public function Destroy(Location $location){
        // $location = Location::find($id);
        // dd($location);
        $location->delete();
        $this->resetUI();
        $this->emit('location-deleted','Ubicación Eliminada');
    }


    // Para poder cerrar la ventana modal
    public function resetUI(){
        $this->name = '';
        $this->state = '';
        $this->city = '';
        $this->note = '';
        $this->search = '';
        $this->selected_id = 0;
    }
}
