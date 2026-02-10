<?php

namespace App\Http\Livewire\Salida;

use App\Models\Articulo;
use App\Models\ArticuloDevolucion;
use App\Models\ArticuloIngreso;
use App\Models\ArticuloOrdenCompra;
use App\Models\ArticuloOrdenDeCompra;
use App\Models\ArticuloRequerimientoPersonal;
use App\Models\ArticuloSolicitudCotizacion;
use App\Models\Ingreso;
use App\Models\OrdenDeCompra;
use App\Models\Personal;
use App\Models\Proveedor;
use App\Models\RequerimientoPersonal;
use App\Models\Salida;
use App\Models\SalidaDetalle;
use App\Models\TipoUnidad;
use App\Models\Transporte;
use App\Models\Util;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use Livewire\WithPagination;

class Formulario extends Component
{

    use WithPagination;
    public $numero_salida,
        $descripcion,
        $estado,
        $orden_de_compras_id, $sucursal_empresas_id, $fecha_salida,
        $personals_id;
    protected $listeners = ['crear_RP', 'editar_RP', 'selectedPersonalItem', 'selectedArticuloRequerimientItem'];
    public $modelId;


    public $estaEnArticulosOrdenCompra = 'd-none';
    public $estaEnOrdenCompra = 'd-none';

    public $sucursal_empresas_id_seleccionado = '';

    /* ARTICULO REQUERIMEINTO */
    public $articulos_id, $stock_disnponible_articulo_requerimiento, $codigo, $articulo, $cantidad,
        $modelArticuloRequemientoId, $precio_unitario, $salidaDetalleId, $fecha_salida_detalle, $numero_requerimiento;


    public $search = '';
    public $perPage = 10;
    public $sortField = 'id';
    public $sortAsc = true;
    public $selectedArticulosRequerimientoPersonal = [];
    public $selectedArticulosOrdenCompra = [];
    public $estaActivadoEliminar = 'disabled';
    public $estaActivadoBotonGuardarSalidaDetalle = 'invisible';
    public $estaActivadoEnviar = 'disabled';
    public $estaActivadorInactivo = 'disabled';
    public $estaActivadorActivo = 'disabled';
    public $filtrarPorEstado = "", $empresas_id;

    public function mount()
    {
        if (!Util::getExisteTiendaSeleccionadaLocalStorage()) {
            return redirect()->route('dashboard');
        } else {
            $this->sucursal_empresas_id_seleccionado = Util::getSucursalEmpresaIdLocalStorage();
        }

        $this->resetVars_RP();
        $this->empresas_id = Util::getEmpresasIngresada();
    }


    public $estado_opciones = [
        'Activo',
        'Inactivo'
    ];



    public function hydrate()
    {
        $this->emit('select2Personal');
        $this->emit('select2ArticuloRequerimient');
    }

    public function selectedPersonalItem($item)
    {
        if ($item) {
            $this->personals_id = $item;
        }
    }


    public function verificarCantidadIngresada()
    {


        if ($this->cantidad == "") {
            $this->estaActivadoBotonGuardarSalidaDetalle = "invisible";
            return;
        }

        if ($this->stock_disnponible_articulo_requerimiento >= $this->cantidad) {

            $this->estaActivadoBotonGuardarSalidaDetalle = "visible";
        } else {

            $this->estaActivadoBotonGuardarSalidaDetalle = "invisible";
        }
    }

    public function cambiarEstaEnOrdenCompra()
    {
        $this->estaEnOrdenCompra = '';
        $this->estaEnArticulosOrdenCompra = 'd-none';
    }

    public function cambiarEstaEnArticulosRequerimientoPersonal()
    {

        $this->estaEnArticulosOrdenCompra = 'd-none';
        $this->estaEnOrdenCompra = 'd-none';
    }
    public function cambiarEstaEnArticulosOrdenCompra()
    {

        $this->estaEnArticulosOrdenCompra = '';
        $this->estaEnOrdenCompra = 'd-none';
    }


    public function render()
    {
        return view('livewire.salida.formulario', [
            'personales' => $this->modelarPersonales(),
            'producto' => $this->modelarArticulosRequerimientoPersonal(),
            'articuloDetalleSalidas' => $this->modelarArticuloSalidaDetalle(),
            'ordenDeCompras' => $this->modelarOrdenDeCompra(),
        ]);
    }


    public function modelarPersonales()
    {
        $data = Personal::where('estado', '=', 1)->where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)->get();
        return $data;
    }
    public function modelarOrdenDeCompra()
    {
        $data = OrdenDeCompra::where('estado', '=', 1)->orWhere('ingresos_id', '=', $this->modelId)->where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)->get();

        return $data;
    }


    public function modelarArticulosRequerimientoPersonal()
    {
          $data = ArticuloRequerimientoPersonal::where('estado', '=', 2)->where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)->get();
         
       /*  $data = Articulo::where('estado', '=', 1)->where('empresas_id', '=', $this->empresas_id)->orderBy('articulo', 'asc')->get();
 */
      
       
        return $data;
    }


    public function modelarArticuloSalidaDetalle()
    {
        $data = SalidaDetalle::search($this->search, $this->modelId)->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')->simplePaginate($this->perPage);

        return $data;
    }


    public function cerrarFormulario()
    {
        /* $this->emit('refreshParent');
        $this->dispatchBrowserEvent('closeModal');
 */
        return redirect()->route('salida');
    }








    /* DATOS DE REQUERIMIENTO PERSONAL */



    public function obtenerUltimoNumeroRequerimiento_RP()
    {
        $response = Salida::where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)->orderby('created_at', 'DESC')->take(1)->first();
        if ($response == null) {
            return 0;
        } else {
            return $response->numero_salida;
        }
    }

    public function crear_RP()
    {

        $this->resetValidation();
        $this->resetVars_RP();
        $this->resetVars_ARP();

        $this->modelId = null;
        $this->numero_salida =  Util::formarNumeroRequerimiento($this->obtenerUltimoNumeroRequerimiento_RP());
        $this->dispatchBrowserEvent('openModal');
    }


    public function guardar_RP()
    {

        $this->validate([

            'numero_salida' => ['required', Rule::unique('salidas', 'numero_salida')->ignore($this->modelId)->where(function ($query) {
                return $query->where('sucursal_empresas_id',  '=', $this->sucursal_empresas_id_seleccionado);
            })],
            'estado' => 'required',
        ]);

        DB::beginTransaction(); //Iniciamos la reansaccion
        try {


            $response = Salida::create($this->modelData_RP());

            if ($response) {

                $this->estaEnOrdenCompra = 'd-none';
                $this->estaEnArticulosOrdenCompra = '';
                $this->modelId = $response->id;
            }

            DB::commit();
            Util::getsuccesscreate($this);
        } catch (\Exception $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        } catch (\Throwable $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        }
    }

    public function modelData_RP()
    {
        return [
            'numero_salida' => $this->numero_salida,

            'descripcion' => $this->descripcion,
            'personals_id' => $this->personals_id,
            'fecha_salida' => $this->fecha_salida,
            'users_id' => Auth::user()->id,
            'estado' => $this->estado == 'Activo' ? 1 : 0,
            'sucursal_empresas_id' => Util::getSucursalEmpresaIdLocalStorage(),
        ];
    }





    public function editar_RP($id)
    {
        $this->resetValidation();
        $this->resetVars_RP();
        $this->resetVars_ARP();
        $this->resetearValores_ARP();
        $this->modelId = $id;
        $this->loadModal_RP();
        $this->dispatchBrowserEvent('openModal');
    }



    public function actualizar_RP()
    {
        $this->validate([
            'numero_salida' => ['required', Rule::unique('salidas', 'numero_salida')->ignore($this->modelId)->where(function ($query) {
                return $query->where('sucursal_empresas_id',  '=', $this->sucursal_empresas_id_seleccionado);
            })],
            'estado' => 'required',
        ]);

        DB::beginTransaction(); //Iniciamos la reansaccion
        try {

            Salida::find($this->modelId)->update($this->modelData_RP());
            DB::commit();
            Util::getsuccessupdate($this);
        } catch (\Exception $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        } catch (\Throwable $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        }
    }


    public function loadModal_RP()
    {

        $data = Salida::find($this->modelId);

        $this->numero_salida = $data->numero_salida;

        $this->descripcion = $data->descripcion;
        $this->orden_de_compras_id = $data->orden_de_compras_id;
        $this->personals_id = $data->personals_id;
        $this->estado = $data->estado == 1 ? "Activo" : 'Inactivo';
    }


    public function resetVars_RP()
    {
        date_default_timezone_set('America/Lima');

        $this->numero_salida = null;

        $this->orden_de_compras_id = null;
        $this->fecha_salida = Carbon::now()->format('Y-m-d H:i:s');
        $this->personals_id = null;
        $this->estado = 'Activo';
        $this->sucursal_empresas_id = null;

        $this->estaEnOrdenCompra = '';
        $this->estaEnArticulosOrdenCompra = 'd-none';

        $this->modelId = null;
    }


    /* DATOS DE REQUERIMIENTO PERSONAL */


    /* DATOS DE ARTICULO DE REQUERIMEINTO PERSONAL */


    public function resetVars_ARP()
    {

        date_default_timezone_set('America/Lima');

        $this->codigo = null;
        $this->articulo = null;
        $this->cantidad = null;
        $this->precio_unitario = null;
        $this->articulos_id = null;
        $this->fecha_salida_detalle = Carbon::now();
        $this->numero_requerimiento = null;




        $this->stock_disnponible_articulo_requerimiento = null;
        $this->modelArticuloRequemientoId = null;
        $this->estaActivadoBotonGuardarSalidaDetalle = 'invisible';
    }


    public function  editar_ARP($id)
    {
        $this->resetValidation();
        $this->resetVars_ARP();
        $this->modelArticuloRequemientoId = $id;

        $this->loadModal_ARP();
    }

    public function actualizar_ARP()
    {
        $this->validate([
            'articulos_id' => ['required'],
            'fecha_salida_detalle' => ['required'],
            'cantidad' => ['required'],
            'articulo' => ['required']
        ]);

        DB::beginTransaction(); //Iniciamos la reansaccion
        try {
            $response = SalidaDetalle::find($this->modelArticuloRequemientoId)->update($this->modelData_ARP());
            if ($response) {
                $this->resetVars_ARP();
            }


            DB::commit();
            Util::getsuccessupdate($this);
        } catch (\Exception $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        } catch (\Throwable $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        }
    }


    public function guardar_ARP()
    {

        $this->validate([
            'cantidad' => ['required'],
            'articulos_id' => ['required'],
            'fecha_salida_detalle' => ['required'],
        ]);


        if ($this->cantidad <= 0) {

            Util::geterrordefine($this, "El articulo no dispone de cantidad disponible");
            return;
        }

        DB::beginTransaction(); //Iniciamos la reansaccion
        /*   try { */

        /* $data = SalidaDetalle::where('articulos_id', '=', $this->articulos_id)->where('salidas_id', '=', $this->modelId)->first();
            if ($data == null) { */
        $response = SalidaDetalle::create($this->modelData_ARP());

        if ($response) {

            $this->resetVars_ARP();
        }
        /*   } else {

                $data->cantidad = $data->cantidad + $this->cantidad;
                $respouesta = $data->update();

                if ($respouesta) {

                    $this->resetVars_ARP();
                }
            } */

        DB::commit();
        Util::getsuccesscreate($this);
        /*   } catch (\Exception $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        } catch (\Throwable $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        } */
    }






    public function selectedArticuloRequerimientItem($item)
    {
        if ($item) {

            $this->articulos_id = $item;
            $this->buscarArticuloRequerimiento();
        } else {
            $this->stock_disnponible_articulo_requerimiento = 0;
        }
    }
    public function buscarArticuloRequerimiento()
    {
        if ($this->articulos_id) {

            $response = ArticuloSolicitudCotizacion::join('sucursal_empresas', 'articulo_solicitud_cotizacions.sucursal_empresas_id', '=', 'sucursal_empresas.id')
                ->join('articulo_requerimiento_compras', 'articulo_solicitud_cotizacions.articuloCompras_id', '=', 'articulo_requerimiento_compras.id')
                ->join('articulo_requerimiento_personals', 'articulo_requerimiento_compras.articulo_r_personals_id', '=', 'articulo_requerimiento_personals.id')
                ->select('articulo_solicitud_cotizacions.*')
                ->where('sucursal_empresas.empresas_id', '=', Util::getTiendaIdLocalStorage())
                ->where('articulo_requerimiento_personals.articulos_id', '=', $this->articulos_id)
                ->get();


            $cantidad = 0;
            foreach ($response as $row) {
                $orden = ArticuloIngreso::join('articulo_orden_compras', 'articulo_ingresos.articulos_orden_id', '=', 'articulo_orden_compras.id')
                    ->select('articulo_ingresos.*')
                    ->where('articulo_orden_compras.articulo_s_cotizacion_id', '=', $row->id)
                    ->get();
                foreach ($orden as $or) {
                    $cantidad = $cantidad + $or->cantidad;
                }
            }


            /* CXontador de devolicones */


            $itemsDevolucion = ArticuloDevolucion::join('sucursal_empresas', 'articulo_devolucions.sucursal_empresas_id', '=', 'sucursal_empresas.id')
                ->select('articulo_devolucions.*')
                ->where('sucursal_empresas.empresas_id', '=', Util::getTiendaIdLocalStorage())
                ->where('articulo_devolucions.articulos_id', '=', $this->articulos_id)
                ->get();

            foreach ($itemsDevolucion as $devolucion) {
                if ($devolucion->tipoDevolucion == "Devolución en salida") {

                    $cantidad = $cantidad + $devolucion->cantidad;
                } else {

                    $cantidad = $cantidad - $devolucion->cantidad;
                }
            }
            /* CXontador de devolicones */




            if ($response) {
                $contador = 0;

                $data = SalidaDetalle::join('sucursal_empresas', 'salida_detalles.sucursal_empresas_id', '=', 'sucursal_empresas.id')
                    ->select('salida_detalles.*')
                    ->where('sucursal_empresas.empresas_id', '=', Util::getTiendaIdLocalStorage())
                    ->where('salida_detalles.articulos_id', '=', $this->articulos_id)
                    ->get();


                foreach ($data as $d) {
                    $contador = $contador + $d->cantidad;
                }



                if ($cantidad >= $contador) {
                    $this->stock_disnponible_articulo_requerimiento = $cantidad - $contador;
                } else {
                    $this->resetearValores_ARP();
                }
            }
        } else {
            $this->stock_disnponible_articulo_requerimiento = 0;
        }
    }





    public function loadModal_ARP()
    {

        $data = SalidaDetalle::find($this->modelArticuloRequemientoId);

        $this->codigo = $data->codigo;
        $this->articulo = $data->articulo;
        $this->cantidad = $data->cantidad;
        $this->fecha_salida_detalle = $data->fecha_salida_detalle;
        $this->precio_unitario = $data->precio_unitario;
        $this->articulos_id = $data->articulos_id;
        $this->numero_requerimiento = $data->numero_requerimiento;
        $this->selectedArticuloRequerimientItem($this->articulos_id);
    }
    public function modelData_ARP()
    {
        return [
            'cantidad' => $this->cantidad,
            'fecha_salida_detalle' => $this->fecha_salida_detalle,
            'numero_requerimiento' => $this->numero_requerimiento,
            'salidas_id' => $this->modelId,
            'articulos_id' => $this->articulos_id,
            'users_id' => Auth::user()->id,
            'sucursal_empresas_id' => Util::getSucursalEmpresaIdLocalStorage(),
        ];
    }


    public function cambiarEstadoBotonesRequerimientoPersonal_ARP()
    {

        if (count($this->selectedArticulosRequerimientoPersonal) > 0) {
            $this->estaActivadoEnviar = 'enabled';
        } else {
            $this->estaActivadoEnviar = 'disabled';
        }
    }

    public function cambiarEstadoBotonesOrdenCompra_ARP()
    {

        if (count($this->selectedArticulosOrdenCompra) > 0) {
            $this->estaActivadoEliminar = 'enabled';
        } else {
            $this->estaActivadoEliminar = 'disabled';
        }
    }

    public function eliminar_ARP()
    {

        DB::beginTransaction(); //Iniciamos la reansaccion
        try {
            foreach ($this->selectedArticulosOrdenCompra as $item) {
                $salida = SalidaDetalle::find($item);

                $salida->delete();
            }


            $this->resetearValores_ARP();
            $this->resetVars_ARP();


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




    public function resetearValores_ARP()
    {
        $this->estaActivadoEliminar = 'disabled';
        $this->estaActivadorInactivo = 'disabled';
        $this->estaActivadorActivo = 'disabled';
        $this->selectedArticulosOrdenCompra = [];
        $this->selectedArticulosRequerimientoPersonal = [];
    }




    public function enviarArticuloRequerimientoParaOrdenCompraItem($id)
    {


        DB::beginTransaction(); //Iniciamos la reansaccion
        try {

            $data = ArticuloRequerimientoPersonal::find($id);
            $data->orden_de_compras_id = $this->modelId;
            $data->estado = 2;
            $response = $data->update();

            if ($response) {
                $this->resetearValores_ARP();
            }

            DB::commit();
            Util::getsuccessupdate($this);
        } catch (\Exception $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        } catch (\Throwable $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        }
    }
    public function enviarArticuloRequerimientoParaOrdenCompra()
    {

        DB::beginTransaction(); //Iniciamos la reansaccion
        try {


            foreach ($this->selectedArticulosRequerimientoPersonal as $id) {
                $data = ArticuloRequerimientoPersonal::find($id);
                $data->orden_de_compras_id = $this->modelId;
                $data->estado = 2;
                $data->update();
            }
            $this->resetearValores_ARP();

            DB::commit();
            Util::getsuccessupdate($this);
        } catch (\Exception $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        } catch (\Throwable $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        }
    }
}
