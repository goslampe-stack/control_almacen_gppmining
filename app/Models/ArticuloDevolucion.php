<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticuloDevolucion extends Model
{
    use HasFactory;
    protected $guarded = [];


    public static function search($search, $sucursal_id)
    {

        return empty($search) ? static::where('sucursal_empresas_id', '=', $sucursal_id) :
            static::join('articulos', 'articulo_devolucions.articulo_r_personals_id', '=', 'articulos.id')
            ->select('articulo_devolucions.*')
            ->where('articulos.articulo', 'like', '%' . $search . '%')
            ->where('articulo_devolucions.sucursal_empresas_id', '=', $sucursal_id);
    }
    public function articulo()
    {
        return $this->belongsTo(Articulo::class, 'articulos_id');
    }
    

}
