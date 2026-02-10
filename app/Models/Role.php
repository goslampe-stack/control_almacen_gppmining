<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'id', 'created_at', 'updated_at'];


    function  modules()
    {
        return $this->belongsToMany('App\Models\Module', 'role_modules');
    }

    function  permissions()
    {
        return $this->belongsToMany('App\Models\Permission', 'role_permissions');
    }


    public static function search($search, $estado)
    {


        if ($estado == '') {
            return empty($search) ? static::where('id', '>=', 1) :
                static::where('name', 'like', '%' . $search . '%');
        } else {
            return   static::where('state', '=',  $estado);
        }
    }
}
