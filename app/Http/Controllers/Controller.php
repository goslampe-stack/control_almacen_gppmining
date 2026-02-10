<?php

namespace App\Http\Controllers;

use App\Models\Util;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function checkpermission($permission)
    {
        $user = Auth::user();
        $roles = $user->roles;
        $permissions = $roles[0]->permissions;

        $access = false;
        foreach ($permissions as $p) {
            if ($p->permission_key == $permission) {
                $access = true;
                break;
            }
        }
        if ($access == false) {
            Util::geterrorpermissionaccess();
        }

        return $access;
    }
}
