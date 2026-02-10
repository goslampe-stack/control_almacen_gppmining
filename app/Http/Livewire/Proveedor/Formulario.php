<?php

namespace App\Http\Livewire\Proveedor;

use App\Models\Proveedor;
use App\Models\User;
use App\Models\Util;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\DB;

class Formulario extends Component
{
    public $ruc, $razon_social, $direccion, $celular, $correo_electronico, $referencia, $estado;
    protected $listeners = ['crear', 'editar'];
    public $modelId,$empresas_id;

    public $estaEnProcesando = "d-none";
    public $estaEnCorrecto = "d-none";
    public $estaEnError = "d-none";
    public $estaEnFormulario = "d-none";

    public $estado_opciones = [
        'Activo',
        'Inactivo'
    ];



    public $tiendas_id_seleccionado = '';

    public function mount()
    {
        $this->empresas_id =  User::find(Auth::user()->id)->empresas_id;
    }

    public function render()
    {
        return view('livewire.proveedor.formulario');
    }



    public function rules()
    {
        return [

            'ruc' => ['required', Rule::unique('proveedors', 'ruc')->ignore($this->modelId)->where(function ($query) {
                return $query->where('empresas_id',  '=', $this->empresas_id);
            })],
            'razon_social' => ['required', Rule::unique('proveedors', 'razon_social')->ignore($this->modelId)->where(function ($query) {
                return $query->where('empresas_id',  '=', $this->empresas_id);
            })],
            'estado' => 'required',
        ];
    }

    public function crear()
    {
        $this->resetValidation();
        $this->resetVars();
        $this->modelId = null;
        $this->dispatchBrowserEvent('openModal');
    }


    public function cerrarFormulario()
    {
       /*  $this->emit('refreshParent');
        $this->dispatchBrowserEvent('closeModal'); */
        return redirect()->route('proveedor');

    }

    public function guardar()
    {
        $this->validate();
      

        DB::beginTransaction(); //Iniciamos la reansaccion
        try {

            Proveedor::create($this->modelData());
          

            DB::commit();
            Util::getsuccesscreate($this);
            $this->cerrarFormulario();
        } catch (\Exception $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        } catch (\Throwable $e) {
            Util::geterrorSistem($this);


            DB::rollback();
        }
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
        
        DB::beginTransaction(); //Iniciamos la reansaccion
        try {

            Proveedor::find($this->modelId)->update($this->modelData());
            DB::commit();
            Util::getsuccessupdate($this);
            $this->cerrarFormulario();
        } catch (\Exception $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        } catch (\Throwable $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        }
    }


    public function loadModel()
    {

        $data = Proveedor::find($this->modelId);

        $this->ruc = $data->ruc;
        $this->razon_social = $data->razon_social;
        $this->direccion = $data->direccion;
        $this->celular = $data->celular;
        $this->referencia = $data->referencia;
        $this->estado = $data->estado == 1 ? "Activo" : 'Inactivo';
        $this->correo_electronico = $data->correo_electronico;
    }


    public function resetVars()
    {

        $this->ruc = null;
        $this->razon_social = null;
        $this->direccion = null;
        $this->celular = null;
        $this->correo_electronico = null;
        $this->referencia = null;
        $this->modelId = null;
        $this->estado = 'Activo';
        $this->estaEnProcesando = "d-none";
        $this->estaEnCorrecto = "d-none";
        $this->estaEnError = "d-none";
        $this->estaEnFormulario = "";
    }

    public function modelData()
    {
        return [
            'ruc' => $this->ruc,
            'razon_social' => $this->razon_social,
            'direccion' => $this->direccion,
            'empresas_id' => $this->empresas_id,
            'users_id' => Auth::user()->id,
            'celular' => $this->celular,
            'correo_electronico' => $this->correo_electronico,
            'referencia' => $this->referencia,
            'estado' => $this->estado == 'Activo' ? 1 : 0,
        ];
    }
}
