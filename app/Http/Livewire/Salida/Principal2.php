<?php

namespace App\Http\Livewire\Salida;

use App\Models\ArticuloRequerimientoPersonal;
use App\Models\Ingreso;
use App\Models\OrdenDeCompra;
use App\Models\RequerimientoPersonal;
use App\Models\SalidaDetalle;
use App\Models\Util;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;


class Principal2 extends Component
{

    // DEFINIDORES DE CAMPOS 

    // DEFINIDORES DE CAMPOS 


    use WithPagination;
    public $search = '';
    public $perPage = 10;
    public $sortField = 'numero_requerimiento';
    public $sortAsc = true;
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


    public function render()
    {
        return view('livewire.salida.principal2', ['data' => $this->modelarDatos()]);
    }
}
