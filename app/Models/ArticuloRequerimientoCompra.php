<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticuloRequerimientoCompra extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function articulo()
    {
        return $this->belongsTo(Articulo::class, 'articulos_id');
    }

    public function articuloRequerimiento()
    {
        return $this->belongsTo(ArticuloRequerimientoPersonal::class, 'articulo_r_personals_id');
    }

    public static function searchRequerimientoCompras($orden_compras_id)
    {

        return static::where('requerimientoCompras_id', '=', $orden_compras_id)->where('estado', '=', 1); //2 orden de compra
    }

    public static function searchSolicitudCotizacion( $orden_compras_id)
    {

        return static::where('solicitudCotizacion_id', '=', $orden_compras_id)->where('estado', '=', 2); //2 orden de compra
    }
    public static function searchSolicitudCotizacionSolicitudCotizacion( $orden_compras_id)
    {

        return static::where('solicitudCotizacion_id', '=', $orden_compras_id)->where('estado', '=', 1); //2 orden de compra
    }

    public function calcularFaltaArticuloRequerimeintoComprasRequerimientoPersonal($id,$orden_compra)
    {
        $sucursal_empresas_id_seleccionado = Util::getSucursalEmpresaIdLocalStorage();

        $data = ArticuloSolicitudCotizacion::where('articuloCompras_id', '=', $id)
            ->where('solicitudCotizacions_id', '=', $orden_compra)
            ->where('sucursal_empresas_id', '=', $sucursal_empresas_id_seleccionado)->get();

        $cantidad = 0;

        foreach ($data as $d) {
            $cantidad = $cantidad + $d->cantidad;
        }

        return $cantidad;
    }
}
