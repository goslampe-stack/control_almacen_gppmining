<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ArticuloSolicitudCotizacion;
use App\Models\PersonalPdf;
use App\Models\SolicitudCotizacion;
use App\Models\SucursalEmpresa;
use App\Models\Util;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;

class SolicitudCotizacionController extends Controller
{
    public $modelId;
    public $sucursal_empresas_id_seleccionado;

    public function imprimirSolicitudCotizacion($medelo_id)
    {

        $this->modelId = $medelo_id;
        $this->sucursal_empresas_id_seleccionado = Util::getSucursalEmpresaIdLocalStorage();
        // Configura el idioma español
        Carbon::setLocale('es');

        $articulos = ArticuloSolicitudCotizacion::where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)
            ->where('solicitudCotizacions_id', '=', $this->modelId)
            ->orderBy('id',  'asc')
            ->get();




        $costoTotal = 0;
        foreach ($articulos as $aux) {


            $costoTotal = $costoTotal +  $aux->cantidad;
        }



        $solicitud = SolicitudCotizacion::find($this->modelId);


        $sucursalEmpresa = SucursalEmpresa::find($this->sucursal_empresas_id_seleccionado);
        $personalPdf = PersonalPdf::where('estado', '=', '1')->where('tipo_opcion', '=', 'Solicitud de cotización')->where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)->take(3)->get();



        ///contador para espacio de tabla 

        //Sacar medidas 
        $cliente1 = "Razon Social: " . $sucursalEmpresa->empresa->razon_social;
        $cliente2 = "RUC: " . $sucursalEmpresa->empresa->ruc;
        $cliente3 = "Domicilio Fiscal: " . $sucursalEmpresa->direccion;
        $cliente4 = "Email: " . $sucursalEmpresa->empresa->correo_electronico;

        $proveedor1 = "Razon Social: " . $solicitud->proveedor->razon_social;
        $proveedor2 = "RUC: " . $solicitud->proveedor->ruc;
        $proveedor3 = "Email: " . $solicitud->proveedor->correo_electronico;

        ##Sumna cliente
        $sumaCliente1 = Util::contarLetras($cliente1);
        $sumaCliente2 = Util::contarLetras($cliente2);
        $sumaCliente3 = Util::contarLetras($cliente3);
        $sumaCliente4 = Util::contarLetras($cliente4);



        ##Sumna proveedor

        $sumaProveedor1 = Util::contarLetras($proveedor1);

        $sumaProveedor2 = Util::contarLetras($proveedor2);
        $sumaProveedor3 = Util::contarLetras($proveedor3);

        $sumaClienteGeneral = $sumaCliente1 + $sumaCliente2 + $sumaCliente3 + $sumaCliente4;
        $sumaProveedorGeneral = $sumaProveedor1 + $sumaProveedor2 + $sumaProveedor3;

        $contadorTotal = 0;
        $sumaTotalDobleLinea = 0;

        //comparamos las sumas quien es mayor para poder sacar 
        if ($sumaClienteGeneral > $sumaProveedorGeneral) {

            $sumaTotalDobleLinea = Util::obtenerTotalLineaPdfParaArriba(42, $sumaCliente1);

            $sumaTotalDobleLinea = $sumaTotalDobleLinea + Util::obtenerTotalLineaPdfParaArriba(42, $sumaCliente2);

            $sumaTotalDobleLinea = $sumaTotalDobleLinea + Util::obtenerTotalLineaPdfParaArriba(42, $sumaCliente3);

            $sumaTotalDobleLinea = $sumaTotalDobleLinea + Util::obtenerTotalLineaPdfParaArriba(42, $sumaCliente4);

            //damos los tamaos 

            if ($sumaTotalDobleLinea == 4) {
                $contadorTotal = 390;
            } elseif ($sumaTotalDobleLinea == 5) {
                $contadorTotal = 410;
            } elseif ($sumaTotalDobleLinea == 6) {
                $contadorTotal = 430;
            } elseif ($sumaTotalDobleLinea == 7) {
                $contadorTotal = 450;
            } elseif ($sumaTotalDobleLinea == 8) {
                $contadorTotal = 470;
            } elseif ($sumaTotalDobleLinea == 9) {
                $contadorTotal = 490;
            } elseif ($sumaTotalDobleLinea == 10) {
                $contadorTotal = 510;
            } elseif ($sumaTotalDobleLinea == 11) {
                $contadorTotal = 530;
            } else {
                $contadorTotal = 550;
            }
        } else {

            $sumaTotalDobleLinea = Util::obtenerTotalLineaPdfParaArriba(41, $sumaProveedor1);

            $sumaTotalDobleLinea = $sumaTotalDobleLinea + Util::obtenerTotalLineaPdfParaArriba(41, $sumaProveedor2);

            $sumaTotalDobleLinea = $sumaTotalDobleLinea + Util::obtenerTotalLineaPdfParaArriba(41, $sumaProveedor3);

            //damos los tamaos 

            if ($sumaTotalDobleLinea == 3) {
                $contadorTotal = 390;
            } elseif ($sumaTotalDobleLinea == 4) {
                $contadorTotal = 400;
            } elseif ($sumaTotalDobleLinea == 5) {
                $contadorTotal = 410;
            } elseif ($sumaTotalDobleLinea == 6) {
                $contadorTotal = 430;
            } elseif ($sumaTotalDobleLinea == 7) {
                $contadorTotal = 450;
            } elseif ($sumaTotalDobleLinea == 8) {
                $contadorTotal = 470;
            } elseif ($sumaTotalDobleLinea == 9) {
                $contadorTotal = 490;
            } elseif ($sumaTotalDobleLinea == 10) {
                $contadorTotal = 510;
            } elseif ($sumaTotalDobleLinea == 11) {
                $contadorTotal = 530;
            } else {
                $contadorTotal = 550;
            }
        }

        ///////LEEMOS EL ARRAGLO
        $arregloFirmas = json_decode($solicitud->personalpdf, true);
        if ($arregloFirmas == null) {
            $arregloFirmas = [];
        }
        ///////LEEMOS EL ARRAGLO



        $abrirPdfPorEmpreas = Util::getAbrirPdfTipoEmpresaSeleccionada();
        $nameUrl = "admin.pdf.solicitud-cotizacion";

        ///verificamos si se abrira con la empresa tipo o normal
        if ($abrirPdfPorEmpreas == "SI") {
            $ruc = $sucursalEmpresa->empresa->ruc;
            if (Util::tienePdfDefinidoEmpresa($ruc, 'solicitud-cotizacion')) {
                $nameUrl = "admin.pdf.empresa." . $ruc . ".solicitud-cotizacion";
                if ($ruc == "10452703675") {
                    $contadorTotal = $contadorTotal + 50;
                } else if ($ruc == "20611539798") {
                    //reducimos porque es menor los pdf a diferencia de lols demas 
                    $contadorTotal = $contadorTotal - 50;
                } else if ($ruc == "20606023996") {
                    //reducimos porque es menor los pdf a diferencia de lols demas 
                   /*  $contadorTotal = $contadorTotal+20 ; */
                }else if ($ruc == "10182040598") {
                    //reducimos porque es menor los pdf a diferencia de lols demas 
                    $contadorTotal = $contadorTotal - 10;
                }
            }
        }







        $name_pdf = "Solicitud-de-cotizacion-N°-" . $solicitud->numero_solicitud_cotizacion . ".pdf";
        $data = PDF::loadView($nameUrl, compact(
            'solicitud',
            'costoTotal',
            'arregloFirmas',
            'sucursalEmpresa',
            'articulos',
            'personalPdf',
            'contadorTotal',
        ));


        if (Util::getEstaEnServidor()) {
            return $data->setPaper('a4', 'portrait')->download($name_pdf);
        } else {
            return $data->stream($name_pdf);
        }
    }
}
