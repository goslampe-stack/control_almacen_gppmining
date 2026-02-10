<?php

namespace App\Models;

use App\Models\OrdenDeCompra;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticuloOrdenCompra extends Model
{



    use HasFactory;
    protected $guarded = [];


    public static function search($search, $sucursal_id)
    {

        return empty($search) ? static::where('sucursal_empresas_id', '=', $sucursal_id) :
            static::join('articulo_requerimiento_personals', 'articulo_orden_compras.articulo_s_cotizacion_id', '=', 'articulo_requerimiento_personals.id')
            ->join('articulos', 'articulo_requerimiento_personals.articulos_id', '=', 'articulos.id')
            ->select('articulo_orden_compras.*')
            ->where('articulos.articulo', 'like', '%' . $search . '%')
            ->where('articulo_orden_compras.sucursal_empresas_id', '=', $sucursal_id);
    }



    public static function searchOrdenCompra($search, $orden_compras_id)
    {

        return empty($search) ? static::where('orden_de_compras_id', '=', $orden_compras_id) :
            static::join('articulos', 'articulo_requerimiento_personals.articulos_id', '=', 'articulos.id')
            ->select('articulo_requerimiento_personals.*')
            ->where('articulos.articulo', 'like', '%' . $search . '%')
            ->where('articulo_requerimiento_personals.orden_de_compras_id', '=', $orden_compras_id) //2 orden de compra
            ->where('articulo_requerimiento_personals.estado', '=', 2); //2 orden de compra
    }


    public static function buscarParaTabla($sucursal, $ordenCompra, $articulo)
    {

        return static::where('sucursal_empresas_id', '=', $sucursal)
            ->where('orden_de_compras_id', '=', $ordenCompra)
            ->where('articulo_s_cotizacion_id', '=', $articulo); //2 orden de compra
    }




    public function articuloRequerimiento()
    {
        return $this->belongsTo(ArticuloSolicitudCotizacion::class, 'articulo_s_cotizacion_id');
    }
    public function ordenCompra()
    {
        return $this->belongsTo(OrdenDeCompra::class, 'orden_de_compras_id');
    }

    public function calcularPrecioTotal($cantidad, $precio)
    {
        try {
            if ($cantidad != null && $precio != null) {
                return Util::darFormatoMoneda($cantidad * $precio);
            } else if ($cantidad != null && $precio == null) {
                return Util::darFormatoMoneda($cantidad);
            } else if ($cantidad == null && $precio != null) {
                return Util::darFormatoMoneda('0');
            }
            return Util::darFormatoMoneda('0');
        } catch (Exception $a) {
          
        }
    }

    public function darFormatoMoneda($moneda)
    {
        return Util::darFormatoMoneda($moneda);;
    }
    

    public function darFormatoFecha($fecha)
    {
        if ($fecha == null) {
            return "";
        } else {

            return Carbon::parse($fecha)->format('d-m-Y H:i');
        }
    }
}
