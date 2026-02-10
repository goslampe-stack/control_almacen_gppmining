<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticuloSolicitudCotizacion extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function solicitudCotizacion()
    {
        return $this->belongsTo(SolicitudCotizacion::class, 'solicitudCotizacions_id');
    }
    public function articuloSolicitudCotizacion()
    {
        return $this->belongsTo(ArticuloRequerimientoCompra::class, 'articuloCompras_id');
    }
   
    public function articuloOrdenCompra()
    {
        return $this->belongsTo(ArticuloRequerimientoCompra::class, 'articuloCompras_id');
    }
   
    public static function searchOrdenCompra($search, $orden_compras_id)
    {

        return empty($search) ? static::where('orden_de_compras_id', '=', $orden_compras_id) :
            static::where('orden_de_compras_id', '=', $orden_compras_id) //2 orden de compra
            ->where('estado', '=', 2); //2 orden de compra
    }


    public static function searchSolicitudCotizacion($requerimiento_p_id)
    {

        return static::where('solicitudCotizacions_id', '=', $requerimiento_p_id)
            ->where('estado', '=', 1); //2 orden de compra
    }

    public static function searchOrdenDeCompra($orden_de_compras_id)
    {

        return static::where('orden_de_compras_id', '=', $orden_de_compras_id)
            ->where('estado', '=', 1); //2 orden de compra
    }

    

    public function calcularFaltaArticuloOrdenCompraRequerimientoPersonal($id,$orden_compra)
    {
        $sucursal_empresas_id_seleccionado = Util::getSucursalEmpresaIdLocalStorage();

        $data = ArticuloOrdenCompra::where('articulo_s_cotizacion_id', '=', $id)
            ->where('orden_de_compras_id', '=', $orden_compra)
            ->where('sucursal_empresas_id', '=', $sucursal_empresas_id_seleccionado)->get();

        $cantidad = 0;

        foreach ($data as $d) {
            $cantidad = $cantidad + $d->cantidad;
        }

        return $cantidad;
    }
    public function calcularFaltaArticuloRequerimeintoComprasRequerimientoPersonal($id,$orden_compra)
    {
        $sucursal_empresas_id_seleccionado = Util::getSucursalEmpresaIdLocalStorage();

        $data = ArticuloRequerimientoCompra::where('articulo_s_cotizacion_id', '=', $id)
            ->where('requerimientoCompras_id', '=', $orden_compra)
            ->where('sucursal_empresas_id', '=', $sucursal_empresas_id_seleccionado)->get();

        $cantidad = 0;

        foreach ($data as $d) {
            $cantidad = $cantidad + $d->cantidad;
        }

        return $cantidad;
    }
}
