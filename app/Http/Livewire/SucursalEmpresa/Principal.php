<?php

namespace App\Http\Livewire\SucursalEmpresa;

use App\Models\PermisoUsuario;
use App\Models\SucursalEmpresa;
use App\Models\TipoUnidad;
use App\Models\Util;
use Database\Seeders\UsuarioSeeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Livewire\Component;
use Livewire\WithPagination;
use RealRashid\SweetAlert\Facades\Alert;

use Illuminate\Support\Facades\DB;

class Principal extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 10;
    public $sortField = 'id';
    public $sortAsc = true, $modeloId;
    public $selectedTipoUnidades = [];
    public $estaActivadoEliminar = 'disabled';
    public $estaActivadorInactivo = 'disabled';
    public $estaActivadorActivo = 'disabled';
    public $filtrarPorEstado = "";
    protected $listeners = ['refreshParent' => '$refresh'];

    public $empresas_id_seleccionao = '';

    /* PERMISOS */

    public $permiso_agregar = 'd-none';
    public $permiso_eliminar = 'd-none';
    public $permiso_actualizar = 'd-none';
    public $permiso_listar = 'd-none';



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

    /* PERMISOS */

    public function mount($empresa_id)
    {



        $this->empresas_id_seleccionao = $empresa_id;

        Util::putTiendaIdLocalStorage($this->empresas_id_seleccionao);

        $this->verificarPermisos();
    }


    public function render()
    {
        return view('livewire.sucursal-empresa.principal', ['data' => $this->modelarDatos()]);
    }

    /**
     * Modelas los datos de la base de datos
     *
     * @return void
     */
    public function modelarDatos()
    {

        $data = SucursalEmpresa::search($this->search, $this->filtrarPorEstado, $this->empresas_id_seleccionao)->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')->simplePaginate($this->perPage);

        if (Util::esUsuario() == false) {

            $auxiliar = PermisoUsuario::where('empresas_id', '=', Util::getEmpresasIngresada())->where('origen', '=', 'sucursal')->where('personals_id', '=', Auth::id())->orderBy('id', 'asc')->get();

            foreach ($data as $index => $aux) {

                $estado = false;

                foreach ($auxiliar as  $item) {

                    if ($item->tipo_permiso == $aux->id) {
                        $estado = true;
                    }
                }

                if ($estado == false) {
                    unset($data[$index]);
                }
            }

            foreach ($data as $index => $aux) {

                $estado = false;
                if ($aux->estado == 0) {
                    unset($data[$index]);
                }
            }
        }


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
    public function eliminar($id)
    {
        $this->modeloId = $id;
        $this->dispatchBrowserEvent('openDeleteModal');
    }




    public function destruir()
    {

        DB::beginTransaction(); //Iniciamos la reansaccion
        try {

            SucursalEmpresa::destroy($this->modeloId);

            $this->dispatchBrowserEvent('closeDeleteModal');

            DB::commit();
            Util::getsuccessdelete($this);
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


    public function inactivarTipoUnidades()
    {

        DB::beginTransaction(); //Iniciamos la reansaccion
        try {

            $response = null;
            foreach ($this->selectedTipoUnidades as $p) {
                $categoriaProducto = SucursalEmpresa::findOrFail($p);

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

    public function activarTipoUnidades()
    {
        DB::beginTransaction(); //Iniciamos la reansaccion
        try {


            $response = null;
            foreach ($this->selectedTipoUnidades as $p) {
                $categoriaProducto = SucursalEmpresa::findOrFail($p);
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

    public function administrarSucural($id)
    {
        Util::putSucursarEmpresaLocalStorage($id);
        return redirect()->route('informacion');
    }
}
