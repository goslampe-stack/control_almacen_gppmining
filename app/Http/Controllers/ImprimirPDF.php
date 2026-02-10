<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\ArticuloDevolucion;
use App\Models\ArticuloIngreso;
use App\Models\ArticuloOrdenCompra;
use App\Models\ArticuloRequerimientoPersonal;
use App\Models\ArticuloSolicitudCotizacion;
use App\Models\OrdenDeCompra;
use App\Models\PersonalPdf;
use App\Models\SalidaDetalle;
use App\Models\SucursalEmpresa;
use App\Models\Tienda;
use App\Models\Util;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ImprimirPDF extends Controller
{

    public $modelIdInventarioInicial = null, $existeInventarioInicial, $cantidad_inicial = 0, $valor_total_total_inicial_auxiliar, $valor_unitario = 0, $inventarioInicial;

    public $cantidad_existencia_total = 0, $valor_unitario_total, $valor_total_total;
    public $cantidad_existencia_total_inicial = 0, $valor_unitario_total_inicial = 0, $valor_total_total_inicial = 0, $cantidad_inicial_inicial = 0;
    public $articulo_id;
    public $sucursal_empresas_id_seleccionado = '';

    public $fecha_actual;
    public $mesSeleccionado, $anio_seleccionado;

    public $criterioBusqueda, $rango_inicio, $rango_fin;


    public function imprimirPdfs($criterioBusqueda, $rango_inicio, $rango_fin, $mes, $anio, $articulo)
    {



        if (!Util::getExisteTiendaSeleccionadaLocalStorage()) {
            return redirect()->route('dashboard');
        } else {
            $this->sucursal_empresas_id_seleccionado = Util::getSucursalEmpresaIdLocalStorage();
        }

        $this->articulo_id = $articulo;


        date_default_timezone_set('America/Lima');

        $dataGeneral = [];

        /*   $response = ArticuloRequerimientoPersonal::where('articulos_id', '=', $this->articulo_id)->where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)->get();
 */

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
            ->get();




        //salidas 



        $articuloSalidaAux = SalidaDetalle::join('sucursal_empresas', 'salida_detalles.sucursal_empresas_id', '=', 'sucursal_empresas.id')
            ->select('salida_detalles.*')
            ->where('sucursal_empresas.empresas_id', '=', Util::getTiendaIdLocalStorage())
            ->where('salida_detalles.articulos_id', '=', $this->articulo_id)
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
                        'articulo' => "Compra " . $item->tipo_documento . " N°  " . $item->numero_documento,
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
                'articulo' => $item->tipoDevolucion,
                'cantidad' => $item->cantidad,
                'fecha' => $item->fecha_devolucion,
                'auxo' => $item->fecha_devolucion,
                'precio' => "",
                'tipoDevolucion' => $item->tipoDevolucion,

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
        $auxiliarGeneral = Util::generarKardex($dataGeneral, $rango_inicio, $rango_fin);



        $articulo = $this->modelarArticulo();



        $sucursalEmpresa = SucursalEmpresa::find($this->sucursal_empresas_id_seleccionado);
       
        $personalPdf = PersonalPdf::where('estado', '=', '1')->where('tipo_opcion', '=', 'Kardex')->where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)->take(3)->get();



        $name_pdf = "kardex-" . $rango_inicio . ".pdf";

          return PDF::loadView('admin.pdf.kardex', compact(
          
            'articulo',
            'sucursalEmpresa',
            'criterioBusqueda',
            'personalPdf',
            'rango_inicio',
            'rango_fin',
            'auxiliarGeneral',
        ))->setPaper('a4', 'landscape')->download($name_pdf);





        /* $data = PDF::loadView('admin.pdf.kardex', compact(
          
            'articulo',
            'sucursalEmpresa',
            'criterioBusqueda',
            'personalPdf',
            'rango_inicio',
            'rango_fin',
            'auxiliarGeneral',
        ))->setPaper('a4', 'landscape');
        return $data->stream($name_pdf); */
    }

    public function obtenerMes($mes)
    {
        $mes = intval($mes);
        $concatenado = "";
        switch ($mes) {
            case 1:
                $concatenado = "Enero";
                break;
            case 2:
                $concatenado = "Febrero";
                break;
            case 3:
                $concatenado = "Marzo";
                break;
            case 4:
                $concatenado = "Abril";
                break;
            case 5:
                $concatenado = "Mayo";
                break;
            case 6:
                $concatenado = "Junio";
                break;
            case 7:
                $concatenado = "Julio";
                break;
            case 8:
                $concatenado = "Agosto";
                break;
            case 9:
                $concatenado = "Septiembre";
                break;
            case 10:
                $concatenado = "Octubre";
                break;
            case 11:
                $concatenado = "Noviembre";
                break;
            case 12:
                $concatenado = "Diciembre";
                break;
        }

        return $concatenado;
    }




    public function obtenerSaldoAnteriorProductoPorMeses()
    {

        $data = ArticuloRequerimientoPersonal::where('articulos_id', '=', $this->articulo_id)
            ->where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)
            ->where('fecha_ingreso', '!=', null)
            ->get();



        $dataGeneral = [];

        foreach ($data as $d) {
            $response = ArticuloOrdenCompra::where('articulo_r_personals_id', '=', $d->id)->get();
            foreach ($response as $re) {
                $re->fecha_ingreso = $d->fecha_ingreso;
                $dataGeneral[] = $re;
            }
        }

        $datos_formateados = [];


        #sacando años seleccionados


        foreach ($dataGeneral as $d) {

            $fecha_obtenida = Carbon::parse($d->fecha_ingreso);

            if ($this->mesSeleccionado == 1) {
                if ($fecha_obtenida->year < intval($this->anio_seleccionado)) {
                    $d->operacion = "entrada_detalle";
                    $datos_formateados[] = $d;
                }
            } else {

                if ($fecha_obtenida->month < intval($this->mesSeleccionado) && $fecha_obtenida->year <= intval($this->anio_seleccionado)) {
                    $d->operacion = "entrada_detalle";
                    $datos_formateados[] = $d;
                }
            }
        }



        $data_salida = $this->modelarArticuloSalidaDetallePorMeses($datos_formateados, 'de_calcular_articulo');



        foreach ($data_salida as $ds) {
            $fecha_obtenida = Carbon::parse($ds->fecha_salida);
            if ($this->mesSeleccionado == 1) {
                if ($fecha_obtenida->year < intval($this->anio_seleccionado)) {
                    $ds->operacion = "salida_detalle";
                    $datos_formateados[] = $ds;
                }
            } else {
                if ($fecha_obtenida->month < intval($this->mesSeleccionado) && $fecha_obtenida->year <= intval($this->anio_seleccionado)) {
                    $ds->operacion = "salida_detalle";
                    $datos_formateados[] = $ds;
                }
            }
        }




        if (count($datos_formateados) > 0) {

            for ($x = 0; $x < count($datos_formateados); $x++) {
                for ($i = 0; $i < count($datos_formateados) - $x - 1; $i++) {
                    $articulo = $datos_formateados[$i];
                    $articulo2 = $datos_formateados[$i + 1];
                    $fecha_actual_uno = null;
                    $fecha_actual_dos = null;
                    if ($articulo->operacion == 'entrada_detalle') {
                        $fecha_actual_uno = Carbon::parse($articulo->fecha_ingreso)->format('Y-m-d');
                    } else if ($articulo->operacion == 'salida_detalle') {
                        $fecha_actual_uno = Carbon::parse($articulo->fecha_salida)->format('Y-m-d');
                    }

                    if ($articulo2->operacion == 'entrada_detalle') {
                        $fecha_actual_dos = Carbon::parse($articulo2->fecha_ingreso)->format('Y-m-d');
                    } else if ($articulo2->operacion == 'salida_detalle') {

                        $fecha_actual_dos = Carbon::parse($articulo2->fecha_salida)->format('Y-m-d');
                    }

                    if ($fecha_actual_uno < $fecha_actual_dos) {
                        $tmp = $datos_formateados[$i + 1];
                        $datos_formateados[$i + 1] = $datos_formateados[$i];
                        $datos_formateados[$i] = $tmp;
                    }
                }
            }
        }





        $reverse = array_reverse($datos_formateados);
        $datos_formateados = $reverse;



        $datos_actualizados = [];
        $cantidad_existencia = 0;

        $valor_existencia = 0;
        $this->cantidad_inicial_inicial = 0;



        for ($i = 0; $i < count($datos_formateados); $i++) {

            $articulo = $datos_formateados[$i];
            if ($i == 0) {
                if ($articulo->operacion == 'entrada_detalle') {
                    $cantidad_existencia = $cantidad_existencia + ($datos_formateados[$i]->cantidad + $this->cantidad_inicial_inicial);
                    $valor_existencia = $datos_formateados[$i]->precio_unitario * $datos_formateados[$i]->cantidad + $valor_existencia;
                    $articulo->cantidad_existencia = $cantidad_existencia;
                    $articulo->valor_existencia = $valor_existencia;
                    $articulo->valor_unitario_existencias = Util::darFormatoMoneda($valor_existencia / $cantidad_existencia);

                    $datos_actualizados[] = $articulo;
                }
            } else {
                if ($articulo->operacion == 'entrada_detalle') {
                    $cantidad_existencia = $cantidad_existencia + $datos_formateados[$i]->cantidad;
                    $valor_existencia = $datos_formateados[$i]->precio_unitario * $datos_formateados[$i]->cantidad + $valor_existencia;
                    $articulo->cantidad_existencia = $cantidad_existencia;
                    $articulo->valor_existencia = $valor_existencia;
                    $articulo->valor_unitario_existencias = Util::darFormatoMoneda($valor_existencia / $cantidad_existencia);

                    $datos_actualizados[] = $articulo;
                } else if ($articulo->operacion == 'salida_detalle') {
                    if ($cantidad_existencia > 0) {

                        $articulo->valor_unitario_salida = $valor_existencia / $cantidad_existencia;
                    } else {
                        $articulo->valor_unitario_salida = $valor_existencia / 1;
                    }
                    $cantidad_existencia = $cantidad_existencia - $datos_formateados[$i]->cantidad;
                    $valor_existencia = $valor_existencia - ($articulo->cantidad * $articulo->valor_unitario_salida);
                    $articulo->cantidad_existencia = $cantidad_existencia;
                    $articulo->valor_existencia = $valor_existencia;

                    if ($cantidad_existencia > 0) {

                        $articulo->valor_unitario_existencias = Util::darFormatoMoneda($valor_existencia /  $cantidad_existencia);
                    } else {
                        $articulo->valor_unitario_existencias = Util::darFormatoMoneda($valor_existencia /  1);
                    }
                    $datos_actualizados[] = $articulo;
                }
            }
        }






        $this->cantidad_existencia_total_inicial = $cantidad_existencia;
        $this->cantidad_inicial_inicial = $cantidad_existencia;

        if ($cantidad_existencia > 0) {

            $this->valor_unitario_total_inicial = Util::darFormatoMoneda($valor_existencia / $cantidad_existencia);
        } else {
            $this->valor_unitario_total_inicial = Util::darFormatoMoneda($valor_existencia);
        }
        $this->valor_total_total_inicial_auxiliar = $valor_existencia;
        $this->valor_total_total_inicial = "S/" . Util::darFormatoMoneda($valor_existencia);
    }


    /* MESES ARTICULOS */

    public function modelarArticuloRequerimientoPersonalPorMeses()
    {


        $this->obtenerSaldoAnteriorProductoPorMeses();
        $data = ArticuloRequerimientoPersonal::where('articulos_id', '=', $this->articulo_id)
            ->where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)
            ->whereMonth('fecha_ingreso', $this->mesSeleccionado)
            ->whereYear('fecha_ingreso', $this->anio_seleccionado)
            ->get();




        $dataGeneral = [];



        foreach ($data as $d) {


            $response = ArticuloOrdenCompra::where('articulo_r_personals_id', '=', $d->id)->get();
            foreach ($response as $re) {
                $re->fecha_ingreso = $d->fecha_ingreso;
                $dataGeneral[] = $re;
            }
        }





        $datos_formateados = [];

        foreach ($dataGeneral as $d) {
            $fecha_obtenida = Carbon::parse($d->fecha_ingreso);

            if ($this->mesSeleccionado == 1) {
                $respuesta_mes = $fecha_obtenida->month == intval($this->mesSeleccionado);
                $respuesta_anio = $fecha_obtenida->year <= intval($this->anio_seleccionado);

                if ($respuesta_mes && $respuesta_anio) {
                    $ordeCompra = OrdenDeCompra::where('id', '=', $d->orden_de_compras_id)->first();
                    if ($ordeCompra) {
                        $d->ordenCompra = $ordeCompra;

                        $d->operacion = "entrada_detalle";
                        $datos_formateados[] = $d;
                    }
                }
            } else {
                $respuesta_mes = $fecha_obtenida->month == intval($this->mesSeleccionado);
                $respuesta_anio = $fecha_obtenida->year <= intval($this->anio_seleccionado);


                if ($respuesta_mes && $respuesta_anio) {
                    $ordeCompra = OrdenDeCompra::where('id', '=', $d->orden_de_compras_id)->first();
                    if ($ordeCompra) {
                        $d->ordenCompra = $ordeCompra;

                        $d->operacion = "entrada_detalle";
                        $datos_formateados[] = $d;
                    }
                }
            }
        }



        $data_salida = $this->modelarArticuloSalidaDetallePorMeses($data, 'de_calcular_articulo');





        foreach ($data_salida as $ds) {

            $fecha_obtenida = Carbon::parse($ds->fecha_salida);

            $respuesta_mes = $fecha_obtenida->month == intval($this->mesSeleccionado);
            $respuesta_anio = $fecha_obtenida->year == intval($this->anio_seleccionado);

            if ($respuesta_mes && $respuesta_anio) {
                $ds->operacion = "salida_detalle";
                $datos_formateados[] = $ds;
            }
        }





        if (count($datos_formateados) > 0) {

            for ($x = 0; $x < count($datos_formateados); $x++) {
                for ($i = 0; $i < count($datos_formateados) - $x - 1; $i++) {
                    $articulo = $datos_formateados[$i];
                    $articulo2 = $datos_formateados[$i + 1];
                    $fecha_actual_uno = null;
                    $fecha_actual_dos = null;
                    if ($articulo->operacion == 'entrada_detalle') {
                        $fecha_actual_uno = Carbon::parse($articulo->fecha_ingreso)->format('Y-m-d h:i:s');
                    } else if ($articulo->operacion == 'salida_detalle') {
                        $fecha_actual_uno = Carbon::parse($articulo->fecha_salida)->format('Y-m-d h:i:s');
                    }

                    if ($articulo2->operacion == 'entrada_detalle') {
                        $fecha_actual_dos = Carbon::parse($articulo2->fecha_ingreso)->format('Y-m-d h:i:s');
                    } else if ($articulo2->operacion == 'salida_detalle') {

                        $fecha_actual_dos = Carbon::parse($articulo2->fecha_salida)->format('Y-m-d h:i:s');
                    }

                    if ($fecha_actual_uno < $fecha_actual_dos) {
                        $tmp = $datos_formateados[$i + 1];
                        $datos_formateados[$i + 1] = $datos_formateados[$i];
                        $datos_formateados[$i] = $tmp;
                    }
                }
            }
        }



        $reverse = array_reverse($datos_formateados);
        $datos_formateados = $reverse;



        $datos_actualizados = [];
        $cantidad_existencia = 0;

        if ($this->cantidad_inicial_inicial == null) {
            $this->cantidad_inicial_inicial = 0;
        }
        if ($this->valor_unitario_total_inicial == null) {
            $this->valor_unitario_total_inicial = 0;
        }
        $valor_existencia = (floatval($this->valor_unitario_total_inicial) * floatval($this->cantidad_inicial_inicial));



        for ($i = 0; $i < count($datos_formateados); $i++) {
            $articulo = $datos_formateados[$i];
            if ($i == 0) {
                if ($articulo->operacion == 'entrada_detalle') {
                    $cantidad_existencia = $cantidad_existencia + ($datos_formateados[$i]->cantidad + $this->cantidad_inicial_inicial);
                    $valor_existencia = $datos_formateados[$i]->precio_unitario * $datos_formateados[$i]->cantidad + $valor_existencia;
                    $articulo->cantidad_existencia = $cantidad_existencia;
                    $articulo->valor_existencia = $valor_existencia;
                    $articulo->valor_unitario_existencias = Util::darFormatoMoneda($valor_existencia / $cantidad_existencia);

                    $datos_actualizados[] = $articulo;
                } else {
                    $cantidad_existencia = $this->cantidad_existencia_total_inicial;
                    $valor_existencia = $this->valor_total_total_inicial_auxiliar;
                    if ($cantidad_existencia > 0) {

                        $articulo->valor_unitario_salida = $valor_existencia / $cantidad_existencia;
                    } else {
                        $articulo->valor_unitario_salida = $valor_existencia / 1;
                    }
                    $cantidad_existencia = $cantidad_existencia - $datos_formateados[$i]->cantidad;
                    $valor_existencia = $valor_existencia - ($articulo->cantidad * $articulo->valor_unitario_salida);

                    $articulo->valor_unitario_salida = Util::darFormatoMoneda($articulo->valor_unitario_salida);

                    $articulo->cantidad_existencia = $cantidad_existencia;

                    $articulo->valor_existencia = $valor_existencia;

                    if ($cantidad_existencia > 0) {

                        $articulo->valor_unitario_existencias = Util::darFormatoMoneda($valor_existencia /  $cantidad_existencia);
                    } else {
                        $articulo->valor_unitario_existencias = Util::darFormatoMoneda($valor_existencia /  1);
                    }
                    $datos_actualizados[] = $articulo;
                }
            } else {
                if ($articulo->operacion == 'entrada_detalle') {
                    $cantidad_existencia = $cantidad_existencia + $datos_formateados[$i]->cantidad;
                    $valor_existencia = $datos_formateados[$i]->precio_unitario * $datos_formateados[$i]->cantidad + $valor_existencia;
                    $articulo->cantidad_existencia = $cantidad_existencia;
                    $articulo->valor_existencia = $valor_existencia;
                    $articulo->valor_unitario_existencias = Util::darFormatoMoneda($valor_existencia / $cantidad_existencia);

                    $datos_actualizados[] = $articulo;
                } else if ($articulo->operacion == 'salida_detalle') {
                    if ($cantidad_existencia > 0) {

                        $articulo->valor_unitario_salida = $valor_existencia / $cantidad_existencia;
                    } else {
                        $articulo->valor_unitario_salida = $valor_existencia / 1;
                    }
                    $cantidad_existencia = $cantidad_existencia - $datos_formateados[$i]->cantidad;
                    $valor_existencia = $valor_existencia - ($articulo->cantidad * $articulo->valor_unitario_salida);
                    $articulo->cantidad_existencia = $cantidad_existencia;
                    $articulo->valor_existencia = $valor_existencia;

                    if ($cantidad_existencia > 0) {

                        $articulo->valor_unitario_existencias = Util::darFormatoMoneda($valor_existencia /  $cantidad_existencia);
                    } else {
                        $articulo->valor_unitario_existencias = Util::darFormatoMoneda($valor_existencia /  1);
                    }
                    $articulo->valor_unitario_salida = Util::darFormatoMoneda($articulo->valor_unitario_salida);

                    $datos_actualizados[] = $articulo;
                }
            }
        }


        $this->cantidad_existencia_total = $cantidad_existencia;
        if ($cantidad_existencia > 0) {

            $this->valor_unitario_total = Util::darFormatoMoneda($valor_existencia / $cantidad_existencia);
        } else {
            $this->valor_unitario_total = Util::darFormatoMoneda($valor_existencia);
        }
        $this->valor_total_total = "S/" . Util::darFormatoMoneda($valor_existencia);






        return $datos_actualizados;
    }

    /* MESES ARTICULOS */



    /* ARTICULOS POR RANGO */
    public function modelarArticuloRequerimientoPersonalPorRango()
    {

        $this->obtenerSaldoAnteriorProductoPorMesesPorRango();

        $data = ArticuloRequerimientoPersonal::where('articulos_id', '=', $this->articulo_id)
            ->where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)
            ->get();

        $dataGeneral = [];

        foreach ($data as $d) {
            $response = ArticuloOrdenCompra::where('articulo_r_personals_id', '=', $d->id)->get();

            foreach ($response as $re) {
                $fecha_parseada = Carbon::parse($re->fecha_ingreso)->format('Y-m-d');

                if ($fecha_parseada >= $this->rango_inicio && $fecha_parseada <= $this->rango_fin) {

                    $dataGeneral[] = $re;
                }
            }
        }










        $datos_formateados = [];

        foreach ($dataGeneral as $d) {
            $fecha_obtenida = Carbon::parse($d->fecha_ingreso);

            if ($fecha_obtenida >= Carbon::parse($this->rango_inicio) && $fecha_obtenida <= Carbon::parse($this->rango_fin)) {
                $ordeCompra = OrdenDeCompra::where('id', '=', $d->orden_de_compras_id)->first();
                if ($ordeCompra) {
                    $d->ordenCompra = $ordeCompra;

                    $d->operacion = "entrada_detalle";
                    $datos_formateados[] = $d;
                }
            }
        }



        $data_salida = $this->modelarArticuloSalidaDetallePorRango($data, 'de_calcular_articulo');


        foreach ($data_salida as $ds) {

            $fecha_salida = Carbon::parse($ds->fecha_salida)->format('Y-m-d');
            $fecha_ingreso = Carbon::parse($ds->fecha_ingreso)->format('Y-m-d');
            $fecha_rango_inicio = Carbon::parse($this->rango_inicio)->format('Y-m-d');
            $fecha_rango_fin = Carbon::parse($this->rango_fin)->format('Y-m-d');


            if ($fecha_ingreso >= $fecha_rango_inicio &&  $fecha_salida <= $fecha_rango_fin) {

                $ds->operacion = "salida_detalle";
                $datos_formateados[] = $ds;
            }
        }








        if (count($datos_formateados) > 0) {
            for ($x = 0; $x < count($datos_formateados); $x++) {
                for ($i = 0; $i < count($datos_formateados) - $x - 1; $i++) {
                    $articulo = $datos_formateados[$i];
                    $articulo2 = $datos_formateados[$i + 1];
                    $fecha_actual_uno = null;
                    $fecha_actual_dos = null;
                    if ($articulo->operacion == 'entrada_detalle') {
                        $fecha_actual_uno = Carbon::parse($articulo->fecha_ingreso)->format('Y-m-d H:i');
                    } else if ($articulo->operacion == 'salida_detalle') {

                        $fecha_actual_uno = Carbon::parse($articulo->fecha_salida)->format('Y-m-d H:i');
                    }

                    if ($articulo2->operacion == 'entrada_detalle') {
                        $fecha_actual_dos = Carbon::parse($articulo2->fecha_ingreso)->format('Y-m-d H:i');
                    } else if ($articulo2->operacion == 'salida_detalle') {

                        $fecha_actual_dos = Carbon::parse($articulo2->fecha_salida)->format('Y-m-d H:i');
                    }

                    if ($fecha_actual_uno < $fecha_actual_dos) {
                        $tmp = $datos_formateados[$i + 1];
                        $datos_formateados[$i + 1] = $datos_formateados[$i];
                        $datos_formateados[$i] = $tmp;
                    }
                }
            }
        }


        $reverse = array_reverse($datos_formateados);
        $datos_formateados = $reverse;



        $datos_actualizados = [];
        $cantidad_existencia = 0;
        $valor_existencia = 0;
        if (count($datos_formateados) > 0) {
            $valor_existencia = ($this->valor_unitario_total_inicial * $this->cantidad_inicial_inicial);
        }



        for ($i = 0; $i < count($datos_formateados); $i++) {
            $articulo = $datos_formateados[$i];
            if ($i == 0) {
                if ($articulo->operacion == 'entrada_detalle') {
                    $cantidad_existencia = $cantidad_existencia + ($datos_formateados[$i]->cantidad + $this->cantidad_inicial_inicial);
                    $valor_existencia = $datos_formateados[$i]->precio_unitario * $datos_formateados[$i]->cantidad + $valor_existencia;
                    $articulo->cantidad_existencia = $cantidad_existencia;
                    $articulo->valor_existencia = $valor_existencia;
                    $articulo->valor_unitario_existencias = Util::darFormatoMoneda($valor_existencia / $cantidad_existencia);

                    $datos_actualizados[] = $articulo;
                } else {
                    $cantidad_existencia = $this->cantidad_existencia_total_inicial;
                    $valor_existencia = $this->valor_total_total_inicial_auxiliar;
                    if ($cantidad_existencia > 0) {

                        $articulo->valor_unitario_salida = $valor_existencia / $cantidad_existencia;
                    } else {
                        $articulo->valor_unitario_salida = $valor_existencia / 1;
                    }
                    $cantidad_existencia = $cantidad_existencia - $datos_formateados[$i]->cantidad;
                    $valor_existencia = $valor_existencia - ($articulo->cantidad * $articulo->valor_unitario_salida);

                    $articulo->valor_unitario_salida = Util::darFormatoMoneda($articulo->valor_unitario_salida);


                    $articulo->cantidad_existencia = $cantidad_existencia;

                    $articulo->valor_existencia = $valor_existencia;

                    if ($cantidad_existencia > 0) {

                        $articulo->valor_unitario_existencias = Util::darFormatoMoneda($valor_existencia /  $cantidad_existencia);
                    } else {
                        $articulo->valor_unitario_existencias = Util::darFormatoMoneda($valor_existencia /  1);
                    }
                    $datos_actualizados[] = $articulo;
                }
            } else {
                if ($articulo->operacion == 'entrada_detalle') {
                    $cantidad_existencia = $cantidad_existencia + $datos_formateados[$i]->cantidad;
                    $valor_existencia = $datos_formateados[$i]->precio_unitario * $datos_formateados[$i]->cantidad + $valor_existencia;
                    $articulo->cantidad_existencia = $cantidad_existencia;
                    $articulo->valor_existencia = $valor_existencia;
                    if ($cantidad_existencia > 0) {

                        $articulo->valor_unitario_existencias = Util::darFormatoMoneda($valor_existencia / $cantidad_existencia);
                    } else {
                        $articulo->valor_unitario_existencias = Util::darFormatoMoneda($valor_existencia / 1);
                    }

                    $datos_actualizados[] = $articulo;
                } else if ($articulo->operacion == 'salida_detalle') {
                    if ($cantidad_existencia > 0) {

                        $articulo->valor_unitario_salida = $valor_existencia / $cantidad_existencia;
                    } else {
                        $articulo->valor_unitario_salida = $valor_existencia / 1;
                    }
                    $cantidad_existencia = $cantidad_existencia - $datos_formateados[$i]->cantidad;
                    $valor_existencia = $valor_existencia - ($articulo->cantidad * $articulo->valor_unitario_salida);
                    $articulo->cantidad_existencia = $cantidad_existencia;
                    $articulo->valor_existencia = $valor_existencia;

                    if ($cantidad_existencia < 0) {
                        $cantidad_existencia = 0;
                    }


                    if ($cantidad_existencia > 0) {

                        $articulo->valor_unitario_existencias = Util::darFormatoMoneda($valor_existencia /  $cantidad_existencia);
                    } else {
                        $articulo->valor_unitario_existencias = Util::darFormatoMoneda($valor_existencia /  1);
                    }
                    $articulo->valor_unitario_salida = Util::darFormatoMoneda($articulo->valor_unitario_salida);

                    $datos_actualizados[] = $articulo;
                }
            }
        }


        $this->cantidad_existencia_total = $cantidad_existencia;
        if ($cantidad_existencia > 0) {

            $this->valor_unitario_total = Util::darFormatoMoneda($valor_existencia / $cantidad_existencia);
        } else {
            $this->valor_unitario_total = Util::darFormatoMoneda($valor_existencia);
        }
        $this->valor_total_total = "S/" . Util::darFormatoMoneda($valor_existencia);






        return $datos_actualizados;
    }

    /* ARTICULOS POR RANGO */




    public function obtenerSaldoAnteriorProductoPorMesesPorRango()
    {


        $data = ArticuloRequerimientoPersonal::where('articulos_id', '=', $this->articulo_id)
            ->where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)

            ->get();

        $dataGeneral = [];

        foreach ($data as $d) {
            $response = ArticuloOrdenCompra::where('articulo_r_personals_id', '=', $d->id)->get();

            foreach ($response as $re) {
                $fecha_parseada = Carbon::parse($re->fecha_ingreso)->format('Y-m-d');
                $rangoInicio = Carbon::parse($this->rango_inicio)->format('Y-m-d');
                if ($fecha_parseada < $rangoInicio) {

                    $dataGeneral[] = $re;
                }
            }
        }


        $datos_formateados = [];

        foreach ($dataGeneral as $d) {


            $ordeCompra = OrdenDeCompra::where('id', '=', $d->orden_de_compras_id)->first();
            if ($ordeCompra) {
                $d->ordenCompra = $ordeCompra;

                $d->operacion = "entrada_detalle";
                $datos_formateados[] = $d;
            }
        }








        $data_salida = $this->modelarArticuloSalidaDetallePorRango($datos_formateados, 'de_calcular_articulo');



        foreach ($data_salida as $ds) {
            $fecha_obtenida = Carbon::parse($ds->fecha_salida);
            if ($fecha_obtenida < Carbon::parse($this->rango_inicio)) {
                $ds->operacion = "salida_detalle";
                $datos_formateados[] = $ds;
            }
        }








        if (count($datos_formateados) > 0) {

            for ($x = 0; $x < count($datos_formateados); $x++) {
                for ($i = 0; $i < count($datos_formateados) - $x - 1; $i++) {
                    $articulo = $datos_formateados[$i];
                    $articulo2 = $datos_formateados[$i + 1];
                    $fecha_actual_uno = null;
                    $fecha_actual_dos = null;
                    if ($articulo->operacion == 'entrada_detalle') {
                        $fecha_actual_uno = Carbon::parse($articulo->fecha_ingreso)->format('Y-m-d H:i');
                    } else if ($articulo->operacion == 'salida_detalle') {
                        $fecha_actual_uno = Carbon::parse($articulo->fecha_salida)->format('Y-m-d H:i');
                    }

                    if ($articulo2->operacion == 'entrada_detalle') {
                        $fecha_actual_dos = Carbon::parse($articulo2->fecha_ingreso)->format('Y-m-d H:i');
                    } else if ($articulo2->operacion == 'salida_detalle') {

                        $fecha_actual_dos = Carbon::parse($articulo2->fecha_salida)->format('Y-m-d H:i');
                    }

                    if ($fecha_actual_uno < $fecha_actual_dos) {
                        $tmp = $datos_formateados[$i + 1];
                        $datos_formateados[$i + 1] = $datos_formateados[$i];
                        $datos_formateados[$i] = $tmp;
                    }
                }
            }
        }



        $reverse = array_reverse($datos_formateados);
        $datos_formateados = $reverse;



        $datos_actualizados = [];
        $cantidad_existencia = 0;

        $valor_existencia = 0;
        $this->cantidad_inicial_inicial = 0;



        for ($i = 0; $i < count($datos_formateados); $i++) {
            $articulo = $datos_formateados[$i];
            if ($i == 0) {
                if ($articulo->operacion == 'entrada_detalle') {
                    $cantidad_existencia = $cantidad_existencia + ($datos_formateados[$i]->cantidad + $this->cantidad_inicial_inicial);
                    $valor_existencia = $datos_formateados[$i]->precio_unitario * $datos_formateados[$i]->cantidad + $valor_existencia;
                    $articulo->cantidad_existencia = $cantidad_existencia;
                    $articulo->valor_existencia = $valor_existencia;
                    if ($cantidad_existencia > 0) {

                        $articulo->valor_unitario_existencias = Util::darFormatoMoneda($valor_existencia / $cantidad_existencia);
                    } else {
                        $articulo->valor_unitario_existencias = Util::darFormatoMoneda($valor_existencia / 1);
                    }

                    $datos_actualizados[] = $articulo;
                }
            } else {
                if ($articulo->operacion == 'entrada_detalle') {
                    $cantidad_existencia = $cantidad_existencia + $datos_formateados[$i]->cantidad;
                    $valor_existencia = $datos_formateados[$i]->precio_unitario * $datos_formateados[$i]->cantidad + $valor_existencia;
                    $articulo->cantidad_existencia = $cantidad_existencia;
                    $articulo->valor_existencia = $valor_existencia;
                    if ($cantidad_existencia > 0) {

                        $articulo->valor_unitario_existencias = Util::darFormatoMoneda($valor_existencia / $cantidad_existencia);
                    } else {
                        $articulo->valor_unitario_existencias = Util::darFormatoMoneda($valor_existencia / 1);
                    }

                    $datos_actualizados[] = $articulo;
                } else if ($articulo->operacion == 'salida_detalle') {
                    if ($cantidad_existencia > 0) {

                        $articulo->valor_unitario_salida = $valor_existencia / $cantidad_existencia;
                    } else {
                        $articulo->valor_unitario_salida = $valor_existencia / 1;
                    }
                    $cantidad_existencia = $cantidad_existencia - $datos_formateados[$i]->cantidad;
                    $valor_existencia = $valor_existencia - ($articulo->cantidad * $articulo->valor_unitario_salida);
                    $articulo->cantidad_existencia = $cantidad_existencia;
                    $articulo->valor_existencia = $valor_existencia;

                    if ($cantidad_existencia > 0) {

                        $articulo->valor_unitario_existencias = Util::darFormatoMoneda($valor_existencia /  $cantidad_existencia);
                    } else {
                        $articulo->valor_unitario_existencias = Util::darFormatoMoneda($valor_existencia /  1);
                    }
                    $datos_actualizados[] = $articulo;
                }
            }
        }





        $this->cantidad_existencia_total_inicial = $cantidad_existencia;
        $this->cantidad_inicial_inicial = $cantidad_existencia;

        if ($cantidad_existencia > 0) {

            $this->valor_unitario_total_inicial = Util::darFormatoMoneda($valor_existencia / $cantidad_existencia);
        } else {
            $this->valor_unitario_total_inicial = Util::darFormatoMoneda($valor_existencia);
        }
        $this->valor_total_total_inicial_auxiliar = $valor_existencia;
        $this->valor_total_total_inicial = "S/" . Util::darFormatoMoneda($valor_existencia);
    }





    /* CALCULO ARTIUCULOS MESES */
    public function modelarArticuloSalidaDetallePorMeses($dataArticulos, $opcion = '')
    {



        $data_salida = [];


        if (count($dataArticulos) > 0) {

            if ($opcion == 'de_calcular_articulos') {
                $data = SalidaDetalle::where('articulos_id', '=', $dataArticulos[0]->articulos_id)
                    ->get();
            } else {

                $data = SalidaDetalle::where('articulos_id', '=', $dataArticulos[0]->articulos_id)
                    ->whereMonth('fecha_salida', '<=', $this->rango_fin)
                    ->get();
            }


            foreach ($data as $d) {

                $d->operacion = "salida_detalle";

                $data_salida[] = $d;
            }
        }



        return $data_salida;
    }

    /* CALCULO ARTIUCULOS MESES */



    public function modelarArticuloSalidaDetallePorRango($dataArticulos, $opcion = '')
    {



        $data_salida = [];




        if ($opcion == 'de_calcular_articulo') {
            $data = ArticuloOrdenCompra::join('articulo_requerimiento_personals', 'articulo_orden_compras.articulo_r_personals_id', '=', 'articulo_requerimiento_personals.id')
                ->join('articulos', 'articulo_requerimiento_personals.articulos_id', '=', 'articulos.id')
                ->select('articulo_orden_compras.*')
                ->where('articulos.id', '=', $this->articulo_id)
                ->where('articulo_orden_compras.fecha_salida', '!=', null)
                ->where('articulo_orden_compras.sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)
                ->get();
        } else {

            $data = ArticuloOrdenCompra::join('articulo_requerimiento_personals', 'articulo_orden_compras.articulo_r_personals_id', '=', 'articulo_requerimiento_personals.id')
                ->join('articulos', 'articulo_requerimiento_personals.articulos_id', '=', 'articulos.id')
                ->select('articulo_orden_compras.*')
                ->where('articulos.id', '=', $this->articulo_id)
                ->whereMonth('articulo_orden_compras.fecha_salida', '<=', $this->rango_fin)
                ->where('articulo_orden_compras.fecha_salida', '!=', null)
                ->where('articulo_orden_compras.sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)
                ->get();
        }


        foreach ($data as $d) {

            $d->operacion = "salida_detalle";

            $data_salida[] = $d;
        }




        return $data_salida;
    }






    public function modelarArticulo()
    {
        return Articulo::find($this->articulo_id);
    }
}
