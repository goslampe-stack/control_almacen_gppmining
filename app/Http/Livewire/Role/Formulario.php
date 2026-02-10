<?php

namespace App\Http\Livewire\Role;

use App\Models\Role;
use App\Models\TipoUnidad;
use App\Models\Util;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class Formulario extends Component
{

    public $name, $state, $tiendas_id;
    protected $listeners = ['crear', 'editar'];
    public $modelId;


    public $estaEnProcesando = "d-none";
    public $estaEnCorrecto = "d-none";
    public $estaEnError = "d-none";
    public $estaEnFormulario = "d-none";


    public $estado_opciones = [
        'Activo',
        'Inactivo'
    ];







    public function render()
    {
        return view('livewire.role.formulario');
    }



    public function rules()
    {
        return [

            'name' => ['required', Rule::unique('roles', 'name')->ignore($this->modelId)],
            'state' => 'required',
        ];
    }

    public function crear()
    {
        $this->resetValidation();
        $this->resetVars();
        $this->modelId = null;
        $this->dispatchBrowserEvent('openModal');
    }

    public function resetVars()
    {

        $this->name = null;
        $this->state = 'Activo';
        $this->tiendas_id = null;
        $this->estaEnProcesando = "d-none";
        $this->estaEnCorrecto = "d-none";
        $this->estaEnError = "d-none";
        $this->estaEnFormulario = "";
        $this->modelId = null;
    }

    public function cerrarFormulario()
    {
        $this->emit('refreshParent');
        $this->dispatchBrowserEvent('closeModal');
    }


    public function guardar()
    {
        $this->validate();
        $this->estaEnFormulario = "d-none";
        $this->estaEnProcesando = "";

        DB::beginTransaction(); //Iniciamos la reansaccion


        Role::create($this->modelData());
        $this->estaEnProcesando = "d-none";
        $this->estaEnCorrecto = "";
    }


    public function modelData()
    {
        return [
            'name' => $this->name,
            'state' => $this->state == 'Activo' ? 1 : 0,
        ];
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
        $this->estaEnFormulario = "d-none";
        $this->estaEnProcesando = "";
        $response = Role::find($this->modelId)->update($this->modelData());
        $this->estaEnProcesando = "d-none";
        if ($response) {
            $this->estaEnCorrecto = "";
        } else {
            $this->estaEnError = "";
        }
    }


    public function loadModel()
    {

        $data = Role::find($this->modelId);
        $this->name = $data->name;
        $this->state = $data->state == 1 ? "Activo" : 'Inactivo';
    }
}
