<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RoleModule;
use App\Models\RolePermission;
use App\Models\Util;
use Illuminate\Http\Request;

class PermissionController extends Controller
{


    public function asign($id)
    {



        Util::checkpermission('permission-asign');



        $roledetails = Role::find($id);
        $permission = Permission::all();
        $rolemodule = RoleModule::where('role_id', '=', $id)->get();





        /*  dd($rolemodule); */

        /* Vamos a recorrer para sacar los mudlos que necesitamos */
        $currentcheckPermission = [];

        foreach ($permission as $p) {
            foreach ($rolemodule as $rm) {
                $module = Module::find($rm->module_id);

                if ($p->type == $module->identity) {

                    $currentcheckPermission[] = $p;
                }
            }
        }




        $currentpermission = $roledetails->permissions;
        $current = [];

        //for para verificar los
        foreach ($currentcheckPermission as $p) {
            $checked = false;
            foreach ($currentpermission as $pc) {
                if ($p->permission_key == $pc->permission_key) {
                    $checked = true;
                    break;
                }
            }
            if ($checked) {
                $p->checked = "checked";
                $current[] = $p;
            } else {
                $p->checked = "Hola";
                $current[] = $p;
            }
        }

        return view('backend.permission.asign', compact('roledetails', 'permission', 'current', 'currentpermission'));
    }

    public function permissionasign(Request $request, $id)
    {


        $data['role_id'] = $id;
        $role = Role::find($id);
        $rp = RolePermission::where('role_id', '=', $id)->get();
        foreach ($rp as $r) {
            $r->delete();
        }

        if (isset($request->asignpermission)) {

            foreach ($request->asignpermission as $p) {

                $data['permission_id'] = $p;

                RolePermission::create($data);
            }

            return redirect()->route('role');
        } else {

            return redirect()->route('role');
        }

        return redirect()->route('role');
    }
}
