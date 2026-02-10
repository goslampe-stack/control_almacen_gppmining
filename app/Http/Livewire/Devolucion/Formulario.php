<?php

namespace App\Http\Livewire\Devolucion;

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
        $descripcion, $comentario,
        $estado,
        $orden_de_compras_id, $sucursal_empresas_id,
        $personals_id;
    protected $listeners = ['crear_RP', 'editar_RP', 'selectedPersonalItem', 'selectedArticuloRequerimientItem'];


    public $estaEnArticulosOrdenCompra = 'd-none';
    public $estaEnOrdenCompra = 'd-none';

    public $sucursal_empresas_id_seleccionado = '';

    /* ARTICULO REQUERIMEINTO */
    public $articulos_id, $stock_disnponible_articulo_requerimiento, $codigo, $articulo, $cantidad, $tipoDevolucion,
        $ModeloId, $precio_unitario, $salidaDetalleId, $fecha_devolucion, $numero_requerimiento;


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
            $this->empresas_id = Util::getEmpresasIngresada();
        }
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

    public $tipo_salida_opciones = [
        'Devolución en compras',
        'Devolución en salida'
    ];
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
        return view('livewire.devolucion.formulario', [
      
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
        $data = OrdenDeCompra::where('estado', '=', 1)->orWhere('ingresos_id', '=', $this->ModeloId)->where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)->get();

        return $data;
    }


    public function modelarArticulosRequerimientoPersonal()
    {
        /*  $data = ArticuloRequerimientoPersonal::where('estado', '=', 2)->where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)->get();
         */
        $data = Articulo::where('empresas_id', '=', $this->empresas_id)->where('estado', '=',  '1')->get();


        return $data;
    }


    public function modelarArticuloSalidaDetalle()
    {
        $data = SalidaDetalle::search($this->search, $this->ModeloId)->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')->simplePaginate($this->perPage);

        return $data;
    }


    public function cerrarFormulario()
    {
        /*  $this->emit('refreshParent');
        $this->dispatchBrowserEvent('closeModal');
 */
        return redirect()->route('devolucion');
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
        $this->resetVars_ARP();

        $this->ModeloId = null;
        $this->numero_salida =  Util::formarNumeroRequerimiento($this->obtenerUltimoNumeroRequerimiento_RP());
        $this->dispatchBrowserEvent('openModal');
    }




    public function editar_RP($id)
    {
        $this->resetValidation();
        $this->resetVars_ARP();
        $this->resetearValores_ARP();
        $this->ModeloId = $id;
        $this->loadModal_ARP();
        $this->dispatchBrowserEvent('openModal');
    }





    /* DATOS DE REQUERIMIENTO PERSONAL */




    /* DATOS DE ARTICULO DE REQUERIMEINTO PERSONAL */


    public function resetVars_ARP()
    {
        date_default_timezone_set('America/Lima');

        $this->cantidad = null;
        $this->tipoDevolucion = null;
        $this->articulos_id = null;
        $this->personals_id = null;
        $this->comentario = null;

        $this->fecha_devolucion = Carbon::now();
        $this->stock_disnponible_articulo_requerimiento = null;
        $this->ModeloId = null;
        $this->estaActivadoBotonGuardarSalidaDetalle = 'invisible';
    }


    public function  editar_ARP($id)
    {
        $this->resetValidation();
        $this->resetVars_ARP();
        $this->ModeloId = $id;

        $this->loadModal_ARP();
    }

    public function actualizar()
    {
        $this->validate([
            'articulos_id' => ['required'],
            'comentario' => ['required'],
            'cantidad' => ['required'],
            'tipoDevolucion' => ['required'],
        ]);

        DB::beginTransaction(); //Iniciamos la reansaccion
        try {
            $response = ArticuloDevolucion::find($this->ModeloId)->update($this->modelData_ARP());
            if ($response) {
                $this->resetVars_ARP();
            }


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


    public function guardar()
    {
        $this->validate([
            'cantidad' => ['required'],
            'tipoDevolucion' => ['required'],
            'articulos_id' => ['required'],
            'comentario' => ['required'],
        ]);


        DB::beginTransaction(); //Iniciamos la reansaccion
        try {


            $response = ArticuloDevolucion::create($this->modelData_ARP());

            if ($response) {

                $this->resetVars_ARP();
            }

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

    public function loadModal_ARP()
    {

        $data = ArticuloDevolucion::find($this->ModeloId);

        $this->cantidad = $data->cantidad;
        $this->tipoDevolucion = $data->tipoDevolucion;
        $this->comentario = $data->comentario;
        $this->fecha_devolucion = $data->fecha_devolucion;
        $this->articulos_id = $data->articulos_id;
    }
    public function modelData_ARP()
    {
        return [
            'cantidad' => $this->cantidad,
            'tipoDevolucion' => $this->tipoDevolucion,
            'comentario' => $this->comentario,
            'fecha_devolucion' => $this->fecha_devolucion,
            'personals_id' => $this->personals_id,
            'articulos_id' => $this->articulos_id,
            'users_id' => Auth::user()->id,
            'sucursal_empresas_id' => Util::getSucursalEmpresaIdLocalStorage(),
        ];
    }




    public function eliminar_ARP()
    {

        DB::beginTransaction(); //Iniciamos la reansaccion
        try {
            foreach ($this->selectedArticulosOrdenCompra as $item) {
                $salida = SalidaDetalle::find($item);

                $articulo = ArticuloRequerimientoPersonal::find($salida->articulos_id);
                if ($articulo) {
                    $articulo->cantidad = $articulo->cantidad + $salida->cantidad;
                    $articulo->update();
                }
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







    public function selectedArticuloRequerimientItem($item)
    {
        if ($this->ModeloId != null) {
            $aux = $this->articulos_id;
            $this->articulos_id = $aux;
            Util::geterrordefine($this, "En editar no se puede cambiar el articulo");
            return;
        }
        if ($item) {


            $this->articulos_id = $item;

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
                ->where('articulo_devolucions.articulos_id', '=', $item)
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
}
