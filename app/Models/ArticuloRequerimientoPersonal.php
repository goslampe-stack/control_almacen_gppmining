<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticuloRequerimientoPersonal extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function search($search,  $requerimiento_p_id)
    {

        return empty($search) ? static::where('requerimiento_p_id', '=', $requerimiento_p_id) :
            static::where('id', 'like', '%' . $search . '%')
            ->orWhere('articulo', 'like', '%' . $search . '%')
            ->where('requerimiento_p_id', '=',  $requerimiento_p_id);
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
    public static function searchRequerimientoCompras($search, $orden_compras_id)
    {

        return empty($search) ? static::where('requerimientoCompras_id', '=', $orden_compras_id) :
            static::join('articulos', 'articulo_requerimiento_personals.articulos_id', '=', 'articulos.id')
            ->select('articulo_requerimiento_personals.*')
            ->where('articulos.articulo', 'like', '%' . $search . '%')
            ->where('articulo_requerimiento_personals.requerimientoCompras_id', '=', $orden_compras_id) //2 orden de compra
            ->where('articulo_requerimiento_personals.estado', '=', 2); //2 orden de compra
    }


    public static function searchRequerimientoPersonal($requerimiento_p_id)
    {

        return static::where('requerimiento_p_id', '=', $requerimiento_p_id)
            ->where('estado', '=', 1); //2 orden de compra
    }

    public static function searchOrdenDeCompra($orden_de_compras_id)
    {

        return static::where('orden_de_compras_id', '=', $orden_de_compras_id)
            ->where('estado', '=', 1); //2 orden de compra
    }

    public function articulo()
    {
        return $this->belongsTo(Articulo::class, 'articulos_id');
    }
    public function requerimientoPersonal()
    {
        return $this->belongsTo(RequerimientoPersonal::class, 'requerimiento_p_id');
    }


    public function calcularPrecioTotal($cantidad, $precio)
    {
        if ($cantidad != null && $precio != null) {
            return Util::darFormatoMoneda($cantidad * $precio);
        } else if ($cantidad != null && $precio == null) {
            return Util::darFormatoMoneda($cantidad);
        } else if ($cantidad == null && $precio != null) {
            return Util::darFormatoMoneda('0');
        }
        return Util::darFormatoMoneda('0');
    }

    public function darFormatoMoneda($moneda)
    {
        return Util::darFormatoMoneda($moneda);;
    }

    public function calcularFaltaArticuloOrdenCompraRequerimientoPersonal($id,$orden_compra)
    {
        $sucursal_empresas_id_seleccionado = Util::getSucursalEmpresaIdLocalStorage();

        $data = ArticuloOrdenCompra::where('articulo_r_personals_id', '=', $id)
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

        $data = ArticuloRequerimientoCompra::where('articulo_r_personals_id', '=', $id)
            ->where('requerimientoCompras_id', '=', $orden_compra)
            ->where('sucursal_empresas_id', '=', $sucursal_empresas_id_seleccionado)->get();

        $cantidad = 0;

        foreach ($data as $d) {
            $cantidad = $cantidad + $d->cantidad;
        }

        return $cantidad;
    }
}
