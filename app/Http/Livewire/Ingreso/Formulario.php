<?php

namespace App\Http\Livewire\Ingreso;

use App\Models\ArticuloIngreso;
use App\Models\Ingreso;
use App\Models\OrdenDeCompra;
use App\Models\ArticuloOrdenCompra;
use App\Models\ArticuloRequerimientoPersonal;
use App\Models\ArticuloSolicitudCotizacion;
use App\Models\Personal;
use App\Models\Proveedor;
use App\Models\RequerimientoPersonal;
use App\Models\Transporte;
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
    public $numero_ingreso, $fecha_ingreso, $articulos_id,
        $ordenCompraNumero,
        $guia_transportista,
        $transportes_ruc_id,
        $sucursal_empresas_id,
        $guia_remision,
        $descripcion,
        $modelArticuloOrdenCompraId,
        $orden_de_compras_id,
        $almacenero_id,
        $jefeLogistica_id,
        $transportes_id;

    public $modelIdArticuloIngreso;
    public $perPageArticuloOrdenCompra = 5;
    public $perPageArticuloIngreso = 80;
    public $serie_guia_remitente, $fecha_traslado, $numero_documento_guia_remitente, $serie_guia_transportista, $numero_documento_guia_transportista;

    public $numero_orden_compra, $fecha_pedido, $numero_requerimiento_personal,  $fecha_estimada_pago, $serie_documento, $proveedors_ruc_id, $terminos_de_entrega, $tipo_documento, $numero_documento, $estado, $requerimiento_personals_id, $proveedors_id;

    public $cantidadTotalArticulosOrdenCompra, $costoTotalArticulosOrdenCompra;

    public $tipo_docuento_opciones = [
        'Factura',
        'Boleta'
    ];

    public $totalPrecioOrdenCompraSubGeneral = 0;
    public $totalCantidadOrdenCompraSubGeneralArticuloRequerimiento = 0;
    public $totalCantidadOrdenCompraSubGeneral = 0;
    public $totalCantidadOrdenCompraGeneral = 0;
    public $estaOcultoFormularioArticuloIngreso = 'd-none';

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

    public $estaOcultoFormularioArticuloOrdenCompra = '', $listaArticulosOridenCompra = [];

    protected $listeners = ['crear_RP', 'editar_RP', 'selectedTransporteItem', 'selectedAlmaceneroItem','selectedJefeLogisticaItem', 'selectedTransporteRucItem', 'selectedOrdenDeCompraItem', 'selectedArticuloItem'];
    public $modelId;


    public $estaEnArticulosOrdenCompra = 'd-none';
    public $estaIngreso = 'd-none';
    public $estaEnOrdenCompra = 'd-none';

    public $sucursal_empresas_id_seleccionado = '';

    /* ARTICULO REQUERIMEINTO */
    public  $codigo, $articulo, $cantidad, $modelArticuloRequemientoId, $precio_unitario;


    public $search = '';
    public $perPage = 500;
    public $sortField = 'id';
    public $sortAsc = true;
    public $selectedArticulosRequerimientoPersonal = [];
    public $estaActivadoEliminar = 'disabled';
    public $estaActivadoEnviar = 'disabled';
    public $estaActivadorInactivo = 'disabled';
    public $estaActivadorActivo = 'disabled';
    public $filtrarPorEstado = "";
    public $selectedArticulosOrdenCompra = [];
    public $buscarArticuloOrdenCompra = '';


    public $estaEnArticulosOrdenCompraRequerimiento = 'd-none', $empresas_id;


    public function mount()
    {


        if (!Util::getExisteTiendaSeleccionadaLocalStorage()) {
            return redirect()->route('dashboard');
        } else {
            $this->sucursal_empresas_id_seleccionado = Util::getSucursalEmpresaIdLocalStorage();
            $this->empresas_id = Util::getTiendaIdLocalStorage();
        }
    }


    public $estado_opciones = [
        'Activo',
        'Inactivo'
    ];
    public $tipo_documento_opciones = [
        'Factura',
        'Boleta'
    ];

    public function hydrate()
    {
        $this->emit('select2Transporte');
        $this->emit('select2TransporteRuc');
        $this->emit('select2OrdenDeCompra');
        $this->emit('select2Articulo');
        $this->emit('select2Almacenero');
        $this->emit('select2JefeLogistica');
    }

    public function selectedTransporteItem($item)
    {
        if ($item) {
            $this->transportes_id = $item;
            $this->transportes_ruc_id = $item;
        }
    }
    public function selectedAlmaceneroItem($item)
    {
        if ($item) {
            $this->almacenero_id = $item;
        }
    }
    public function selectedJefeLogisticaItem($item)
    {
        if ($item) {
            $this->jefeLogistica_id = $item;
        }
    }
    public function selectedTransporteRucItem($item)
    {
        if ($item) {
            $this->transportes_id = $item;
            $this->transportes_ruc_id = $item;
        }
    }
    public function selectedOrdenDeCompraItem($item)
    {

        if ($item) {

            $response = OrdenDeCompra::find($item);

            if ($response != null) {
                $this->fecha_ingreso = Carbon::now()->format('Y-m-d H:i:s');
                $this->descripcion = $response->terminos_de_entrega;
                $this->orden_de_compras_id = $item;
            } else {
                return redirect()->route('dashboard');
            }
        }
    }
    public function selectedArticuloItem($item)
    {

        if ($item) {


            $this->articulos_id = $item;
            $this->editarArticuloOrdenCompra($item);
        }
    }


    public function cambiarEstaEnOrdenCompra()
    {
        $this->estaEnOrdenCompra = '';
        $this->estaEnArticulosOrdenCompra = 'd-none';
        $this->estaEnArticulosOrdenCompraRequerimiento = 'd-none';
        $this->estaIngreso = 'd-none';
    }

    public function cambiarEstaEnArticulosRequerimientoPersonal()
    {

        $this->estaEnArticulosOrdenCompraRequerimiento = '';
        $this->estaEnArticulosOrdenCompra = 'd-none';
        $this->estaEnOrdenCompra = 'd-none';
        $this->estaIngreso = 'd-none';
    }
    public function cambiarEstaEnArticulosOrdenCompra()
    {

        $this->estaEnArticulosOrdenCompra = '';
        $this->estaEnArticulosOrdenCompraRequerimiento = 'd-none';
        $this->estaIngreso = 'd-none';
        $this->estaEnOrdenCompra = 'd-none';
    }
    public function cambiarEstaEnArticulosIngreso()
    {

        $this->estaEnArticulosOrdenCompra = 'd-none';
        $this->estaEnArticulosOrdenCompraRequerimiento = 'd-none';
        $this->estaEnOrdenCompra = 'd-none';
        $this->estaIngreso = '';
    }
    public function render()
    {
        $arreglo = [
            'transportistas' => $this->modelarTransportistas(),
            'articuloIngresos' => $this->modelarArticulosIngreso(),
            'articuloOrdenCompra' => $this->modelarArticulosOrdenCompra(),
            'ordenDeCompras' => $this->modelarOrdenDeCompra(),
            'personales' => $this->modelarPersonal(),
            'costoTotalArticulosOrdenCosmpra' => $this->calcularCostoTotalArticulosOrdenCompra(),
        ];
        return view('livewire.ingreso.formulario', $arreglo);
    }

  
    public function modelarPersonal()
    {
        $data = Personal::where('estado', '=', 1)->where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)->get();
        return $data;
    }

   


    public function modelarTransportistas()
    {
        $data = Transporte::where('estado', '=', 1)->where('empresas_id', '=', Util::getEmpresasIngresada())->get();
        return $data;
    }
    public function modelarOrdenDeCompra()
    {

        $data = OrdenDeCompra::join('sucursal_empresas', 'orden_de_compras.sucursal_empresas_id', '=', 'sucursal_empresas.id')
            ->select('orden_de_compras.*')
            ->where('sucursal_empresas.empresas_id', '=', $this->empresas_id) //2 orden de compra
            ->where('orden_de_compras.estado', '=', 1)
            ->where('orden_de_compras.ingresos_id', '=', $this->modelId)->orderBy('numero_orden_compra', 'desc')->get();
        return $data;
    }


    public function modelarArticulosOrdenCompra()
    {

        $this->modelarArticulosIngreso();
        $data = ArticuloOrdenCompra::where('orden_de_compras_id', '=', $this->orden_de_compras_id)
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->simplePaginate($this->perPageArticuloOrdenCompra);


        $this->totalPrecioOrdenCompraSubGeneral = 0;
        $this->totalCantidadOrdenCompraSubGeneral = 0;
        foreach ($data as $d) {
            $this->totalPrecioOrdenCompraSubGeneral = $this->totalPrecioOrdenCompraSubGeneral + ($d->precio_unitario * $d->cantidad);
            $this->totalCantidadOrdenCompraSubGeneral = $this->totalCantidadOrdenCompraSubGeneral + $d->cantidad;
        }
        $this->totalPrecioOrdenCompraSubGeneral = Util::darFormatoMoneda($this->totalPrecioOrdenCompraSubGeneral);

        for ($x = 0; $x < count($data); $x++) {
            for ($i = 0; $i < count($data) - $x - 1; $i++) {
                $articulo = $data[$i];
                $articulo2 = $data[$i + 1];


                if ($articulo->articuloRequerimiento->articuloSolicitudCotizacion->articuloRequerimiento->articulo->codigo > $articulo2->articuloRequerimiento->articuloSolicitudCotizacion->articuloRequerimiento->articulo->codigo) {
                    $tmp = $data[$i + 1];
                    $data[$i + 1] = $data[$i];
                    $data[$i] = $tmp;
                }
            }
        }


        if ($this->modelArticuloRequemientoId) {
            $datas = ArticuloRequerimientoPersonal::find($this->modelArticuloRequemientoId);


            $this->articulo = $datas->articulo->articulo;
        }




        return $data;
    }


    public function modelarArticulosIngreso()
    {
        $data = ArticuloIngreso::where('orden_de_compras_id', '=', $this->orden_de_compras_id)
            ->orderBy('id', 'desc')
            ->get();


        $this->listaArticulosOridenCompra = [];
        foreach ($data as $item) {

            $this->listaArticulosOridenCompra[] = $item->articulos_orden_id;
        }



        return $data;
    }

    public function calcularCostoTotalArticulosOrdenCompra()
    {
        $data = $this->modelarArticulosOrdenCompra();

        $this->costoTotalArticulosOrdenCompra = 0;
        $this->cantidadTotalArticulosOrdenCompra = 0;

        foreach ($data as $item) {
            $this->cantidadTotalArticulosOrdenCompra = $this->cantidadTotalArticulosOrdenCompra + $item->cantidad;
            $this->costoTotalArticulosOrdenCompra = $this->costoTotalArticulosOrdenCompra + ($item->cantidad * $item->precio_unitario);
        }

        $this->costoTotalArticulosOrdenCompra =  Util::darFormatoMoneda($this->costoTotalArticulosOrdenCompra);

        $datas = ArticuloRequerimientoPersonal::find($this->modelArticuloRequemientoId);
        if ($datas) {

            $this->totalCantidadOrdenCompraSubGeneralArticuloRequerimiento = $datas->cantidad;
        }
    }

    public function cerrarFormulario()
    {
        /*  $this->emit('refreshParent');
        $this->dispatchBrowserEvent('closeModal'); */

        return redirect()->route('ingreso');
    }








    /* DATOS DE REQUERIMIENTO PERSONAL */



    public function obtenerUltimoNumeroRequerimiento_RP()
    {
        $response = Ingreso::where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)->orderby('created_at', 'DESC')->take(1)->first();
        if ($response == null) {
            return 0;
        } else {
            return $response->numero_ingreso;
        }
    }

    public function crear_RP()
    {

        $this->resetValidation();
        $this->resetVars_RP();
        $this->modelId = null;
        $this->numero_ingreso =  Util::formarNumeroRequerimiento($this->obtenerUltimoNumeroRequerimiento_RP());
        $this->dispatchBrowserEvent('openModal');
    }
    public function modelData_RP()
    {
        return [
            'numero_ingreso' => $this->numero_ingreso,
            'fecha_ingreso' => $this->fecha_ingreso,

            'descripcion' => $this->descripcion,
            'users_id' => Auth::user()->id,
            'guia_transportista' => $this->guia_transportista,
            'guia_remision' => $this->guia_remision,
            'orden_de_compras_id' => $this->orden_de_compras_id,
            'transportes_id' => $this->transportes_id,
            'almacenero_id' => $this->almacenero_id,
            'jefeLogistica_id' => $this->jefeLogistica_id,
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
        $this->loadIngreso();
        $this->dispatchBrowserEvent('openModal');
    }
    public function eliminar_ARP($id)
    {
        $item = ArticuloIngreso::find($id);

        $item->delete();

        $this->estaOcultoFormularioArticuloIngreso = 'd-none';
        $this->estaOcultoFormularioArticuloOrdenCompra = 'd-none';

        Util::getsuccessdelete($this);

        $this->resetArticuloIngreso();
        $this->resetVars_ARP();
        try {
        } catch (Exception $e) {
            Util::geterrordelete($this);
        }
    }

    public function resetVars_RP()
    {

        date_default_timezone_set('America/Lima');

        $this->numero_ingreso = null;
        $this->numero_documento = null;
        $this->descripcion = null;
        $this->guia_transportista = null;
        $this->guia_remision = null;
        $this->orden_de_compras_id = null;
        $this->almacenero_id = null;
        $this->jefeLogistica_id = null;
        $this->transportes_id = null;
        $this->transportes_ruc_id = null;
        $this->estado = 'Activo';
        $this->sucursal_empresas_id = null;
        $this->fecha_ingreso = Carbon::now()->format('Y-m-d H:i:s');;




        $this->estaEnOrdenCompra = '';
        $this->estaEnArticulosOrdenCompra = 'd-none';
        $this->estaIngreso = 'd-none';

        $this->modelId = null;
    }


    /* DATOS DE REQUERIMIENTO PERSONAL */




    /* DATOS DE ARTICULO DE REQUERIMEINTO PERSONAL */


    public function resetVars_ARP()
    {

        $this->codigo = null;
        $this->articulo = null;
        $this->cantidad = null;
        $this->precio_unitario = null;
        $this->tipo_documento = null;
        $this->numero_documento = null;
        $this->fecha_ingreso = null;
        $this->fecha_traslado = null;
        $this->transportes_id = null;
        $this->transportes_ruc_id = null;
        $this->modelArticuloOrdenCompraId = null;
        $this->estaOcultoFormularioArticuloIngreso = 'd-none';
        $this->estaOcultoFormularioArticuloOrdenCompra = 'd-none';
    }


    public function editar_ArticuloPersonal($id)
    {
        $this->resetValidation();
        $this->resetVars_ARP();

        $this->modelArticuloRequemientoId = $id;
    }







    public function cambiarEstadoBotonesRequerimientoPersonal_ARP()
    {

        if (count($this->selectedArticulosRequerimientoPersonal) > 0) {
            $this->estaActivadoEnviar = 'enabled';
        } else {
            $this->estaActivadoEnviar = 'disabled';
        }
    }


    public function resetearValores_ARP()
    {
        $this->estaActivadoEliminar = 'disabled';
        $this->estaActivadorInactivo = 'disabled';
        $this->estaActivadorActivo = 'disabled';
        $this->estaOcultoFormularioArticuloOrdenCompra = 'd-none';
        $this->selectedArticulosRequerimientoPersonal = [];
    }






    /////////////////////////////////////////////////////////////////////////////////

    //ARTICULO INGRESO


    public function agregarArticuloIngreso()
    {
        $this->validate([
            'cantidad' => ['required'],
        ]);

        DB::beginTransaction(); //Iniciamos la reansaccion
        try {


            ArticuloIngreso::create($this->modelarArticuloIngreso());

            $this->resetVars_ARP();
            $this->resetArticuloIngreso();
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
    public function actualizarArticuloIngreso()
    {
        $this->validate([
            'cantidad' => ['required'],
        ]);

        DB::beginTransaction(); //Iniciamos la reansaccion
        try {


            ArticuloIngreso::find($this->modelIdArticuloIngreso)->update($this->modelarArticuloIngreso());

            $this->resetVars_ARP();
            $this->resetArticuloIngreso();
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



    public function modelarArticuloIngreso()
    {
        return [
            'cantidad' => $this->cantidad,
            'articulos_orden_id' => $this->modelArticuloOrdenCompraId,
            'users_id' => Auth::user()->id,

            'tipo_documento' => $this->tipo_documento,
            'orden_de_compras_id' => $this->orden_de_compras_id,
            'numero_documento' => $this->numero_documento,
            'ingresos_id' => $this->modelId,
            'fecha_ingreso' => $this->fecha_ingreso,
            'fecha_traslado' => $this->fecha_traslado,
            'transportes_id' => $this->transportes_id,
            'serie_documento' => $this->serie_documento,
            'serie_guia_remitente' => $this->serie_guia_remitente,
            'numero_documento_guia_remitente' => $this->numero_documento_guia_remitente,
            'serie_guia_transportista' => $this->serie_guia_transportista,
            'numero_documento_guia_transportista' => $this->numero_documento_guia_transportista,
            'precio_unitario' => $this->precio_unitario,
            'sucursal_empresas_id' => Util::getSucursalEmpresaIdLocalStorage(),
        ];
    }

    public function loadArticuloIngreso()
    {

        $data = ArticuloIngreso::find($this->modelIdArticuloIngreso);



        $this->cantidad = $data->cantidad;
        $this->modelArticuloOrdenCompraId = $data->articulos_orden_id;
        $this->tipo_documento = $data->tipo_documento;
        $this->orden_de_compras_id = $data->orden_de_compras_id;

        $this->numero_documento = $data->numero_documento;
        $this->modelId = $data->ingresos_id;
        $this->fecha_ingreso = $data->fecha_ingreso;
        $this->fecha_traslado = $data->fecha_traslado;
        $this->transportes_id = $data->transportes_id;
        $this->serie_documento = $data->serie_documento;
        $this->serie_guia_remitente = $data->serie_guia_remitente;
        $this->numero_documento_guia_remitente = $data->numero_documento_guia_remitente;
        $this->serie_guia_transportista = $data->serie_guia_transportista;
        $this->numero_documento_guia_transportista = $data->numero_documento_guia_transportista;
        $this->precio_unitario = $data->precio_unitario;
    }
    public function resetArticuloIngreso()
    {




        $this->cantidad = null;
        $this->modelArticuloOrdenCompraId = null;
        $this->tipo_documento = null;

        $this->numero_documento = null;
        $this->fecha_ingreso = null;
        $this->fecha_traslado = null;
        $this->transportes_id = null;
        $this->serie_documento = null;
        $this->modelIdArticuloIngreso = null;
        $this->serie_guia_remitente = null;
        $this->numero_documento_guia_remitente = null;
        $this->serie_guia_transportista = null;
        $this->numero_documento_guia_transportista = null;
        $this->precio_unitario = null;
        $this->estaOcultoFormularioArticuloIngreso = 'd-none';
        $this->estaOcultoFormularioArticuloOrdenCompra = 'd-none';
    }


    public function  editarArticuloIngreso($id)
    {

        $this->resetValidation();
        $this->resetArticuloIngreso();
        $this->modelIdArticuloIngreso = $id;
        $this->estaOcultoFormularioArticuloIngreso = '';

        $this->loadArticuloIngreso();
        $this->emit('refresacarComponentes');

    }



    //ARTICULO INGRESO
    /////////////////////////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////////////
    //ARTICULO ORDEN COMPRA

    public function  editarArticuloOrdenCompra($id)
    {
        if (Util::estaAgregaEnArticuloOrdenCompraElArticuloIngreso($this->listaArticulosOridenCompra, $id)) {
            Util::geterrordefine($this, "El artículo ya se agrego, revisa en la parte de articulo ingresados");
            $this->modelArticuloOrdenCompraId = null;
            $this->estaOcultoFormularioArticuloOrdenCompra = 'd-none';
            return;
        }
        $this->resetValidation();
        $this->modelArticuloOrdenCompraId = $id;
        $this->estaOcultoFormularioArticuloOrdenCompra = '';

        $this->loadArticuloOrdenCompra();
        $this->emit('refresacarComponentes');

    }



    public function loadArticuloOrdenCompra()
    {

        $data = ArticuloOrdenCompra::find($this->modelArticuloOrdenCompraId);



        $this->codigo = $data->articuloRequerimiento->articuloSolicitudCotizacion->articuloRequerimiento->articulo->codigo;
        $this->articulo = $data->articuloRequerimiento->articuloSolicitudCotizacion->articuloRequerimiento->articulo->articulo;
        $this->cantidad = $data->cantidad;
        $this->precio_unitario = $data->precio_unitario;
        $this->tipo_documento = $data->tipo_documento;
        $this->numero_documento = $data->numero_documento;
        $this->serie_documento = $data->serie_documento;
        $this->transportes_id = $data->transportes_id;
        $this->transportes_ruc_id = $data->transportes_id;


        $fecha = Carbon::parse($data->fecha_ingreso)->format('Y-m-d');
        $hora = Carbon::parse($data->fecha_ingreso)->format('H:i');

        $formateado = $fecha . "T" . $hora;

        $this->fecha_ingreso = $formateado;
        $this->fecha_traslado = $data->fecha_traslado;




        $this->serie_guia_remitente = $data->serie_guia_remitente;
        $this->numero_documento_guia_remitente = $data->numero_documento_guia_remitente;
        $this->serie_guia_transportista = $data->serie_guia_transportista;
        $this->numero_documento_guia_transportista = $data->numero_documento_guia_transportista;
    }


    //RTICULO ORDEN COMPRA
    /////////////////////////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////////////
    //INGRESO

    public function actualizarIngreso()
    {
        $this->validate([
            'numero_ingreso' => ['required', Rule::unique('ingresos', 'numero_ingreso')->ignore($this->modelId)->where(function ($query) {
                return $query->where('sucursal_empresas_id',  '=', $this->sucursal_empresas_id_seleccionado);
            })],
            'estado' => 'required',
       /*      'almacenero_id' => ['required'],
            'jefeLogistica_id' => ['required'], */
        ]);

        DB::beginTransaction(); //Iniciamos la reansaccion
        try {

            $response = Ingreso::find($this->modelId)->update($this->modelData_RP());
            if ($response) {

                $data = OrdenDeCompra::find($this->orden_de_compras_id);

                $dataRequerimeinto = ArticuloRequerimientoPersonal::where('requerimiento_p_id', '=', $data->requerimiento_personals_id)->get();


                foreach ($dataRequerimeinto as $d) {
                    $data = ArticuloRequerimientoPersonal::find($d->id);
                    $data->orden_de_compras_id = $this->orden_de_compras_id;
                    $data->estado = 2;
                    $data->update();
                }
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


    public function guardarIngreso()
    {
        $this->validate([

            'numero_ingreso' => ['required', Rule::unique('ingresos', 'numero_ingreso')->ignore($this->modelId)->where(function ($query) {
                return $query->where('sucursal_empresas_id',  '=', $this->sucursal_empresas_id_seleccionado);
            })],
            'orden_de_compras_id' => ['required'],
          /*   'almacenero_id' => ['required'],
            'jefeLogistica_id' => ['required'], */
            'estado' => 'required',
        ]);

        DB::beginTransaction(); //Iniciamos la reansaccion
        try { 


            $response = Ingreso::create($this->modelData_RP());

            if ($response) {

                $data = OrdenDeCompra::find($this->orden_de_compras_id);
                $data->estado = 2;
                $data->ingresos_id = $response->id;
                //significa que ya esta agregado a un orden de pago el requerimiento
                $data->update();

           
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


    public function loadIngreso()
    {

        $data = Ingreso::find($this->modelId);

        $this->numero_ingreso = $data->numero_ingreso;
        $this->fecha_ingreso = $data->fecha_ingreso;

        $this->guia_remision = $data->guia_remision;
        $this->descripcion = $data->descripcion;
        $this->orden_de_compras_id = $data->orden_de_compras_id;

        $this->ordenCompraNumero = $data->ordenDeCompra->numero_orden_compra;
        $this->estado = $data->estado == 1 ? "Activo" : 'Inactivo';
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

            DB::commit();
            Util::getsuccessupdate($this);
        } catch (\Exception $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        } catch (\Throwable $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        }


        $this->resetearValores_ARP();
    }

    public function enviarArticuloRequerimientoParaOrdenCompraItem($id)
    {

        DB::beginTransaction(); //Iniciamos la reansaccion
        try {


            $data = ArticuloRequerimientoPersonal::find($id);
            $data->orden_de_compras_id = $this->modelId;
            $data->estado = 2;
            $response = $data->update();


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



    //INGRESO
    /////////////////////////////////////////////////////////////////////////////////
}
