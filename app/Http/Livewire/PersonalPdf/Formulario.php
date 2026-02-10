<?php

namespace App\Http\Livewire\PersonalPdf;

use App\Models\Personal;
use App\Models\PersonalPdf;
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
        $tipo_opcion,
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
    public $modelId;


    public $estaEnProcesando = "d-none";
    public $estaEnCorrecto = "d-none";
    public $estaEnError = "d-none";
    public $estaEnFormulario = "d-none";

    public $tipo_opcion_opciones = [
        'Requerimiento interno de productos',
        'Orden de compra ',
        'Ingreso',
        'Requerimiento de compras',
        'Solicitud de cotización',
        'Salida',
        'Kardex'
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
        'Requerimiento de compras',
        'Solicitud de cotización',
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
        return view('livewire.personal-pdf.formulario', ['tipoPersonales' => $this->modelarPersonal()]);
    }

    public function modelarPersonal()
    {
        return Personal::where('estado', '=', 1)->where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)->get();
    }



    public function rules()
    {
        return [
            'tipo_opcion' => ['required'],
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

        $this->tipo_opcion = null;
        $this->personals_id = null;
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
      /*   $this->emit('refreshParent');
        $this->dispatchBrowserEvent('closeModal'); */

        return redirect()->route('personal-pdf');

    }


    public function guardar()
    {
        $this->validate();
        //verificamos 

        $personalPdf = PersonalPdf::where('estado', '=', 1)->where('personals_id', '=', $this->personals_id)->get();
        $resultado = false;
        foreach ($personalPdf as $item) {
            if ($item->tipo_opcion == $this->tipo_opcion) {
                $resultado = true;
                break;
            }
        }
        if ($resultado == true) {
            Util::geterrordefine($this, "El tipo opción ya se encuentra registrado con el personal");
            return;
        }
        
        DB::beginTransaction(); //Iniciamos la reansaccion

        try {
            PersonalPdf::create($this->modelData());


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
            'tipo_opcion' => $this->tipo_opcion,
            'users_id' => Auth::user()->id,
            'personals_id' => $this->personals_id,
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
            PersonalPdf::find($this->modelId)->update($this->modelData());


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

        $data = PersonalPdf::find($this->modelId);


        $this->tipo_opcion = $data->tipo_opcion;
        $this->personals_id = $data->personals_id;
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
