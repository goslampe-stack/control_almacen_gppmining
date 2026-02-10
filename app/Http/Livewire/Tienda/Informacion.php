<?php

namespace App\Http\Livewire\Tienda;

use App\Models\Util;
use Livewire\Component;

class Informacion extends Component
{
    public $tiendas_id_seleccionado = '';


    public function mount()
    {
        if (!Util::getExisteTiendaSeleccionadaLocalStorage()) {
           
            return redirect()->route('dashboard');
        } else {
            
            $this->tiendas_id_seleccionado = Util::getTiendaIdLocalStorage();
        }
    }
    public function render()
    {
        return view('livewire.tienda.informacion');
    }
}
