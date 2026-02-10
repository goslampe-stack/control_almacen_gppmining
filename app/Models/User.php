<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'last_name',
        'username',
        'dni',
        'empresas_id',
        'gender',
        'phone',
        'salary',
        'email',
        'password',
        'tipoUsuario',
        'cantidadEmpresas',
        'descripcion',
        'estado',
        'last_login',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public static function search($search, $estado, $empresas_id)
    {


        if ($estado == '') {
            return empty($search) ? static::where('estado', '=', 1)->where('empresas_id', '=',$empresas_id)->where('tipoUsuario', '!=', 'Usuario') :
                static::where('name', 'like', '%' . $search . '%')->orWhere('last_name', 'like', '%' . $search . '%')->where('empresas_id','=',$empresas_id)->where('tipoUsuario', '!=', 'Usuario');
        } else {

            return   static::where('estado', '=',  $estado)->where('empresas_id','=',$empresas_id)->where('tipoUsuario', '!=', 'Usuario');
        }
    }
    public static function searchPermisoUsuario($search, $estado, $empresas_id)
    {


        if ($estado == '') {
            return empty($search) ? static::where('estado', '=', 1)->where('empresas_id', '=',$empresas_id)->where('tipoUsuario', '!=', 'Usuario') :
                static::where('name', 'like', '%' . $search . '%')->orWhere('last_name', 'like', '%' . $search . '%')->where('empresas_id','=',$empresas_id)->where('tipoUsuario', '!=', 'Usuario');
        } else {

            return   static::where('estado', '=',  $estado)->where('empresas_id','=',$empresas_id)->where('tipoUsuario', '!=', 'Usuario');
        }
    }

    function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'user_roles');
    }

    function full_name()
    {
        return $this->last_name.", ".$this->name;
    }

    
}
