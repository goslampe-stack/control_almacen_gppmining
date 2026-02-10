<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Role;
use App\Models\RoleModule;
use App\Models\Util;
use Illuminate\Http\Request;

class RoleModuleController extends Controller
{
    public function asign($id)
    {

        if (!Util::checkpermission('permission-asign')) {
            return redirect()->back();
        }

        /*         Util::checkpermission('permission-asign'); */

        $roledetails = Role::find($id);
        $rolemodule = Module::all();



        $currentrolemodule = $roledetails->modules;



        $current = [];

        //for para verificar los
        foreach ($rolemodule as $p) {
            $checked = false;
            foreach ($currentrolemodule as $pc) {
                if ($p->id == $pc->id) {
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
        return view('backend.rolemodule.asign', compact('roledetails', 'rolemodule', 'current', 'currentrolemodule'));
    }

    public function rolemoduleasign(Request $request, $id)
    {

        $data['role_id'] = $id;
        $role = Role::find($id);
        $rp = RoleModule::where('role_id', '=', $id)->get();

        foreach ($rp as $r) {
            $r->delete();
        }

        if (isset($request->asignpermission)) {
            foreach ($request->asignpermission as $p) {
                $data['module_id'] = $p;
                RoleModule::create($data);
            }
            return redirect()->route('role');
        } else {
            return redirect()->route('role');
        }
        return redirect()->route('role');
    }
}
