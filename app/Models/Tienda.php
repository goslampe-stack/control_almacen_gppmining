<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tienda extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function search($search, $estado)
    {


        if ($estado == '') {
            return empty($search) ? static::where('estado', '>=', 0) :
                static::where('razon_social', 'like', '%' . $search . '%');
        } else {

            return   static::where('estado', '=',  $estado);
        }
    }
}
