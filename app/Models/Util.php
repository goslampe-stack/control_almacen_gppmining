<?php

namespace App\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Illuminate\Support\Facades\Http;

class Util extends Model
{


    public static function getEstaEnServidor()
    {
        return false;
        /*  return true; */
    }
    public static function getAbrirPdfTipoEmpresaSeleccionada()
    {
        return "SI";
    }


    public const  RUC_GRUPO_ALFA_DORADO = "20614808340";
    public const  RUC_GPP_MINING = "20615159418";

    public static function tienePdfDefinidoEmpresa($ruc, $name)
    {

        $estado = "NO";


        /////GRUPO ALFA DORADO
        if ($ruc == Util::RUC_GRUPO_ALFA_DORADO && $name == "orden-compra") {
            $estado = "SI";
        } else if ($ruc == Util::RUC_GRUPO_ALFA_DORADO && $name == "requerimiento-personal") {
            $estado = "SI";
        } else if ($ruc == Util::RUC_GRUPO_ALFA_DORADO && $name == "solicitud-cotizacion") {
            $estado = "SI";
        } else if ($ruc == Util::RUC_GRUPO_ALFA_DORADO && $name == "requerimiento-compras") {
            $estado = "SI";
        } else if ($ruc == Util::RUC_GRUPO_ALFA_DORADO && $name == "ingreso-articulos") {
            $estado = "SI";
        } else if ($ruc == Util::RUC_GRUPO_ALFA_DORADO && $name == "salida-articulos") {
            $estado = "SI";
        } else if ($ruc == Util::RUC_GRUPO_ALFA_DORADO && $name == "kardex") {
            $estado = "SI";
        }
        /////GRUPO ALFA DORADO

        /////RUC_GPP_MINING
        if ($ruc == Util::RUC_GPP_MINING && $name == "orden-compra") {
            $estado = "SI";
        } else if ($ruc == Util::RUC_GPP_MINING && $name == "requerimiento-personal") {
            $estado = "SI";
        } else if ($ruc == Util::RUC_GPP_MINING && $name == "solicitud-cotizacion") {
            $estado = "SI";
        } else if ($ruc == Util::RUC_GPP_MINING && $name == "requerimiento-compras") {
            $estado = "SI";
        } else if ($ruc == Util::RUC_GPP_MINING && $name == "ingreso-articulos") {
            $estado = "SI";
        } else if ($ruc == Util::RUC_GPP_MINING && $name == "salida-articulos") {
            $estado = "SI";
         } else if ($ruc == Util::RUC_GRUPO_ALFA_DORADO && $name == "kardex") {
            $estado = "SI";
        }
        /////GRUPO ALFA DORADO


        //arteaga        
        if ($ruc == "10452703675" && $name == "orden-compra") {
            $estado = "SI";
        } else if ($ruc == "10452703675" && $name == "requerimiento-personal") {
            $estado = "SI";
        } else if ($ruc == "10452703675" && $name == "solicitud-cotizacion") {
            $estado = "SI";
        }
        //arteaga  

        //arteaga        
        if ($ruc == "20606023996" && $name == "requerimiento-personal") {
            $estado = "SI";
        } else if ($ruc == "20606023996" && $name == "solicitud-cotizacion") {
            $estado = "SI";
        } else if ($ruc == "20606023996" && $name == "orden-compra") {
            $estado = "SI";
        }
        //arteaga 

        //piedra azul    

        if ($ruc == "10182040598" && $name == "solicitud-cotizacion") {
            $estado = "SI";
        } else if ($ruc == "10182040598" && $name == "orden-compra") {
            $estado = "SI";
        } else if ($ruc == "10182040598" && $name == "requerimiento-personal") {
            $estado = "SI";
        }
        //piedra azul       

        return $estado == "SI" ? true : false;
    }
    public static function sacarImagen()
    {

        // 1. Validar y guardar la imagen
        $url = "data:image/jpeg;base64,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";

        $base64 = $url;



        // Limpiar la cabecera
        if (preg_match('/^data:image\/(\w+);base64,/', $base64, $type)) {
            $base64 = substr($base64, strpos($base64, ',') + 1);
        } else {
            return response()->json(['error' => 'Formato Base64 inválido'], 422);
        }



        // Llamamos a OCR.space pasando el base64 directamente
        $response = Http::asForm()->post('https://api.ocr.space/parse/image', [
            'apikey'    => env('OCR_SPACE_API_KEY'),
            'language'  => 'eng',
            'base64Image' => "data:image/{$type[1]};base64," . $base64,
        ]);


        $json = $response->json();

        if (empty($json['ParsedResults'][0]['ParsedText'])) {
            return response()->json(['error' => 'No se pudo leer el texto'], 422);
        }

        $raw = $json['ParsedResults'][0]['ParsedText'];
        preg_match('/\d+/', $raw, $m);
        $number = $m[0] ?? null;

        return response()->json([
            'raw_text' => trim($raw),
            'number'   => $number,
        ]);
    }



    public static function getPersonalPdf($sucursal_empresas_id_seleccionado, $tipo)
    {
        $personalPdf = PersonalPdf::where('estado', '=', '1')->where('tipo_opcion', '=', $tipo)->where('sucursal_empresas_id', '=', $sucursal_empresas_id_seleccionado)->take(3)->get();
        $requerimiento = [];
        foreach ($personalPdf as $item) {
            $nombre = $item->personal->apellidos . ", " . $item->personal->nombre;
            $tipoPersonal = ["tipo" => $item->personal->tipoPersonal->nombre, "imagen" => $item->personal->imagen];
            $requerimiento[$nombre] =   $tipoPersonal;
        }

        return $requerimiento;
    }

    public static function getImagenFirmaDigitalDefecto()
    {
        return "https://res.cloudinary.com/velasquez-paz/image/upload/v1719896033/u8te5cspah6ocv7c1dyj.jpg";
    }
    public static function getImagenPapelMembretadoDefecto()
    {
        return "https://res.cloudinary.com/velasquez-paz/image/upload/v1720034568/l9lenxlpnawchyvi2idr.jpg";
    }

    public static function verificarEstadoUsuario($urlAux)
    {

        $data = User::find(Auth::id());
        $url = "admin.configuracion.cuenta-inactiva";
        if ($data) {


            if ($data->estado == "1") {
                $url = $urlAux;
            }
        }

        return $url;
    }

    public static function contarLetras($texto)
    {
        // Elimina todo lo que no sea letra

        return strlen($texto);;
    }
    public static function sacarMedidaTableArribaSoloUnTexto($contadorTotal1)
    {
        // Elimina todo lo que no sea letra


        if ($contadorTotal1 < 62) {
            $contadorTotal1 = 260;
        } elseif ($contadorTotal1 < 125) {
            $contadorTotal1 = 270;
        } elseif ($contadorTotal1 < 187) {
            $contadorTotal1 = 290;
        } elseif ($contadorTotal1 < 249) {
            $contadorTotal1 = 310;
        } elseif ($contadorTotal1 < 316) {
            $contadorTotal1 = 320;
        }

        return $contadorTotal1;
    }


    public static function  obtenerTotalLineaOrdenCompra($tamanio)
    {
        $sumaTotalDobleLinea = 0;

        if ($tamanio <= 36) {
            $sumaTotalDobleLinea = $sumaTotalDobleLinea + 1;
        } elseif ($tamanio <= 72) {
            $sumaTotalDobleLinea = $sumaTotalDobleLinea + 2;
        } elseif ($tamanio <= 108) {

            $sumaTotalDobleLinea = $sumaTotalDobleLinea + 3;
        } elseif ($tamanio <= 144) {
            $sumaTotalDobleLinea = $sumaTotalDobleLinea + 4;
        } elseif ($tamanio <= 180) {
            $sumaTotalDobleLinea = $sumaTotalDobleLinea + 5;
        } elseif ($tamanio <= 216) {
            $sumaTotalDobleLinea = $sumaTotalDobleLinea + 6;
        } elseif ($tamanio <= 256) {
            $sumaTotalDobleLinea = $sumaTotalDobleLinea + 7;
        }

        return $sumaTotalDobleLinea;
    }
    public static function  obtenerTotalLineaRequerimientoPersonal($tamanio)
    {
        $sumaTotalDobleLinea = 0;

        if ($tamanio <= 79) {
            $sumaTotalDobleLinea = $sumaTotalDobleLinea + 1;
        } elseif ($tamanio <= 158) {
            $sumaTotalDobleLinea = $sumaTotalDobleLinea + 2;
        } elseif ($tamanio <= 237) {

            $sumaTotalDobleLinea = $sumaTotalDobleLinea + 3;
        } elseif ($tamanio <= 316) {
            $sumaTotalDobleLinea = $sumaTotalDobleLinea + 4;
        } elseif ($tamanio <= 395) {
            $sumaTotalDobleLinea = $sumaTotalDobleLinea + 5;
        } elseif ($tamanio <= 474) {
            $sumaTotalDobleLinea = $sumaTotalDobleLinea + 6;
        } elseif ($tamanio <= 553) {
            $sumaTotalDobleLinea = $sumaTotalDobleLinea + 7;
        }

        return $sumaTotalDobleLinea;
    }
    public static function  obtenerTotalLineaPdfParaArriba($tamanioSumar, $tamanioFrase)
    {
        $sumaTotalDobleLinea = 0;
        $tamanioSumarAux = $tamanioSumar;

        for ($i = 1; $i < 10; $i++) {
            if ($tamanioFrase <= $tamanioSumarAux) {

                $sumaTotalDobleLinea = $sumaTotalDobleLinea + $i;
                break;
            }
            $tamanioSumarAux = $tamanioSumarAux + $tamanioSumar;
        }

        return $sumaTotalDobleLinea;
    }



    public static function sacarMedidaTableArribaSoloDosTexto($contadorTotal1, $contadorTotal2)
    {
        // Elimina todo lo que no sea letra

        $suma = $contadorTotal1 + $contadorTotal2;

        if ($suma < 125) {

            $contadorTotal1 = 298;
        } elseif ($suma < 183) {
            $contadorTotal1 = 315;
        } elseif ($suma < 249) {
            $contadorTotal1 = 330;
        } elseif ($suma < 316) {
            $contadorTotal1 = 340;
        }

        return $contadorTotal1;
    }
    public static function sacarMedidaTableArribaSoloOrdenCompraTexto($contadorTotal1)
    {
        // Elimina todo lo que no sea letra


        if ($contadorTotal1 < 62) {
            $contadorTotal1 = 260;
        } elseif ($contadorTotal1 < 125) {
            $contadorTotal1 = 270;
        } elseif ($contadorTotal1 < 187) {
            $contadorTotal1 = 290;
        } elseif ($contadorTotal1 < 249) {
            $contadorTotal1 = 310;
        } elseif ($contadorTotal1 < 316) {
            $contadorTotal1 = 320;
        }

        return $contadorTotal1;
    }



    public static function putTiendaIdLocalStorage($id)
    {


        if (!Util::is_session_started()) {
            session_start();
        }

        $tienda = Empresa::find($id);

        if ($tienda) {
            $_SESSION["empresa_id"] = $id;
            $_SESSION["empresa_seleccionada"] = $tienda->razon_social;

            $data = User::find(Auth::id());

            $data->empresa_seleccionada = $tienda->razon_social;

            $data->update();
            return true;
        } else {

            return redirect()->route('dashboard');
        }
    }
    public static function esUsuario()
    {

        if (!Util::is_session_started()) {
            session_start();
        }

        $data = User::find(Auth::id());


        if ($data) {
            if ($data->tipoUsuario == "Usuario") {
                return true;
            } else {

                return false;
            }
        } else {

            return false;
        }
    }

    public static $OPCION_REQUERIMIENTO_PERSONAL = "Requerimiento interno de productos";
    public static $OPCION_UNIDAD_MEDIDAD = "Unidad de medida";
    public static $OPCION_EMPRESAS = "Empresas";
    public static $OPCION_ORDEN_COMPRA = "Orden de compra";
    public static $OPCION_INGRESO = "Ingreso";
    public static $OPCION_REQUERIMIENTO_DE_COMPRAS = "Requerimiento de compras";
    public static $OPCION_SOLICITUD_DE_COTIZACION = "Solicitud de cotización";
    public static $OPCION_SALIDA = "Salida";
    public static $OPCION_DEVOLUCION = "Devolución";
    public static $OPCION_KARDEX = "Kardex";
    public static $OPCION_TIPO_PERSONAL = "Tipo personal";
    public static $OPCION_PERSONAL = "Personal";
    public static $OPCION_PERSONAL_PDF = "Personal y pdf";

    public static $OPCION_ARTICULO = "Artículo";
    public static $OPCION_TRANSPORTE = "Transporte";
    public static $OPCION_PROVEEDOR = "Proveedor";
    public static $OPCION_USUARIOS = "Usuarios";
    public static $OPCION_PERMISO_USUARIO = "Permiso Usuario";


    public static function getMayuscula($txt)
    {
        return mb_strtoupper($txt, 'UTF-8');
    }
    public static function tienePermiso($permiso)
    {


        $data = User::find(Auth::id());

        $empresas_id = $data->empresas_id;
        $tipo = $data->tipoUsuario;
        $estado = false;
        if ($empresas_id != null) {

            $auxiliar = PermisoUsuario::where('empresas_id', '=', $empresas_id)->where('personals_id', '=', Auth::id())->where('tipo_permiso', '=', $permiso)->where('estado', '=', 1)->count();
            if ($auxiliar > 0) {
                $estado = true;
            } else {
                if ($tipo == "Usuario") {
                    $estado = true;
                }
            }
        }
        return $estado;
    }
    public static function tienePermisoUsuario($permiso)
    {

        $data = User::find(Auth::id());

        $empresas_id = $data->empresas_id;

        $estado = false;
        $cantidad = 0;
        if ($empresas_id != null) {

            $auxiliar = MensualidadUsuario::where('estado', '=', 1)->where('users_id', '=', $data->empresas_id)->first();

            if ($auxiliar) {

                $data = ItemMensualidad::where('mensualidads_id', '=', $auxiliar->mensualidads_id)->where('estado', '=', 1)->get();

                foreach ($data as $item) {
                    if ($item->descripcion == $permiso) {
                        $estado = true;
                        $cantidad = $item->cantidad;
                    }
                }
            }
        }
        $data = ['estado' => $estado, 'cantidad' => $cantidad];
        return $data;
    }
    public static function tienePermisoAux($permiso)
    {


        $data = User::find(Auth::id());

        $empresas_id = $data->empresas_id;
        $tipo = $data->tipoUsuario;
        $estado = "false";
        if ($empresas_id != null) {

            $auxiliar = PermisoUsuario::where('empresas_id', '=', $empresas_id)->where('tipo_permiso', '=', $permiso)->where('estado', '=', 1)->count();
            if ($auxiliar > 0) {
                $estado = "true";
            } else {
                if ($tipo == "Usuario") {
                    $estado = "true";
                }
            }
        }
        return $auxiliar;
    }

    public static function existeUsuarioRegistrado($item, $permisosUsuario)
    {
        $dataAuxiliar = [];

        $encontraod = false;
        foreach ($permisosUsuario as $aux) {
            if ($aux->tipo_permiso == $item) {
                $encontraod = true;
            }
        }

        //llenamos al arreglo el que no lo encontro


        return $encontraod;
    }
    public static function getUsuarioNombre()
    {

        if (!Util::is_session_started()) {
            session_start();
        }

        $data = User::find(Auth::id());


        if ($data) {
            return $data->name . ", " . $data->last_name . " ( " . $data->tipoUsuario . " ) \n" . $data->email;
        } else {

            return "-";
        }
    }


    public static function verificarNumero($numero)
    {
        return $numero == null || $numero == "" ? 0 : $numero;
    }
    public static function checkNumeroVacio($numero)
    {
        $data = $numero == null || $numero == "" ? 0 : $numero;
        return Util::darFormatoMoneda($data);
    }
    public static function checkNumeroVacioyDouble($numero)
    {
        $data = $numero == null || $numero == "" ? 0 : $numero;
        return $data;
    }
    public static function checkEntero($numero)
    {
        $data = $numero == null || $numero == "" ? 0 : $numero;
        return (int)($numero);
    }
    public static function checkNumeroVacioEntero($numero)
    {
        $data = $numero == null || $numero == "" ? 0 : $numero;
        return Util::darFormatoMoneda($data);
    }
    public static function checkNumeroVacioDivicion($numero)
    {
        $data = $numero == null || $numero == "" ? 0 : $numero;

        if ($data == 0) {
            $data = 1;
        }
        return Util::darFormatoMoneda($data);
    }

    public static function putSucursarEmpresaLocalStorage($id)
    {
        if (!Util::is_session_started()) {
            session_start();
        }

        $tienda = SucursalEmpresa::find($id);
        if ($tienda) {
            $_SESSION["sucursal_empresa_id"] = $id;
            $_SESSION["sucursal_empresa_nombre"] = $tienda->nombre_sucursal;

            $data = User::find(Auth::id());

            $data->sucursal_empresa_nombre = $tienda->nombre_sucursal;

            $data->update();
        } else {
            return redirect()->route('dashboard');
        }
    }

    public static function getInventarioInicial($dataGeneral, $rango_inicio)
    {
        $auxiliar = [
            'nombre' => 'Inventario-inicial',
            'estado' => 'false',
            'articulo' => "Inventario Inicial",
            'cantidad' => "0",
            'fecha' => "2024-06-17",
            'auxo' => "2024-06-17",
            'precio' => "0",
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

        // Extraer la columna de fechas
        $fechas = array_column($dataGeneral, 'fecha');

        // Convertir las fechas a timestamp para la comparación
        $fechas = array_map('strtotime', $fechas);

        // Ordenar el arreglo por la columna de fechas
        array_multisort($fechas, SORT_ASC, $dataGeneral);





        $i = 0;
        $precioUltimaCompra = 0; //precio para la devolucion
        $vueltas = 0;
        $data = "";

        /*   try { */

        foreach ($dataGeneral as $item) {

            if ($dataGeneral[$i]['nombre'] == "Inventario-inicial") {

                //Inventario incial
                $dataGeneral[$i]['cantidad-existencia'] =  Util::checkNumeroVacioyDouble($dataGeneral[$i]['cantidad']);

                $dataGeneral[$i]['precio-existencia'] = Util::checkNumeroVacioyDouble($dataGeneral[$i]['precio']);

                $dataGeneral[$i]['total-existencia'] = Util::checkNumeroVacioyDouble($dataGeneral[$i]['cantidad-existencia']) * Util::checkNumeroVacioyDouble($dataGeneral[$i]['precio-existencia']);
            } else if ($dataGeneral[$i]['nombre'] == "Ingreso") {

                //ingreso
                $dataGeneral[$i]['cantidad-entrada'] = Util::checkNumeroVacioyDouble($dataGeneral[$i]['cantidad']);

                $dataGeneral[$i]['precio-entrada'] = Util::checkNumeroVacioyDouble($dataGeneral[$i]['precio']);
                $precioUltimaCompra = Util::checkNumeroVacioyDouble($dataGeneral[$i]['precio']);

                $dataGeneral[$i]['total-entrada'] = Util::checkNumeroVacioyDouble($dataGeneral[$i]['cantidad-entrada']) * Util::checkNumeroVacioyDouble($dataGeneral[$i]['precio-entrada']);
                //existencia

                $dataGeneral[$i]['cantidad-existencia'] = Util::checkNumeroVacioyDouble($dataGeneral[$i - 1]['cantidad-existencia']) + Util::checkNumeroVacioyDouble($dataGeneral[$i]['cantidad']);

                $data = $dataGeneral[$i - 1]['total-existencia'] + $dataGeneral[$i]['total-entrada'];
                $dataGeneral[$i]['total-existencia'] = Util::checkNumeroVacioyDouble($dataGeneral[$i - 1]['total-existencia']) + Util::checkNumeroVacioyDouble($dataGeneral[$i]['total-entrada']);

                if ($dataGeneral[$i]['cantidad-existencia'] > 0) {

                    $dataGeneral[$i]['precio-existencia'] = Util::darFormatoMoneda(Util::checkNumeroVacioyDouble($dataGeneral[$i]['total-existencia']) / Util::checkNumeroVacioyDouble($dataGeneral[$i]['cantidad-existencia']));
                } else {

                    $dataGeneral[$i]['precio-existencia'] = Util::darFormatoMoneda(Util::checkNumeroVacioyDouble($dataGeneral[$i]['total-existencia']) / 1);
                }
            } else if ($dataGeneral[$i]['nombre'] == "Devolucion") {

                //ingreso
                $dataGeneral[$i]['cantidad-entrada'] = Util::checkNumeroVacioyDouble($dataGeneral[$i]['cantidad']);

                $dataGeneral[$i]['precio-entrada'] = Util::checkNumeroVacioyDouble($precioUltimaCompra);

                $dataGeneral[$i]['total-entrada'] = Util::checkNumeroVacioyDouble($dataGeneral[$i]['cantidad-entrada']) * Util::checkNumeroVacioyDouble($dataGeneral[$i]['precio-entrada']);



                //Existencia
                $dataGeneral[$i]['cantidad-existencia'] = Util::checkNumeroVacioyDouble($dataGeneral[$i - 1]['cantidad-existencia']) - Util::checkNumeroVacioyDouble($dataGeneral[$i]['cantidad-entrada']);

                $dataGeneral[$i]['total-existencia'] = Util::checkNumeroVacioyDouble($dataGeneral[$i - 1]['total-existencia']) - Util::checkNumeroVacioyDouble($dataGeneral[$i]['total-entrada']);

                if ($dataGeneral[$i]['cantidad-existencia'] > 0) {

                    $dataGeneral[$i]['precio-existencia'] = Util::darFormatoMoneda(Util::checkNumeroVacioyDouble($dataGeneral[$i]['total-existencia']) / Util::checkNumeroVacioyDouble($dataGeneral[$i]['cantidad-existencia']));
                } else {
                    $dataGeneral[$i]['precio-existencia'] = Util::darFormatoMoneda(Util::checkNumeroVacioyDouble($dataGeneral[$i]['total-existencia']) / 1);
                }
            } else if ($dataGeneral[$i]['nombre'] == "Salida") {

                //salida
                $dataGeneral[$i]['cantidad-salida'] = Util::checkNumeroVacioyDouble($dataGeneral[$i]['cantidad']);

                $dataGeneral[$i]['precio-salida'] = Util::checkNumeroVacioyDouble($dataGeneral[$i - 1]['precio-existencia']);

                $dataGeneral[$i]['total-salida'] = Util::checkNumeroVacioyDouble($dataGeneral[$i]['cantidad-salida']) * Util::checkNumeroVacioyDouble($dataGeneral[$i]['precio-salida']);

                //Existencia
                $dataGeneral[$i]['cantidad-existencia'] = Util::checkNumeroVacioyDouble($dataGeneral[$i - 1]['cantidad-existencia']) - Util::checkNumeroVacioyDouble($dataGeneral[$i]['cantidad-salida']);

                $dataGeneral[$i]['total-existencia'] = Util::checkNumeroVacioyDouble($dataGeneral[$i - 1]['total-existencia']) - Util::checkNumeroVacioyDouble($dataGeneral[$i]['total-salida']);

                if ($dataGeneral[$i]['cantidad-existencia'] > 0) {

                    $dataGeneral[$i]['precio-existencia'] = Util::darFormatoMoneda(Util::checkNumeroVacioyDouble($dataGeneral[$i]['total-existencia']) / Util::checkNumeroVacioyDouble($dataGeneral[$i]['cantidad-existencia']));
                } else {
                    $dataGeneral[$i]['precio-existencia'] = Util::darFormatoMoneda(Util::checkNumeroVacioyDouble($dataGeneral[$i]['total-existencia']) / 1);
                }
            }


            $i = $i + 1;
            $vueltas = $vueltas + 1;
        }
        /*  } catch (Exception $e) {
            dd($e,$data);
        } */

        //ogreaterThanOrEqualTonermos el ultima de la fecha

        $ultimaFecha = Carbon::parse($rango_inicio);
        $data = null;
        $estadoComprobante = false;
        $i = 0;
        foreach ($dataGeneral as $item) {

            if ($item['estado'] == 'true') {

                if (Carbon::parse($item['fecha'])->greaterThanOrEqualTo($ultimaFecha) && $estadoComprobante == false) {
                    $data = $dataGeneral[$i - 1];

                    /*    $comprobador=Carbon::parse($item['fecha'])->greaterThanOrEqualTo($ultimaFecha);
                    dd("hola",$comprobador,$dataGeneral); */
                    $estadoComprobante = true;
                }
            }
            $i = $i + 1;
        }
        /*  dd($data, $dataGeneral); */
        return $data;
    }

    public static function estaAgregaEnArticuloOrdenCompraElArticuloIngreso($listaArticulosOridenCompra, $id)
    {


        $aux = false;
        foreach ($listaArticulosOridenCompra as $auxliar) {

            if ($id == $auxliar) {

                $aux = true;
            }
        }

        return $aux;
    }


    public static function generarKardex($dataGeneral, $rango_inicio, $rango_fin)
    {


        $iniciak = Util::getInventarioInicial($dataGeneral, $rango_inicio);



        if ($iniciak != null) {
            $auxiliar = [
                'nombre' => 'Inventario-inicial',
                'articulo' => "Inventario Inicial",
                'cantidad' => $iniciak['cantidad-existencia'],
                'fecha' => $iniciak['fecha'],
                'auxo' => $iniciak['fecha'],
                'precio' => $iniciak['precio-existencia'],
                'cantidad-entrada' => "",
                'precio-entrada' => "",
                'total-entrada' => "",
                'tipoDevolucion' => "",

                'cantidad-salida' => "",
                'precio-salida' => "",
                'total-salida' => "",

                'cantidad-existencia' => "",
                'precio-existencia' => "",
                'total-existencia' => "",

            ];

            $dataGeneral[] = $auxiliar;
        } else {
            $auxiliar = [
                'nombre' => 'Inventario-inicial',
                'articulo' => "Inventario Inicial",
                'cantidad' => "0",
                'fecha' => "2019-06-17",
                'auxo' => "2019-06-17",
                'precio' => "0",
                'cantidad-entrada' => "",
                'precio-entrada' => "",
                'total-entrada' => "",
                'tipoDevolucion' => "",

                'cantidad-salida' => "",
                'precio-salida' => "",
                'total-salida' => "",

                'cantidad-existencia' => "",
                'precio-existencia' => "",
                'total-existencia' => "",

            ];

            $dataGeneral[] = $auxiliar;
        }

        // Extraer la columna de fechas
        $fechas = array_column($dataGeneral, 'fecha');

        // Convertir las fechas a timestamp para la comparación
        $fechas = array_map('strtotime', $fechas);

        // Ordenar el arreglo por la columna de fechas
        array_multisort($fechas, SORT_ASC, $dataGeneral);


        /* 
        usort($dataGeneral, function($a, $b) {
            $fecha1=Carbon::parse($a['fecha']);
            $fecha2=Carbon::parse($b['fecha']);
          
            return $fecha1-> lessThan( $fecha2);
        });

        dd($dataGeneral); */


        $auxiliarGeneral = [];


        $auxFechaFin = Carbon::parse($rango_fin)->addDay();



        //recorremos para eliminar lo que no esta en la fecha 
        foreach ($dataGeneral as $item) {

            if ($item['nombre'] == 'Inventario-inicial') {

                $auxiliarGeneral[] = $item;
            } else {
                $aux1 = Carbon::parse($item['fecha'])->greaterThanOrEqualTo(Carbon::parse($rango_inicio));
                $aux2 = Carbon::parse($item['fecha'])->lessThanOrEqualTo($auxFechaFin);

                if ($aux1 &&  $aux2) {
                    $auxiliarGeneral[] = $item;
                }
            }
        }


        $i = 0;
        $precioUltimaCompra = 0; //precio para la devolucion
        foreach ($auxiliarGeneral as $item) {
            if ($auxiliarGeneral[$i]['nombre'] == "Inventario-inicial") {

                //Inventario incial
                $auxiliarGeneral[$i]['cantidad-existencia'] =  Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['cantidad']);

                $auxiliarGeneral[$i]['precio-existencia'] = Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['precio']);

                $auxiliarGeneral[$i]['total-existencia'] = Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['cantidad-existencia']) * Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['precio-existencia']);
            } else if ($auxiliarGeneral[$i]['nombre'] == "Ingreso") {

                //ingreso
                $auxiliarGeneral[$i]['cantidad-entrada'] = Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['cantidad']);

                $auxiliarGeneral[$i]['precio-entrada'] = Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['precio']);
                $precioUltimaCompra = Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['precio']);

                $auxiliarGeneral[$i]['total-entrada'] = Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['cantidad-entrada']) * Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['precio-entrada']);

                //existencia


                $auxiliarGeneral[$i]['cantidad-existencia'] = Util::checkNumeroVacioyDouble($auxiliarGeneral[$i - 1]['cantidad-existencia']) + Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['cantidad']);

                $auxiliarGeneral[$i]['total-existencia'] = Util::checkNumeroVacioyDouble($auxiliarGeneral[$i - 1]['total-existencia']) + Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['total-entrada']);

                if ($auxiliarGeneral[$i]['cantidad-existencia'] > 0) {

                    $auxiliarGeneral[$i]['precio-existencia'] = Util::darFormatoMoneda(Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['total-existencia']) / Util::checkNumeroVacioDivicion($auxiliarGeneral[$i]['cantidad-existencia']));
                } else {

                    $auxiliarGeneral[$i]['precio-existencia'] = Util::darFormatoMoneda(Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['total-existencia']) / 5);
                }
            } else if ($auxiliarGeneral[$i]['nombre'] == "Devolucion" && $item['tipoDevolucion'] == "Devolución en salida") {

                //ingreso
                $auxiliarGeneral[$i]['cantidad-entrada'] = Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['cantidad']);

                $auxiliarGeneral[$i]['precio-entrada'] = Util::checkNumeroVacioyDouble($precioUltimaCompra);

                $auxiliarGeneral[$i]['total-entrada'] = Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['cantidad-entrada']) * Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['precio-entrada']);



                //Existencia
                if (Util::checkNumeroVacioyDouble($auxiliarGeneral[$i - 1]['cantidad-existencia']) <= 0) {
                    $auxiliarGeneral[$i]['cantidad-existencia'] = Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['cantidad-entrada']);
                } else {
                    $auxiliarGeneral[$i]['cantidad-existencia'] = Util::checkNumeroVacioyDouble($auxiliarGeneral[$i - 1]['cantidad-existencia']) + Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['cantidad-entrada']);
                }

                if (Util::checkNumeroVacioyDouble($auxiliarGeneral[$i - 1]['total-existencia']) <= 03) {

                    $auxiliarGeneral[$i]['total-existencia'] = Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['total-entrada']);
                } else {

                    $auxiliarGeneral[$i]['total-existencia'] = Util::checkNumeroVacioyDouble($auxiliarGeneral[$i - 1]['total-existencia']) + Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['total-entrada']);
                }

                if ($auxiliarGeneral[$i]['cantidad-existencia'] > 0) {

                    $auxiliarGeneral[$i]['precio-existencia'] = Util::darFormatoMoneda(Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['total-existencia']) / Util::checkNumeroVacioDivicion($auxiliarGeneral[$i]['cantidad-existencia']));
                } else {
                    $auxiliarGeneral[$i]['precio-existencia'] = Util::darFormatoMoneda(Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['total-existencia']) / 1);
                }
            } else if ($auxiliarGeneral[$i]['nombre'] == "Devolucion" && $item['tipoDevolucion'] == "Devolución en compras") {

                //salida
                $auxiliarGeneral[$i]['cantidad-salida'] = Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['cantidad']);

                $auxiliarGeneral[$i]['precio-salida'] = Util::checkNumeroVacioyDouble($auxiliarGeneral[$i - 1]['precio-existencia']);

                $auxiliarGeneral[$i]['total-salida'] = Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['cantidad-salida']) * Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['precio-salida']);

                //Existencia
                if (Util::checkNumeroVacioyDouble($auxiliarGeneral[$i - 1]['cantidad-existencia']) <= 0) {

                    $auxiliarGeneral[$i]['cantidad-existencia'] =  Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['cantidad-salida']);
                } else {

                    $auxiliarGeneral[$i]['cantidad-existencia'] = Util::checkNumeroVacioyDouble($auxiliarGeneral[$i - 1]['cantidad-existencia']) - Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['cantidad-salida']);
                }

                if (Util::checkNumeroVacioyDouble($auxiliarGeneral[$i - 1]['total-existencia']) <= 0) {
                    $auxiliarGeneral[$i]['total-existencia'] =  Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['total-salida']);
                } else {
                    $auxiliarGeneral[$i]['total-existencia'] = Util::checkNumeroVacioyDouble($auxiliarGeneral[$i - 1]['total-existencia']) - Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['total-salida']);
                }


                if ($auxiliarGeneral[$i]['cantidad-existencia'] > 0) {

                    $auxiliarGeneral[$i]['precio-existencia'] = Util::darFormatoMoneda(Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['total-existencia']) / Util::checkNumeroVacioDivicion($auxiliarGeneral[$i]['cantidad-existencia']));
                } else {
                    $auxiliarGeneral[$i]['precio-existencia'] = Util::darFormatoMoneda(Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['total-existencia']) / 1);
                }
            } else if ($auxiliarGeneral[$i]['nombre'] == "Salida") {

                //salida
                $auxiliarGeneral[$i]['cantidad-salida'] = Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['cantidad']);

                $auxiliarGeneral[$i]['precio-salida'] = Util::checkNumeroVacioyDouble($auxiliarGeneral[$i - 1]['precio-existencia']);

                $auxiliarGeneral[$i]['total-salida'] = Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['cantidad-salida']) * Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['precio-salida']);

                //Existencia
                $auxiliarGeneral[$i]['cantidad-existencia'] = Util::checkNumeroVacioyDouble($auxiliarGeneral[$i - 1]['cantidad-existencia']) - Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['cantidad-salida']);

                $auxiliarGeneral[$i]['total-existencia'] = Util::checkNumeroVacioyDouble($auxiliarGeneral[$i - 1]['total-existencia']) - Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['total-salida']);

                if ($auxiliarGeneral[$i]['cantidad-existencia'] > 0) {

                    $auxiliarGeneral[$i]['precio-existencia'] = Util::darFormatoMoneda(Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['total-existencia']) / Util::checkNumeroVacioDivicion($auxiliarGeneral[$i]['cantidad-existencia']));
                } else {
                    $auxiliarGeneral[$i]['precio-existencia'] = Util::darFormatoMoneda(Util::checkNumeroVacioyDouble($auxiliarGeneral[$i]['total-existencia']) / 1);
                }
            }


            $i = $i + 1;
        }

        return $auxiliarGeneral;
    }


    public static function getStockDisponibleArticulo($articulos_id)
    {
        $response = ArticuloSolicitudCotizacion::join('sucursal_empresas', 'articulo_solicitud_cotizacions.sucursal_empresas_id', '=', 'sucursal_empresas.id')
            ->join('articulo_requerimiento_compras', 'articulo_solicitud_cotizacions.articuloCompras_id', '=', 'articulo_requerimiento_compras.id')
            ->join('articulo_requerimiento_personals', 'articulo_requerimiento_compras.articulo_r_personals_id', '=', 'articulo_requerimiento_personals.id')
            ->select('articulo_solicitud_cotizacions.*')
            ->where('sucursal_empresas.empresas_id', '=', Util::getTiendaIdLocalStorage())
            ->where('articulo_requerimiento_personals.articulos_id', '=', $articulos_id)
            ->get();


        $cantidad = 0;
        foreach ($response as $row) {
            $orden = ArticuloIngreso::join('articulo_orden_compras', 'articulo_ingresos.articulos_orden_id', '=', 'articulo_orden_compras.id')
                ->select('articulo_ingresos.*')
                ->where('articulo_orden_compras.articulo_s_cotizacion_id', '=', $row->id)
                ->get();
            foreach ($orden as $or) {
                $cantidad = $cantidad + $or->cantidad;
            }
        }


        /* CXontador de devolicones */


        $itemsDevolucion = ArticuloDevolucion::join('sucursal_empresas', 'articulo_devolucions.sucursal_empresas_id', '=', 'sucursal_empresas.id')
            ->select('articulo_devolucions.*')
            ->where('sucursal_empresas.empresas_id', '=', Util::getTiendaIdLocalStorage())
            ->where('articulo_devolucions.articulos_id', '=', $articulos_id)
            ->get();

        foreach ($itemsDevolucion as $devolucion) {
            if ($devolucion->tipoDevolucion == "Devolución en salida") {

                $cantidad = $cantidad + $devolucion->cantidad;
            } else {

                $cantidad = $cantidad - $devolucion->cantidad;
            }
        }
        /* CXontador de devolicones */




        if ($response) {
            $contador = 0;

            $data = SalidaDetalle::join('sucursal_empresas', 'salida_detalles.sucursal_empresas_id', '=', 'sucursal_empresas.id')
                ->select('salida_detalles.*')
                ->where('sucursal_empresas.empresas_id', '=', Util::getTiendaIdLocalStorage())
                ->where('salida_detalles.articulos_id', '=', $articulos_id)
                ->get();


            foreach ($data as $d) {
                $contador = $contador + $d->cantidad;
            }



            if ($cantidad >= $contador) {
                $stock_disnponible_articulo_requerimiento = $cantidad - $contador;
                return $stock_disnponible_articulo_requerimiento;
            } else {
                return 0;
            }
        }
    }




    public static function eliminarDatosEmpresa()
    {
        if (!Util::is_session_started()) {
            session_start();
        }
        $_SESSION["empresa_id"] = "";
        $_SESSION["empresa_seleccionada"] = "";
    }


    public static function eliminarDatosSucursalEmpresa()
    {
        if (!Util::is_session_started()) {
            session_start();
        }
        $_SESSION["sucursal_empresa_id"] = "";
        $_SESSION["sucursal_empresa_nombre"] = "";
    }

    public static function getTiendaIdLocalStorage()
    {
        try {
            if (!Util::is_session_started()) {
                session_start();
            }

            if (!isset($_SESSION["empresa_id"])) {

                return -10;
            }

            $empresa_id = $_SESSION["empresa_id"];

            if ($empresa_id == null || $empresa_id == "") {

                return -10;
            }

            return $empresa_id;
        } catch (Exception $e) {
            return -10;
        }
    }
    public static function getEmpresasIngresada()
    {
        $empresas_id = 0;
        try {

            $empresas_id =  User::find(Auth::user()->id)->empresas_id;
            return $empresas_id;
        } catch (Exception $e) {
            return $empresas_id;
        }
    }
    public static function getCantidadLetras($palabra, $cantidad)
    {
        try {
            $longitud = strlen($palabra);

            $aux = "";
            if ($longitud < $cantidad) {
                $aux = $palabra;
            } else {
                $subcadena = substr($palabra, 0, $cantidad);

                $aux = $subcadena . "...";
            }



            return $aux;
        } catch (Exception $e) {
            return -10;
        }
    }

    public static function getSucursalEmpresaIdLocalStorage()
    {

        try {
            if (!Util::is_session_started()) {
                session_start();
            }

            if (!isset($_SESSION["sucursal_empresa_id"])) {
                return -10;
            }

            $sucursal_empresa_id = $_SESSION["sucursal_empresa_id"];

            if ($sucursal_empresa_id == null || $sucursal_empresa_id == "") {

                return -10;
            }

            return $sucursal_empresa_id;
        } catch (Exception $e) {
            return -10;
        }
    }

    public static function getExisteTiendaSeleccionadaLocalStorage()
    {
        $estado = true;
        try {
            if (!Util::is_session_started()) {
                session_start();
            }


            if (!isset($_SESSION["empresa_id"])) {
                $estado = false;
            }




            $empresa_id = $_SESSION["empresa_id"];

            if ($empresa_id == null || $empresa_id == "") {

                $estado = false;
            }
        } catch (Exception $e) {
            $estado = false;
        }



        return $estado;
    }

    public static function getExisteSucursalEmpresaSeleccionadaLocalStorage()
    {
        $estado = true;
        try {
            if (!Util::is_session_started()) {
                session_start();
            }


            if (!isset($_SESSION["sucursal_empresa_id"])) {
                $estado = false;
            }


            $empresa_id = $_SESSION["sucursal_empresa_id"];

            if ($empresa_id == null || $empresa_id == "") {

                $estado = false;
            }
        } catch (Exception $e) {
            return -10;
        }



        return $estado;
    }


    public static function getTiendaNombreLocalStorage()
    {
        if (!Util::is_session_started()) {
            session_start();
        }
        if (!isset($_SESSION["empresa_seleccionada"])) {
            return -10;
        }


        $empresa_seleccionada = $_SESSION["empresa_seleccionada"];

        if ($empresa_seleccionada == null || $empresa_seleccionada == "") {
            return -10;
        }
        return $empresa_seleccionada;
    }


    public static function getRandomImagenesParaTiendas()
    {
        $arrayImagenes = [
            'https://res.cloudinary.com/velasquez-paz/image/upload/v1617026266/dropzone_lp1pg7.png',
            'https://res.cloudinary.com/velasquez-paz/image/upload/v1617026266/tienda_lyztti.png',
            'https://res.cloudinary.com/velasquez-paz/image/upload/v1617026266/tienda-configuracion_qo1g7w.png',
            'https://res.cloudinary.com/velasquez-paz/image/upload/v1617028206/bg-producto_p5fohb.png',
        ];
        $numero = rand(1, 3);
        $url_imagen = $arrayImagenes[$numero];
        return $url_imagen;
    }


    public static function is_session_started()
    {

        // chequear que no esté ejecutándole 
        // desde la línea de comandos:
        if (php_sapi_name() !== 'cli') {

            if (version_compare(phpversion(), '5.4.0', '>=')) {

                return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
            } else {

                return session_id() === '' ? FALSE : TRUE;
            }
        }

        return FALSE;
    }


    public static function formarNumeroRequerimiento($numero)
    {
        $numero_validado = intval($numero);
        $formateado = '0';
        $numero_validado = $numero_validado + 1;

        if ($numero_validado < 10) {
            $formateado = '000' . $numero_validado;
        } else if ($numero_validado < 100) {
            $formateado = '00' . $numero_validado;
        } else if ($numero_validado < 1000) {
            $formateado = '0' . $numero_validado;
        } else if ($numero_validado < 10000) {
            $formateado = $numero_validado;
        }

        return $formateado;
    }



    public static function darFormatoMoneda($dinero)
    {
        setlocale(LC_MONETARY, 'es_ES');

        $data = number_format($dinero, 2, '.', ',');
        return $data;
    }

    public static function money_format($format, $number)
    {
        $regex = '/%((?:[\^!\-]|\+|\(|\=.)*)([0-9]+)?' .
            '(?:#([0-9]+))?(?:\.([0-9]+))?([in%])/';
        if (setlocale(LC_MONETARY, 0) == 'C') {
            setlocale(LC_MONETARY, '');
        }
        $locale = localeconv();
        preg_match_all($regex, $format, $matches, PREG_SET_ORDER);
        foreach ($matches as $fmatch) {
            $value = floatval($number);
            $flags = array(
                'fillchar' => preg_match('/\=(.)/', $fmatch[1], $match) ?
                    $match[1] : ' ',
                'nogroup' => preg_match('/\^/', $fmatch[1]) > 0,
                'usesignal' => preg_match('/\+|\(/', $fmatch[1], $match) ?
                    $match[0] : '+',
                'nosimbol' => preg_match('/\!/', $fmatch[1]) > 0,
                'isleft' => preg_match('/\-/', $fmatch[1]) > 0
            );
            $width = trim($fmatch[2]) ? (int) $fmatch[2] : 0;
            $left = trim($fmatch[3]) ? (int) $fmatch[3] : 0;
            $right = trim($fmatch[4]) ? (int) $fmatch[4] : $locale['int_frac_digits'];
            $conversion = $fmatch[5];

            $positive = true;
            if ($value < 0) {
                $positive = false;
                $value *= -1;
            }
            $letter = $positive ? 'p' : 'n';

            $prefix = $suffix = $cprefix = $csuffix = $signal = '';

            $signal = $positive ? $locale['positive_sign'] : $locale['negative_sign'];
            switch (true) {
                case $locale["{$letter}_sign_posn"] == 1 && $flags['usesignal'] == '+':
                    $prefix = $signal;
                    break;
                case $locale["{$letter}_sign_posn"] == 2 && $flags['usesignal'] == '+':
                    $suffix = $signal;
                    break;
                case $locale["{$letter}_sign_posn"] == 3 && $flags['usesignal'] == '+':
                    $cprefix = $signal;
                    break;
                case $locale["{$letter}_sign_posn"] == 4 && $flags['usesignal'] == '+':
                    $csuffix = $signal;
                    break;
                case $flags['usesignal'] == '(':
                case $locale["{$letter}_sign_posn"] == 0:
                    $prefix = '(';
                    $suffix = ')';
                    break;
            }
            if (!$flags['nosimbol']) {
                $currency = $cprefix .
                    ($conversion == 'i' ? $locale['int_curr_symbol'] : $locale['currency_symbol']) .
                    $csuffix;
            } else {
                $currency = $cprefix . $csuffix;
            }
            $space = $locale["{$letter}_sep_by_space"] ? ' ' : '';

            $value = number_format($value, $right, $locale['mon_decimal_point'], $flags['nogroup'] ? '' : $locale['mon_thousands_sep']);
            $value = @explode($locale['mon_decimal_point'], $value);

            $n = strlen($prefix) + strlen($currency) + strlen($value[0]);
            if ($left > 0 && $left > $n) {
                $value[0] = str_repeat($flags['fillchar'], $left - $n) . $value[0];
            }
            $value = implode($locale['mon_decimal_point'], $value);
            if ($locale["{$letter}_cs_precedes"]) {
                $value = $prefix . $currency . $space . $value . $suffix;
            } else {
                $value = $prefix . $value . $space . $currency . $suffix;
            }
            if ($width > 0) {
                $value = str_pad($value, $width, $flags['fillchar'], $flags['isleft'] ?
                    STR_PAD_RIGHT : STR_PAD_LEFT);
            }

            $format = str_replace($fmatch[0], $value, $format);
        }
        return $format;
    }

    public static function geterrorSistem($hola)
    {
        $hola->dispatchBrowserEvent('alert', [
            'tipo' => 'error',
            'icono' => 'fas fa-times text-danger mr-2',

            'title' => 'Por favor, intentelo más tarde.'
        ]);
    }

    public static function getsuccessDefine($hola, $mensaje)
    {
        $hola->dispatchBrowserEvent('alert', [
            'tipo' => 'success',
            'icono' => 'fas fa-check text-success mr-2',
            'title' => $mensaje
        ]);
    }
    public static function geterrorcreate($hola)
    {
        $hola->dispatchBrowserEvent('alert', [
            'tipo' => 'error',
            'icono' => 'fas fa-times text-danger mr-2',

            'title' => 'Ocurrio un error al crear.'
        ]);
    }
    public static function geterrorupdate($hola)
    {
        $hola->dispatchBrowserEvent('alert', [
            'tipo' => 'error',
            'icono' => 'fas fa-times text-danger mr-2',

            'title' => 'Ocurrio un error al actualizar.'
        ]);
    }
    public static function geterrordelete($hola)
    {
        $hola->dispatchBrowserEvent('alert', [
            'tipo' => 'error',
            'icono' => 'fas fa-times text-danger mr-2',

            'title' => 'Ocurrio un error al eliminar.'
        ]);
    }
    public static function getsuccesscreate($hola)
    {
        $hola->dispatchBrowserEvent('alert', [
            'tipo' => 'success',
            'icono' => 'fas fa-check text-success mr-2',
            'title' => 'Se creo correctamente.'
        ]);
    }
    public static function geterrordefine($hola, $message)
    {
        $hola->dispatchBrowserEvent('alert', [
            'tipo' => 'error',
            'icono' => 'fas fa-times text-danger mr-2',
            'title' => $message
        ]);
    }
    public static function getwarningdefine($hola, $message)
    {
        $hola->dispatchBrowserEvent('alert', [
            'tipo' => 'warning',
            'icono' => 'fas fa-exclamation text-warning mr-2',
            'title' => $message
        ]);
    }
    public static function getsuccessupdate($hola)
    {
        $hola->dispatchBrowserEvent('alert', [
            'tipo' => 'success',
            'icono' => 'fas fa-check text-success mr-2',
            'title' => 'Se actualizo correctamente'
        ]);
    }
    public static function getsuccessdelete($hola)
    {
        $hola->dispatchBrowserEvent('alert', [
            'tipo' => 'success',
            'icono' => 'fas fa-check text-success mr-2',
            'title' => 'Se elimino correctamente.'
        ]);
    }
    public static function geterrorpermissionaccess($hola)
    {
        $hola->dispatchBrowserEvent('alert', [
            'tipo' => 'warning',
            'icono' => 'fas fa-times text-danger mr-2',

            'title' => 'No tienes permiso para hacer uso de esta opcion.'
        ]);
    }
    public static function geterrorexport($hola)
    {
        $hola->dispatchBrowserEvent('alert', [
            'tipo' => 'warning',
            'icono' => 'fas fa-times text-danger mr-2',

            'title' => 'No puede exportar comuniquese con el desarrollador.'
        ]);
    }


    public static function geterroralreadyregister($hola, $message)
    {
        $hola->dispatchBrowserEvent('alert', [
            'tipo' => 'error',
            'icono' => 'fas fa-times text-danger mr-2',
            'title' => $message
        ]);
    }

    public static function darFormatoFecha($fecha)
    {
        try {
            if ($fecha) {
                return Carbon::parse($fecha)->format('d-m-Y');
            } else {
                return $fecha;
            }
        } catch (Exception $e) {
            return "";
        }
    }

    public static function checkPermission($permission)
    {

        $access = true;
        /*   foreach ($permissions as $p) {
            if ($p->permission_key == $permission) {
                $access = true;
                break;
            }
        }
 */

        return $access;
    }
}



/* 

use Illuminate\Support\Facades\DB;



DB::beginTransaction(); //Iniciamos la reansaccion

try {
    DB::commit();
} catch (\Exception $e) {
    DB::rollback();
} */


// DEFINIDORES DE CAMPOS 

    // DEFINIDORES DE CAMPOS 



    // CAMPOS INICIALIZADORES 

    // CAMPOS INICIALIZADORES 



    // OTROS COMPONENTES 

    // OTROS COMPONENTES 