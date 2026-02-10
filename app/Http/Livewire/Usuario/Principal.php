<?php

namespace App\Http\Livewire\Usuario;

use App\Models\ArticuloDevolucion;
use App\Models\Ingreso;
use App\Models\OrdenDeCompra;
use App\Models\RequerimientoCompra;
use App\Models\RequerimientoPersonal;
use App\Models\Salida;
use App\Models\SolicitudCotizacion;
use App\Models\TipoUnidad;
use App\Models\User;
use App\Models\Util;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;

class Principal extends Component
{
    use WithPagination;
    public $search = '', $cantidad;
    public $perPage = 50;
    public $sortField = 'id';
    public $sortAsc = true, $empresas_id;
    public $selectedTipoUnidades = [];
    public $estaActivadoEliminar = 'disabled';
    public $estaActivadorInactivo = 'disabled';
    public $estaActivadorActivo = 'disabled';
    public $filtrarPorEstado = "";
    protected $listeners = ['refreshParent' => '$refresh'];

    public $tiendas_id_seleccionado = '';

    /* PERMISOS */

    public $permiso_agregar = 'd-none';
    public $permiso_eliminar = 'd-none';
    public $permiso_actualizar = 'd-none';
    public $permiso_listar = 'd-none';



    public function verificarPermisos()
    {

        //ver empresas

        $data = Util::tienePermisoUsuario('Usuarios');
        $estado = $data['estado'];
        $this->cantidad = $data['cantidad'];
        if ($estado == false) {
            return redirect()->route('facturacion');
        }
    }

    /* PERMISOS */



    public function mount()
    {

        $this->verificarPermisos();

        $this->empresas_id = Auth::id();

        //VERIFICAMOS SI TIENE PERMISOS

        if (!Util::tienePermiso(Util::$OPCION_USUARIOS)) {
            return redirect()->route('dashboard');
        }
    }


    public function render()
    {
        return view('livewire.usuario.principal', ['data' => $this->modelarDatos()]);
    }

    /**
     * Modelas los datos de la base de datos
     *
     * @return void
     */
    public function modelarDatos()
    {

        $data = User::search($this->search,$this->filtrarPorEstado,$this->empresas_id)->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')->simplePaginate($this->perPage);

        if ($data->count() < $this->cantidad && Util::esUsuario()) {
            $this->permiso_agregar = "";
        } else {
            $this->permiso_agregar = "d-none";
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
    public function irAPermisos()
    {
        return redirect()->route('permiso-usuario');
    }

    public function cambiarPassword($id)
    {
        try {
            $data = User::find($id);

            $data->password = bcrypt('123456');
            $data->update();

            Util::getsuccessDefine($this, "Se cambio correctamente la contraseña");
        } catch (\Exception $e) {
            Util::geterrorSistem($this);
        } catch (\Throwable $e) {
            Util::geterrorSistem($this);
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

            //verificamos si hay en 

            $selectEliminar = [];

            foreach ($this->selectedTipoUnidades as $item) {
                $eliminar = true;
                $data = RequerimientoPersonal::where('users_id', '=', $item)->count();
                if ($data > 0) {
                    $eliminar = false;
                }

                if ($eliminar) {

                    $data = RequerimientoCompra::where('users_id', '=', $item)->count();
                    if ($data > 0) {
                        $eliminar = false;
                    }
                }

                if ($eliminar) {
                    $data = SolicitudCotizacion::where('users_id', '=', $item)->count();
                    if ($data > 0) {
                        $eliminar = false;
                    }
                }




                if ($eliminar) {
                    $data = OrdenDeCompra::where('users_id', '=', $item)->count();
                    if ($data > 0) {
                        $eliminar = false;
                    }
                }



                if ($eliminar) {
                    $data = Ingreso::where('users_id', '=', $item)->count();
                    if ($data > 0) {
                        $eliminar = false;
                    }
                }




                if ($eliminar) {
                    $data = ArticuloDevolucion::where('users_id', '=', $item)->count();
                    if ($data > 0) {
                        $eliminar = false;
                    }
                }



                if ($eliminar) {
                    $data = Salida::where('users_id', '=', $item)->count();
                    if ($data > 0) {
                        $eliminar = false;
                    }
                }



                if ($eliminar == true) {
                    $selectEliminar[] = $item;
                } else {
                    Util::geterrordefine($this, "El usuario se encuentra en uso en otros recursos");
                }
            }

           

            if(count($selectEliminar)>0){
                User::destroy($selectEliminar);
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


    public function inactivarTipoUnidades()
    {

        DB::beginTransaction(); //Iniciamos la reansaccion
        try {

            $response = null;
            foreach ($this->selectedTipoUnidades as $p) {
                $categoriaProducto = User::findOrFail($p);

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
                $categoriaProducto = User::findOrFail($p);
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
