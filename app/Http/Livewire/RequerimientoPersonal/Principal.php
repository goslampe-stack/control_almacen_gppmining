<?php

namespace App\Http\Livewire\RequerimientoPersonal;

use App\Models\ArticuloRequerimientoPersonal;
use App\Models\Ingreso;
use App\Models\OrdenDeCompra;
use App\Models\RequerimientoCompra;
use App\Models\RequerimientoPersonal;
use App\Models\SalidaDetalle;
use App\Models\Util;
use Carbon\Carbon;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;


class Principal extends Component
{

    // DEFINIDORES DE CAMPOS 

    // DEFINIDORES DE CAMPOS 


    use WithPagination;
    public $fecha_inicio = null, $fecha_fin = null;


    public $search = '';
    public $perPage = 10;
    public $sortField = 'numero_requerimiento';
    public $sortAsc = false;
    public $selectedItems = [];
    public $estaActivadoEliminar = 'disabled';
    public $estaActivadorInactivo = 'disabled';
    public $estaActivadorActivo = 'disabled';
    public $filtrarPorEstado = "";
    protected $listeners = ['refreshParent' => '$refresh'];

    public $sucursal_empresas_id_seleccionado = '';


    public $almacenamientoNombreSinEliminar = [];
    public $almacenamientoNombreElimados = [];
    /* PERMISOS */


    // CAMPOS INICIALIZADORES 
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

        if (!Util::tienePermiso(Util::$OPCION_REQUERIMIENTO_PERSONAL)) {
            return redirect()->route('dashboard');
        }
    }
    // CAMPOS INICIALIZADORES 

    public function render()
    {
        return view('livewire.requerimiento-personal.principal', ['data' => $this->modelarDatos()]);
    }




    // OTROS COMPONENTES 
    public function modelarDatos()
    {
        $datas = RequerimientoPersonal::search($this->search, $this->filtrarPorEstado, $this->sucursal_empresas_id_seleccionado)->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')->simplePaginate($this->perPage);


        $carbonFechaInicio = Carbon::parse($this->fecha_inicio);
        $carbonFechaFin = Carbon::parse($this->fecha_fin);

        foreach ($datas as $indez => $item) {
            $auxFechaItem = Carbon::parse($item->fecha_pedido);
           /*  if ($auxFechaItem->greaterThanOrEqualTo($carbonFechaInicio) && $auxFechaItem->lessThanOrEqualTo($carbonFechaFin)) {
            } else {
                unset($datas[$indez]);
            } */

                if ($auxFechaItem->between($carbonFechaInicio->startOfDay(),$carbonFechaFin->endOfDay())) {
            } else {                
                unset($datas[$indez]);
            }
        }




        return $datas;
    }

    public function cambiarFiltrarPorEstado($estado)
    {
        $this->selectedItems = [];
        $this->estaActivadoEliminar = 'disabled';
        $this->filtrarPorEstado = $estado;
    }


    public function cambiarEstadoBotones()
    {

        if (count($this->selectedItems) > 0) {
            $this->estaActivadoEliminar = 'enabled';
        } else {
            $this->estaActivadoEliminar = 'disabled';
        }
    }


    public function resetearValores()
    {
        $this->estaActivadoEliminar = 'disabled';
        $this->selectedItems = [];
    }



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
            foreach ($this->selectedItems as $d) {
                $data = RequerimientoCompra::where('requerimiento_personals_id', '=', $d)->count();

                if ($data > 0) {
                    $existe = true;
                }
            }

            if ($existe == true) {
                Util::geterrordefine($this, "El requerimiento ya esta en uso en requerimiento de compras");
            } else {

                //actualizamos ahora el requerimiento de personal

                foreach ($this->selectedItems as $item) {



                    //volvemos a estado normal articulo solicitud de cotizacion
                    $aux = ArticuloRequerimientoPersonal::where('requerimiento_p_id', '=', $item)->get();
                    foreach ($aux as $a) {
                        $a->delete();
                    }
                }


                RequerimientoPersonal::destroy($this->selectedItems);
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
