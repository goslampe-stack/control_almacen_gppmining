<?php

namespace App\Http\Livewire\TipoPersonal;

use App\Models\TipoPersonal;
use App\Models\User;
use App\Models\Util;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;


class Formulario extends Component
{
    // DEFINIDORES DE CAMPOS 
    public $modelId, $nombre, $estado, $tiendas_id, $sucursal_empresas_id;

    // DEFINIDORES DE CAMPOS 

    public function render()
    {
        return view('livewire.tipo-personal.formulario');
    }

    // CAMPOS INICIALIZADORES 
    protected $listeners = ['crear', 'editar'];

    public function mount()
    {
        $this->sucursal_empresas_id = Util::getSucursalEmpresaIdLocalStorage();
    }

    // CAMPOS INICIALIZADORES 




    // GUARDAR Y ACTUALAR DATOS 

    public function crear()
    {

        $this->resetValidation();
        $this->resetVars();
        $this->modelId = null;
        $this->dispatchBrowserEvent('openModal');
    }



    public function guardar()
    {
        $this->validate();

        try {

            DB::beginTransaction();
            TipoPersonal::create($this->modelData());
            DB::commit();
            Util::getsuccesscreate($this);
            $this->cerrarFormulario();
        } catch (\Exception $e) {
            DB::rollback();
            Util::geterrorSistem($this);
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

        try {
            DB::beginTransaction();
            TipoPersonal::find($this->modelId)->update($this->modelData());
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


    // GUARDAR Y ACTUALAR DATOS 




    // OTROS COMPONENTES 
    public function modelData()
    {
        return [
            'nombre' => $this->nombre,
            'sucursal_empresas_id' => $this->sucursal_empresas_id,
            'users_id' => Auth::user()->id,
            'estado' => $this->estado == 'Activo' ? 1 : 0,
        ];
    }



    public function cerrarFormulario()
    {
        /*      $this->emit('refreshParent');
        $this->dispatchBrowserEvent('closeModal'); */

        return redirect()->route('tipo-personal');
    }



    public function rules()
    {
        return [
            'nombre' => ['required', Rule::unique('tipo_personals', 'nombre')->ignore($this->modelId)->where(function ($query) {
                return $query->where('sucursal_empresas_id',  '=', $this->sucursal_empresas_id);
            })],
            'estado' => 'required',
        ];
    }

    public function resetVars()
    {

        $this->nombre = null;
        $this->estado = 'Activo';
        $this->tiendas_id = null;
        $this->modelId = null;
    }


    public function loadModel()
    {
        $data = TipoPersonal::find($this->modelId);
        $this->nombre = $data->nombre;
        $this->estado = $data->estado == 1 ? "Activo" : 'Inactivo';
    }



    // OTROS COMPONENTES 




    // CAMPO PARA SELECTS 

    public $estado_opciones = [
        'Activo',
        'Inactivo'
    ];

    // CAMPO PARA SELECTS 













}
