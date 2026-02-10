<?php

namespace App\Http\Livewire\TipoPersonal;


use App\Models\Articulo;
use App\Models\ArticuloRequerimientoPersonal;
use App\Models\Personal;
use App\Models\TipoPersonal;
use App\Models\User;
use App\Models\Util;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use RealRashid\SweetAlert\Facades\Alert;

use Illuminate\Support\Facades\DB;


class Principal extends Component
{
    // DEFINIDORES DE CAMPOS 
    use WithPagination;
    public $search = '', $sucursal_empresas_id_seleccionado;
    public $perPage = 10;
    public $sortField = 'nombre';
    public $sortAsc = true;
    public $selectedItemsTable = [];
    public $estaActivadoEliminar = 'disabled';
    public $estaActivadorInactivo = 'disabled';
    public $estaActivadorActivo = 'disabled';
    public $filtrarPorEstado = "";

    protected $listeners = ['refreshParent' => '$refresh'];

    public $almacenamientoNombreSinEliminar = [];
    public $almacenamientoNombreElimados = [];
    // DEFINIDORES DE CAMPOS 
    public function render()
    {
        return view('livewire.tipo-personal.principal', ['data' => $this->modelarDatos()]);
    }




    // CAMPOS INICIALIZADORES 
    public function mount()
    {
        $this->sucursal_empresas_id_seleccionado = Util::getSucursalEmpresaIdLocalStorage();
        //VERIFICAMOS SI TIENE PERMISOS

        if (!Util::tienePermiso(Util::$OPCION_TIPO_PERSONAL)) {
            return redirect()->route('dashboard');
        }
    }
    public function modelarDatos()
    {

        $data = TipoPersonal::search($this->search, $this->filtrarPorEstado, $this->sucursal_empresas_id_seleccionado)->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')->simplePaginate($this->perPage);

        return $data;
    }

    public function cambiarFiltrarPorEstado($estado)
    {
        $this->selectedItemsTable = [];
        $this->estaActivadoEliminar = 'disabled';
        $this->estaActivadorInactivo = 'disabled';
        $this->estaActivadorActivo = 'disabled';
        $this->filtrarPorEstado = $estado;
    }


    public function cambiarEstadoBotones()
    {

        if (count($this->selectedItemsTable) > 0) {
            $this->estaActivadoEliminar = 'enabled';
            $this->estaActivadorInactivo = 'enabled';
            $this->estaActivadorActivo = 'enabled';
        } else {
            $this->estaActivadoEliminar = 'disabled';
            $this->estaActivadorInactivo = 'disabled';
            $this->estaActivadorActivo = 'disabled';
        }
    }
    // CAMPOS INICIALIZADORES 



    // OTROS COMPONENTES 
    public function crear()
    {

        $this->emit('crear');
    }

    public function editar($id)
    {
        $this->emit('editar', $id);
    }

    public function resetearValores()
    {
        $this->estaActivadoEliminar = 'disabled';
        $this->estaActivadorInactivo = 'disabled';
        $this->estaActivadorActivo = 'disabled';
        $this->selectedItemsTable = [];
    }


    public function eliminar()
    {
        $this->dispatchBrowserEvent('openDeleteModal');
    }

    public function destruir()
    {
        try {
            DB::beginTransaction();
            $selectEliminar = [];

            //verificamos si estan relacionados los datos
            foreach ($this->selectedItemsTable as $s) {
                $eliminar = true;
                $data = Personal::where('tipoPersonals_Id', '=', $s)->count();
                if ($data > 0) {
                    $eliminar = false;
                }

                if ($eliminar == true) {
                    $selectEliminar[] = $s;
                } else {
                    Util::geterrordefine($this, "El Tipo Personal se encuentra en uso en otros recursos");
                }
            }


            if (count($selectEliminar) > 0) {
                TipoPersonal::destroy($selectEliminar);
                Util::getsuccessdelete($this);
            }
            $this->resetearValores();
            $this->dispatchBrowserEvent('closeDeleteModal');

            DB::commit();
        } catch (\Throwable $th) {

            DB::rollback();
            $this->dispatchBrowserEvent('closeDeleteModal');

            Util::geterrorSistem($this);
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


    public function inactivarItems()
    {

        DB::beginTransaction(); //Iniciamos la reansaccion
        try {
            $response = null;
            foreach ($this->selectedItemsTable as $p) {
                $categoriaProducto = TipoPersonal::findOrFail($p);

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

            Util::getsuccessupdate($this);

            DB::commit();
        } catch (\Exception $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        } catch (\Throwable $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        }
    }

    public function activarItems()
    {

        DB::beginTransaction(); //Iniciamos la reansaccion
        try {
            $response = null;
            foreach ($this->selectedItemsTable as $p) {
                $categoriaProducto = TipoPersonal::findOrFail($p);
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

            Util::getsuccessupdate($this);


            DB::commit();
        } catch (\Exception $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        } catch (\Throwable $e) {
            Util::geterrorSistem($this);
            DB::rollback();
        }
    }


    // OTROS COMPONENTES 

}
