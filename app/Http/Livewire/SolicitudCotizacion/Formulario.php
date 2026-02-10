<?php

namespace App\Http\Livewire\SolicitudCotizacion;

use App\Models\ArticuloOrdenCompra;
use App\Models\ArticuloRequerimientoCompra;
use App\Models\ArticuloRequerimientoPersonal;
use App\Models\ArticuloSolicitudCotizacion;
use App\Models\OrdenDeCompra;
use App\Models\Personal;
use App\Models\Proveedor;
use App\Models\RequerimientoCompra;
use App\Models\RequerimientoPersonal;
use App\Models\SolicitudCotizacion;
use App\Models\User;
use App\Models\Util;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use Livewire\WithPagination;

class Formulario extends Component
{
    use WithPagination;
    public $numero_solicitud_cotizacion,$numero_cotizacion, $fecha_solicitud, $sucursal_empresas_id, $articuloRequerimientoPersonal, $numero_requerimiento_compras,  $fecha_estimada_pago, $serie_documento, $proveedors_ruc_id, $elaboradoPor_id, $descripcion,$descripcion_solicitamos, $tipo_documento, $numero_documento, $estado, $requerimiento_compras_id, $proveedors_id;
    protected $listeners = ['crear_RP', 'editar_RP', 'selectedProveedorItem', 'selectedElaboradoPorItem', 'selectedProveedorRucItem',  'selectedRequerimientoComprasItem'];
    public $modelId, $UsuarioGeneralIngresado;

    public $serie_guia_remitente, $numero_documento_guia_remitente;


    public $estaEnArticulosOrdenCompraRequerimiento = 'd-none';
    public $estaEnArticulosOrdenCompra = 'd-none';
    public $estaEnOrdenCompra = 'd-none';
    public $estaOcultoFormularioArticuloOrdenCompra = 'd-none';


    public $sucursal_empresas_id_seleccionado = '';

    /* ARTICULO REQUERIMEINTO */
    public  $codigo, $articulo, $cantidad, $modelArticuloRequemientoId, $modelArticuloOrdenCompraId, $precio_unitario;


    public $search = '';
    public $buscarArticuloOrdenCompra = '';
    public $perPage = 80;
    public $perPageArticuloOrdenCompra = 5, $empresas_id;
    public $sortField = 'id';
    public $sortAsc = true;
    public $selectedArticulosRequerimientoPersonal = [];
    public $selectedItemsTable = [];
    public $selectedArticulosOrdenCompra = [];
    public $estaActivadoEliminar = 'disabled';
    public $estaActivadoEnviar = 'disabled';
    public $estaActivadorInactivo = 'disabled';
    public $estaActivadorActivo = 'disabled';
    public $filtrarPorEstado = "";

    public $selectAllArticuloRequerimiento = false;
    public $selectAllArticuloOrdenCompra = false;

    public $totalPrecioOrdenCompraSubGeneral = 0;
    public $totalCantidadOrdenCompraSubGeneralArticuloRequerimiento = 0;
    public $totalCantidadOrdenCompraSubGeneral = 0;
    public $totalCantidadOrdenCompraGeneral = 0;

    public function mount()
    {
        if (!Util::getExisteTiendaSeleccionadaLocalStorage()) {
            return redirect()->route('dashboard');
        } else {
            $this->sucursal_empresas_id_seleccionado = Util::getSucursalEmpresaIdLocalStorage();

            $this->empresas_id = Util::getTiendaIdLocalStorage();
            $this->UsuarioGeneralIngresado = Util::getEmpresasIngresada();
        }
    }



    public function render()
    {
        $arreglo = [
            'proveedores' => $this->modelarProveedores(),
            'personales' => $this->modelarPersonal(),
            'articulosRequerimientoCompras' => $this->modelarArticuloRequerimientoCompras(),
            'articulosGeneralRequerimientoCompra' => $this->modelarArticulosGeneralOrdenCompra(),
            'articuloOrdenCompra' => $this->modelarArticuloSolicitudCotizacion(),
            'modeloRequerimientoCompras' => $this->modelarRequerimientoPersonales(),
        ];
        return view('livewire.solicitud-cotizacion.formulario', $arreglo);
    }

    public function cambiarEstadoBotones()
    {
    }


    public $opciones_perPage = [
        '5',
        '10',
        '50',
        '100',
        '150',
        '200',
        '500',
        '600',
    ];
    public $estado_opciones = [
        'Activo',
        'Inactivo',
        'Terminado',
    ];
    public $tipo_docuento_opciones = [
        'Factura',
        'Boleta'
    ];




    public function hydrate()
    {
        $this->emit('select2Proveedor');
        $this->emit('select2ProveedorRuc');
        $this->emit('select2ElaboradoPor');
        $this->emit('select2RequerimientoPersonal');
    }

    public function selectedProveedorItem($item)
    {
        if ($item) {
            $this->proveedors_id = $item;
            $this->proveedors_ruc_id = $item;
        }
    }
    public function selectedProveedorRucItem($item)
    {
        if ($item) {
            $this->proveedors_ruc_id = $item;
            $this->proveedors_id = $item;
        }
    }
    public function selectedElaboradoPorItem($item)
    {
        if ($item) {
            $this->elaboradoPor_id = $item;
        }
    }
    public function selectedRequerimientoComprasItem($item)
    {

        if ($item) {
            $response = RequerimientoCompra::find($item);

            if ($response != null) {
                $this->requerimiento_compras_id = $item;
            } else {
                return redirect()->route('dashboard');
            }
        }
    }


    public function cambiarEstaEnOrdenCompra()
    {
        $this->estaEnOrdenCompra = '';
        $this->estaEnArticulosOrdenCompra = 'd-none';
        $this->estaEnArticulosOrdenCompraRequerimiento = 'd-none';
    }

    public function cambiarEstaEnArticulosRequerimientoPersonal()
    {

        $this->estaEnArticulosOrdenCompraRequerimiento = '';
        $this->estaEnArticulosOrdenCompra = 'd-none';
        $this->estaEnOrdenCompra = 'd-none';
    }
    public function cambiarEstaEnArticulosOrdenCompra()
    {

        $this->estaEnArticulosOrdenCompra = '';
        $this->estaEnArticulosOrdenCompraRequerimiento = 'd-none';
        $this->estaEnOrdenCompra = 'd-none';
    }




    public function modelarProveedores()
    {

        $data = Proveedor::where('estado', '=', 1)->where('empresas_id', '=', $this->UsuarioGeneralIngresado)->get();
        return $data;
    }
    public function modelarPersonal()
    {
        $data = Personal::where('estado', '=', 1)->where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)->get();
        return $data;
    }
    public function modelarRequerimientoPersonales()
    {
        $data = RequerimientoCompra::join('sucursal_empresas', 'requerimiento_compras.sucursal_empresas_id', '=', 'sucursal_empresas.id')
            ->select('requerimiento_compras.*')
            ->where('sucursal_empresas.empresas_id', '=', $this->empresas_id)
            ->where('requerimiento_compras.estado', '=', '1')
            ->orderBy('requerimiento_compras.numero_requerimiento_compra',  'desc')->get();

        return $data;
    }

    public function modelarArticuloRequerimientoCompras()
    {

        $data = ArticuloRequerimientoCompra::searchRequerimientoCompras($this->requerimiento_compras_id)->orderBy('id', $this->sortAsc ? 'asc' : 'desc')->simplePaginate($this->perPage);

        foreach ($data as $item) {
            $stock_disponible = Util::getStockDisponibleArticulo($item->articuloRequerimiento->articulos_id);
            
            $item->stock_disponible = $stock_disponible;
        }



        return $data;
    }
    public function modelarArticulosGeneralOrdenCompra()
    {

        $data = ArticuloRequerimientoCompra::searchSolicitudCotizacion($this->modelId)->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')->simplePaginate($this->perPageArticuloOrdenCompra);

        $this->totalCantidadOrdenCompraGeneral = 0;
        foreach ($data  as $d) {
            $this->totalCantidadOrdenCompraGeneral = $this->totalCantidadOrdenCompraGeneral + $d->cantidad;
            $stock_disponible = Util::getStockDisponibleArticulo($d->articuloRequerimiento->articulos_id);
            $d->stock_disponible = $stock_disponible;
        }


        return $data;
    }

    public function modelarArticuloSolicitudCotizacion()
    {


        $data = ArticuloSolicitudCotizacion::where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)
            ->where('solicitudCotizacions_id', '=', $this->modelId)
            ->where('articuloCompras_id', '=', $this->modelArticuloRequemientoId)
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->get();



        $this->totalPrecioOrdenCompraSubGeneral = 0;
        $this->totalCantidadOrdenCompraSubGeneral = 0;
        foreach ($data as $d) {
            $this->totalPrecioOrdenCompraSubGeneral = $this->totalPrecioOrdenCompraSubGeneral + ($d->precio_unitario * $d->cantidad);
            $this->totalCantidadOrdenCompraSubGeneral = $this->totalCantidadOrdenCompraSubGeneral + $d->cantidad;
        }
        $this->totalPrecioOrdenCompraSubGeneral = Util::darFormatoMoneda($this->totalPrecioOrdenCompraSubGeneral);

        return $data;
    }





    public function cerrarFormulario()
    {

        return redirect()->route('solicitud-cotizacion');
    }


    /* DATOS DE REQUERIMIENTO PERSONAL */



    public function obtenerUltimoNumeroRequerimiento_RP()
    {
        $response = SolicitudCotizacion::where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)->orderby('created_at', 'DESC')->take(1)->first();
        if ($response == null) {
            return 0;
        } else {
            return $response->numero_solicitud_cotizacion;
        }
    }

    public function crear_RP()
    {

        $this->resetValidation();
        $this->resetVars_RP();
        $this->modelId = null;
        $this->numero_solicitud_cotizacion =  Util::formarNumeroRequerimiento($this->obtenerUltimoNumeroRequerimiento_RP());
        $this->dispatchBrowserEvent('openModal');
    }


    public function guardar_RP()
    {
        
         /* $this->validate([

            'numero_solicitud_cotizacion' => ['required', Rule::unique('solicitud_cotizacions', 'numero_solicitud_cotizacion')->ignore($this->modelId)->where(function ($query) {
                return $query->where('sucursal_empresas_id',  '=', $this->sucursal_empresas_id_seleccionado);
            })],
            'fecha_solicitud' => ['required'],
            'requerimiento_compras_id' => ['required'],
            'proveedors_id' => ['required'],
            'descripcion' => ['required'],
            'estado' => 'required',
        ]);*/


        $this->validate([

            'numero_solicitud_cotizacion' => ['required'],
            'fecha_solicitud' => ['required'],
            'requerimiento_compras_id' => ['required'],
            'proveedors_id' => ['required'],
            'descripcion' => ['required'],
            'descripcion_solicitamos' => ['required'],
            'estado' => 'required',
        ]);



        DB::beginTransaction(); //Iniciamos la reansaccion
        try {

            $response = SolicitudCotizacion::create($this->modelData_RP());

            if ($response) {

                $data = RequerimientoCompra::find($this->requerimiento_compras_id);
                 $data->estado = 2;
                $data->solicitudCotizacion_id = $response->id;
                //significa que ya esta agregado a un orden de pago el requerimiento
                $data->update();

                //cuando se creea por primera vez

                $this->resetValidation();
                $this->resetVars_ARP();
                $this->resetVars_RP();
                $this->resetearValores_ARP();
                $this->modelId = $response->id;
                $this->loadModal_RP();
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
            'numero_solicitud_cotizacion' => $this->numero_solicitud_cotizacion,
            'numero_cotizacion' => $this->numero_cotizacion,
            'fecha_solicitud' => $this->fecha_solicitud,
            'descripcion' => $this->descripcion,
            'personalpdf' => json_encode(Util::getPersonalPdf($this->sucursal_empresas_id_seleccionado,Util::$OPCION_SOLICITUD_DE_COTIZACION)),
            'descripcion_solicitamos' => $this->descripcion_solicitamos,
            'proveedors_id' => $this->proveedors_id,
            'users_id' => Auth::user()->id,
            'requerimiento_compras_id' => $this->requerimiento_compras_id,
            'estado' => $this->getEstadoNumero(),
            'sucursal_empresas_id' => Util::getSucursalEmpresaIdLocalStorage(),
        ];
    }

    public function getEstadoNumero()
    {
        $aux = "1";

        if ($this->estado == 'Activo') {
            $aux = 1;
        } else if ($this->estado == 'Terminado') {

            $aux = 2;
        } else {
            $aux = 0;
        }
        return $aux;
    }


    public function editar_RP($id)
    {

        $this->resetValidation();
        $this->resetVars_ARP();
        $this->resetVars_RP();
        $this->resetearValores_ARP();
        $this->modelId = $id;
        $this->loadModal_RP();

        $this->dispatchBrowserEvent('openModal');
    }



    public function actualizar_RP()
    {
        $this->validate([
            'numero_solicitud_cotizacion' => ['required', Rule::unique('solicitud_cotizacions', 'numero_solicitud_cotizacion')->ignore($this->modelId)->where(function ($query) {
                return $query->where('sucursal_empresas_id',  '=', $this->sucursal_empresas_id_seleccionado);
            })],
            'estado' => 'required',
            'proveedors_id' => 'required',
            'descripcion' => ['required'],
            'descripcion_solicitamos' => ['required'],

        ]);


        DB::beginTransaction(); //Iniciamos la reansaccion
        try {

            SolicitudCotizacion::find($this->modelId)->update($this->modelData_RP());

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

        $data = SolicitudCotizacion::find($this->modelId);

        $this->numero_solicitud_cotizacion = $data->numero_solicitud_cotizacion;
        $this->numero_cotizacion = $data->numero_cotizacion;

        $this->fecha_solicitud = $data->fecha_solicitud;

        $this->proveedors_id = $data->proveedors_id;
        $this->descripcion = $data->descripcion;
        $this->descripcion_solicitamos = $data->descripcion_solicitamos;
        $this->requerimiento_compras_id = $data->requerimiento_compras_id;


        $this->numero_requerimiento_compras = $data->requerimientoCompras->numero_requerimiento_compra;

        if ($data->estado == 1) {
            $this->estado = "Activo";
        } else if ($data->estado == 2) {
            $this->estado = "Terminado";
        } else {
            $this->estado = "Inactivo";
        }
    }



    public function resetVars_RP()
    {

        $this->numero_solicitud_cotizacion = null;
        $this->numero_cotizacion = null;
        $this->fecha_solicitud = Carbon::now()->format('Y-m-d');
        $this->fecha_estimada_pago = null;
        $this->descripcion = null;
        $this->descripcion_solicitamos = null;
        $this->requerimiento_compras_id = null;
        $this->proveedors_id = null;
        $this->proveedors_ruc_id = null;
        $this->elaboradoPor_id = null;
        $this->estado = 'Activo';
        $this->sucursal_empresas_id = null;

        $this->estaEnOrdenCompra = '';
        $this->estaEnArticulosOrdenCompra = 'd-none';
        $this->estaEnArticulosOrdenCompraRequerimiento = 'd-none';



        $this->modelId = null;

        ///obtenemos el ultimos registro de direccion 
        $this->getUltimoSolicitudCotizacion();
    }

    public function getUltimoSolicitudCotizacion()
    {
        
        $data = SolicitudCotizacion::where('sucursal_empresas_id','=',$this->sucursal_empresas_id_seleccionado)->latest()->first();

        if ($data) {

            $this->descripcion = $data->descripcion;
            $this->descripcion_solicitamos = $data->descripcion_solicitamos;
        }
    }

    /* DATOS DE REQUERIMIENTO PERSONAL */




    /* DATOS DE ARTICULO DE REQUERIMEINTO PERSONAL */





    public function nuevoArticuloOrdenCompra()
    {
        try {

            $this->resetVars_ARP();
            $this->estaOcultoFormularioArticuloOrdenCompra = "";
            $data = ArticuloRequerimientoCompra::find($this->modelArticuloRequemientoId);


            $this->totalCantidadOrdenCompraSubGeneralArticuloRequerimiento = $data->cantidad;
            $this->codigo = $data->articuloRequerimiento->articulo->codigo;
            $this->articulo = $data->articuloRequerimiento->articulo->articulo;
            $this->articuloRequerimientoPersonal = $data->id;
            $this->modelArticuloOrdenCompraId = null;
        } catch (Exception $e) {
            Util::geterrorSistem($this);
        }
    }
    public function cancelar_articuloOrdenCompra()
    {
        $this->resetVars_ARP();
        $this->estaOcultoFormularioArticuloOrdenCompra = "d-none";
    }

    public function eliminarArticuloOrdenCompra($id)
    {

        if ($id) {
            ///verificamos si esta en uso en solicitud de cotizacion

            $data = ArticuloOrdenCompra::where('articulo_s_cotizacion_id', '=', $id)->count();

            if ($data > 0) {
                Util::geterrordefine($this, "El artículo esta en uso en orden de compra");
            } else {
                $articulo = ArticuloSolicitudCotizacion::find($id);
                $articulo->delete();
                $this->nuevoArticuloOrdenCompra();
                /* $this->estaOcultoFormularioArticuloOrdenCompra = "d-none"; */
                Util::getsuccessdelete($this);

                $this->editar_ArticuloRequerimiento($this->modelArticuloRequemientoId);
            }
        }
    }





    public function resetVars_ARP()
    {

        $this->codigo = null;
        $this->articulo = null;
        $this->cantidad = null;
        $this->precio_unitario = null;
        $this->modelArticuloOrdenCompraId = null;
        $this->tipo_documento = 'Factura';
        $this->numero_documento = null;
        $this->serie_documento = null;
        $this->serie_guia_remitente = null;
        $this->numero_documento_guia_remitente = null;
    }


    public function  editar_ARP($id)
    {

        $this->resetValidation();
        $this->resetVars_ARP();
        $this->modelArticuloOrdenCompraId = $id;

        $this->loadModal_ARP();
        $this->estaOcultoFormularioArticuloOrdenCompra = "";
    }

    public function  editar_ArticuloRequerimiento($id)
    {

        $this->resetValidation();
        $this->modelArticuloRequemientoId = $id;
        $this->nuevoArticuloOrdenCompra();
    }

    public function actualizar_ARP()
    {
        $this->validate([
            'cantidad' => ['required']

        ]);

        DB::beginTransaction(); //Iniciamos la reansaccion
      /*   try { */

            $articuloRequerimiento = ArticuloRequerimientoCompra::find($this->modelArticuloRequemientoId);

            $articulo = ArticuloSolicitudCotizacion::find($this->modelArticuloOrdenCompraId);
            $ordenCompra = $this->modelarArticuloSolicitudCotizacion();

            $cantidad = 0;

            foreach ($ordenCompra as $ar) {
                $cantidad = $cantidad + $ar->cantidad;
            }
            $cantidad = $cantidad + $this->cantidad;

            if ($articulo) {

                $cantidad = $cantidad - $articulo->cantidad;
            }



            if ($articuloRequerimiento->cantidad >= $cantidad) {

                ArticuloSolicitudCotizacion::find($this->modelArticuloOrdenCompraId)->update($this->modelData_ARP());
                $this->resetVars_ARP();


                DB::commit();
                Util::getsuccessupdate($this);
                /*  $this->estaOcultoFormularioArticuloOrdenCompra = "d-none"; */
                $this->editar_ArticuloRequerimiento($this->modelArticuloRequemientoId);
            } else {
                Util::getwarningdefine($this, "La cantidad ingresada supera la cantidad de requerimiento");
            }
        /* } catch (\Exception $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        } catch (\Throwable $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        } */
    }


    public function guardar_ArticuloordenCompra()
    {
        $this->validate([
            'cantidad' => ['required'],
        ]);

        DB::beginTransaction(); //Iniciamos la reansaccion
        try {

            $articuloRequerimiento = ArticuloRequerimientoCompra::find($this->modelArticuloRequemientoId);

            $ordenCompra = $this->modelarArticuloSolicitudCotizacion();

            $cantidad = 0;

            foreach ($ordenCompra as $ar) {
                $cantidad = $cantidad + $ar->cantidad;
            }
            $cantidad = $cantidad + $this->cantidad;

            if ($articuloRequerimiento->cantidad >= $cantidad) {

                ArticuloSolicitudCotizacion::create($this->modelData_ARP());


                DB::commit();
                $this->nuevoArticuloOrdenCompra();
                Util::getsuccesscreate($this);
                /*  $this->estaOcultoFormularioArticuloOrdenCompra = "d-none"; */
                $this->editar_ArticuloRequerimiento($this->modelArticuloRequemientoId);
            } else {
                Util::getwarningdefine($this, "La cantidad ingresada supera la cantidad de requerimiento");
            }
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

        $data = ArticuloSolicitudCotizacion::find($this->modelArticuloOrdenCompraId);

        /*    $this->codigo = $data->articuloRequerimiento->articulo->codigo;
        $this->articulo = $data->articuloRequerimiento->articulo->articulo; */
        $this->cantidad = $data->cantidad;
    }
    public function modelData_ARP()
    {

        return [
            'cantidad' => $this->cantidad,
            'users_id' => Auth::user()->id,
            'solicitudCotizacions_id' => $this->modelId,
            'articuloCompras_id' => $this->modelArticuloRequemientoId,
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
                $dataAux = ArticuloSolicitudCotizacion::where('articuloCompras_id', '=', $item)->count();

                if ($dataAux > 0) {
                    Util::geterrordefine($this, "Debe eliminar los articulos de cotización.");
                } else {

                    $data = ArticuloRequerimientoCompra::find($item);
                    $data->estado = 1;
                    $data->solicitudCotizacion_id = null;
                    $data->update();
                    Util::getsuccessdelete($this);
                }
            }
            $this->selectAllArticuloOrdenCompra = false;
            $this->resetearValores_ARP();
            $this->resetVars_ARP();
            $this->cancelar_articuloOrdenCompra();

            DB::commit();
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
        $this->estaActivadoEnviar = 'disabled';
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

            $data = ArticuloRequerimientoCompra::find($id);
            $data->solicitudCotizacion_id = $this->modelId;
            $data->estado = 2;
            $data->update();

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


    public function enviarArticuloRequerimientoParaOrdenCompra()
    {
        DB::beginTransaction(); //Iniciamos la reansaccion
        try {

            foreach ($this->selectedArticulosRequerimientoPersonal as $id) {
                $data = ArticuloRequerimientoCompra::find($id);
                $data->solicitudCotizacion_id = $this->modelId;
                $data->estado = 2;
                $data->update();
            }
            $this->selectAllArticuloRequerimiento = false;
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


    public function updatedSelectAllArticuloRequerimiento($value)
    {

        if ($value) {
       

            $this->selectedArticulosRequerimientoPersonal = ArticuloRequerimientoCompra::where('requerimientoCompras_id', '=', $this->requerimiento_compras_id)->where('estado', '=', 1)->pluck('id');


            $this->estaActivadoEnviar = 'enabled';
        } else {
            $this->selectedArticulosRequerimientoPersonal = [];
            $this->estaActivadoEnviar = 'disabled';
        }
    }

    public function updatedSelectAllArticuloOrdenCompra($value)
    {

        if ($value) {
           
           
            $this->selectedArticulosOrdenCompra = ArticuloRequerimientoCompra::where('solicitudCotizacion_id', '=', $this->modelId)->pluck('id');

            $this->estaActivadoEliminar = 'enabled';
        } else {
            $this->selectedArticulosOrdenCompra = [];
            $this->estaActivadoEliminar = 'disabled';
        }
    }

    /* DATOS DE ARTICULO DE REQUERIMEINTO PERSONAL */
}
