<?php

namespace App\Http\Livewire;

use App\Traits\CartTrait;
use Livewire\Component;
use Illuminate\Support\Str; // helper Str

class SearchController extends Component
{
    use CartTrait;
    public $search;
    public $currentPath;

    public function render()
    {
        return view('livewire.search');
    }
    public function mount()
    {
        // obtener la url actual del navegador
       $this->currentPath = url()->current();

    }
    // escuchar el evento scan-code
    protected $listeners = [
        'scan-code'  =>  'ScanCode'
    ];

    public function ScanCode($barcode)
    {
        // obtener el nombre de la ruta
        $routeName = Str::afterLast($this->currentPath, '/');

        // validar si la ruta actual donde se captura el código de barras es diferente a la ruta de ventas
        if($routeName != 'pos') {

        // agregar el producto al carrito
            $this->ScanearCode($barcode);

        // redireccionar a la ruta de ventas
           redirect()->to('/pos');


        }
    }
}
