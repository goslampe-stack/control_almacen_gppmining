<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalPdf extends Model
{
    use HasFactory;


    protected $guarded = [];

    public static function  search($search, $estado, $sucursal_empresas_id)
    {


        if ($estado == '') {
            return empty($search) ? static::where('sucursal_empresas_id', '=', $sucursal_empresas_id) :
                static::join('personals', 'personal_pdfs.personals_id', '=', 'personals.id')
                ->select('personal_pdfs.*')
                ->where('personals.nombre', 'like', '%' . $search . '%')
                ->orWhere('personals.apellidos', 'like', '%' . $search . '%')
                ->where('personal_pdfs.sucursal_empresas_id', '=',  $sucursal_empresas_id);
        } else {

            return   static::where('estado', '=',  $estado)->where('sucursal_empresas_id', '=',  $sucursal_empresas_id);
        }
    }

    public function personal()
    {
        return $this->belongsTo(Personal::class, 'personals_id');
    }
}
