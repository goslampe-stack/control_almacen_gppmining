<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SucursalEmpresa extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function search($search, $estado, $sucursal)
    {


        if ($estado == '') {
            return empty($search) ? static::where('empresas_id', '=', $sucursal) :
                static::where('nombre_sucursal', 'like', '%' . $search . '%')->where('empresas_id', '=', $sucursal);
        } else {

            return   static::where('estado', '=',  $estado)->where('empresas_id', '=', $sucursal);
        }
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresas_id');
    }
}
