<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalidaDetalle extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function search($search,  $salidas_id)
    {

        return empty($search) ? static::where('salidas_id', '=', $salidas_id) :
            static::where('id', 'like', '%' . $search . '%')
            ->where('salidas_id', '=',  $salidas_id);
    }

    public function articuloRequerimientoPersonal()
    {
        return $this->belongsTo(ArticuloRequerimientoPersonal::class, 'articulo_r_personals_id');
    }

    public function calcularPrecioTotal($cantidad, $precio)
    {
        if ($cantidad != null && $precio != null) {
            return Util::darFormatoMoneda(floatval($cantidad) * floatval($precio));
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


    public function articulo()
    {
        return $this->belongsTo(Articulo::class, 'articulos_id');
    }

    public function formatoFecha($fecha){
        return Carbon::parse($fecha)->format('d/m/Y H:m');
    }
}
