<?php

namespace App\Http\Controllers;

use App\Models\ArticuloOrdenCompra;
use App\Models\Personal;
use App\Models\PersonalPdf;
use App\Models\Salida;
use App\Models\SalidaDetalle;
use App\Models\SucursalEmpresa;
use App\Models\Util;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SalidaArticulos extends Controller
{
    public $modelId;
    public $sucursal_empresas_id_seleccionado;
    /*  public function imprimirSalida($modelo_id)
    {

        $this->modelId = $modelo_id;
        $this->sucursal_empresas_id_seleccionado = Util::getSucursalEmpresaIdLocalStorage();

        $articulos = SalidaDetalle::where('salidas_id', '=', $this->modelId)->orderBy('id', 'asc')->get();

        $salida = Salida::find($this->modelId);

        $total_articulos = 0;
        foreach ($articulos as $d) {
            $total_articulos = $total_articulos + $d->cantidad;
        }

        $sucursalEmpresa = SucursalEmpresa::find($this->sucursal_empresas_id_seleccionado);
        $usuario=auth()->user();

    
        


        $name_pdf = "Salida-N°-" . $salida->numero_salida . ".pdf";
        return PDF::loadView('admin.pdf.salida', compact(
            'salida',
            'total_articulos',
            'sucursalEmpresa',
            'usuario',
            'articulos',
        ))->download($name_pdf);
    }
 */

    public function imprimirSalida($rango_inicio, $rango_salida)
    {

        $this->sucursal_empresas_id_seleccionado = Util::getSucursalEmpresaIdLocalStorage();



        $fecha_seleccionada = Carbon::parse($rango_inicio)->format('d-m-Y');

        $fecha_seleccionada_salida = Carbon::parse($rango_salida)->format('d-m-Y');

        $articulos = ArticuloOrdenCompra::where(DB::raw("(DATE_FORMAT(fecha_salida,'%d-%m-%Y'))"), '>=', $fecha_seleccionada)
            ->where(DB::raw("(DATE_FORMAT(fecha_salida,'%d-%m-%Y'))"), '<=', $fecha_seleccionada_salida)
            ->where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)
            ->orderBy('id', 'asc')->get();


        $orders = ArticuloOrdenCompra::where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)->orderBy('fecha_salida', 'asc')->get();

        $datos_generados = [];
        foreach ($orders as $or) {
            $fecha = Carbon::parse($or->fecha_salida)->format('d-m-Y');

            $datos_generados[] = $fecha;
        }

        $reverse = array_unique($datos_generados);

        $contador = 0;
        $formato_numero_serie = '0000';

        foreach ($reverse as $orden) {
            if ($orden == $fecha_seleccionada) {

                $formato_numero_serie = Util::formarNumeroRequerimiento($contador);
                break;
            }

            $contador = $contador + 1;
        }






        $sucursalEmpresa = SucursalEmpresa::find($this->sucursal_empresas_id_seleccionado);
        $usuario = auth()->user();





        $name_pdf = "Salida-N°.pdf";
        return PDF::loadView('admin.pdf.salida', compact(
            'sucursalEmpresa',
            'rango_inicio',
            'formato_numero_serie',
            'usuario',
            'articulos',
            'rango_salida',
        ))->setPaper('a4', 'portrait')->download($name_pdf);
    }
    public function imprimirSalidaId($modeloId)
    {

        $this->sucursal_empresas_id_seleccionado = Util::getSucursalEmpresaIdLocalStorage();





        $articulos = SalidaDetalle::where('salidas_id', '=', $modeloId)
            ->orderBy('id', 'asc')->get();


        $salida = Salida::find($modeloId);

        $orders = ArticuloOrdenCompra::where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)->orderBy('fecha_salida', 'asc')->get();



        $contador = 0;
        $formato_numero_serie = '0000';


        $sucursalEmpresa = SucursalEmpresa::find($this->sucursal_empresas_id_seleccionado);

        $personalPdf = PersonalPdf::where('estado', '=', '1')->where('tipo_opcion', '=', 'Salida')->where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)->take(3)->get();



        $name_pdf = "Salida-N°.pdf";
        return PDF::loadView('admin.pdf.salida', compact(
            'sucursalEmpresa',
            'salida',
            'formato_numero_serie',
            'personalPdf',
            'articulos',
        ))->setPaper('a4', 'portrait')->download($name_pdf);



        /* 
        $data = PDF::loadView('admin.pdf.salida', compact(
            'sucursalEmpresa',
            'salida',
            'formato_numero_serie',
            'personalPdf',
            'articulos',
        ));
        return $data->stream($name_pdf); */
    }

    public function imprimirSalidaGeneral($fecha_salida)
    {

        $this->sucursal_empresas_id_seleccionado = Util::getSucursalEmpresaIdLocalStorage();


        $jefe_mina = Personal::where('cargo', '=', 'Jefe de mina')
            ->where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)->first();


        $fecha_seleccionada = Carbon::parse($fecha_salida)->format('d-m-Y');

        $fecha_seleccionada_salida = Carbon::parse($fecha_salida)->format('d-m-Y');

        $articulos = ArticuloOrdenCompra::where(DB::raw("(DATE_FORMAT(fecha_salida,'%d-%m-%Y'))"), '>=', $fecha_seleccionada)
            ->where(DB::raw("(DATE_FORMAT(fecha_salida,'%d-%m-%Y'))"), '<=', $fecha_seleccionada_salida)
            ->where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)
            ->orderBy('id', 'asc')->get();


        $orders = ArticuloOrdenCompra::where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)->orderBy('fecha_salida', 'asc')->get();

        $datos_generados = $this->modelarFechaArticuloOrdenCompra();


        $reverse = array_unique($datos_generados);

        $contador = 0;
        $formato_numero_serie = '0000';

        foreach ($reverse as $orden) {
            $fecha = Util::darFormatoFecha($orden);
            if ($orden == $fecha_salida) {

                $formato_numero_serie = Util::formarNumeroRequerimiento($contador);
                break;
            }

            $contador = $contador + 1;
        }






        $sucursalEmpresa = SucursalEmpresa::find($this->sucursal_empresas_id_seleccionado);
        $usuario = auth()->user();





        $name_pdf = "Salida-N°" . $formato_numero_serie . ".pdf";
        return PDF::loadView('admin.pdf.salida', compact(
            'sucursalEmpresa',
            'fecha_salida',
            'jefe_mina',
            'formato_numero_serie',
            'usuario',
            'articulos',
        ))->setPaper('a4', 'portrait')->download($name_pdf);
    }


    public function modelarFechaArticuloOrdenCompra()
    {
        $data = ArticuloOrdenCompra::select('fecha_salida')
            ->where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)
            ->where('fecha_salida', '!=', null)
            ->groupBy('fecha_salida')
            ->orderBy('fecha_salida', 'asc')
            ->get();

        $arreglo_fecha = [];

        foreach ($data as $item) {
            $fecha = Util::darFormatoFecha($item->fecha_salida);
            $arreglo_fecha[] = $fecha;
        }


        $arreglo_fecha = array_unique($arreglo_fecha);


        return $arreglo_fecha;
    }
}
