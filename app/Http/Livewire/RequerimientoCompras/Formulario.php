<?php

namespace App\Http\Livewire\RequerimientoCompras;


use App\Models\ArticuloOrdenCompra;
use App\Models\ArticuloRequerimientoCompra;
use App\Models\ArticuloRequerimientoPersonal;
use App\Models\ArticuloSolicitudCotizacion;
use App\Models\OrdenDeCompra;
use App\Models\Personal;
use App\Models\Proveedor;
use App\Models\RequerimientoCompra;
use App\Models\RequerimientoPersonal;
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
    public $numero_requerimiento_compra, $fecha_requerimiento, $sucursal_empresas_id, $articuloRequerimientoPersonal, $numero_requerimiento_personal,  $fecha_estimada_pago, $serie_documento, $proveedors_ruc_id, $elaboradoPor_id, $descripcion, $tipo_documento, $numero_documento, $estado, $requerimiento_personals_id, $proveedors_id;
    protected $listeners = ['crear_RP', 'editar_RP', 'selectedProveedorItem', 'selectedElaboradoPorItem', 'selectedProveedorRucItem',  'selectedRequerimientoPersonalItem'];
    public $modelId;

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
            'requerimientoRersonales' => $this->modelarRequerimientoPersonales(),
        ];
        return view('livewire.requerimiento-compras.formulario', $arreglo);
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
    public function selectedRequerimientoPersonalItem($item)
    {

        if ($item) {
            $response = RequerimientoPersonal::find($item);

            if ($response != null) {
                $this->requerimiento_personals_id = $item;
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

        $this->buscarArticuloOrdenCompra = "";
    }




    public function modelarProveedores()
    {
        $data = Proveedor::where('estado', '=', 1)->get();
        return $data;
    }
    public function modelarPersonal()
    {
        $data = Personal::where('estado', '=', 1)->where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)->get();
        return $data;
    }
    public function modelarRequerimientoPersonales()
    {
        $data = RequerimientoPersonal::join('sucursal_empresas', 'requerimiento_personals.sucursal_empresas_id', '=', 'sucursal_empresas.id')
            ->select('requerimiento_personals.*')
            ->where('sucursal_empresas.empresas_id', '=', $this->empresas_id)
            ->where('requerimiento_personals.estado', '=', '1')
            ->orderBy('requerimiento_personals.numero_requerimiento',  'desc')->get();

        return $data;
    }

    public function modelarArticuloRequerimientoPersonal()
    {
        $data = ArticuloRequerimientoPersonal::searchRequerimientoPersonal($this->requerimiento_personals_id)->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')->simplePaginate($this->perPage);

        //buscamos stock disponible de cada producto 

        foreach ($data as $item) {
            $stock_disponible = Util::getStockDisponibleArticulo($item->articulos_id);
            $item->stock_disponible = $stock_disponible;
        }

        return $data;
    }
    public function modelarArticulosGeneralOrdenCompra()
    {

        $data = ArticuloRequerimientoPersonal::searchRequerimientoCompras($this->buscarArticuloOrdenCompra, $this->modelId, $this->sucursal_empresas_id_seleccionado)->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')->simplePaginate($this->perPageArticuloOrdenCompra);

        $this->totalCantidadOrdenCompraGeneral = 0;
        foreach ($data  as $item) {
            $this->totalCantidadOrdenCompraGeneral = $this->totalCantidadOrdenCompraGeneral + $item->cantidad;
            $stock_disponible = Util::getStockDisponibleArticulo($item->articulos_id);
            $item->stock_disponible = $stock_disponible;
        }

        return $data;
    }

    public function modelarArticulosOrdenCompra()
    {


        $data = ArticuloRequerimientoCompra::where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)
            ->where('requerimientoCompras_id', '=', $this->modelId)
            ->where('articulo_R_personals_id', '=', $this->modelArticuloRequemientoId)
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
        /* $this->emit('refreshParent');
        $this->dispatchBrowserEvent('closeModal');
 */
        return redirect()->route('requerimiento-compras');
    }


    /* DATOS DE REQUERIMIENTO PERSONAL */



    public function obtenerUltimoNumeroRequerimiento_RP()
    {
        $response = RequerimientoCompra::where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)->orderby('created_at', 'DESC')->take(1)->first();
        if ($response == null) {
            return 0;
        } else {
            return $response->numero_requerimiento_compra;
        }
    }

    public function crear_RP()
    {

        $this->resetValidation();
        $this->resetVars_RP();
        $this->modelId = null;
        $this->numero_requerimiento_compra =  Util::formarNumeroRequerimiento($this->obtenerUltimoNumeroRequerimiento_RP());
        $this->dispatchBrowserEvent('openModal');
    }


    public function guardar_RP()
    {
        $this->validate([

            'numero_requerimiento_compra' => ['required', Rule::unique('requerimiento_compras', 'numero_requerimiento_compra')->ignore($this->modelId)->where(function ($query) {
                return $query->where('sucursal_empresas_id',  '=', $this->sucursal_empresas_id_seleccionado);
            })],
            'fecha_requerimiento' => ['required'],
            'requerimiento_personals_id' => ['required'],
            'estado' => 'required',
        ]);


        DB::beginTransaction(); //Iniciamos la reansaccion
        try {

            $response = RequerimientoCompra::create($this->modelData_RP());

            if ($response) {

                $data = RequerimientoPersonal::find($this->requerimiento_personals_id);
                $data->estado = 2;
                $data->requerimientoCompras_id = $response->id;
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
            'numero_requerimiento_compra' => $this->numero_requerimiento_compra,
            'fecha_requerimiento' => $this->fecha_requerimiento,
            'descripcion' => $this->descripcion,
            'personalpdf' => json_encode(Util::getPersonalPdf($this->sucursal_empresas_id_seleccionado,Util::$OPCION_REQUERIMIENTO_DE_COMPRAS)),
            'users_id' => Auth::user()->id,
            'requerimiento_personals_id' => $this->requerimiento_personals_id,
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
            'numero_requerimiento_compra' => ['required', Rule::unique('requerimiento_compras', 'numero_requerimiento_compra')->ignore($this->modelId)->where(function ($query) {
                return $query->where('sucursal_empresas_id',  '=', $this->sucursal_empresas_id_seleccionado);
            })],
            'estado' => 'required',
        ]);


        DB::beginTransaction(); //Iniciamos la reansaccion
        try {

            RequerimientoCompra::find($this->modelId)->update($this->modelData_RP());

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

        $data = RequerimientoCompra::find($this->modelId);

        $this->numero_requerimiento_compra = $data->numero_requerimiento_compra;

        $this->fecha_requerimiento = $data->fecha_requerimiento;

        $this->descripcion = $data->descripcion;
        $this->requerimiento_personals_id = $data->requerimiento_personals_id;


        $this->numero_requerimiento_personal = $data->requerimientoPersonal->numero_requerimiento;

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

        $this->numero_requerimiento_compra = null;
        $this->fecha_requerimiento = Carbon::now()->format('Y-m-d');
        $this->fecha_estimada_pago = null;
        $this->descripcion = null;
        $this->requerimiento_personals_id = null;
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
        $data = ArticuloRequerimientoPersonal::find($this->modelArticuloRequemientoId);
        $this->totalCantidadOrdenCompraSubGeneralArticuloRequerimiento = $data->cantidad;
        $this->codigo = $data->articulo->codigo;
        $this->articulo = $data->articulo->articulo;
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

            $data = ArticuloSolicitudCotizacion::where('articuloCompras_id', '=', $id)->count();

            if ($data > 0) {
                Util::geterrordefine($this, "El artículo esta en uso en solicitud de cotización");
            } else {
                $articulo = ArticuloRequerimientoCompra::find($id);
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

        $articuloRequerimiento = ArticuloRequerimientoPersonal::find($this->modelArticuloRequemientoId);

        $articulo = ArticuloRequerimientoCompra::find($this->modelArticuloOrdenCompraId);
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

            ArticuloRequerimientoCompra::find($this->modelArticuloOrdenCompraId)->update($this->modelData_ARP());
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
        ]);

        DB::beginTransaction(); //Iniciamos la reansaccion
        /* try { */

        $articuloRequerimiento = ArticuloRequerimientoPersonal::find($this->modelArticuloRequemientoId);

        $ordenCompra = $this->modelarArticulosOrdenCompra();

        $cantidad = 0;

        foreach ($ordenCompra as $ar) {
            $cantidad = $cantidad + $ar->cantidad;
        }
        $cantidad = $cantidad + $this->cantidad;

        if ($articuloRequerimiento->cantidad >= $cantidad) {

            ArticuloRequerimientoCompra::create($this->modelData_ARP());


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

        $data = ArticuloRequerimientoCompra::find($this->modelArticuloOrdenCompraId);

        $this->codigo = $data->articuloRequerimiento->articulo->codigo;
        $this->articulo = $data->articuloRequerimiento->articulo->articulo;
        $this->cantidad = $data->cantidad;
    }
    public function modelData_ARP()
    {

        return [
            'cantidad' => $this->cantidad,
            'users_id' => Auth::user()->id,
            'requerimientoCompras_id' => $this->modelId,
            'articulo_r_personals_id' => $this->modelArticuloRequemientoId,
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

            $eliminado = false;
            foreach ($this->selectedArticulosOrdenCompra as $item) {
                $dataAux = ArticuloRequerimientoCompra::where('articulo_r_personals_id', '=', $item)->count();
                if ($dataAux > 0) {
                    Util::geterrordefine($this, "Debe eliminar los articulos de requerimiento de compras.");
                } else {

                    $data = ArticuloRequerimientoPersonal::find($item);
                    $data->estado = 1;
                    $data->requerimientoCompras_id = null;
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

            $data = ArticuloRequerimientoPersonal::find($id);
            $data->requerimientoCompras_id = $this->modelId;
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
                $data = ArticuloRequerimientoPersonal::find($id);
                $data->requerimientoCompras_id = $this->modelId;
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

            $this->selectedArticulosRequerimientoPersonal = ArticuloRequerimientoPersonal::where('requerimiento_p_id', '=', $this->requerimiento_personals_id)->where('estado', '=', 1)->pluck('id');

            $this->estaActivadoEnviar = 'enabled';
        } else {
            $this->selectedArticulosRequerimientoPersonal = [];
            $this->estaActivadoEnviar = 'disabled';
        }
    }

    public function updatedSelectAllArticuloOrdenCompra($value)
    {

        if ($value) {

            $this->selectedArticulosOrdenCompra = ArticuloRequerimientoPersonal::where('requerimientoCompras_id', '=', $this->modelId)->pluck('id');

            $this->estaActivadoEliminar = 'enabled';
        } else {
            $this->selectedArticulosOrdenCompra = [];
            $this->estaActivadoEliminar = 'disabled';
        }
    }

    /* DATOS DE ARTICULO DE REQUERIMEINTO PERSONAL */
}
