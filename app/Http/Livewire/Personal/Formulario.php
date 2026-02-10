<?php

namespace App\Http\Livewire\Personal;

use App\Models\Personal;
use App\Models\TipoPersonal;
use App\Models\Util;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Validation\Rule;

class Formulario extends Component
{
    public $nombre,
        $apellidos,
        $tipo_documento,
        $numero_documento,
        $correo_electronico,
        $celular,
        $direccion,
        $referencia,
        $genero,
        $tipoPersonals_Id,
        $fecha_nacimiento,
        $imagen,
        $estado,
        $sucursal_empresas_id;
    protected $listeners = ['crear', 'editar','selectedTipoPersonalItem'];
    public $modelId;


    public $estaEnProcesando = "d-none";
    public $estaEnCorrecto = "d-none";
    public $estaEnError = "d-none";
    public $estaEnFormulario = "d-none";

    public $tipo_documento_opciones = [
        'DNI',
        'CARNET EXTR',
        'RUC',
        'PASAPORTE'
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
    public $cargo_opciones = [
        'Jefe de producción',
        'Jefe de logistica',
        'Almacenero',
        'Gerente general',
        'Otros',
    ];

    public $sucursal_empresas_id_seleccionado = '';

    
    public function hydrate()
    {
        $this->emit('select2TipoPersonal');
    }

    public function mount()
    {
        $this->sucursal_empresas_id_seleccionado = Util::getSucursalEmpresaIdLocalStorage();
    }

    public function render()
    {
        return view('livewire.personal.formulario',['tipoPersonales'=>$this->modelarTipoPersonal()]);
    }

    public function modelarTipoPersonal(){
        return TipoPersonal::where('estado','=',1)->where('sucursal_empresas_id','=',$this->sucursal_empresas_id_seleccionado)->get();
    }



    public function rules()
    {
        return [
            'nombre' => ['required'],
            'apellidos' => ['required'],
            'tipo_documento' => ['required'],
            'numero_documento' => ['required'],

            'genero' => ['required'],
            'tipoPersonals_Id' => ['required'],
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

        $this->nombre = null;
        $this->apellidos = null;
        $this->tipo_documento = null;
        $this->numero_documento = null;
        $this->correo_electronico = null;
        $this->celular = null;
        $this->direccion = null;
        $this->referencia = null;
        $this->genero = null;
        $this->tipoPersonals_Id = null;
        $this->fecha_nacimiento = null;
        $this->imagen = Util::getImagenFirmaDigitalDefecto();
        $this->estado = 'Activo';
        $this->sucursal_empresas_id = null;
        $this->estaEnProcesando = "d-none";
        $this->estaEnCorrecto = "d-none";
        $this->estaEnError = "d-none";
        $this->estaEnFormulario = "";
        $this->modelId = null;
    }

    public function cerrarFormulario()
    {
        /* $this->emit('refreshParent');
        $this->dispatchBrowserEvent('closeModal'); */
        return redirect()->route('personal');

    }


    public function guardar()
    {
        $this->validate();


        DB::beginTransaction(); //Iniciamos la reansaccion
        try {
            Personal::create($this->modelData());


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
            'nombre' => $this->nombre,
            'apellidos' => $this->apellidos,
            'tipo_documento' => $this->tipo_documento,
            'numero_documento' => $this->numero_documento,
            'correo_electronico' => $this->correo_electronico,
            'celular' => $this->celular,
            'direccion' => $this->direccion,
            'imagen' => $this->imagen,
            'referencia' => $this->referencia,
            'users_id' => Auth::user()->id,
            'genero' => $this->genero,
            'tipoPersonals_Id' => $this->tipoPersonals_Id,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'estado' => $this->estado == 'Activo' ? 1 : 0,
            'sucursal_empresas_id' => Util::getSucursalEmpresaIdLocalStorage(),
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
            Personal::find($this->modelId)->update($this->modelData());


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


    public function loadModel()
    {

        $data = Personal::find($this->modelId);


        $this->nombre = $data->nombre;
        $this->apellidos = $data->apellidos;
        $this->tipo_documento = $data->tipo_documento;
        $this->numero_documento = $data->numero_documento;
        $this->correo_electronico = $data->correo_electronico;
        $this->celular = $data->celular;
        $this->direccion = $data->direccion;
        $this->referencia = $data->referencia;
        $this->genero = $data->genero;
        $this->tipoPersonals_Id = $data->tipoPersonals_Id;
        $this->imagen = $data->imagen;
        $this->fecha_nacimiento = $data->fecha_nacimiento;
        $this->estado = $data->estado == 1 ? "Activo" : 'Inactivo';
    }

    public function agregarImagen($ruta)
    {

    
        $this->imagen = $ruta;
    }


    public function selectedTipoPersonalItem($item)
    {
        if ($item) {
            $this->tipoPersonals_Id = $item;
        }
    }
}
