<?php

namespace App\Http\Livewire\Tienda;

use App\Models\Empresa;
use App\Models\Tienda;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Principal extends Component
{
    protected $listeners = ['refreshParent' => '$refresh'];


    /* PERMISOS */

    public $permiso_agregar = 'd-none';



    public function verificarPermisos()
    {
        if (Util::checkpermission('empresa-create')) {
            $this->permiso_agregar = '';
        } else {
            $this->permiso_agregar = 'd-none';
        }
    }

    /* PERMISOS */

    public function mount()
    {
        $this->verificarPermisos();
        $data = User::find(Auth::id());
        $data->username = "";
        $data->update();
    }


    public function render()
    {
        return view('livewire.tienda.principal', ['tiendas' => $this->modelarDatos()]);
    }

    /**
     * crear un nuevo proveedor
     *
     * @return void
     */
    public function crear()
    {

        $this->emit('crear');
    }




    /**
     * Modelas los datos de la base de datos
     *
     * @return void
     */
    public function modelarDatos()
    {
        $data = Empresa::where('estado', '=', 1)->get();

        return $data;
    }
}
