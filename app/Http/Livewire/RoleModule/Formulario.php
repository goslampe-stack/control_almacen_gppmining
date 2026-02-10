<?php

namespace App\Http\Livewire\RoleModule;

use App\Models\Module;
use App\Models\Role;
use App\Models\RoleModule;
use App\Models\Util;
use Livewire\Component;
use Livewire\WithPagination;

class Formulario extends Component
{
    use WithPagination;

    public $modelId, $search, $realizo_cambios = true;
    public $selectedPermisosRoleModule = [];
    public $perPage = 10;

    public function mount($id)
    {

       
        $this->modelId = $id;
    }


    public function render()
    {
        return view('livewire.role-module.formulario', ['modulos' => $this->obtenerModulos()]);
    }


    public function obtenerModulos()
    {

        $data = Module::search($this->search)->orderBy('id', 'asc')->simplePaginate($this->perPage);
        $this->obtenerDatos();

        return $data;
    }


    public function obtenerDatos()
    {

        $roledetails = Role::find($this->modelId);
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

                $this->selectedPermisosRoleModule[] = $p->id;
            }
        }

        $this->realizo_cambios = false;
    }


    public function actualizarDatos()
    {
        $rp = RoleModule::where('role_id', '=', $this->modelId)->get();
      
        foreach ($rp as $r) {
            $r->delete();
        }


        foreach ($this->selectedPermisosRoleModule as $p) {
            $data['module_id'] = $p;
            $data['role_id'] = $this->modelId;
            RoleModule::create($data);
        }
        return redirect()->route('role');
    }
}
