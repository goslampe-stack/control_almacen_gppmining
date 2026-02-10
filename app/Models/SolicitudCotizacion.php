<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudCotizacion extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function search($search, $estado, $sucursal_empresas_id)
    {


        if ($estado == '') {
            return empty($search) ? static::where('sucursal_empresas_id', '=', $sucursal_empresas_id) :
                static::where('numero_solicitud_cotizacion', 'like', '%' . $search . '%')
                ->where('sucursal_empresas_id', '=',  $sucursal_empresas_id);
        } else {

            return   static::where('estado', '=',  $estado)->where('sucursal_empresas_id', '=',  $sucursal_empresas_id);
        }
    }

    public function personal()
    {
        return $this->belongsTo(Personal::class, 'personals_id');
    }
    public function sucursal()
    {
        return $this->belongsTo(SucursalEmpresa::class, 'sucursal_empresas_id');
    }

    public function requerimientoCompras()
    {
        return $this->belongsTo(RequerimientoCompra::class, 'requerimiento_compras_id');
    }
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedors_id');
    }
}
