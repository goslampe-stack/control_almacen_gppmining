<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensualidad extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function planesDetalle($id)
    {

        return ItemMensualidad::where('mensualidads_id', '=', $id)->where('estado', '=', 1)->get();
    }
    public function tienePlanActivo($plan,$empresas_id)
    {

        $data = MensualidadUsuario::where('estado', '=', 1)->where('users_id', '=', $empresas_id)->where('mensualidads_id', '=', $plan)->count();

        if ($data > 0) {
            return true;
        } else {
            return false;
        }
    }

    
}
