<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenDeCompra extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function search($search, $estado, $sucursal_empresas_id)
    {


        if ($estado == '') {
            return empty($search) ? static::where('sucursal_empresas_id', '=', $sucursal_empresas_id) :
                static::orWhere('numero_orden_compra', 'like', '%' . $search . '%')
                ->where('sucursal_empresas_id', '=',  $sucursal_empresas_id);
        } else {

            return   static::where('estado', '=',  $estado)->where('sucursal_empresas_id', '=',  $sucursal_empresas_id);
        }
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'proveedors_id');
    }
    public function personal()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function elaboradoPor()
    {
        return $this->belongsTo(Personal::class, 'elaboradoPor_id');
    }

    public function solicitudCotizacion()
    {
        return $this->belongsTo(SolicitudCotizacion::class, 'solicitud_cotizacions_id');
    }
    public function sucursal()
    {
        return $this->belongsTo(SucursalEmpresa::class, 'sucursal_empresas_id');
    }
}
