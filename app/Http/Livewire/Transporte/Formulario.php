<?php

namespace App\Http\Livewire\Transporte;

use App\Models\Transporte;
use App\Models\User;
use App\Models\Util;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class Formulario extends Component
{

    public $ruc, $razon_social, $direccion,  $celular, $estado;
    protected $listeners = ['crear', 'editar'];
    public $modelId, $empresas_id;


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
        return view('livewire.transporte.formulario');
    }


    public function rules()
    {
        return [
            'ruc' => ['required', Rule::unique('transportes', 'ruc')->ignore($this->modelId)->where(function ($query) {
                return $query->where('empresas_id',  '=', $this->empresas_id);
            })],
            'razon_social' => 'required',
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

    public function resetVars()
    {

        $this->ruc = null;
        $this->razon_social = null;
        $this->direccion = null;
        $this->celular = null;
        $this->estado = 'Activo';
        $this->estaEnProcesando = "d-none";
        $this->estaEnCorrecto = "d-none";
        $this->estaEnError = "d-none";
        $this->estaEnFormulario = "";
        $this->modelId = null;
    }

    public function cerrarFormulario()
    {
        /* $this->emit('refreshParent'); */
        /* $this->dispatchBrowserEvent('closeModal'); */
        return redirect()->route('transporte');

    }


    public function guardar()
    {
        $this->validate();
     
        DB::beginTransaction(); //Iniciamos la reansaccion
        try {

            Transporte::create($this->modelData());
      

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


    public function modelData()
    {
        return [
            'ruc' => $this->ruc,
            'empresas_id' => $this->empresas_id,
            'razon_social' => $this->razon_social,
            'direccion' => $this->direccion,
            'celular' => $this->celular,
            'users_id' => Auth::user()->id,
            'estado' => $this->estado == 'Activo' ? 1 : 0,
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
   

        DB::beginTransaction(); //Iniciamos la reansaccion
        try {

            Transporte::find($this->modelId)->update($this->modelData());
      


            DB::commit();
            Util::getsuccessupdate($this);
            $this->cerrarFormulario();
        } catch (\Exception $e) {
            Util::geterrorSistem($this);
            $this->estaEnError = "";


            DB::rollback();
        } catch (\Throwable $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        }
    }


    public function loadModel()
    {
        $data = Transporte::find($this->modelId);
        $this->ruc = $data->ruc;
        $this->razon_social = $data->razon_social;
        $this->direccion = $data->direccion;
        $this->celular = $data->celular;
        $this->estado = $data->estado == 1 ? "Activo" : 'Inactivo';
    }
}
