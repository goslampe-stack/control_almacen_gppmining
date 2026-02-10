<?php

namespace App\Http\Livewire\OrdenCompra;

use App\Models\ArticuloIngreso;
use App\Models\ArticuloOrdenCompra;
use App\Models\ArticuloSolicitudCotizacion;
use App\Models\OrdenDeCompra;
use App\Models\Personal;
use App\Models\PersonalPdf;
use App\Models\Proveedor;
use App\Models\RequerimientoPersonal;
use App\Models\SolicitudCotizacion;
use App\Models\Util;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use Livewire\WithPagination;


class Formularios extends Component
{
    use WithPagination;
    public $numero_orden_compra, $fecha_pedido, $sucursal_empresas_id, $articuloRequerimientoPersonal, $numero_requerimiento_personal,  $fecha_estimada_pago, $serie_documento, $proveedors_ruc_id, $elaboradoPor_id, $terminos_de_entrega, $tipo_documento, $numero_documento, $estado, $solicitud_cotizacions_id, $proveedors_id, $descripcion_solicitamos;
    protected $listeners = ['crear_RP', 'editar_RP', 'selectedProveedorItem', 'selectedElaboradoPorItem', 'selectedProveedorRucItem',  'selectedRequerimientoPersonalItem'];
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
            'articuloRequerimientosPersonal' => $this->modelarArticuloRequerimientoPersonal(),
            'articuloGeneralOrdenCompra' => $this->modelarArticulosGeneralOrdenCompra(),
            'articuloOrdenCompra' => $this->modelarArticulosOrdenCompra(),
            'dataSolicitudCotizacion' => $this->modelarSolicitudCotizacion(),
            'costoTotalArticulosOrdenCompra' => $this->calcularCostoTotalArticulosOrdenCompra(),
        ];
        return view('livewire.orden-compra.formularios', $arreglo);
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
    public function selectedRequerimientoPersonalItem($item)
    {

        if ($item) {
            $response = SolicitudCotizacion::find($item);

            if ($response != null) {
                $this->fecha_pedido = $response->fecha_solicitud;
                $this->solicitud_cotizacions_id = $item;
                $this->proveedors_id = $response->proveedors_id;
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
    public function modelarSolicitudCotizacion()
    {
        $data = SolicitudCotizacion::join('sucursal_empresas', 'solicitud_cotizacions.sucursal_empresas_id', '=', 'sucursal_empresas.id')
            ->select('solicitud_cotizacions.*')
            ->where('sucursal_empresas.empresas_id', '=', $this->empresas_id)
            ->where('solicitud_cotizacions.estado', '=', '1')
            ->orderBy('solicitud_cotizacions.numero_solicitud_cotizacion',  'desc')->get();

        return $data;
    }

    public function modelarArticuloRequerimientoPersonal()
    {
        $data = ArticuloSolicitudCotizacion::searchSolicitudCotizacion($this->solicitud_cotizacions_id)->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')->simplePaginate($this->perPage);
        foreach ($data as $item) {
            $stock_disponible = Util::getStockDisponibleArticulo($item->articuloOrdenCompra->articuloRequerimiento->articulos_id);
            $item->stock_disponible = $stock_disponible;
        }
        return $data;
    }
    public function modelarArticulosGeneralOrdenCompra()
    {

        $data = ArticuloSolicitudCotizacion::searchOrdenCompra($this->buscarArticuloOrdenCompra, $this->modelId, $this->sucursal_empresas_id_seleccionado)->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')->simplePaginate($this->perPageArticuloOrdenCompra);

        $this->totalCantidadOrdenCompraGeneral = 0;
        foreach ($data  as $d) {
            $this->totalCantidadOrdenCompraGeneral = $this->totalCantidadOrdenCompraGeneral + $d->cantidad;
            $stock_disponible = Util::getStockDisponibleArticulo($d->articuloOrdenCompra->articuloRequerimiento->articulos_id);
            $d->stock_disponible = $stock_disponible;
        }
        return $data;
    }

    public function modelarArticulosOrdenCompra()
    {

        $data = ArticuloOrdenCompra::where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)
            ->where('orden_de_compras_id', '=', $this->modelId)
            ->where('articulo_s_cotizacion_id', '=', $this->modelArticuloRequemientoId)
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

    public function calcularCostoTotalArticulosOrdenCompra()
    {
        $data = ArticuloSolicitudCotizacion::where('orden_de_compras_id', '=', $this->modelId)->where('estado', '=', 2)->get();
        $response = 0.0;
        foreach ($data as $item) {
            $response = $response + ($item->precio_unitario * $item->cantidad);
        }

        return Util::darFormatoMoneda($response);
    }



    public function cerrarFormulario()
    {
        /* $this->emit('refreshParent');
        $this->dispatchBrowserEvent('closeModal');
 */
        return redirect()->route('orden-compra');
    }


    /* DATOS DE REQUERIMIENTO PERSONAL */



    public function obtenerUltimoNumeroRequerimiento_RP()
    {
        $response = OrdenDeCompra::where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)->orderby('created_at', 'DESC')->take(1)->first();
        if ($response == null) {
            return 0;
        } else {
            return $response->numero_orden_compra;
        }
    }

    public function crear_RP()
    {

        $this->resetValidation();
        $this->resetVars_RP();
        $this->modelId = null;
        $this->numero_orden_compra =  Util::formarNumeroRequerimiento($this->obtenerUltimoNumeroRequerimiento_RP());
        $this->dispatchBrowserEvent('openModal');
    }


    public function guardar_RP()
    {
        /*  $this->validate([

            'numero_orden_compra' => ['required', Rule::unique('orden_de_compras', 'numero_orden_compra')->ignore($this->modelId)->where(function ($query) {
                return $query->where('sucursal_empresas_id',  '=', $this->sucursal_empresas_id_seleccionado);
            })],
            'proveedors_id' => ['required'],
            'fecha_pedido' => ['required'],
            'solicitud_cotizacions_id' => ['required'],
            'estado' => 'required',
        ]);*/

        $this->validate([

            'numero_orden_compra' => ['required'],
            'proveedors_id' => ['required'],
            'fecha_pedido' => ['required'],
            'solicitud_cotizacions_id' => ['required'],
            'estado' => 'required',
        ]);


        DB::beginTransaction(); //Iniciamos la reansaccion
        try {

            $response = OrdenDeCompra::create($this->modelData_RP());

            if ($response) {

                $data = SolicitudCotizacion::find($this->solicitud_cotizacions_id);
                $data->estado = 2;
                $data->orden_de_compras_id = $response->id;
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
            'numero_orden_compra' => $this->numero_orden_compra,
            'fecha_pedido' => $this->fecha_pedido,
            'fecha_estimada_pago' => $this->fecha_estimada_pago,
            'personalpdf' => json_encode(Util::getPersonalPdf($this->sucursal_empresas_id_seleccionado,Util::$OPCION_ORDEN_COMPRA)),
            'elaboradoPor_id' => $this->elaboradoPor_id,
            'terminos_de_entrega' => $this->terminos_de_entrega,
            'descripcion_solicitamos' => $this->descripcion_solicitamos,
            'users_id' => Auth::user()->id,
            'numero_documento' => $this->numero_documento,
            'solicitud_cotizacions_id' => $this->solicitud_cotizacions_id,
            'proveedors_id' => $this->proveedors_id,
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
            'numero_orden_compra' => ['required', Rule::unique('orden_de_compras', 'numero_orden_compra')->ignore($this->modelId)->where(function ($query) {
                return $query->where('sucursal_empresas_id',  '=', $this->sucursal_empresas_id_seleccionado);
            })],
            'proveedors_id' => ['required'],
            'fecha_pedido' => ['required'],
            'estado' => 'required',
        ]);


        DB::beginTransaction(); //Iniciamos la reansaccion
        try {
     

            OrdenDeCompra::find($this->modelId)->update($this->modelData_RP());

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

        $data = OrdenDeCompra::find($this->modelId);

        $this->numero_orden_compra = $data->numero_orden_compra;

        $this->fecha_estimada_pago = $data->fecha_estimada_pago;

        $this->terminos_de_entrega = $data->terminos_de_entrega;
        $this->descripcion_solicitamos = $data->descripcion_solicitamos;
        $this->solicitud_cotizacions_id = $data->solicitud_cotizacions_id;
        $this->selectedRequerimientoPersonalItem($this->solicitud_cotizacions_id);

        $this->proveedors_id = $data->proveedors_id;
        $this->proveedors_ruc_id = $data->proveedors_id;
        $this->elaboradoPor_id = $data->elaboradoPor_id;


        $this->numero_requerimiento_personal = $data->solicitudCotizacion->numero_solicitud_cotizacion;

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

        $this->numero_orden_compra = null;
        $this->fecha_pedido = null;
        $this->fecha_estimada_pago = null;
        $this->terminos_de_entrega = null;
        $this->descripcion_solicitamos = null;
        $this->solicitud_cotizacions_id = null;
        $this->proveedors_id = null;
        $this->proveedors_ruc_id = null;
        $this->elaboradoPor_id = null;
        $this->estado = 'Activo';
        $this->sucursal_empresas_id = null;

        $this->estaEnOrdenCompra = '';
        $this->estaEnArticulosOrdenCompra = 'd-none';
        $this->estaEnArticulosOrdenCompraRequerimiento = 'd-none';



        $this->modelId = null;
    }


    /* DATOS DE REQUERIMIENTO PERSONAL */




    /* DATOS DE ARTICULO DE REQUERIMEINTO PERSONAL */





    public function nuevoArticuloOrdenCompra()
    {
        $this->resetVars_ARP();
        $this->estaOcultoFormularioArticuloOrdenCompra = "";
        $data = ArticuloSolicitudCotizacion::find($this->modelArticuloRequemientoId);
        $this->totalCantidadOrdenCompraSubGeneralArticuloRequerimiento = $data->cantidad;
        $this->articuloRequerimientoPersonal = $data->id;
        $this->modelArticuloOrdenCompraId = null;
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

            $data = ArticuloIngreso::where('articulos_orden_id', '=', $id)->count();

            if ($data > 0) {
                Util::geterrordefine($this, "El artículo esta en uso en ingreso");
            } else {

                $articulo = ArticuloOrdenCompra::find($id);
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

        $articuloRequerimiento = ArticuloSolicitudCotizacion::find($this->modelArticuloRequemientoId);

        $articulo = ArticuloOrdenCompra::find($this->modelArticuloOrdenCompraId);
        $ordenCompra = $this->modelarArticulosOrdenCompra();

        $cantidad = 0;

        foreach ($ordenCompra as $ar) {
            $cantidad = $cantidad + $ar->cantidad;
        }
        $cantidad = $cantidad + $this->cantidad;

        if ($articulo) {

            $cantidad = $cantidad - $articulo->cantidad;
        }



        if ($articuloRequerimiento->cantidad >= $cantidad) {

            ArticuloOrdenCompra::find($this->modelArticuloOrdenCompraId)->update($this->modelData_ARP());
            $this->resetVars_ARP();


            DB::commit();
            Util::getsuccessupdate($this);
            /*  $this->estaOcultoFormularioArticuloOrdenCompra = "d-none"; */
            $this->editar_ArticuloRequerimiento($this->modelArticuloRequemientoId);
        } else {
            Util::getwarningdefine($this, "La cantidad ingresada supera la cantidad de requerimiento");
        }



        /*  } catch (\Exception $e) {
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
            'precio_unitario' => ['required'],
        ]);

        DB::beginTransaction(); //Iniciamos la reansaccion
        /* try { */

        $articuloRequerimiento = ArticuloSolicitudCotizacion::find($this->modelArticuloRequemientoId);

        $ordenCompra = $this->modelarArticulosOrdenCompra();

        $cantidad = 0;

        foreach ($ordenCompra as $ar) {
            $cantidad = $cantidad + $ar->cantidad;
        }
        $cantidad = $cantidad + $this->cantidad;

        if ($articuloRequerimiento->cantidad >= $cantidad) {

            ArticuloOrdenCompra::create($this->modelData_ARP());


            DB::commit();
            $this->nuevoArticuloOrdenCompra();
            Util::getsuccesscreate($this);
            /*  $this->estaOcultoFormularioArticuloOrdenCompra = "d-none"; */
            $this->editar_ArticuloRequerimiento($this->modelArticuloRequemientoId);
        } else {
            Util::getwarningdefine($this, "La cantidad ingresada supera la cantidad de requerimiento");
        }

        /*  } catch (\Exception $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        } catch (\Throwable $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        } */
    }

    public function loadModal_ARP()
    {

        $data = ArticuloOrdenCompra::find($this->modelArticuloOrdenCompraId);

        $this->cantidad = $data->cantidad;
        $this->precio_unitario = $data->precio_unitario;
        $this->tipo_documento = $data->tipo_documento;
        $this->numero_documento = $data->numero_documento;
        $this->serie_documento = $data->serie_documento;

        $this->serie_guia_remitente = $data->serie_guia_remitente;
        $this->numero_documento_guia_remitente = $data->numero_documento_guia_remitente;
    }
    public function modelData_ARP()
    {

        return [
            'cantidad' => $this->cantidad,
            'users_id' => Auth::user()->id,

            'tipo_documento' => $this->tipo_documento,
            'numero_documento' => $this->numero_documento,
            'serie_documento' => $this->serie_documento,
            'serie_guia_remitente' => $this->serie_guia_remitente,
            'numero_documento_guia_remitente' => $this->numero_documento_guia_remitente,
            'precio_unitario' => $this->precio_unitario,
            'orden_de_compras_id' => $this->modelId,
            'articulo_s_cotizacion_id' => $this->modelArticuloRequemientoId,
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

                $dataAux = ArticuloOrdenCompra::where('articulo_s_cotizacion_id', '=', $item)->count();

                if ($dataAux > 0) {
                    Util::geterrordefine($this, "Debe eliminar los articulos de orden de compra.");
                } else {

                    $data = ArticuloSolicitudCotizacion::find($item);
                    $data->estado = 1;
                    $data->orden_de_compras_id = null;
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

            $data = ArticuloSolicitudCotizacion::find($id);
            $data->orden_de_compras_id = $this->modelId;
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
                $data = ArticuloSolicitudCotizacion::find($id);
                $data->orden_de_compras_id = $this->modelId;
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
            $this->selectedArticulosRequerimientoPersonal = ArticuloSolicitudCotizacion::where('solicitudCotizacions_id', '=', $this->solicitud_cotizacions_id)->where('estado', '=', 1)->pluck('id');

            $this->estaActivadoEnviar = 'enabled';
        } else {
            $this->selectedArticulosRequerimientoPersonal = [];
            $this->estaActivadoEnviar = 'disabled';
        }
    }

    public function updatedSelectAllArticuloOrdenCompra($value)
    {

        if ($value) {
            $this->selectedArticulosOrdenCompra = ArticuloSolicitudCotizacion::where('orden_de_compras_id', '=', $this->modelId)->pluck('id');

            $this->estaActivadoEliminar = 'enabled';
        } else {
            $this->selectedArticulosOrdenCompra = [];
            $this->estaActivadoEliminar = 'disabled';
        }
    }

    /* DATOS DE ARTICULO DE REQUERIMEINTO PERSONAL */
}
