<?php

namespace App\Http\Livewire\PermisoUsuario;

use App\Models\PermisoUsuario;
use App\Models\Personal;
use App\Models\PersonalPdf;
use App\Models\User;
use App\Models\Util;
use Livewire\Component;
use Livewire\WithPagination;
class Principal extends Component
{

    use WithPagination;
    public $search = '';
    public $perPage = 10;
    public $sortField = 'id';
    public $sortAsc = true;
    public $selectedPersonales = [];
    public $estaActivadoEliminar = 'disabled';
    public $estaActivadorInactivo = 'disabled';
    public $estaActivadorActivo = 'disabled';
    public $filtrarPorEstado = "";
    protected $listeners = ['refreshParent' => '$refresh'];

    public $sucursal_empresas_id_seleccionado = '';

    /* PERMISOS */

    public $permiso_agregar = 'd-none';
    public $permiso_eliminar = 'd-none';
    public $permiso_actualizar = 'd-none';
    public $permiso_listar = 'd-none';



    public function verificarPermisos()
    {
        if (Util::checkpermission('personal-create')) {
            $this->permiso_agregar = '';
        } else {
            $this->permiso_agregar = 'd-none';
        }

        if (Util::checkpermission('personal-edit')) {
            $this->permiso_actualizar = '';
        } else {
            $this->permiso_actualizar = 'd-none';
        }

        if (Util::checkpermission('personal-delete')) {
            $this->permiso_eliminar = '';
        } else {
            $this->permiso_eliminar = 'd-none';
        }

        if (Util::checkpermission('personal-list')) {
            $this->permiso_listar = '';
        } else {
            $this->permiso_listar = 'd-none';
        }
    }

    /* PERMISOS */


    public function mount()
    {
        
            $numero = Util::getEmpresasIngresada();
            if ($numero != -10) {
                $this->sucursal_empresas_id_seleccionado = $numero;
                $this->verificarPermisos();
            } else {
                return redirect()->route('dashboard');
            }
   

          //VERIFICAMOS SI TIENE PERMISOS
          if (!Util::tienePermiso(Util::$OPCION_PERMISO_USUARIO)) {
            return redirect()->route('dashboard');
        }
          
    }


    public function render()
    {
        return view('livewire.permiso-usuario.principal', ['data' => $this->modelarDatos()]);
    }
    /**
     * Modelas los datos de la base de datos
     *
     * @return void
     */
    public function modelarDatos()
    {

        $data = User::searchPermisoUsuario($this->search, $this->filtrarPorEstado, $this->sucursal_empresas_id_seleccionado)->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')->simplePaginate($this->perPage);
        return $data;
    }

    public function cambiarFiltrarPorEstado($estado)
    {
        $this->selectedPersonales = [];
        $this->estaActivadoEliminar = 'disabled';
        $this->estaActivadorInactivo = 'disabled';
        $this->estaActivadorActivo = 'disabled';
        $this->filtrarPorEstado = $estado;
    }


    public function cambiarEstadoBotones()
    {

        if (count($this->selectedPersonales) > 0) {
            $this->estaActivadoEliminar = 'enabled';
            $this->estaActivadorInactivo = 'enabled';
            $this->estaActivadorActivo = 'enabled';
        } else {
            $this->estaActivadoEliminar = 'disabled';
            $this->estaActivadorInactivo = 'disabled';
            $this->estaActivadorActivo = 'disabled';
        }
    }


    public function resetearValores()
    {
        $this->estaActivadoEliminar = 'disabled';
        $this->estaActivadorInactivo = 'disabled';
        $this->estaActivadorActivo = 'disabled';
        $this->selectedPersonales = [];
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

    public function editar($id)
    {
        $this->emit('editar', $id);
    }



    public function eliminar()
    {
        $this->dispatchBrowserEvent('openDeleteModal');
    }

    public function destruir()
    {

        PermisoUsuario::destroy($this->selectedPersonales);
        $this->resetearValores();
        $this->dispatchBrowserEvent('closeDeleteModal');
    }


    public function abrirModalInactivar()
    {
        $this->dispatchBrowserEvent('openInactivarModal');
    }
    public function abrirModalActivar()
    {
        $this->dispatchBrowserEvent('openActivarModal');
    }


    public function inactivarPersonales()
    {
        $response = null;
        foreach ($this->selectedPersonales as $p) {
            $categoriaProducto = PermisoUsuario::findOrFail($p);

            if ($categoriaProducto->estado == 1) {
                $categoriaProducto->estado = 0;
                $response = $categoriaProducto->update();
                if (!$response) {
                    break;
                }
            }
        }

        if ($response == null || $response == true) {

            $this->resetearValores();
            $this->dispatchBrowserEvent('closeInactivarModal');
        } else {

            $this->dispatchBrowserEvent('closeInactivarModal');
            $this->dispatchBrowserEvent('openErrorModal');
        }
    }

    public function activarPersonales()
    {
        $response = null;
        foreach ($this->selectedPersonales as $p) {
            $categoriaProducto = PermisoUsuario::findOrFail($p);
            if ($categoriaProducto->estado == 0) {
                $categoriaProducto->estado = 1;
                $response = $categoriaProducto->update();

                if (!$response) {
                    break;
                }
            }
        }
        if ($response == null || $response == true) {
            $this->resetearValores();
            $this->dispatchBrowserEvent('closeActivarModal');
        } else {
            $this->dispatchBrowserEvent('closeActivarModal');
            $this->dispatchBrowserEvent('openErrorModal');
        }
    }
}
