<?php

namespace App\Http\Livewire\Articulo;

use App\Models\Articulo;
use App\Models\ArticuloRequerimientoPersonal;
use App\Models\TipoUnidad;
use App\Models\Util;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class Principal extends Component
{

    // DEFINIDORES DE CAMPOS 
    use WithPagination;

    use WithFileUploads;

    public $archivo;

    protected $rules = [
        'archivo' => 'required|mimes:xlsx,xls'
    ];



    public $search = '';
    public $perPage = 10;
    public $sortField = 'codigo';
    public $sortAsc = false, $empresas_id;
    public $selectedItems = [];
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
        return view('livewire.articulo.principal', ['data' => $this->modelarDatos()]);
    }



    // CAMPOS INICIALIZADORES 

    public function modelarDatos()
    {

        $data = Articulo::search($this->search, $this->filtrarPorEstado, $this->empresas_id)->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')->simplePaginate($this->perPage);

        return $data;
    }

    public function mount()
    {
        $this->empresas_id = Util::getEmpresasIngresada();
        //VERIFICAMOS SI TIENE PERMISOS

        if (!Util::tienePermiso(Util::$OPCION_ARTICULO)) {
            return redirect()->route('dashboard');
        }

        //ver empresas

        $data = Util::tienePermisoUsuario('Empresas');
        $estado = $data['estado'];

        if ($estado == false) {
            return redirect()->route('facturacion');
        }
    }

    // CAMPOS INICIALIZADORES 



    // OTROS COMPONENTES 


    public function cambiarFiltrarPorEstado($estado)
    {
        $this->selectedItems = [];
        $this->estaActivadoEliminar = 'disabled';
        $this->estaActivadorInactivo = 'disabled';
        $this->estaActivadorActivo = 'disabled';
        $this->filtrarPorEstado = $estado;
    }


    public function cambiarEstadoBotones()
    {

        if (count($this->selectedItems) > 0) {
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
        $this->selectedItems = [];
    }


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
        try {
            DB::beginTransaction();
            $selectEliminar = [];

            //verificamos si estan relacionados los datos
            foreach ($this->selectedItems as $s) {
                $eliminar = true;

                $data = ArticuloRequerimientoPersonal::where('articulos_id', '=', $s)->count();
                if ($data > 0) {
                    $eliminar = false;
                }

                if ($eliminar == true) {
                    $selectEliminar[] = $s;
                } else {
                    Util::geterrordefine($this, "El Artículo se encuentra en uso en otros recursos");
                }
            }

            if (count($selectEliminar) > 0) {
                Articulo::destroy($selectEliminar);
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
            foreach ($this->selectedItems as $p) {
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

    public function activarItems()
    {

        DB::beginTransaction(); //Iniciamos la reansaccion
        try {


            $response = null;
            foreach ($this->selectedItems as $p) {
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


    /* dATOS PARA EL PRODUCTO */
    public $codigo;
    public    $descripcion;
    public    $tipo_unidads_id;
    /* dATOS PARA EL PRODUCTO */
    public function importarExcel()
    {

        $this->validate();

        $data = Excel::toArray([], $this->archivo);

        foreach ($data[0] as $fila) {

            $this->codigo = $fila[1];
            $this->descripcion = $fila[2];
            $tipoUnidad = $fila[3];
            $tipoUnidad =  $tipoUnidad
                ? mb_strtoupper($tipoUnidad, 'UTF-8')
                : 28;

            $articuloExiste = Articulo::where('codigo', '=', $this->codigo)->first();

            //buscamos tipo unidad
            $tipoUnidadModel = TipoUnidad::where('nombre', '=',  mb_strtoupper($tipoUnidad, 'UTF-8'))->first();

            if ($tipoUnidadModel) {
                $this->tipo_unidads_id = $tipoUnidadModel->id;
            } else {
                $dataTipoUnidad = [
                    'nombre' => $tipoUnidad,
                    'empresas_id' => $this->empresas_id,
                    'users_id' => Auth::user()->id,
                    'estado' => 1,
                ];
                $modelTipoUnidad = TipoUnidad::create($dataTipoUnidad);

                $this->tipo_unidads_id = $modelTipoUnidad->id;
            }

            $auxiliarData = [
                'codigo' => $this->codigo,
                'articulo' => $this->descripcion,
                'tipo_unidads_id' => $this->tipo_unidads_id,
                'estado' =>  1,
                'users_id' => Auth::user()->id,
                'empresas_id' => $this->empresas_id,

            ];

            if ($articuloExiste == null) {
                Articulo::create($auxiliarData);
            } else {
                Articulo::find($articuloExiste->id)->update($auxiliarData);
            }
        }
        Util::getsuccesscreate($this);
    }
}
