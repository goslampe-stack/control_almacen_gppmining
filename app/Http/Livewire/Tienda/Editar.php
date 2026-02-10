<?php

namespace App\Http\Livewire\Tienda;

use App\Models\Tienda;
use App\Models\Util;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class Editar extends Component
{
    public  $ruc, $razon_social, $descripcion, $modelId, $estado, $imagen;


    public function mount()
    {

        if (!Util::getExisteTiendaSeleccionadaLocalStorage()) {
            return redirect()->route('dashboard');
        } else {
            $this->modelId = Util::getTiendaIdLocalStorage();
        }
        $this->editar($this->modelId);
    }

    public function rules()
    {
        return [
            'ruc' => ['required',  Rule::unique('tiendas', 'ruc')->ignore($this->modelId)],
            'razon_social' => ['required',  Rule::unique('tiendas', 'razon_social')->ignore($this->modelId)],
        ];
    }


    public function render()
    {
        return view('livewire.tienda.editar');
    }

    public function modelData()
    {
        return [
            'ruc' => $this->ruc,
            'razon_social' => $this->razon_social,
            'descripcion' => $this->descripcion,
            'users_id' => Auth::user()->id,
            'estado' => 1,

        ];
    }

    public function resetVars()
    {

        $this->ruc = null;
        $this->razon_social = null;
        $this->descripcion = null;
        $this->estado = 'Activo';
        $this->modelId = null;
    }



    public function editar($id)
    {
        $this->resetValidation();
        $this->resetVars();
        $this->modelId = $id;
        $this->loadModel();
        $this->dispatchBrowserEvent('openModal');
    }

    public function actualizar()
    {
        $this->validate();

       
        Tienda::find($this->modelId)->update($this->modelData());
    }


    public function loadModel()
    {
        $data = Tienda::find($this->modelId);
        $this->ruc = $data->ruc;
        $this->razon_social = $data->razon_social;
        $this->descripcion = $data->descripcion;
        $this->estado = $data->estado == 1 ? "Activo" : 'Inactivo';
    }
}
