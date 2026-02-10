<?php

namespace App\Http\Livewire\Proveedor;

use App\Models\OrdenDeCompra;
use App\Models\Proveedor;
use App\Models\SolicitudCotizacion;
use App\Models\User;
use App\Models\Util;
use Illuminate\Support\Facades\Auth;
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
    public $selectedProveedores = [];
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
        if (Util::checkpermission('proveedor-create')) {
            $this->permiso_agregar = '';
        } else {
            $this->permiso_agregar = 'd-none';
        }

        if (Util::checkpermission('proveedor-edit')) {
            $this->permiso_actualizar = '';
        } else {
            $this->permiso_actualizar = 'd-none';
        }

        if (Util::checkpermission('proveedor-delete')) {
            $this->permiso_eliminar = '';
        } else {
            $this->permiso_eliminar = 'd-none';
        }

        if (Util::checkpermission('proveedor-list')) {
            $this->permiso_listar = '';
        } else {
            $this->permiso_listar = 'd-none';
        }
    }

    /* PERMISOS */




    public function mount()
    {

        $this->verificarPermisos();
        $this->empresas_id =  User::find(Auth::user()->id)->empresas_id;
        //VERIFICAMOS SI TIENE PERMISOS

        if (!Util::tienePermiso(Util::$OPCION_PROVEEDOR)) {
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
        return view('livewire.proveedor.principal', ['data' => $this->modelarDatos()]);
    }

    /**
     * Modelas los datos de la base de datos
     *
     * @return void
     */
    public function modelarDatos()
    {

        $data = Proveedor::search($this->search, $this->filtrarPorEstado, $this->empresas_id)->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')->simplePaginate($this->perPage);

        return $data;
    }




    public function cambiarFiltrarPorEstado($estado)
    {
        $this->selectedProveedores = [];
        $this->estaActivadoEliminar = 'disabled';
        $this->estaActivadorInactivo = 'disabled';
        $this->estaActivadorActivo = 'disabled';
        $this->filtrarPorEstado = $estado;
    }


    public function cambiarEstadoBotones()
    {

        if (count($this->selectedProveedores) > 0) {
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
        $this->selectedProveedores = [];
    }




    /**
     * crear un nuevo proveedor
     *
     * @return void
     */
    public function crear()
    {
        try {
            $this->emit('crear');
        } catch (\Exception $e) {
        }
    }

    public function editar($id)
    {
        try {
            $this->emit('editar', $id);
        } catch (\Exception $e) {
        }
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
            foreach ($this->selectedProveedores as $item) {
                $eliminar = true;
                $data = SolicitudCotizacion::where('proveedors_id', '=', $item)->count();
                if ($data > 0) {
                    $eliminar = false;
                }
                $data = OrdenDeCompra::where('proveedors_id', '=', $item)->count();
                if ($data > 0) {
                    $eliminar = false;
                }

                if ($eliminar == true) {
                    $selectEliminar[] = $item;
                } else {
                    Util::geterrordefine($this, "El Proveedor se encuentra en uso en otros recursos");
                }
            }


            if (count($selectEliminar) > 0) {
                Proveedor::destroy($selectEliminar);
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


    public function inactivarProveedores()
    {


        DB::beginTransaction(); //Iniciamos la reansaccion
        try {

            $response = null;
            foreach ($this->selectedProveedores as $p) {
                $proveedor = Proveedor::findOrFail($p);
                if ($proveedor->estado == 1) {
                    $proveedor->estado = 0;
                    $response = $proveedor->update();
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

    public function activarProveedores()
    {

        DB::beginTransaction(); //Iniciamos la reansaccion
        try {

            $response = null;
            foreach ($this->selectedProveedores as $p) {
                $proveedor = Proveedor::findOrFail($p);
                if ($proveedor->estado == 0) {
                    $proveedor->estado = 1;
                    $response = $proveedor->update();

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
