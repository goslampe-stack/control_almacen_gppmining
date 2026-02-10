<?php

namespace App\Http\Livewire\PermisoUsuario;

use App\Models\PermisoUsuario;
use App\Models\Personal;
use App\Models\PersonalPdf;
use App\Models\TipoPersonal;
use App\Models\User;
use App\Models\Util;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Validation\Rule;

class Formulario extends Component
{

    public $nombre,
        $apellidos,
        $tipo_permiso,
        $numero_documento,
        $correo_electronico,
        $celular,
        $direccion,
        $referencia,
        $genero,
        $personals_id,
        $fecha_nacimiento,
        $imagen,
        $estado,
        $sucursal_empresas_id;
    protected $listeners = ['crear', 'editar', 'selectedTipoPersonalItem'];
    public $modelId, $listaTipoPermiso = [];





    public $estaEnFormulario = "d-none";

    public $tipo_permiso_opciones = [

        'Unidad de medida' =>  'Unidad de medida (General)',
        'Artículo' => 'Artículo (General)',
        'Proveedor' => 'Proveedor (General)',
        'Usuarios' => 'Usuarios (General)',
        'Transporte' => 'Transporte (General)',
        '' => '',
        'Requerimiento interno de productos'
        => 'Requerimiento interno de productos (Sucursal)',
        'Requerimiento de compras' => 'Requerimiento de compras (Sucursal)',
        'Solicitud de cotización' =>  'Solicitud de cotización (Sucursal)',
        'Orden de compra ' => 'Orden de compra (Sucursal)',
        'Ingreso' => 'Ingreso (Sucursal)',
        'Salida' => 'Salida (Sucursal)',
        'Devolución' => 'Devolución (Sucursal)',
        'Kardex' => 'Kardex (Sucursal)',
        'Tipo personal' => 'Tipo personal (Sucursal)',
        'Personal' => 'Personal (Sucursal)',
        'Personal y pdf' => 'Personal y pdf (Sucursal)',
    ];

    public $estado_opciones = [
        'Activo',
        'Inactivo'
    ];
    public $genero_opciones = [
        'Masculino',
        'Femenino',
        'Otro',
    ];

    public $empresas_id = '';


    public function hydrate()
    {
        $this->emit('select2TipoPersonal');
    }

    public function mount()
    {
        $this->empresas_id = Util::getEmpresasIngresada();
    }

    public function render()
    {
        return view('livewire.permiso-usuario.formulario', ['tipoPersonales' => $this->modelarPersonal(), 'data' => $this->modelarPermisoUsuario(), 'modelarTipoPermiso' => $this->modelarTipoPermiso(),]);
    }

    public function modelarPersonal()
    {


        return User::where('empresas_id', '=', $this->empresas_id)->where('tipoUsuario', '!=', 'Usuario')->get();
    }
    public function modelarTipoPermiso()
    {

        $data = [];
        $data = $this->tipo_permiso_opciones;

        foreach ($this->tipo_permiso_opciones as $index => $item) {
            $encontrado = false;
            foreach ($this->listaTipoPermiso as $itemAux) {
                if ($index == $itemAux) {
                    $encontrado = true;
                }
            }

            ///verifcamos si se encontro 

            if ($encontrado == true) {
                unset($data[$index]);
            }
        }

        return $data;
    }
    public function modelarPermisoUsuario()
    {
        $data =
            PermisoUsuario::where('empresas_id', '=', $this->empresas_id)->where('origen', '=', 'usuario')->where('personals_id', '=', $this->personals_id)->orderBy('id', 'asc')->simplePaginate(30);
        $this->listaTipoPermiso = [];

        foreach ($data as $item) {
            $this->listaTipoPermiso[] = $item->tipo_permiso;
        }



        return $data;
    }





    public function rules()
    {
        return [
            'tipo_permiso' => ['required'],
            'personals_id' => ['required'],
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

        $this->tipo_permiso = null;
        $this->estado = 'Activo';
        $this->estaEnFormulario = "";
        $this->modelId = null;
    }

    public function cerrarFormulario()
    {
        /*   $this->emit('refreshParent');
        $this->dispatchBrowserEvent('closeModal'); */

        return redirect()->route('permiso-usuario');
    }


    public function guardar()
    {
        $this->validate();
        //verificamos 

        $personalPdf = PermisoUsuario::where('estado', '=', 1)->where('personals_id', '=', $this->personals_id)->get();
        $resultado = false;
        foreach ($personalPdf as $item) {
            if ($item->tipo_permiso == $this->tipo_permiso) {
                $resultado = true;
                break;
            }
        }
        if ($resultado == true) {
            Util::geterrordefine($this, "El tipo permiso ya se encuentra registrado con el usuario");
            return;
        }

        DB::beginTransaction(); //Iniciamos la reansaccion

        try {
            PermisoUsuario::create($this->modelData());


            DB::commit();
            Util::getsuccesscreate($this);
            $this->resetVars();
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
            'tipo_permiso' => $this->tipo_permiso,
            'users_id' => Auth::user()->id,
            'personals_id' => $this->personals_id,
            'estado' => $this->estado == 'Activo' ? 1 : 0,
            'empresas_id' => Util::getEmpresasIngresada(),
        ];
    }


    public function editar($id)
    {
        $this->resetValidation();
        $this->resetVars();
        $this->personals_id = $id;

        $this->dispatchBrowserEvent('openModal');
    }

    public function actualizar()
    {
        $this->validate();

        DB::beginTransaction(); //Iniciamos la reansaccion
        try {
            PermisoUsuario::find($this->modelId)->update($this->modelData());


            DB::commit();
            Util::getsuccesscreate($this);
            $this->resetVars();
        } catch (\Exception $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        } catch (\Throwable $e) {
            Util::geterrorSistem($this);
            DB::rollback();
        }
    }
    public function eliminarPermiso($id)
    {

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
    public function editarPermiso($id)
    {


        $this->modelId = $id;

        $this->loadModel();
    }


    public function loadModel()
    {

        $data = PermisoUsuario::find($this->modelId);


        $this->tipo_permiso = $data->tipo_permiso;
        $this->estado = $data->estado == 1 ? "Activo" : 'Inactivo';
    }

    public function agregarImagen($ruta)
    {


        $this->imagen = $ruta;
    }


    public function selectedTipoPersonalItem($item)
    {
        if ($item) {
            $this->personals_id = $item;
        }
    }
}
