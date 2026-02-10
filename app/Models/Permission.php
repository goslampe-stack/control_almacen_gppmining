<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name', 'permission_key', 'created_at','updated_at'];

    public static function search($search)
    {

        return empty($search) ? static::where('state', '=', 1) :
            static::where('name', 'like', '%' . $search . '%');
    }
}
