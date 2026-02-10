<?php

namespace App\Http\Livewire\SalidaDetallada;

use App\Models\Articulo;
use App\Models\ArticuloOrdenCompra;
use App\Models\ArticuloRequerimientoPersonal;
use App\Models\RequerimientoPersonal;
use App\Models\TipoUnidad;
use App\Models\Util;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class Formulario extends Component
{
    public $codigo, $articulo, $tipo_unidads_id, $stock_disponible, $articulos_id, $saldo, $fecha_ingreso, $estado, $tiendas_id, $fecha_salida, $cantidad_salida;

    protected $listeners = ['crear', 'editar', 'selectedTipoUnidadItem'];
    public $modelId;


    public $estaEnProcesando = "d-none";
    public $estaEnCorrecto = "d-none";
    public $estaEnError = "d-none";
    public $estaEnFormulario = "d-none";
    public $sucursal_empresas_id_seleccionado;

    public $estaActivadoBotonGuardarSalidaDetalle = 'invisible';



    public $estado_opciones = [
        'Activo',
        'Inactivo'
    ];

    public function mount()
    {

        $this->sucursal_empresas_id_seleccionado = Util::getSucursalEmpresaIdLocalStorage();
    }


    public function render()
    {
        return view('livewire.salida-detallada.formulario');
    }







    public function rules()
    {
        return [
            'articulo' => ['required'],
            'cantidad_salida' => ['required'],
            'fecha_salida' => 'required',
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

        $this->cantidad_salida = null;
        $this->articulo = null;
        $this->cantidad = null;
        $this->estado = 'Activo';
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
        try {
            ArticuloOrdenCompra::create($this->modelData());
            $this->estaEnProcesando = "d-none";
            $this->estaEnCorrecto = "";
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
            'cantidad_salida' => $this->cantidad_salida,
            'fecha_salida' => $this->fecha_salida,
            'fecha_ingreso' => $this->fecha_ingreso,

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
            ArticuloOrdenCompra::find($this->modelId)->update($this->modelData());




            DB::commit();
            Util::getsuccessupdate($this);
            $this->cerrarFormulario();
        } catch (\Exception $e) {
            Util::geterrorSistem($this);
            $this->estaEnError = "";

            DB::rollback();
        } catch (\Throwable $e) {
            Util::geterrorSistem($this);
            $this->estaEnError = "";

            DB::rollback();
        }
    }


    public function loadModel()
    {
        $data = ArticuloOrdenCompra::find($this->modelId);




        $articuloRequerimiento = ArticuloRequerimientoPersonal::find($data->articulo_r_personals_id);
        $this->articulos_id = $articuloRequerimiento->articulos_id;
        $articulo = Articulo::find($articuloRequerimiento->articulos_id);
        $this->cantidad_salida = $data->cantidad_salida;
        $this->articulo = $articulo->articulo;
        /*  $this->articulo = $data->articulo; */
        $fecha = Carbon::parse($data->fecha_ingreso)->format('Y-m-d');
        $hora = Carbon::parse($data->fecha_ingreso)->format('H:i');

        $formateado = $fecha . "T" . $hora;

        $this->fecha_salida = $data->fecha_salida;
        $this->fecha_ingreso = $formateado;
        $this->obtenerStockDisponible();
        $this->verificarCantidadIngresada();
    }


    public function obtenerStockDisponible()
    {


        $response = ArticuloRequerimientoPersonal::where('articulos_id', '=', $this->articulos_id)->where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)->get();


        $cantidad = 0;
        $cantidad_salida = 0;
        foreach ($response as $row) {
            $orden = ArticuloOrdenCompra::where('articulo_r_personals_id', '=', $row->id)->where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)->get();


            foreach ($orden as $or) {
                if ($or->cantidad_salida > 0) {
                    try {
                        $cantidad_salida = Util::verificarNumero($cantidad_salida) + Util::verificarNumero($or->cantidad_salida);
                    } catch (Exception $e) {
                        $cantidad_salida = $cantidad_salida;
                    }
                }
                $cantidad = $cantidad + $or->cantidad;
            }
        }


        $total = $cantidad - $cantidad_salida;

        $this->stock_disponible = $total;
    }

    public function verificarCantidadIngresada()
    {


        if ($this->cantidad_salida == "") {
            $this->estaActivadoBotonGuardarSalidaDetalle = "invisible";
            return;
        }

        if ($this->stock_disponible >= $this->cantidad_salida) {
            $this->estaActivadoBotonGuardarSalidaDetalle = "visible";
        } else {

            $this->estaActivadoBotonGuardarSalidaDetalle = "invisible";
        }
    }
}
