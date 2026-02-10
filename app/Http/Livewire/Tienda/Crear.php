<?php

namespace App\Http\Livewire\Tienda;

use App\Models\Tienda;
use App\Models\Util;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
class Crear extends Component
{
    public  $ruc,$razon_social, $descripcion, $modelId, $estado, $imagen;
    protected $listeners = ['crear', 'editar', 'selectedTipoRubroItem'];


    public function render()
    {
        return view('livewire.tienda.crear');
    }

    public function crear()
    {
        $this->resetValidation();
        $this->resetVars();
        $this->modelId = null;
        $this->estado = 1;
        $this->dispatchBrowserEvent('openModal');
    }

    public function resetVars()
    {

        $this->tipo_rubros_id = null;
        $this->ruc = null;
        $this->razon_social = null;
        $this->descripcion = null;
        $this->modelId = null;
        $this->estado = null;
        $this->imagen = Util::getRandomImagenesParaTiendas();
    }

    /**
     * Modelas los datos de la base de datos
     *
     * @return void
     */
    public function modelarDatos()
    {
        $data = Tienda::where('estado', '=', 1)->get();

        return $data;
    }

    public function rules()
    {
        return [
            'ruc' => ['required',  Rule::unique('tiendas', 'ruc')->ignore($this->modelId)],
            'razon_social' => ['required',  Rule::unique('tiendas', 'razon_social')->ignore($this->modelId)],
        ];
    }

    public function guardar()
    {
      

        $this->validate();
        
        $response = Tienda::create($this->modelData());
        if ($response) {
            $this->cerrarFormulario();
        } else {
            dd("error al crear la tienda ");
        }
    }


    public function cerrarFormulario()
    {
        $this->emit('refreshParent');
        $this->dispatchBrowserEvent('closeModal');
    }

    public function modelData()
    {
        return [
            'ruc' => $this->ruc,
            'razon_social' => $this->razon_social,
            'descripcion' => $this->descripcion,
            'users_id' => Auth::user()->id,
            'imagen' => $this->imagen,
            'estado' => 1,

        ];
    }
}
