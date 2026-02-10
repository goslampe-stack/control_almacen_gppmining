<?php

namespace App\Http\Livewire\Empresa;

use App\Models\SucursalEmpresa;
use Livewire\Component;
use Illuminate\Support\Facades\Crypt;

class Sucursales extends Component
{

    public $permiso_agregar = 'd-none';
    public $permiso_eliminar = 'd-none';
    public $permiso_actualizar = 'd-none';
    public $permiso_listar = 'd-none';
    public $modelId;

    public function mount($id)
    {

        $this->modelId = Crypt::decrypt($id);
        $this->verificarPermisos();
    }


    public function verificarPermisos()
    {
        if (Util::checkpermission('empresa-create')) {
            $this->permiso_agregar = '';
        } else {
            $this->permiso_agregar = 'd-none';
        }

        if (Util::checkpermission('empresa-edit')) {
            $this->permiso_actualizar = '';
        } else {
            $this->permiso_actualizar = 'd-none';
        }

        if (Util::checkpermission('empresa-delete')) {
            $this->permiso_eliminar = '';
        } else {
            $this->permiso_eliminar = 'd-none';
        }

        if (Util::checkpermission('empresa-list')) {
            $this->permiso_listar = '';
        } else {
            $this->permiso_listar = 'd-none';
        }
    }



    public function render()
    {
        return view('livewire.empresa.sucursales', ['sucursales' => $this->modelarDatos()]);
    }

    /**
     * Modelas los datos de la base de datos
     *
     * @return void
     */
    public function modelarDatos()
    {
        $data = SucursalEmpresa::where('empresas_id', '=', $this->modelId)->get();

        return $data;
    }


    public function crear()
    {
        $this->emit('crear');
    }
}
