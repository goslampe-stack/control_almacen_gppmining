<?php

namespace App\Http\Controllers;

use App\Models\ArticuloIngreso;
use App\Models\ArticuloOrdenCompra;
use App\Models\ArticuloRequerimientoPersonal;
use App\Models\Ingreso;
use App\Models\PersonalPdf;
use App\Models\SucursalEmpresa;
use App\Models\User;
use App\Models\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;

class IngresosArticulos extends Controller
{
    public $modelId;
    public $sucursal_empresas_id_seleccionado;
    public function imprimirIngreso($medelo_id)
    {
        $this->modelId = $medelo_id;
        $this->sucursal_empresas_id_seleccionado = Util::getSucursalEmpresaIdLocalStorage();

        $ingreso = Ingreso::find($this->modelId);


        $articulos = ArticuloIngreso::where('orden_de_compras_id', '=', $ingreso->orden_de_compras_id)->orderBy('id', 'asc')->get();

       


        $total_articulos = 0;
        foreach ($articulos as $d) {
            $total_articulos = $total_articulos + $d->cantidad;
        }



        $sucursalEmpresa = SucursalEmpresa::find($this->sucursal_empresas_id_seleccionado);


        $personalPdf = PersonalPdf::where('estado','=','1')->where('tipo_opcion','=','Ingreso')->where('sucursal_empresas_id','=',$this->sucursal_empresas_id_seleccionado)->take(3)->get();
       

        $name_pdf = "Ingreso-N°-" . $ingreso->numero_ingreso . ".pdf";
   return PDF::loadView('admin.pdf.ingreso', compact(
               'ingreso',
            'personalPdf',
            'total_articulos',
            'sucursalEmpresa',
            'articulos',
        ))->setPaper('a4', 'portrait')->download($name_pdf); 

     
       /*  $data = PDF::loadView('admin.pdf.ingreso', compact(
            'ingreso',
            'personalPdf',
            'total_articulos',
            'sucursalEmpresa',
            'articulos',
        ));
        return $data->stream($name_pdf);  */


    }
    public function imprimirIngresoGeneral($fecha_ingreso)
    {
        $this->sucursal_empresas_id_seleccionado = Util::getSucursalEmpresaIdLocalStorage();


        $articulos = ArticuloOrdenCompra::where(DB::raw("(DATE_FORMAT(fecha_ingreso,'%d-%m-%Y'))"), '>=', $fecha_ingreso)
            ->where(DB::raw("(DATE_FORMAT(fecha_ingreso,'%d-%m-%Y'))"), '<=', $fecha_ingreso)
            ->where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)
            ->orderBy('id', 'asc')->get();

        for ($x = 0; $x < count($articulos); $x++) {
            for ($i = 0; $i < count($articulos) - $x - 1; $i++) {
                $articulo = $articulos[$i];
                $articulo2 = $articulos[$i + 1];

                if($articulo!=null && $articulo2!=null){

                    if($articulo->articuloRequerimiento!=null && $articulo2->articuloRequerimiento!=null){

                        if($articulo->articuloRequerimiento->articulo!=null && $articulo2->articuloRequerimiento->articulo){
        
                            if ($articulo->articuloRequerimiento->articulo->codigo > $articulo2->articuloRequerimiento->articulo->codigo) {
                                $tmp = $articulos[$i + 1];
                                $articulos[$i + 1] = $articulos[$i];
                                $articulos[$i] = $tmp;
                            }
                        }
                    }

                }

            }
        }




        $total_articulos = 0;
        foreach ($articulos as $d) {
            $total_articulos = $total_articulos + $d->cantidad;
        }



        $sucursalEmpresa = SucursalEmpresa::find($this->sucursal_empresas_id_seleccionado);

        $usuario = auth()->user();

        $datos_generados =$this->modelarFechaArticuloOrdenCompra();
        
        $reverse = array_unique($datos_generados);
        
        $contador = 0;
        $formato_numero_serie = '0000';
        
        foreach ($reverse as $orden) {
            $fecha=Util::darFormatoFecha($orden);
            if ($orden == $fecha_ingreso) {
                $formato_numero_serie = Util::formarNumeroRequerimiento($contador);
                break;
            }
            $contador = $contador + 1;
        }

        $name_pdf = "Ingreso-N°".$formato_numero_serie.".pdf";
        return PDF::loadView('admin.pdf.ingreso-general', compact(
            'usuario',
            'fecha_ingreso',
            'total_articulos',
            'sucursalEmpresa',
            'formato_numero_serie',
            'articulos',
        ))->download($name_pdf);
    }

    public function modelarFechaArticuloOrdenCompra()
    {
        $data = ArticuloOrdenCompra::select('fecha_ingreso')
            ->where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)
            ->where('fecha_ingreso', '!=', null)
            ->groupBy('fecha_ingreso')
            ->orderBy('fecha_ingreso', 'asc')
            ->get();

        $arreglo_fecha = [];

        foreach ($data as $item) {
            $fecha = Util::darFormatoFecha($item->fecha_ingreso);
            $arreglo_fecha[] = $fecha;
        }


        $arreglo_fecha = array_unique($arreglo_fecha);


        return $arreglo_fecha;
    }
}
