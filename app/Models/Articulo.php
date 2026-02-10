<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $guarded = [];

    public static function search($search, $estado, $empresas_id)
    {


        if ($estado == '') {
            return empty($search) ? static::where('empresas_id', '=', $empresas_id) :
                static::where('articulo', 'like', '%' . $search . '%')->where('empresas_id', '=', $empresas_id)
                ->orWhere('codigo', 'like', '%' . $search . '%')->where('empresas_id', '=', $empresas_id);
        } else {

            return empty($search) ? static::where('empresas_id', '=', $empresas_id)->where('estado', '=',  $estado) :
                static::where('articulo', 'like', '%' . $search . '%')->where('empresas_id', '=', $empresas_id)
                ->orWhere('codigo', 'like', '%' . $search . '%')->where('empresas_id', '=', $empresas_id)->where('estado', '=',  $estado);
     
        }
    }


    public function tipoUnidad()
    {
        return $this->belongsTo(TipoUnidad::class, 'tipo_unidads_id');
    }
}
