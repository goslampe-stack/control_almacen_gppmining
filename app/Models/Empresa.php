<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function search($search, $estado,$usuario)
    {


        if ($estado == '') {
            return empty($search) ? static::where('users_id','=',$usuario) :
                static::where('razon_social', 'like', '%' . $search . '%')->where('users_id','=',$usuario) ;
        } else {

            return   static::where('estado', '=',  $estado)->where('users_id','=',$usuario) ;
        }
    }
}
