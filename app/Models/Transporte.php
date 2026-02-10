<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transporte extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function search($search, $estado, $empresas_id)
    {


        if ($estado == '') {
            return empty($search) ? static::where('empresas_id', '=', $empresas_id) :
                static::where('razon_social', 'like', '%' . $search . '%')->where('empresas_id', '=', $empresas_id);
        } else {

            return empty($search) ? static::where('empresas_id', '=', $empresas_id)->where('estado', '=',  $estado) :
                static::where('razon_social', 'like', '%' . $search . '%')->where('empresas_id', '=', $empresas_id)->where('estado', '=',  $estado);
        }
    }
}
