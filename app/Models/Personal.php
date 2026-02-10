<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function search($search, $estado, $sucursal_empresas_id)
    {


        if ($estado == '') {
            return empty($search) ? static::where('sucursal_empresas_id', '=', $sucursal_empresas_id) :
                static::where('nombre', 'like', '%' . $search . '%')
                ->orWhere('apellidos', 'like', '%' . $search . '%')
                ->where('sucursal_empresas_id', '=',  $sucursal_empresas_id);
        } else {

            return   static::where('estado', '=',  $estado)->where('sucursal_empresas_id', '=',  $sucursal_empresas_id);
        }
    }

    public function tipoPersonal()
    {
        return $this->belongsTo(TipoPersonal::class, 'tipoPersonals_Id');
    }
}
