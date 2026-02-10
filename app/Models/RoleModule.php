<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleModule extends Model
{
    use HasFactory;

    
    protected $fillable = ['id', 'role_id', 'module_id', 'created_at', 'updated_at'];


    function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }
}
