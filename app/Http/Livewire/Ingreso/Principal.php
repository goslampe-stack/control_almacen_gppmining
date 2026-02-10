<?php

namespace App\Http\Livewire\Ingreso;

use App\Models\ArticuloOrdenCompra;
use App\Models\ArticuloRequerimientoPersonal;
use App\Models\Ingreso;
use App\Models\OrdenDeCompra;
use App\Models\RequerimientoPersonal;
use App\Models\Util;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;


class Principal extends Component
{
    use WithPagination;
    public $fecha_inicio = null, $fecha_fin = null;


    public $search = '';
    public $perPage = 3500;
    public $sortField = 'numero_ingreso';
    public $sortAsc = false;
    public $fecha_imrpimir;
    public $selectedItemTabla = [];
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
        if (Util::checkpermission('ingreso-create')) {
            $this->permiso_agregar = '';
        } else {
            $this->permiso_agregar = 'd-none';
        }

        if (Util::checkpermission('ingreso-edit')) {
            $this->permiso_actualizar = '';
        } else {
            $this->permiso_actualizar = 'd-none';
        }

        if (Util::checkpermission('ingreso-delete')) {
            $this->permiso_eliminar = '';
        } else {
            $this->permiso_eliminar = 'd-none';
        }

        if (Util::checkpermission('ingreso-list')) {
            $this->permiso_listar = '';
        } else {
            $this->permiso_listar = 'd-none';
        }
    }

    /* PERMISOS */



    public function mount()
    {
      

        if (!Util::getExisteTiendaSeleccionadaLocalStorage()) {
            return redirect()->route('dashboard');
        } else {
            $numero = Util::getSucursalEmpresaIdLocalStorage();
            if ($numero != -10) {
                $this->sucursal_empresas_id_seleccionado = $numero;
                $this->verificarPermisos();
            } else {
                return redirect()->route('dashboard');
            }
        }

        $this->fecha_inicio = Carbon::now()->subDays(30)->format('Y-m-d');
        $this->fecha_fin = Carbon::now()->format('Y-m-d');

          //VERIFICAMOS SI TIENE PERMISOS

          if (!Util::tienePermiso(Util::$OPCION_INGRESO)) {
            return redirect()->route('dashboard');
        }
    }
    public function render()
    {
        return view('livewire.ingreso.principal', ['data' => $this->modelarDatos(), 'fecha_ingresos' => $this->modelarFechaArticuloOrdenCompra()]);
    }

    public function modelarFechaArticuloOrdenCompra()
    {
        $data = ArticuloOrdenCompra::select('fecha_ingreso')
            ->where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)
            ->where('fecha_ingreso', '!=', null)
            ->groupBy('fecha_ingreso')
            ->orderBy('fecha_ingreso', 'asc')
            ->get();

        $arreglo_fecha = [];

        foreach ($data as $item) {
            $fecha = Util::darFormatoFecha($item->fecha_ingreso);
            $arreglo_fecha[] = $fecha;
        }

     
        $arreglo_fecha = array_unique($arreglo_fecha);
      

        return $arreglo_fecha;
    }

    /**
     * Modelas los datos de la base de datos
     *
     * @return void
     */
    public function modelarDatos()
    {

        $datas = Ingreso::search($this->search, $this->filtrarPorEstado, $this->sucursal_empresas_id_seleccionado)->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')->simplePaginate($this->perPage);
        $carbonFechaInicio = Carbon::parse($this->fecha_inicio);
        $carbonFechaFin = Carbon::parse($this->fecha_fin);

        foreach ($datas as $indez => $item) {
            $auxFechaItem = Carbon::parse($item->fecha_ingreso);
            if ($auxFechaItem->greaterThanOrEqualTo($carbonFechaInicio) && $auxFechaItem->lessThanOrEqualTo($carbonFechaFin)) {
            } else {
                unset($datas[$indez]);
            }
        }



        return $datas;
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

            foreach ($this->selectedItemTabla as $s) {

                $ingreso = Ingreso::find($s);

                if ($ingreso) {

                    $data = OrdenDeCompra::find($ingreso->orden_de_compras_id);

                    if ($data) {

                        $data->estado = 1;
                        $data->ingresos_id = null;
                        //significa que ya esta agregado a un orden de pago el requerimiento
                        $data->update();

                        $dataRequerimeinto = ArticuloRequerimientoPersonal::where('requerimiento_p_id', '=', $data->requerimiento_personals_id)->get();

                        foreach ($dataRequerimeinto as $d) {
                            $data = ArticuloRequerimientoPersonal::find($d->id);
                            $data->fecha_ingreso = null;
                            $data->estado = 2;
                            $data->update();
                        }
                    }
                }
            }
            Ingreso::destroy($this->selectedItemTabla);

            $this->resetearValores();
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


    public function inactivarOrdenCompras()
    {


        DB::beginTransaction(); //Iniciamos la reansaccion
        try {

            $response = null;
            foreach ($this->selectedItemTabla as $p) {
                $categoriaProducto = Ingreso::findOrFail($p);

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

    public function activarOrdenCompras()
    {
        DB::beginTransaction(); //Iniciamos la reansaccion
        try {

            $response = null;
            foreach ($this->selectedItemTabla as $p) {
                $categoriaProducto = Ingreso::findOrFail($p);
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
