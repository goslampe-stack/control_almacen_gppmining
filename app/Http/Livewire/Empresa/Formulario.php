<?php

namespace App\Http\Livewire\Empresa;

use App\Models\Empresa;
use App\Models\PermisoUsuario;
use App\Models\User;
use App\Models\Util;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class Formulario extends Component
{
    public $ruc, $estado,  $razon_social,$empresas_id, $direccion, $celular, $correo_electronico, $encargado;
    protected $listeners = ['crear', 'editar'];
    public $modelId;
    public $imagenes_producto = [], $dataPermisoUsuario = [];

    public $usuarios_id,$empresas_auxiliar;


    public $estaEnProcesando = "d-none";
    public $estaEnCorrecto = "d-none";
    public $estaEnError = "d-none";
    public $estaEnFormulario = "d-none";
    public $estaAccesoUsuario = "d-none";

    public $visibleImagenPrincipal = '';
    public $visibleImagenAdicional = 'd-none';


    public $estado_opciones = [
        'Activo',
        'Inactivo'
    ];





    public function mount()
    {
        $this->empresas_id =  User::find(Auth::user()->id)->empresas_id;
        $this->empresas_auxiliar = Util::getEmpresasIngresada();
    }


    public function render()
    {
        return view('livewire.empresa.formulario', ['permisoUsuarios' => $this->modelarPermisoUsuario(), 'usuarios' => $this->modelarUsuarios()]);
    }


    public function modelarUsuarios()
    {
        $data = User::where('empresas_id', '=', $this->empresas_auxiliar)->where('tipoUsuario', '!=', 'Usuario')->where('estado', '=', 1)->get();

        foreach ($data as $index => $item) {
            foreach ($this->dataPermisoUsuario as $aux) {

                if ($aux == $item->id) {
                    unset($data[$index]);
                }
            }
        }
        return $data;
    }
    public function modelarPermisoUsuario()
    {
        $data =  PermisoUsuario::where('empresas_id', '=', $this->empresas_auxiliar)->where('origen', '=', 'empresas')->where('tipo_permiso', '=', $this->modelId)->orderBy('id', 'asc')->simplePaginate(30);
        $this->dataPermisoUsuario = [];
        foreach ($data as $item) {
            $this->dataPermisoUsuario[] = $item->personals_id;
        }


        return $data;
    }
    public function cambiarInformacionBasica()
    {
        $this->estaEnFormulario = '';
        $this->estaAccesoUsuario = 'd-none';
    }
    public function cambiarAccesoUsuario()
    {
        $this->estaEnFormulario = 'd-none';
        $this->estaAccesoUsuario = '';
    }



    public function rules()
    {
        return [

            'ruc' => ['required', Rule::unique('empresas', 'ruc')->ignore($this->modelId)->where(function ($query) {
                return $query->where('users_id',  '=', $this->empresas_id);
            })],
            'razon_social' => ['required', Rule::unique('empresas', 'razon_social')->ignore($this->modelId)->where(function ($query) {
                return $query->where('users_id',  '=', $this->empresas_id);
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

    public function resetVars()
    {




        $this->direccion = null;
        $this->celular = null;
        $this->correo_electronico = null;
        $this->encargado = null;
        $this->ruc = null;
        $this->razon_social = null;
        $this->direccion = null;
        $this->estado = 'Activo';
        $this->estaEnProcesando = "d-none";
        $this->estaEnCorrecto = "d-none";
        $this->estaEnError = "d-none";
        $this->estaEnFormulario = "";
        $this->modelId = null;
        $this->imagenes_producto = [];



        $this->visibleImagenPrincipal = '';
        $this->visibleImagenAdicional = 'd-none';
    }

    public function cerrarFormulario()
    {
       /*  $this->emit('refreshParent');
        $this->dispatchBrowserEvent('closeModal'); */

        return redirect()->route('dashboard');


    }


    public function guardar()
    {
        $this->validate();
    
        DB::beginTransaction(); //Iniciamos la reansaccion
        try {
            Empresa::create($this->modelData());
          
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
        $imagen = "";

        if (count($this->imagenes_producto) > 0) {
            $imagen = $this->imagenes_producto[0];
        } else {
            $imagen =  Util::getRandomImagenesParaTiendas();
        }
        return [
            'ruc' => $this->ruc,
            'razon_social' => $this->razon_social,
            'direccion' => $this->direccion,
            'celular' => $this->celular,
            'correo_electronico' => $this->correo_electronico,
            'encargado' => $this->encargado,
            'imagen' => $imagen,
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


            Empresa::find($this->modelId)->update($this->modelData());
          
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
        $data = Empresa::find($this->modelId);
        $this->ruc = $data->ruc;
        $this->razon_social = $data->razon_social;
        $this->direccion = $data->direccion;
        $this->celular = $data->celular;
        $this->correo_electronico = $data->correo_electronico;
        $this->encargado = $data->encargado;
        $this->imagenes_producto[] = $data->imagen;

        $this->estado = $data->estado == 1 ? "Activo" : 'Inactivo';
        if (count($this->imagenes_producto) > 0) {
            $this->visibleImagenPrincipal = 'd-none';
            $this->visibleImagenAdicional = '';
        } else {
            $this->visibleImagenPrincipal = '';
            $this->visibleImagenAdicional = 'd-none';
        }
    }

    public function agregarImagen($ruta)
    {

        $this->imagenes_producto = [];
        $this->imagenes_producto[] = $ruta;

        if (count($this->imagenes_producto) > 0) {
            $this->visibleImagenPrincipal = 'd-none';
            $this->visibleImagenAdicional = '';
        } else {
            $this->visibleImagenPrincipal = '';
            $this->visibleImagenAdicional = 'd-none';
        }
    }


     ///permiso usuario

     public function guardarUsuarioPermiso()
     {
 
         //verificamos 

         if($this->usuarios_id==null){
            Util::geterrordefine($this,"Falta seleccionar un usuario");
            return;
         }
 
         DB::beginTransaction(); //Iniciamos la reansaccion
         try {
             $data = [
                 'tipo_permiso' => $this->modelId,
                 'users_id' => Auth::user()->id,
                 'origen' => "empresas",
                 'personals_id' => $this->usuarios_id,
                 'estado' =>  1,
                 'empresas_id' => Util::getEmpresasIngresada(),
 
             ];
             PermisoUsuario::create($data);
 
 
             DB::commit();
             Util::getsuccesscreate($this);
 
             $this->usuarios_id = null;
         } catch (\Exception $e) {
             Util::geterrorSistem($this);
 
             DB::rollback();
         } catch (\Throwable $e) {
             Util::geterrorSistem($this);
 
             DB::rollback();
         }
     }
     public function eliminarPermisoUsuario($id)
     {
 
         //verificamos 
 
         DB::beginTransaction(); //Iniciamos la reansaccion
         try {
 
             PermisoUsuario::destroy($id);
 
 
             DB::commit();
             Util::getsuccessdelete($this);
         } catch (\Exception $e) {
             Util::geterrorSistem($this);
 
             DB::rollback();
         } catch (\Throwable $e) {
             Util::geterrorSistem($this);
 
             DB::rollback();
         }
     }
}
