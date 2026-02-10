<?php

namespace App\Http\Livewire\Role;

use App\Models\Role;
use App\Models\TipoUnidad;
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
    public $selectedTipoUnidades = [];
    public $estaActivadoEliminar = 'disabled';
    public $estaActivadorInactivo = 'disabled';
    public $estaActivadorActivo = 'disabled';
    public $filtrarPorEstado = "";
    protected $listeners = ['refreshParent' => '$refresh'];

    public $tiendas_id_seleccionado = '';


   


    public function render()
    {
        return view('livewire.role.principal', ['data' => $this->modelarDatos()]);
    }


    
    /**
     * Modelas los datos de la base de datos
     *
     * @return void
     */
    public function modelarDatos()
    {

        $data = Role::search($this->search, $this->filtrarPorEstado, $this->tiendas_id_seleccionado)->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')->simplePaginate($this->perPage);

        return $data;
    }

    public function cambiarFiltrarPorEstado($estado)
    {
        $this->selectedTipoUnidades = [];
        $this->estaActivadoEliminar = 'disabled';
        $this->estaActivadorInactivo = 'disabled';
        $this->estaActivadorActivo = 'disabled';
        $this->filtrarPorEstado = $estado;
    }


    public function cambiarEstadoBotones()
    {

        if (count($this->selectedTipoUnidades) > 0) {
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
        $this->selectedTipoUnidades = [];
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

        Role::destroy($this->selectedTipoUnidades);
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


    public function inactivarTipoUnidades()
    {
        $response = null;
        foreach ($this->selectedTipoUnidades as $p) {
            $categoriaProducto = Role::findOrFail($p);

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

    public function activarTipoUnidades()
    {
        $response = null;
        foreach ($this->selectedTipoUnidades as $p) {
            $categoriaProducto = Role::findOrFail($p);
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
