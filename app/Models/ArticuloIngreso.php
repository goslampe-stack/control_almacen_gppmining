<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;


class ArticuloIngreso extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function articuloOrdenCompra()
    {
        return $this->belongsTo(ArticuloOrdenCompra::class, 'articulos_orden_id');
    }
    public function darFormatoMoneda($moneda)
    {
        return Util::darFormatoMoneda($moneda);;
    }
    public function calcularPrecioTotal($cantidad, $precio)
    {
        try {
            if ($cantidad != null && $precio != null) {
                return Util::darFormatoMoneda($cantidad * $precio);
            } else if ($cantidad != null && $precio == null) {
                return Util::darFormatoMoneda($cantidad);
            } else if ($cantidad == null && $precio != null) {
                return Util::darFormatoMoneda('0');
            }
            return Util::darFormatoMoneda('0');
        } catch (Exception $a) {
          
        }
    }

}
