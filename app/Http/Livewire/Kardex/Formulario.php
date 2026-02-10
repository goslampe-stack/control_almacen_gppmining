<?php

namespace App\Http\Livewire\Kardex;

use App\Http\Controllers\ImprimirPDF;
use App\Models\Anio;
use App\Models\Articulo;
use App\Models\ArticuloDevolucion;
use App\Models\ArticuloIngreso;
use App\Models\ArticuloOrdenCompra;
use App\Models\ArticuloRequerimientoPersonal;
use App\Models\ArticuloSolicitudCotizacion;
use App\Models\CierreArticulos;
use App\Models\InventarioInicial;
use App\Models\Mes;
use App\Models\OrdenDeCompra;
use App\Models\SalidaDetalle;
use App\Models\Util;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Crypt;
use Barryvdh\DomPDF\Facade as PDF;


class Formulario extends Component
{

    public $modelIdInventarioInicial = null, $existeInventarioInicial, $cantidad_inicial = 0, $valor_unitario = 0, $inventarioInicial, $modelId;

    public $cantidad_existencia_total = 0, $valor_unitario_total, $valor_total_total;
    public $cantidad_existencia_total_inicial = 0, $valor_unitario_total_inicial = 0, $valor_total_total_inicial = 0, $valor_total_total_inicial_auxiliar = 0, $cantidad_inicial_inicial = 0;
    public $articulo_id;
    public $sucursal_empresas_id_seleccionado = '';
    public $criterioBusqueda = 'rango', $empresas_id;

    public $fecha_actual;
    public $mesSeleccionado, $anio_seleccionado;

    public $rango_inicio, $rango_fin;

    public $estaHabilitadoCriterioMeses = "d-none";
    public $estaHabilitadoCriterioRango = "";
    protected $listeners = ['selectedArticuloItem'];




    public function  mount($articulo_id)
    {
        if (!Util::getExisteTiendaSeleccionadaLocalStorage()) {
            return redirect()->route('dashboard');
        } else {
            $numero = Util::getSucursalEmpresaIdLocalStorage();
            if ($numero != -10) {
                $this->sucursal_empresas_id_seleccionado = $numero;
            } else {
                return redirect()->route('dashboard');
            }
        }
        $this->criterioBusqueda = "meses";


        $this->articulo_id = $articulo_id;
        $this->fecha_actual = Carbon::now();
        $this->mesSeleccionado = $this->fecha_actual->month;
        $this->anio_seleccionado = $this->fecha_actual->year;

        $this->rango_fin = $this->fecha_actual->format('Y-m-d');
        $this->rango_inicio = $this->fecha_actual->subDays(30)->format('Y-m-d');
        $this->empresas_id = Util::getEmpresasIngresada();
    }


    public function render()
    {
        return view('livewire.kardex.formulario', [
            'articulo' => $this->modelarArticulo(),
            'opcionesAnio' => $this->modelarAnio(),
            'opcionesMes' => $this->modelarMes(),
            'articulos' => $this->modelarDatos(),
            'auxiliar' => $this->obtenerPromedioPonderado(),

        ]);
    }

    public function hydrate()
    {
        $this->emit('select2Articulo');
    }

    public function selectedArticuloItem($item)
    {
        if ($item) {
            $this->articulo_id = $item;
        }
    }


    public function modelarDatos()
    {

        $data = Articulo::where('empresas_id', '=', $this->empresas_id)->where('estado', '=',  '1')->get();

        return $data;
    }

    public function updatedCriterioBusqueda()
    {

        if ($this->criterioBusqueda == 'meses') {
            $this->estaHabilitadoCriterioMeses = "";
            $this->estaHabilitadoCriterioRango = "d-none";
        } else {
            $this->estaHabilitadoCriterioMeses = "d-none";
            $this->estaHabilitadoCriterioRango = "";
        }
    }


    public function modelarArticulo()
    {
        return Articulo::find($this->articulo_id);
    }
    public function modelarAnio()
    {
        return Anio::orderBy('identificador',  'asc')->get();
    }
    public function modelarMes()
    {
        return Mes::all();
    }




    public function obtenerPromedioPonderado()
    {

        date_default_timezone_set('America/Lima');

        $dataGeneral = [];

        //articulo requerimiento de personal
    
            $response = ArticuloSolicitudCotizacion::join('sucursal_empresas', 'articulo_solicitud_cotizacions.sucursal_empresas_id', '=', 'sucursal_empresas.id')
            ->join('articulo_requerimiento_compras', 'articulo_solicitud_cotizacions.articuloCompras_id', '=', 'articulo_requerimiento_compras.id')
            ->join('articulo_requerimiento_personals', 'articulo_requerimiento_compras.articulo_r_personals_id', '=', 'articulo_requerimiento_personals.id')
            ->select('articulo_solicitud_cotizacions.*')
            ->where('sucursal_empresas.empresas_id', '=', Util::getTiendaIdLocalStorage())
            ->where('articulo_requerimiento_personals.articulos_id', '=', $this->articulo_id)
            ->get();

            



        //Ingreso
        $articuloIngresoAux = [];
        foreach ($response as $row) {


            $articuloIngresoAux[] = ArticuloIngreso::join('articulo_orden_compras', 'articulo_ingresos.articulos_orden_id', '=', 'articulo_orden_compras.id')
            ->select('articulo_ingresos.*')
            ->where('articulo_orden_compras.articulo_s_cotizacion_id', '=', $row->id)
            ->orderByRaw("STR_TO_DATE(articulo_orden_compras.fecha_ingreso, '%d-%m-%Y %H:%i:%s') DESC")
            ->get();
     
        }


        //devoluciones

        $articuloDevolucionesAux = ArticuloDevolucion::join('sucursal_empresas', 'articulo_devolucions.sucursal_empresas_id', '=', 'sucursal_empresas.id')
            ->select('articulo_devolucions.*')
            ->where('sucursal_empresas.empresas_id', '=', Util::getTiendaIdLocalStorage())
            ->where('articulo_devolucions.articulos_id', '=', $this->articulo_id)
            ->orderByRaw("STR_TO_DATE(articulo_devolucions.fecha_devolucion, '%d-%m-%Y %H:%i:%s') DESC")
            ->get();


        //salidas 

        $articuloSalidaAux = SalidaDetalle::join('sucursal_empresas', 'salida_detalles.sucursal_empresas_id', '=', 'sucursal_empresas.id')
            ->select('salida_detalles.*')
            ->where('sucursal_empresas.empresas_id', '=', Util::getTiendaIdLocalStorage())
            ->where('salida_detalles.articulos_id', '=', $this->articulo_id)
            ->orderByRaw("STR_TO_DATE(salida_detalles.fecha_salida_detalle, '%d-%m-%Y %H:%i:%s') DESC")
            ->get();


        $dataGeneral = [];



        //ingreso
        if ($articuloIngresoAux != null) {
            $i = 0;
            foreach ($articuloIngresoAux as $itemAux) {

                foreach ($itemAux as $item) {

                    $auxiliar = [
                        'nombre' => 'Ingreso',
                        'estado' => 'true',
                        'articulo' => "Compra " . $item->tipo_documento . " N°  ". $item->numero_documento,
                        'cantidad' => $item->cantidad,
                        'fecha' => $item->fecha_ingreso,
                        'auxo' => $item->fecha_ingreso,
                        'precio' => $item->precio_unitario,
                        'tipoDevolucion' => "",

                        'cantidad-entrada' => "",
                        'precio-entrada' => "",
                        'total-entrada' => "",

                        'cantidad-salida' => "",
                        'precio-salida' => "",
                        'total-salida' => "",

                        'cantidad-existencia' => "",
                        'precio-existencia' => "",
                        'total-existencia' => "",


                    ];

                    $dataGeneral[] = $auxiliar;
                }
            }
        }

        //devoluciones
        foreach ($articuloDevolucionesAux as $item) {
            $auxiliar = [
                'nombre' => 'Devolucion',
                'estado' => 'true',
                'tipoDevolucion' => $item->tipoDevolucion,
                'articulo' => $item->tipoDevolucion,
                'cantidad' => $item->cantidad,
                'fecha' => $item->fecha_devolucion,
                'auxo' => $item->fecha_devolucion,
                'precio' => "",
                'cantidad-entrada' => "",
                'precio-entrada' => "",
                'total-entrada' => "",

                'cantidad-salida' => "",
                'precio-salida' => "",
                'total-salida' => "",

                'cantidad-existencia' => "",
                'precio-existencia' => "",
                'total-existencia' => "",

            ];

            $dataGeneral[] = $auxiliar;
        }

        //salidas
        foreach ($articuloSalidaAux as $item) {
            $auxiliar = [
                'nombre' => 'Salida',
                'estado' => 'true',
                'articulo' => "Salida de artículo",
                'cantidad' => $item->cantidad,
                'fecha' => $item->fecha_salida_detalle,
                'auxo' => $item->fecha_salida_detalle,
                'tipoDevolucion' => "",

                'cantidad-entrada' => "",
                'precio-entrada' => "",
                'total-entrada' => "",

                'cantidad-salida' => "",
                'precio-salida' => "",
                'total-salida' => "",

                'cantidad-existencia' => "",
                'precio-existencia' => "",
                'total-existencia' => "",

            ];

            $dataGeneral[] = $auxiliar;
        }


        ///inventario incial
        $auxiliarGeneral = Util::generarKardex($dataGeneral, $this->rango_inicio, $this->rango_fin);


        return $auxiliarGeneral;
    }



    // Función de comparación para `usort`

    public function modelData()
    {
        return [
            'cantidad_inicial' => $this->cantidad_inicial,
            'valor_unitario' => $this->valor_unitario,
            'articulos_id' => $this->articulo_id,
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





    public function volverAtras()
    {
        return redirect()->route('kardex');
    }

    public function imprimir_kardex()
    {


        $articuloRequerimientoPersonal = $this->modelarArticuloRequerimientoPersonalPorMeses();

        $articulo = $this->modelarArticulo();

        $name_file = "holacomoestas";



        $cantidad_existencia_total_inicial = $this->cantidad_existencia_total_inicial;
        $valor_unitario_total_inicial = $this->valor_unitario_total_inicial;
        $valor_total_total_inicial = $this->valor_total_total_inicial;
        $cantidad_existencia_total = $this->cantidad_existencia_total;
        $valor_unitario_total = $this->valor_unitario_total;
        $valor_total_total = $this->valor_total_total;



        $arreglo = [];

        $arreglo[] = $articulo;
        $arreglo[] = $cantidad_existencia_total_inicial;
        $arreglo[] = $valor_total_total_inicial;
        $arreglo[] = $cantidad_existencia_total;
        $arreglo[] = $valor_unitario_total;
        $arreglo[] = $valor_total_total;
        $arreglo[] = $articuloRequerimientoPersonal;
        $arreglo[] = $valor_unitario_total_inicial;

        return  redirect()->action([ImprimirPDF::class, 'imprimirPdfs']);
    }
    public function modelDataCierreMes()
    {

        return [
            'fecha_actual_cierre' => $this->fecha_actual,
            'mes_cierre' => $this->fecha_actual->month,
            'anio_cierre' => $this->fecha_actual->year,
            'articulos_id' => $this->articulo_id,
            'estado' => 1,
            'sucursal_empresas_id' => Util::getSucursalEmpresaIdLocalStorage(),
        ];
    }
}
