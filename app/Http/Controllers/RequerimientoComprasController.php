<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ArticuloRequerimientoCompra;
use App\Models\PersonalPdf;
use App\Models\RequerimientoCompra;
use App\Models\SucursalEmpresa;
use App\Models\Util;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade as PDF;


class RequerimientoComprasController extends Controller
{
    public $modelId;
    public $sucursal_empresas_id_seleccionado;

    public function imprimirRequerimientoCompra($medelo_id)
    {

        $this->modelId = $medelo_id;
        $this->sucursal_empresas_id_seleccionado = Util::getSucursalEmpresaIdLocalStorage();


        $articulos = ArticuloRequerimientoCompra::where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)
            ->where('requerimientoCompras_id', '=', $this->modelId)
            ->orderBy('id',  'asc')
            ->get();




        $costoTotal = 0;
        foreach ($articulos as $aux) {


            $costoTotal = $costoTotal +  $aux->cantidad;
        }





        $requerimiento = RequerimientoCompra::find($this->modelId);


        $sucursalEmpresa = SucursalEmpresa::find($this->sucursal_empresas_id_seleccionado);
        $personalPdf = PersonalPdf::where('estado', '=', '1')->where('tipo_opcion', '=', 'Requerimiento de compras')->where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)->take(3)->get();

        //Sacar medidas 
        $direccionEmpresa = "DIRECCI&Oacute;N DE LA EMPRESA: " . $sucursalEmpresa->direccion;
        $terminosDelRequerimiento = "N° DE REQUERIMIENTO INTERNO DE PRODUCTOS: " . $requerimiento->requerimientoPersonal->numero_requerimiento;

        $contadorTotal1 = Util::contarLetras($direccionEmpresa);

        $contadorTotal2 = Util::contarLetras($terminosDelRequerimiento);

        /* Fase 1 */

        //91 es el tamanio de la frase de una linea
        $sumaTotalDobleLinea = Util::obtenerTotalLineaPdfParaArriba(91, $contadorTotal1);

        $sumaTotalDobleLinea = $sumaTotalDobleLinea + Util::obtenerTotalLineaPdfParaArriba(91, $contadorTotal2);


        $contadorTotal = 0;

        if ($sumaTotalDobleLinea == 2) {
            $contadorTotal = 280;
        } elseif ($sumaTotalDobleLinea == 3) {
            $contadorTotal = 300;
        } elseif ($sumaTotalDobleLinea == 4) {
            $contadorTotal = 320;
        } elseif ($sumaTotalDobleLinea == 5) {
            $contadorTotal = 340;
        } elseif ($sumaTotalDobleLinea == 6) {
            $contadorTotal = 360;
        } elseif ($sumaTotalDobleLinea == 7) {
            $contadorTotal = 380;
        } elseif ($sumaTotalDobleLinea == 8) {
            $contadorTotal = 400;
        } else {
            $contadorTotal = 420;
        }
        ///////LEEMOS EL ARRAGLO
        $arregloFirmas = json_decode($requerimiento->personalpdf, true);
         if($arregloFirmas==null){
            $arregloFirmas=[];
        }
        ///////LEEMOS EL ARRAGLO


        $name_pdf = "Requerimiento-de-compras-N°-" . $requerimiento->numero_requerimiento_compra . ".pdf";
        return PDF::loadView('admin.pdf.requerimiento-compras', compact(
            'requerimiento',
            'costoTotal',
            'sucursalEmpresa',
            'arregloFirmas',
            'articulos',
            'personalPdf',
            'contadorTotal',
        ))->setPaper('a4', 'portrait')->download($name_pdf);

        /*  $data = PDF::loadView('admin.pdf.requerimiento-compras', compact(
            'requerimiento',
            'costoTotal',
            'sucursalEmpresa',
            'articulos',
            'personalPdf',
            'contadorTotal',
        ));
        return $data->stream($name_pdf);  */
    }
}
