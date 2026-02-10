<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function search($search, $estado, $sucursal_empresas_id)
    {


        if ($estado == '') {
            return empty($search) ? static::where('sucursal_empresas_id', '=', $sucursal_empresas_id) :
                static::where('id', 'like', '%' . $search . '%')
                ->orWhere('numero_ingreso', 'like', '%' . $search . '%')
                ->where('sucursal_empresas_id', '=',  $sucursal_empresas_id);
        } else {

            return   static::where('estado', '=',  $estado)->where('sucursal_empresas_id', '=',  $sucursal_empresas_id);
        }
    }



    public function ordenDeCompra()
    {
        return $this->belongsTo(OrdenDeCompra::class, 'orden_de_compras_id');
    }
    public function transporte()
    {
        return $this->belongsTo(Transporte::class, 'transportes_id');
    }
    public function almacenero()
    {
        return $this->belongsTo(Personal::class, 'almacenero_id');
    }

    public function jefeLogistico()
    {
        return $this->belongsTo(Personal::class, 'jefeLogistica_id');
    }
}
