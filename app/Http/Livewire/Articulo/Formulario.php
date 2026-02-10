<?php

namespace App\Http\Livewire\Articulo;

use App\Models\Articulo;
use App\Models\TipoUnidad;
use App\Models\User;
use App\Models\Util;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;


class Formulario extends Component
{
    // DEFINIDORES DE CAMPOS 
    public $modelId, $codigo, $articulo, $tipo_unidads_id, $estado, $tiendas_id, $empresas_id;
    protected $listeners = ['crear', 'editar', 'selectedTipoUnidadItem'];

    // DEFINIDORES DE CAMPOS 

    public function render()
    {
        return view('livewire.articulo.formulario', [
            'tipoUnidad' => $this->modelarTipoUnidad()
        ]);
    }


    // CAMPOS INICIALIZADORES 
    public function modelarTipoUnidad()
    {
        $data = TipoUnidad::where('estado', '=', 1)->where('empresas_id','=',$this->empresas_id)->get();
        return $data;
    }

    public function hydrate()
    {
        $this->emit('select2TipoUnidad');
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
        DB::beginTransaction(); //Iniciamos la reansaccion
        Articulo::create($this->modelData());
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
            Articulo::find($this->modelId)->update($this->modelData());

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
    public function rules()
    {
        return [
            'articulo' => ['required', Rule::unique('articulos', 'articulo')->ignore($this->modelId)->where(function ($query) {
                return $query->where('empresas_id',  '=', $this->empresas_id);
            })],
            'codigo' => ['required', Rule::unique('articulos', 'codigo')->ignore($this->modelId)->where(function ($query) {
                return $query->where('empresas_id',  '=', $this->empresas_id);
            })],
            'tipo_unidads_id' => 'required',
            'estado' => 'required',
        ];
    }


    public function mount()
    {
        $this->empresas_id =  User::find(Auth::user()->id)->empresas_id;
    }

    public function resetVars()
    {

        $this->codigo = null;
        $this->articulo = null;
        $this->tipo_unidads_id = null;
        $this->estado = 'Activo';
        $this->tiendas_id = null;
        $this->modelId = null;
    }

    public function cerrarFormulario()
    {
     /*    $this->emit('refreshParent');
        $this->dispatchBrowserEvent('closeModal'); */
        return redirect()->route('articulo');

    }


    public function modelData()
    {
        return [
            'codigo' => $this->codigo,
            'articulo' => $this->articulo,
            'tipo_unidads_id' => $this->tipo_unidads_id,
            'estado' => $this->estado == 'Activo' ? 1 : 0,
            'users_id' => Auth::user()->id,
            'empresas_id' => $this->empresas_id,

        ];
    }



    public function loadModel()
    {
        $data = Articulo::find($this->modelId);
        $this->codigo = $data->codigo;
        $this->articulo = $data->articulo;
        $this->tipo_unidads_id = $data->tipo_unidads_id;
        $this->empresas_id = $data->empresas_id;
        $this->estado = $data->estado == 1 ? "Activo" : 'Inactivo';
    }


    // OTROS COMPONENTES 




    // CAMPO PARA SELECTS 

    public $estado_opciones = [
        'Activo',
        'Inactivo'
    ];

    public function selectedTipoUnidadItem($item)
    {
        if ($item) {
            $this->tipo_unidads_id = $item;
        }
    }
    // CAMPO PARA SELECTS 
















}
