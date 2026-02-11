<?php

namespace App\Http\Controllers;

use App\Models\ArticuloRequerimientoCompra;
use App\Models\ArticuloRequerimientoPersonal;
use App\Models\Empresa;
use App\Models\PersonalPdf;
use App\Models\RequerimientoCompra;
use App\Models\Util;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\RequerimientoPersonal as Requerimeinto;
use App\Models\SucursalEmpresa;

class RequerimientoPersonal extends Controller
{
    public $modelId, $sucursal_empresas_id_seleccionado;
    public $perPage = 10;
    public $sortField = 'id';
    public $sortAsc = true;


    public function imprimirRequemiento($medelo_id)
    {


        $this->modelId = $medelo_id;
        $this->sucursal_empresas_id_seleccionado = Util::getSucursalEmpresaIdLocalStorage();
        $data = ArticuloRequerimientoPersonal::where('requerimiento_p_id', '=', intval($this->modelId))->orderBy('id', 'asc')->get();


        $total_articulos = 0;
        foreach ($data as $d) {
            $total_articulos = $total_articulos + $d->cantidad;
        }

        $sucursalEmpresa = SucursalEmpresa::find($this->sucursal_empresas_id_seleccionado);

        $requerimiento = Requerimeinto::find($this->modelId);
        /*  $personalPdf = PersonalPdf::where('estado', '=', '1')->where('tipo_opcion', '=', Util::$OPCION_REQUERIMIENTO_PERSONAL)->where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)->take(3)->get();
 */

        $name_pdf = "requerimiento-personal-N°-" . $requerimiento->numero_requerimiento . ".pdf";

        $direccionEmpresa = "DIRECCIÒN DE LA EMPRESA: " . $sucursalEmpresa->direccion;
        $terminosDelRequerimiento = "TÉRMINOS DEL REQUERIMIENTO: " . $requerimiento->descripcion;

        $contadorTotal1 = Util::contarLetras($direccionEmpresa);
        $contadorTotal2 = Util::contarLetras($terminosDelRequerimiento);

        // 79 ES EL NUMERO DE FILA DEL PDF PARA ARRIBA
        $sumaTotalDobleLinea = Util::obtenerTotalLineaPdfParaArriba(79, $contadorTotal1);

        $sumaTotalDobleLinea = $sumaTotalDobleLinea + Util::obtenerTotalLineaPdfParaArriba(79, $contadorTotal2);

        $contadorTotal = 0;
        $alturaEmcabezado = 150;

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
        if ($arregloFirmas == null) {
            $arregloFirmas = [];
        }
        ///////LEEMOS EL ARRAGLO

        $abrirPdfPorEmpreas = Util::getAbrirPdfTipoEmpresaSeleccionada();
        $nameUrl = "admin.pdf.requerimiento-personal";

        ///verificamos si se abrira con la empresa tipo o normal
        if ($abrirPdfPorEmpreas == "SI") {
            $ruc = $sucursalEmpresa->empresa->ruc;
            if (Util::tienePdfDefinidoEmpresa($ruc, 'requerimiento-personal')) {
                $nameUrl = "admin.pdf.empresa." . $ruc . ".requerimiento-personal";
                //GRUPO ALFA DORADO
               
                if ($ruc == Util::RUC_GRUPO_ALFA_DORADO) {
                    $alturaEmcabezado=$alturaEmcabezado+65;
                }
                
            }
        }

        ///verificamos para aumentar el tamaño del espacio



        $data = PDF::loadView($nameUrl, compact(
            'requerimiento',
            'total_articulos',
            'sucursalEmpresa',
            'data',
            'contadorTotal',
            'alturaEmcabezado',
            'arregloFirmas',
        ));

        if (Util::getEstaEnServidor()) {
            return $data->setPaper('a4', 'portrait')->download($name_pdf);
        } else {
            return $data->stream($name_pdf);
        }





        /*   return $data->stream($name_pdf); */
    }

    public function abrirPdfPorEmpresa($ruc)
    {
        if ($ruc == "20611539798") {
        }
    }


    public function imprimirRequerimientoCompras($medelo_id)
    {

        $this->modelId = $medelo_id;
        $this->sucursal_empresas_id_seleccionado = Util::getSucursalEmpresaIdLocalStorage();


        $articulos = ArticuloRequerimientoPersonal::where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)
            ->where('requerimientoCompras_id', '=', $this->modelId)
            ->orderBy('id',  'asc')
            ->get();




        $totalArticulos = 0;
        foreach ($articulos as $aux) {


            $totalArticulos = $totalArticulos + $aux->cantidad;
        }



        $requerimiento = RequerimientoCompra::find($this->modelId);


        $sucursalEmpresa = SucursalEmpresa::find($this->sucursal_empresas_id_seleccionado);
        $personalPdf = PersonalPdf::where('estado', '=', '1')->where('tipo_opcion', '=', 'Requerimiento de compras')->where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)->take(3)->get();


        $name_pdf = "Orden-compra-N°-" . $requerimiento->numero_requerimiento_compra . ".pdf";
        return PDF::loadView('admin.pdf.requerimiento-compras', compact(
            'requerimiento',
            'totalArticulos',
            'sucursalEmpresa',
            'articulos',
            'personalPdf',
        ))->download($name_pdf);
    }
}
