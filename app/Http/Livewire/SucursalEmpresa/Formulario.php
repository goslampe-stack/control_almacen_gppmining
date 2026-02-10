<?php

namespace App\Http\Livewire\SucursalEmpresa;

use App\Models\PermisoUsuario;
use App\Models\SucursalEmpresa;
use App\Models\User;
use App\Models\Util;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class Formulario extends Component
{
    public
        $estado,
        $nombre_sucursal,
        $identificador,
        $direccion,
        $celular,
        $correo_electronico,
        $encargado,
        $tipografia_pdf,
        $colorPdf,
        $empresas_id;

    public $usuarios_id;

    protected $listeners = ['crear', 'editar','selectorTipografia'];
    public $modelId;
    public $imagenes_producto = null, $dataPermisoUsuario = [];




    public $estaAccesoUsuario = "d-none";
    public $estaEnCorrecto = "d-none";
    public $estaEnError = "d-none";
    public $estaEnFormulario = "d-none";
    public $estaConfiguracion = "d-none";

    public $empresas_auxiliar;


    public $estado_opciones = [
        'Activo',
        'Inactivo'
    ];

    public function mount()
    {
        if (!Util::getExisteTiendaSeleccionadaLocalStorage()) {
            return redirect()->route('dashboard');
        } else {
            $numero = Util::getTiendaIdLocalStorage();
            if ($numero != -10) {
                $this->empresas_id = $numero;
                $this->empresas_auxiliar = Util::getEmpresasIngresada();
            } else {
                return redirect()->route('dashboard');
            }
        }
    }

    public function render()
    {
        return view('livewire.sucursal-empresa.formulario', ['permisoUsuarios' => $this->modelarPermisoUsuario(), 'usuarios' => $this->modelarUsuarios(),]);
    }

   
      public function hydrate()
    {
        $this->emit('tipografia_pdf');
  
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
        $data =  PermisoUsuario::where('empresas_id', '=', $this->empresas_auxiliar)->where('origen', '=', 'sucursal')->where('tipo_permiso', '=', $this->modelId)->orderBy('id', 'asc')->simplePaginate(30);
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
        $this->estaConfiguracion = 'd-none';
    }
    public function cambiarAccesoUsuario()
    {
        $this->estaEnFormulario = 'd-none';
        $this->estaAccesoUsuario = '';
        $this->estaConfiguracion = 'd-none';
    }
    public function cambiarCOnfiguracion()
    {
        $this->estaEnFormulario = 'd-none';
        $this->estaAccesoUsuario = 'd-none';
        $this->estaConfiguracion = '';
    }


    public function rules()
    {
        return [
            'nombre_sucursal' => ['required',  Rule::unique('sucursal_empresas', 'nombre_sucursal')->where(function ($query) {
                return $query->where('empresas_id', '=', $this->empresas_id);
            })->ignore($this->modelId),],
            'direccion' => 'required',
            /*  'encargado' => 'required', */
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
        $this->imagenes_producto = null;

        $this->agregarImagen(Util::getImagenPapelMembretadoDefecto());


        $this->identificador = null;
        $this->nombre_sucursal = null;
        $this->direccion = null;
        $this->celular = null;
        $this->correo_electronico = null;
        $this->colorPdf = "#000000";
        $this->tipografia_pdf = "'Montserrat', sans-serif";
        $this->encargado = null;
        $this->estado = 'Activo';
        $this->estaAccesoUsuario = "d-none";
        $this->estaEnCorrecto = "d-none";
        $this->estaConfiguracion = "d-none";
        $this->estaEnError = "d-none";
        $this->estaEnFormulario = "";
        $this->modelId = null;
    }


    public function cerrarFormulario()
    {
        /* $this->emit('refreshParent');
        $this->dispatchBrowserEvent('closeModal'); */
        return redirect()->route('ver-surcursales-empresa', $this->empresas_id);
    }


    public function guardar()
    {
        $this->validate();


        DB::beginTransaction(); //Iniciamos la reansaccion
        try {
          


            SucursalEmpresa::create($this->modelData());


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
            'nombre_sucursal' => $this->nombre_sucursal,
            'identificador' => "Sucursal: " . $this->nombre_sucursal,
            'direccion' => $this->direccion,
            'celular' => $this->celular,
            'correo_electronico' => $this->correo_electronico,
            'colorPdf' => $this->colorPdf,
            'tipografia_pdf' => $this->tipografia_pdf,
            'encargado' => $this->encargado,
            'users_id' => Auth::user()->id,
            'imagen' => $this->imagenes_producto,
            'empresas_id' => $this->empresas_id,
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

  

            SucursalEmpresa::find($this->modelId)->update($this->modelData());



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
        $data = SucursalEmpresa::find($this->modelId);
        $this->encargado = $data->encargado;
        $this->nombre_sucursal = $data->nombre_sucursal;
        $this->direccion = $data->direccion;
        $this->correo_electronico = $data->correo_electronico;
        $this->colorPdf = $data->colorPdf;
        $this->tipografia_pdf = $data->tipografia_pdf;

        $this->agregarImagen($data->imagen);

        $this->empresas_id = $data->empresas_id;
        $this->estado = $data->estado == 1 ? "Activo" : 'Inactivo';
    }

    public function agregarImagen($ruta)
    {
        $this->imagenes_producto = $ruta;
    }

    ///permiso usuario

    public function guardarUsuarioPermiso()
    {

        //verificamos 

        if ($this->usuarios_id == null) {
            Util::geterrordefine($this, "Falta seleccionar un usuario");
            return;
        }


        DB::beginTransaction(); //Iniciamos la reansaccion
        try {
            $data = [
                'tipo_permiso' => $this->modelId,
                'users_id' => Auth::user()->id,
                'origen' => "sucursal",
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

    ////////////////CONFIGURACION/////////////////
     public function selectorTipografia($ruta)
    {
        $this->tipografia_pdf = $ruta;
    }
    ////////////////CONFIGURACION/////////////////
}
