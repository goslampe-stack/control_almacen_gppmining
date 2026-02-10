<?php

namespace App\Http\Livewire\Transporte;

use App\Models\ArticuloIngreso;
use App\Models\Transporte;
use App\Models\Util;
use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;

class Principal extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 10;
    public $sortField = 'id';
    public $sortAsc = true;
    public $selectedItemTabla = [];
    public $estaActivadoEliminar = 'disabled';
    public $estaActivadorInactivo = 'disabled';
    public $estaActivadorActivo = 'disabled';
    public $filtrarPorEstado = "";
    protected $listeners = ['refreshParent' => '$refresh'];

    public $empresas_id = '';

    /* PERMISOS */

    public $permiso_agregar = 'd-none';
    public $permiso_eliminar = 'd-none';
    public $permiso_actualizar = 'd-none';
    public $permiso_listar = 'd-none';



    public function verificarPermisos()
    {
        if (Util::checkpermission('transporte-create')) {
            $this->permiso_agregar = '';
        } else {
            $this->permiso_agregar = 'd-none';
        }

        if (Util::checkpermission('transporte-edit')) {
            $this->permiso_actualizar = '';
        } else {
            $this->permiso_actualizar = 'd-none';
        }

        if (Util::checkpermission('transporte-delete')) {
            $this->permiso_eliminar = '';
        } else {
            $this->permiso_eliminar = 'd-none';
        }

        if (Util::checkpermission('transporte-list')) {
            $this->permiso_listar = '';
        } else {
            $this->permiso_listar = 'd-none';
        }
    }

    /* PERMISOS */




    public function mount()
    {

        $this->verificarPermisos();

        $this->empresas_id = Util::getEmpresasIngresada();

        //VERIFICAMOS SI TIENE PERMISOS

        if (!Util::tienePermiso(Util::$OPCION_TRANSPORTE)) {
            return redirect()->route('dashboard');
        }

           //ver empresas

           $data = Util::tienePermisoUsuario('Empresas');
           $estado = $data['estado'];
   
           if ($estado == false) {
               return redirect()->route('facturacion');
           }
    }


    public function render()
    {
        return view('livewire.transporte.principal', ['data' => $this->modelarDatos()]);
    }


    /**
     * Modelas los datos de la base de datos
     *
     * @return void
     */
    public function modelarDatos()
    {


        $data = Transporte::search($this->search, $this->filtrarPorEstado, $this->empresas_id)->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')->simplePaginate($this->perPage);

        return $data;
    }

    public function cambiarFiltrarPorEstado($estado)
    {
        $this->selectedItemTabla = [];
        $this->estaActivadoEliminar = 'disabled';
        $this->estaActivadorInactivo = 'disabled';
        $this->estaActivadorActivo = 'disabled';
        $this->filtrarPorEstado = $estado;
    }


    public function cambiarEstadoBotones()
    {

        if (count($this->selectedItemTabla) > 0) {
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
        $this->selectedItemTabla = [];
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
        DB::beginTransaction(); //Iniciamos la reansaccion
        try {

            $selectEliminar = [];



            foreach ($this->selectedItemTabla as $item) {
                $eliminar = true;
                $data = ArticuloIngreso::where('transportes_id', '=', $item)->count();
                if ($data > 0) {
                    $eliminar = false;
                }

                if ($eliminar == true) {
                    $selectEliminar[] = $item;
                } else {
                    Util::geterrordefine($this, "El Transporte se encuentra en uso en otros recursos");
                }
            }


            if(count($selectEliminar)>0){
                Transporte::destroy($selectEliminar);
                Util::getsuccessdelete($this);
            }
            $this->resetearValores();
            $this->dispatchBrowserEvent('closeDeleteModal');

            DB::commit();

        } catch (\Exception $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        } catch (\Throwable $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        }
    }


    public function abrirModalInactivar()
    {
        $this->dispatchBrowserEvent('openInactivarModal');
    }
    public function abrirModalActivar()
    {
        $this->dispatchBrowserEvent('openActivarModal');
    }


    public function inactivarItemSeleccionados()
    {



        DB::beginTransaction(); //Iniciamos la reansaccion
        try {
            $response = null;
            foreach ($this->selectedItemTabla as $p) {
                $categoriaProducto = Transporte::findOrFail($p);

                if ($categoriaProducto->estado == 1) {
                    $categoriaProducto->estado = 0;
                    $response = $categoriaProducto->update();
                    if (!$response) {
                        break;
                    }
                }
            }



            $this->resetearValores();
            $this->dispatchBrowserEvent('closeInactivarModal');



            DB::commit();

            Util::getsuccessupdate($this);
        } catch (\Exception $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        } catch (\Throwable $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        }
    }

    public function activarItemSeleccionado()
    {

        DB::beginTransaction(); //Iniciamos la reansaccion
        try {

            $response = null;
            foreach ($this->selectedItemTabla as $p) {
                $categoriaProducto = Transporte::findOrFail($p);
                if ($categoriaProducto->estado == 0) {
                    $categoriaProducto->estado = 1;
                    $response = $categoriaProducto->update();

                    if (!$response) {
                        break;
                    }
                }
            }
            $this->resetearValores();
            $this->dispatchBrowserEvent('closeActivarModal');


            DB::commit();
            Util::getsuccessupdate($this);
        } catch (\Exception $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        } catch (\Throwable $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        }
    }
}
