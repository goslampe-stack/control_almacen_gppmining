<?php

namespace App\Http\Controllers;

use App\Models\ArticuloOrdenCompra;
use App\Models\ArticuloRequerimientoPersonal;
use App\Models\OrdenDeCompra;
use App\Models\PersonalPdf;
use App\Models\SucursalEmpresa;
use App\Models\Tienda;
use App\Models\Util;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class OrdenCompra extends Controller
{
    public $modelId;
    public $sucursal_empresas_id_seleccionado;

    public function imprimirOrdenCompra($medelo_id)
    {

        $this->modelId = $medelo_id;
        $this->sucursal_empresas_id_seleccionado = Util::getSucursalEmpresaIdLocalStorage();


        $articulos = ArticuloOrdenCompra::where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)
            ->where('orden_de_compras_id', '=', $this->modelId)
            ->orderBy('id',  'asc')
            ->get();




        $subTotal = 0;
        foreach ($articulos as $aux) {


            $precioUnitario = $aux->cantidad * $aux->precio_unitario;

            $subTotal = $subTotal + $precioUnitario;
        }
        $auxiliar = $subTotal;

        $aux = $subTotal / 1.18;

        $igv = $aux * 0.18;

        $costoTotal = $aux + $igv;;


        $subTotal = Util::darFormatoMoneda($aux);
        $costoTotal = Util::darFormatoMoneda($costoTotal);
        $igv = Util::darFormatoMoneda($igv);


        $orden = OrdenDeCompra::find($this->modelId);


        $sucursalEmpresa = SucursalEmpresa::find($this->sucursal_empresas_id_seleccionado);
        $personalPdf = PersonalPdf::where('estado', '=', '1')->where('tipo_opcion', '=', 'Orden de compra')->where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)->take(3)->get();


        ///contador para espacio de tabla 
        //Sacar medidas 
        $cliente1 = "Razon Social: " . $sucursalEmpresa->empresa->razon_social;
        $cliente2 = "RUC: " . $sucursalEmpresa->empresa->ruc;
        $cliente3 = "Domicilio Fiscal: " . $sucursalEmpresa->direccion;
        $cliente4 = "Email: " . $sucursalEmpresa->empresa->correo_electronico;

        $proveedor1 = "Razon Social: " . $orden->proveedor->razon_social;
        $proveedor2 = "RUC: " . $orden->proveedor->ruc;
        $proveedor3 = "Direccion: " . $orden->proveedor->direccion;
        $proveedor4 = "Email: " . $orden->proveedor->correo_electronico;
        $proveedor5 = "N° de contacto: " . $orden->proveedor->celular;

        ##Sumna cliente
        $sumaCliente1 = Util::contarLetras($cliente1);
        $sumaCliente2 = Util::contarLetras($cliente2);
        $sumaCliente3 = Util::contarLetras($cliente3);
        $sumaCliente4 = Util::contarLetras($cliente4);



        ##Sumna proveedor

        $sumaProveedor1 = Util::contarLetras($proveedor1);

        $sumaProveedor2 = Util::contarLetras($proveedor2);
        $sumaProveedor3 = Util::contarLetras($proveedor3);
        $sumaProveedor4 = Util::contarLetras($proveedor4);
        $sumaProveedor5 = Util::contarLetras($proveedor5);

        $sumaClienteGeneral = $sumaCliente1 + $sumaCliente2 + $sumaCliente3 + $sumaCliente4;
        $sumaProveedorGeneral = $sumaProveedor1 + $sumaProveedor2 + $sumaProveedor3 + $sumaProveedor4 + $sumaProveedor5;

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
                $contadorTotal = 400;
            } elseif ($sumaTotalDobleLinea == 5) {
                $contadorTotal = 420;
            } elseif ($sumaTotalDobleLinea == 6) {
                $contadorTotal = 440;
            } elseif ($sumaTotalDobleLinea == 7) {
                $contadorTotal = 460;
            } elseif ($sumaTotalDobleLinea == 8) {
                $contadorTotal = 480;
            } elseif ($sumaTotalDobleLinea == 9) {
                $contadorTotal = 500;
            } elseif ($sumaTotalDobleLinea == 10) {
                $contadorTotal = 520;
            } elseif ($sumaTotalDobleLinea == 11) {
                $contadorTotal = 540;
            } else {
                $contadorTotal = 560;
            }
        } else {

            $sumaTotalDobleLinea = Util::obtenerTotalLineaPdfParaArriba(41, $sumaProveedor1);

            $sumaTotalDobleLinea = $sumaTotalDobleLinea + Util::obtenerTotalLineaPdfParaArriba(41, $sumaProveedor2);

            $sumaTotalDobleLinea = $sumaTotalDobleLinea + Util::obtenerTotalLineaPdfParaArriba(41, $sumaProveedor3);

            $sumaTotalDobleLinea = $sumaTotalDobleLinea + Util::obtenerTotalLineaPdfParaArriba(41, $sumaProveedor4);
            $sumaTotalDobleLinea = $sumaTotalDobleLinea + Util::obtenerTotalLineaPdfParaArriba(41, $sumaProveedor5);
            //damos los tamaos 

            if ($sumaTotalDobleLinea == 0) {
                $contadorTotal = 390;
            } elseif ($sumaTotalDobleLinea == 1) {
                $contadorTotal = 405;
            } elseif ($sumaTotalDobleLinea == 2) {
                $contadorTotal = 420;
            } elseif ($sumaTotalDobleLinea == 3) {
                $contadorTotal = 435;
            } elseif ($sumaTotalDobleLinea == 4) {
                $contadorTotal = 380;
            } elseif ($sumaTotalDobleLinea == 5) {
                $contadorTotal = 420;
            } elseif ($sumaTotalDobleLinea == 6) {
                $contadorTotal = 440;
            } elseif ($sumaTotalDobleLinea == 7) {
                $contadorTotal = 460;
            } elseif ($sumaTotalDobleLinea == 8) {
                $contadorTotal = 470;
            } elseif ($sumaTotalDobleLinea == 9) {
                $contadorTotal = 500;
            } elseif ($sumaTotalDobleLinea == 10) {
                $contadorTotal = 520;
            } elseif ($sumaTotalDobleLinea == 11) {
                $contadorTotal = 540;
            } else {
                $contadorTotal = 560;
            }
        }
        $contadorTotal = $contadorTotal+5;
       


        ///////LEEMOS EL ARRAGLO
        $arregloFirmas = json_decode($orden->personalpdf, true);
        if ($arregloFirmas == null) {
            $arregloFirmas = [];
        }
        ///////LEEMOS EL ARRAGLO


        $abrirPdfPorEmpreas = Util::getAbrirPdfTipoEmpresaSeleccionada();
        $nameUrl = "admin.pdf.orden-compra";

        ///verificamos si se abrira con la empresa tipo o normal
        if ($abrirPdfPorEmpreas == "SI") {
            $ruc = $sucursalEmpresa->empresa->ruc;
            if (Util::tienePdfDefinidoEmpresa($ruc, 'orden-compra')) {
                $nameUrl = "admin.pdf.empresa." . $ruc . ".orden-compra";

            }
        }

       

        $name_pdf = "Orden-compra-N°-" . $orden->numero_orden_compra . ".pdf";

        $data =  PDF::loadView($nameUrl, compact(
            'orden',

            'costoTotal',
            'subTotal',
            'arregloFirmas',
            'igv',
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
