<?php

namespace App\Http\Livewire\OrdenCompra;

use App\Models\ArticuloOrdenCompra;
use App\Models\ArticuloRequerimientoPersonal;
use App\Models\ArticuloSolicitudCotizacion;
use App\Models\Ingreso;
use App\Models\OrdenDeCompra;
use App\Models\RequerimientoPersonal;
use App\Models\SolicitudCotizacion;
use App\Models\Util;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;


use Illuminate\Support\Facades\DB;

class Principal extends Component
{
    // DEFINIDORES DE CAMPOS 

    use WithPagination;
    public $fecha_inicio = null, $fecha_fin = null;

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
        $this->fecha_inicio = Carbon::now()->subDays(30)->format('Y-m-d');
        $this->fecha_fin = Carbon::now()->format('Y-m-d');

        //VERIFICAMOS SI TIENE PERMISOS

        if (!Util::tienePermiso(Util::$OPCION_ORDEN_COMPRA)) {
            return redirect()->route('dashboard');
        }
    }

    public function render()
    {
        return view('livewire.orden-compra.principal', ['data' => $this->modelarDatos()]);
    }

    // CAMPOS INICIALIZADORES 
    public function modelarDatos()
    {

        $datas = OrdenDeCompra::search($this->search, $this->filtrarPorEstado, $this->sucursal_empresas_id_seleccionado)->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')->simplePaginate($this->perPage);

        $carbonFechaInicio = Carbon::parse($this->fecha_inicio);
        $carbonFechaFin = Carbon::parse($this->fecha_fin);

        foreach ($datas as $indez => $item) {
            $auxFechaItem = Carbon::parse($item->fecha_pedido);

            /*  if ($auxFechaItem->greaterThanOrEqualTo($carbonFechaInicio) && $auxFechaItem->lessThanOrEqualTo($carbonFechaFin)) {
            } else {
                unset($datas[$indez]);
            } */

            if ($auxFechaItem->between($carbonFechaInicio->startOfDay(), $carbonFechaFin->endOfDay())) {
            } else {
                unset($datas[$indez]);
            }
        }



        return $datas;
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

                //actualizamos ahora el requerimiento de personal

                foreach ($this->selectedItemsTable as $item) {
                    $data = SolicitudCotizacion::where('orden_de_compras_id', '=', $item)->get();
                    foreach ($data as $aux) {
                        $aux->estado = 1;
                        $aux->orden_de_compras_id = "";
                        $aux->update();
                    }


                    //volvemos a estado normal articulo
                    $aux = ArticuloSolicitudCotizacion::where('orden_de_compras_id', '=', $item)->get();
                    foreach ($aux as $a) {
                        $a->orden_de_compras_id = "";
                        $a->estado = "1";
                        $a->update();
                    }

                    //volvemos a estado normal articulo orden de compra
                    $aux = ArticuloOrdenCompra::where('orden_de_compras_id', '=', $item)->get();
                    foreach ($aux as $a) {
                        $a->delete();
                    }
                }

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
