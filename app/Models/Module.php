<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'id',
        'name',
        'view_sidebar',
        'module_key',
        'identity',
        'module_url',
        'module_rank',
        'module_icon',
        'created_at',
        'updated_at'
    ];

    function users()
    {
        return $this->belongsToMany('App\Models\User', 'role_modules');
    }

    
    public static function search($search)
    {

        return empty($search) ? static::where('state', '=', 1) :
            static::where('name', 'like', '%' . $search . '%');
    }
}
