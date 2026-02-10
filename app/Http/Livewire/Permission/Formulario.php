<?php

namespace App\Http\Livewire\Permission;

use App\Models\Module;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RoleModule;
use App\Models\RolePermission;
use App\Models\Util;
use Livewire\Component;
use Livewire\WithPagination;

class Formulario extends Component
{

    use WithPagination;

    public $modelId, $search;
    public $selectedPermisosRole = [];
    public $perPage = 10;

    public function mount($id)
    {

        $this->modelId = $id;
    }

    public function render()
    {
        return view('livewire.permission.formulario', ['permission' => $this->obtenerPermisos()]);
    }


    public function obtenerPermisos()
    {

        $data = Permission::search($this->search)->orderBy('id', 'asc')->simplePaginate($this->perPage);
        $this->obtenerData();

        return $data;
    }

    public function obtenerData()
    {



        $roledetails = Role::find($this->modelId);
        $permission = Permission::all();
        $rolemodule = RoleModule::where('role_id', '=', $this->modelId)->get();


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

        $this->selectedPermisosRole = [];
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
                $this->selectedPermisosRole[] = $p->id;
            }
        }
    }



    public function actualizar()
    {
        $rp = RolePermission::where('role_id', '=', $this->modelId)->get();
        foreach ($rp as $r) {
            $r->delete();
        }



        if (count($this->selectedPermisosRole) > 0) {

            foreach ($this->selectedPermisosRole as $p) {

                $data['permission_id'] = $p;
                $data['role_id'] = $this->modelId;
                RolePermission::create($data);
            }
        } else {
        }
        /*    return redirect()->route('role'); */
    }
}
