<?php

namespace App\Http\Livewire\Tienda;

use App\Models\Util;
use Livewire\Component;
use Illuminate\Support\Facades\Crypt;


class DetalleTienda extends Component
{

    public $tienda_id;

    public function  mount($tienda_id)
    {

        $this->tienda_id = Crypt::decrypt($tienda_id);
        if ($this->tienda_id != '2515454545') {

            Util::putSucursarEmpresaLocalStorage($this->tienda_id);
            return redirect()->route('informacion');
        }
    }

    public function render()
    {
        return view('livewire.tienda.detalle-tienda');
    }
}
