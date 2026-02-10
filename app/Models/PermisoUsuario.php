<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermisoUsuario extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function search($search, $estado, $empresas_id)
    {
        /* return static::where('empresas_id', '=', $empresas_id); */

        return empty($search) ? static::where('empresas_id', '=', $empresas_id) :
            static::join('users', 'permiso_usuarios.personals_id', '=', 'users.id')
            ->select('permiso_usuarios.*')
            ->where('users.name', 'like', '%' . $search . '%')
            ->where('permiso_usuarios.empresas_id', '=', $empresas_id);
    }

    public function personal()
    {
        return $this->belongsTo(User::class, 'personals_id');
    }
}
