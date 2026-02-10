<?php

namespace App\Http\Livewire\ListaProductos;

use App\Models\ArticuloOrdenCompra;
use App\Models\ArticuloRequerimientoPersonal;
use App\Models\Ingreso;
use App\Models\OrdenDeCompra;
use App\Models\RequerimientoPersonal;
use App\Models\Util;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;


class Principal extends Component
{
    // DEFINIDORES DE CAMPOS 

    use WithPagination;
    public $search = '';
    public $perPage = 10;
    public $sortField = 'numero_orden_compra';
    public $sortAsc = false;

    public $selectedItemsTable = [];
    public $estaActivadoEliminar = 'disabled';
    public $estaActivadorInactivo = 'disabled';
    public $estaActivadorActivo = 'disabled';
    public $filtrarPorEstado = "";
    protected $listeners = ['refreshParent' => '$refresh'];

    public $sucursal_empresas_id_seleccionado = '';

    // DEFINIDORES DE CAMPOS 

    // DEFINIDORES DE CAMPOS 

    public function mount()
    {
        if (!Util::getExisteTiendaSeleccionadaLocalStorage()) {
            return redirect()->route('dashboard');
        } else {
            $numero = Util::getSucursalEmpresaIdLocalStorage();
            if ($numero != -10) {
                $this->sucursal_empresas_id_seleccionado = $numero;
            } else {
                return redirect()->route('dashboard');
            }
        }
        //VERIFICAMOS SI TIENE PERMISOS

        if (!Util::tienePermiso(Util::$OPCION_ORDEN_COMPRA)) {
            return redirect()->route('dashboard');
        }
    }

    public function render()
    {
        return view('livewire.lista-productos.principal', ['data' => $this->modelarDatos()]);
    }

    // CAMPOS INICIALIZADORES 
    public function modelarDatos()
    {

        $data = OrdenDeCompra::search($this->search, $this->filtrarPorEstado, $this->sucursal_empresas_id_seleccionado)->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')->simplePaginate($this->perPage);


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


    public function resetearValores()
    {
        $this->estaActivadoEliminar = 'disabled';
        $this->estaActivadorInactivo = 'disabled';
        $this->estaActivadorActivo = 'disabled';
        $this->selectedItemsTable = [];
    }

    // CAMPOS INICIALIZADORES 



    // OTROS COMPONENTES 



    public function crear()
    {
        try {

            $this->emit('crear_RP');
        } catch (\Exception $e) {
        }
    }

    public function editar_RP($id)
    {

        try {
            $this->emit('editar_RP', $id);
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


            $existe = false;
            foreach ($this->selectedItemsTable as $d) {
                $data = Ingreso::where('orden_de_compras_id', '=', $d)->count();

                if ($data > 0) {
                    $existe = true;
                }
            }
           

            if ($existe == true) {
                Util::geterrordefine($this, "La orden de compra ya se encuentra en uso en ingresos");
            } else {
                OrdenDeCompra::destroy($this->selectedItemsTable);
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



    // OTROS COMPONENTES 








}
