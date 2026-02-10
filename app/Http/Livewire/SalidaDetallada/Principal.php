<?php

namespace App\Http\Livewire\SalidaDetallada;

use App\Models\Articulo;
use App\Models\ArticuloOrdenCompra;
use App\Models\ArticuloRequerimientoPersonal;
use App\Models\OrdenDeCompra;
use App\Models\Util;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Principal extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 1000;
    public $orden_compras_id;
    public $fecha_imrpimir;

    public $rango_inicio, $rango_fin;
    public $sortField = 'id';
    public $sortAsc = true;
    public $selectedTipoUnidades = [];
    public $estaActivadoEliminar = 'disabled';
    public $estaActivadorInactivo = 'disabled';
    public $estaActivadorActivo = 'disabled';
    public $filtrarPorEstado = "";
    protected $listeners = ['refreshParent' => '$refresh', 'selectedOrdenCompraItem'];

    public $tiendas_id_seleccionado = '';


    public $almacenamientoNombreSinEliminar = [];
    public $almacenamientoNombreElimados = [];
    public $sucursal_empresas_id_seleccionado;

    /* PERMISOS */

    public $permiso_agregar = '';
    public $permiso_eliminar = '';
    public $permiso_actualizar = '';
    public $permiso_listar = '';


    public function mount()
    {

        $this->sucursal_empresas_id_seleccionado = Util::getSucursalEmpresaIdLocalStorage();
        $fecha_actual = Carbon::now();
        $this->rango_fin = $fecha_actual->format('Y-m-d');
        $this->rango_inicio = $fecha_actual->subDays(1)->format('Y-m-d');
    }



    public function render()
    {
        return view('livewire.salida-detallada.principal', ['data' => $this->modelarDatos(), 'ordenCompra' => $this->modelarOrdenRequerimiento(),'fechas_salidas'=>$this->modelarFechaArticuloOrdenCompra()]);
    }


    /**
     * Modelas los datos de la base de datos
     *
     * @return void
     */
    public function modelarDatos()
    {
        $articulos = ArticuloOrdenCompra::search($this->search, $this->sucursal_empresas_id_seleccionado)->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')->simplePaginate($this->perPage);
        return $articulos;
    }

    public function modelarFechaArticuloOrdenCompra()
    {
        $data = ArticuloOrdenCompra::select('fecha_salida')
            ->where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)
            ->where('fecha_salida', '!=', null)
            ->groupBy('fecha_salida')
            ->orderBy('fecha_salida', 'asc')
            ->get();

        $arreglo_fecha = [];

        foreach ($data as $item) {
            $fecha = Util::darFormatoFecha($item->fecha_salida);
            $arreglo_fecha[] = $fecha;
        }


        $arreglo_fecha = array_unique($arreglo_fecha);


        return $arreglo_fecha;
    }



    public function modelarOrdenRequerimiento()
    {

        return OrdenDeCompra::where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)->get();
    }


    public function hydrate()
    {
        $this->emit('select2OrdenCompra');
    }


    public function selectedOrdenCompraItem($item)
    {
        if ($item) {
            $this->orden_compras_id = $item;
        }
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
        /*   try { */
        DB::beginTransaction();
        $this->almacenamientoNombreElimados = [];
        $this->almacenamientoNombreSinEliminar = [];
        $selccionadoParaEliminar = [];
        //verificamos si estan relacionados los datos
        foreach ($this->selectedTipoUnidades as $s) {
            $habitacion = ArticuloRequerimientoPersonal::where('articulos_id', '=', $s)->get();
            if (count($habitacion) > 0) {
                foreach ($habitacion as $ha) {
                    $nombre = $ha->articulo->articulo;
                    if (count($this->almacenamientoNombreSinEliminar) > 0) {
                        foreach ($this->almacenamientoNombreSinEliminar as $alma) {
                            if ($nombre != $alma) {
                                $this->almacenamientoNombreSinEliminar[] =  $nombre;
                            }
                        }
                    } else {
                        $this->almacenamientoNombreSinEliminar[] =  $nombre;
                    }
                }
            } else {
                $data = Articulo::find($s);
                $nombre = $data->articulo;
                if (count($this->almacenamientoNombreElimados) > 0) {
                    foreach ($this->almacenamientoNombreElimados as $alma) {
                        if ($nombre != $alma) {
                            $this->almacenamientoNombreElimados[] =  $nombre;
                        }
                    }
                } else {
                    $this->almacenamientoNombreElimados[] =  $nombre;
                }
                $selccionadoParaEliminar[] = $s;
            }
        }

        $this->almacenamientoNombreElimados = array_unique($this->almacenamientoNombreElimados);
        $this->almacenamientoNombreSinEliminar = array_unique($this->almacenamientoNombreSinEliminar);



        if (count($selccionadoParaEliminar) > 0) {
            Articulo::destroy($selccionadoParaEliminar);
        }

        $this->dispatchBrowserEvent('closeDeleteModal');
        $this->dispatchBrowserEvent('openErrorModal');

        $this->resetearValores();
        DB::commit();
        /*  } catch (\Throwable $th) {
            dd($th);
            DB::rollback();
            $this->dispatchBrowserEvent('closeDeleteModal');

            Util::geterrorSistem($this);
        } */
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
                $categoriaProducto = Articulo::findOrFail($p);

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
                $categoriaProducto = Articulo::findOrFail($p);
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
