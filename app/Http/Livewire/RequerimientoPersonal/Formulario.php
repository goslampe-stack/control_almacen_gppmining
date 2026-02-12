<?php

namespace App\Http\Livewire\RequerimientoPersonal;

use App\Models\ArticuloRequerimientoPersonal;
use App\Models\Personal;
use App\Models\RequerimientoPersonal;
use App\Models\Articulo;
use App\Models\ArticuloDevolucion;
use App\Models\ArticuloIngreso;
use App\Models\ArticuloRequerimientoCompra;
use App\Models\ArticuloSolicitudCotizacion;
use App\Models\SalidaDetalle;
use App\Models\Util;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\DB;

use Livewire\WithPagination;

class Formulario extends Component
{
    use WithPagination;
    public $nombre, $codigo, $estado,$listaPersonal, $articulo, $sucursal_empresas_id, $personals_id,$destinatarios_id, $numero_requerimiento, $descripcion, $fecha_pedido, $stock_disnponible_articulo_requerimiento;
    protected $listeners = ['crear_RP', 'editar_RP', 'selectedPersonalItem','selectedDestinarioItem', 'selectedArticuloItem'];
    public $modelId;

    public $estaEnRequerimiento = 'd-none';
    public $estaEnArticulos = 'd-none';

    public $empresa_id_seleccionado = '';

    /* ARTICULO REQUERIMEINTO */
    public $articulos_id,  $cantidad, $modelArticuloRequemientoId;


    public $search = '';
    public $perPage = 5;
    public $sortField = 'id';
    public $sortAsc = true;
    public $selectedArticulosRequerimientoPersonal = [];
    public $estaActivadoEliminar = 'disabled';
    public $estaActivadorInactivo = 'disabled';
    public $estaActivadorActivo = 'disabled';
    public $filtrarPorEstado = "", $empresas_id;

    public function mount()
    {
        $this->empresa_id_seleccionado = Util::getSucursalEmpresaIdLocalStorage();
        $this->empresas_id = Util::getEmpresasIngresada();
        $this->fecha_pedido = Carbon::now()->format('Y-m-d');


    }


    public $estado_opciones = [
        'Activo',
        'Inactivo',
        'Terminado',
    ];

    public function hydrate()
    {
        $this->emit('select2Personal');
        $this->emit('select2Destinartario');
        $this->emit('select2Articulo');
    }

    public function selectedPersonalItem($item)
    {
        if ($item) {
            $this->personals_id = $item;
            $this->emit('change-focus-cantidad');
        }
    }
    public function selectedDestinarioItem($item)
    {
        if ($item) {
            $this->destinatarios_id = $item;
        }
    }

    public function buscarPorCodigo()
    {
        if ($this->codigo) {
            $articulo = Articulo::where('codigo', '=', $this->codigo)->first();

            if ($articulo) {
                $this->articulos_id = $articulo->id;
                $this->emit('change-focus-cantidad');
            } else {
                $this->articulos_id = null;
                Util::getwarningdefine($this, "No se ha podido encontrar el artículo con el codigo");
            }
        }
    }
    public function selectedArticuloItem($item)
    {
        if ($item) {
            $this->articulos_id = $item;
            $articulo = Articulo::find($item);
            $this->codigo = $articulo->codigo;
            $this->getCantidadStock($item);
            $this->emit('change-focus-cantidad');
        }
    }

    public function getCantidadStock($item)
    {



        $this->articulos_id = $item;
        /*  $response = ArticuloRequerimientoPersonal::where('articulos_id', '=', $item)->where('sucursal_empresas_id', '=', $this->sucursal_empresas_id_seleccionado)->get();

 */

        $response = ArticuloSolicitudCotizacion::join('sucursal_empresas', 'articulo_solicitud_cotizacions.sucursal_empresas_id', '=', 'sucursal_empresas.id')
            ->join('articulo_requerimiento_compras', 'articulo_solicitud_cotizacions.articuloCompras_id', '=', 'articulo_requerimiento_compras.id')
            ->join('articulo_requerimiento_personals', 'articulo_requerimiento_compras.articulo_r_personals_id', '=', 'articulo_requerimiento_personals.id')
            ->select('articulo_solicitud_cotizacions.*')
            ->where('sucursal_empresas.empresas_id', '=', Util::getTiendaIdLocalStorage())
            ->where('articulo_requerimiento_personals.articulos_id', '=', $this->articulos_id)
            ->get();


        $cantidad = 0;
        foreach ($response as $row) {
            $orden = ArticuloIngreso::join('articulo_orden_compras', 'articulo_ingresos.articulos_orden_id', '=', 'articulo_orden_compras.id')
                ->select('articulo_ingresos.*')
                ->where('articulo_orden_compras.articulo_s_cotizacion_id', '=', $row->id)
                ->get();
            foreach ($orden as $or) {
                $cantidad = $cantidad + $or->cantidad;
            }
        }


        /* CXontador de devolicones */


        $itemsDevolucion = ArticuloDevolucion::join('sucursal_empresas', 'articulo_devolucions.sucursal_empresas_id', '=', 'sucursal_empresas.id')
            ->select('articulo_devolucions.*')
            ->where('sucursal_empresas.empresas_id', '=', Util::getTiendaIdLocalStorage())
            ->where('articulo_devolucions.articulos_id', '=', $item)
            ->get();

        foreach ($itemsDevolucion as $devolucion) {
            if ($devolucion->tipoDevolucion == "Devolución en salida") {

                $cantidad = $cantidad + $devolucion->cantidad;
            } else {

                $cantidad = $cantidad - $devolucion->cantidad;
            }
        }
        /* CXontador de devolicones */




        if ($response) {
            $contador = 0;

            $data = SalidaDetalle::join('sucursal_empresas', 'salida_detalles.sucursal_empresas_id', '=', 'sucursal_empresas.id')
                ->select('salida_detalles.*')
                ->where('sucursal_empresas.empresas_id', '=', Util::getTiendaIdLocalStorage())
                ->where('salida_detalles.articulos_id', '=', $this->articulos_id)
                ->get();


            foreach ($data as $d) {
                $contador = $contador + $d->cantidad;
            }



            if ($cantidad >= $contador) {
                $this->stock_disnponible_articulo_requerimiento = $cantidad - $contador;
            } else {
                $this->resetearValores_ARP();
            }
        }
    }

    public function cambiarEstaEnRequeremiento()
    {

        $this->estaEnRequerimiento = '';
        $this->estaEnArticulos = 'd-none';
    }
    public function cambiarEstaEnArticulos()
    {

        $this->estaEnArticulos = '';
        $this->estaEnRequerimiento = 'd-none';
    }


    public function render()
    {
        $arreglo =  [
            'personal' => $this->modelarPersonal(),
            'articulos' => $this->modelarArticulos(),
            'articuloRequerimientos' => $this->modelarRequerimientoPersonal()
        ];




        return view('livewire.requerimiento-personal.formulario', $arreglo);
    }

    public function modelarPersonal()
    {
        $data = Personal::where('estado', '=', 1)->where('sucursal_empresas_id', '=', $this->empresa_id_seleccionado)->get();
        return $data;
    }
    public function modelarArticulos()
    {
        $data = Articulo::where('estado', '=', 1)->where('empresas_id', '=', $this->empresas_id)->get();
        return $data;
    }
    public function abrirPersonal()
    {
        return redirect()->route('personal');
    }
    public function modelarRequerimientoPersonal()
    {


        $data = ArticuloRequerimientoPersonal::search($this->search,  $this->modelId)->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')->simplePaginate($this->perPage);
        return $data;
    }

    public function cerrarFormulario()
    {
        /*     $this->emit('refreshParent');
        $this->dispatchBrowserEvent('closeModal');
 */
        return redirect()->route('requerimiento-personal');
    }



    /* DATOS DE REQUERIMIENTO PERSONAL */


    public function obtenerUltimoNumeroRequerimiento_RP()
    {
        $response = RequerimientoPersonal::where('sucursal_empresas_id', '=', $this->empresa_id_seleccionado)->orderby('created_at', 'DESC')->take(1)->first();

        if ($response == null) {
            return 0;
        } else {
            return $response->numero_requerimiento;
        }
    }

    public function crear_RP()
    {

        $this->resetValidation();
        $this->resetVars_RP();
        $this->modelId = null;
        $this->numero_requerimiento =  Util::formarNumeroRequerimiento($this->obtenerUltimoNumeroRequerimiento_RP());
        $this->dispatchBrowserEvent('openModal');
    }


    public function guardar_RP()
    {
        $this->validate([

            'fecha_pedido' => ['required'],
            'estado' => 'required',
        ]);


        DB::beginTransaction(); //Iniciamos la reansaccion
 /*        try { */

            $response = RequerimientoPersonal::create($this->modelData_RP());

            $this->estaEnRequerimiento = 'd-none';
            $this->estaEnArticulos = '';
            $this->modelId = $response->id;


            DB::commit();
            Util::getsuccesscreate($this);
     /*    } catch (\Exception $e) {
            Util::geterrorSistem($this);
            DB::rollback();
        } catch (\Throwable $e) {
            Util::geterrorSistem($this);
            DB::rollback();
        } */
    }



    public function editar_RP($id)
    {
        $this->resetValidation();
        $this->resetVars_RP();
        $this->resetearValores_ARP();
        $this->modelId = $id;
        $this->loadModal_RP();
        $this->dispatchBrowserEvent('openModal');
    }



    public function actualizar_RP()
    {
        $this->validate([
          
            'fecha_pedido' => ['required'],
            'estado' => 'required',
        ]);


        DB::beginTransaction(); //Iniciamos la reansaccion
        /* try { */
            RequerimientoPersonal::find($this->modelId)->update($this->modelData_RP());
            DB::commit();
            Util::getsuccessupdate($this);
       /*  } catch (\Exception $e) {
            Util::geterrorSistem($this);


            DB::rollback();
        } catch (\Throwable $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        } */
    }

    public function modelData_RP()
    {

        return [
            'numero_requerimiento' => $this->numero_requerimiento,
            'fecha_pedido' => $this->fecha_pedido,
            'descripcion' => $this->descripcion,
            'personalpdf' =>json_encode( Util::getPersonalPdf($this->empresa_id_seleccionado,Util::$OPCION_REQUERIMIENTO_PERSONAL)),
            'users_id' => Auth::user()->id,
            'personals_id' => $this->personals_id,
            'destinatarios_id' => $this->destinatarios_id,
            'estado' => $this->getEstadoNumero(),
            'sucursal_empresas_id' => Util::getSucursalEmpresaIdLocalStorage(),
        ];
    }

    public function getEstadoNumero()
    {
        $aux = "1";

        if ($this->estado == 'Activo') {
            $aux = 1;
        } else if ($this->estado == 'Terminado') {

            $aux = 2;
        } else {
            $aux = 0;
        }
        return $aux;
    }
    public function getEstadoLetra($aux)
    {
        $aux = "1";

        if ($aux == '1') {
            $aux = 'Activo';
        } else if ($aux == '2') {

            $aux = 'Terminado';
        } else {
            $aux = '0';
        }

        return $aux;
    }

    public function loadModal_RP()
    {

        $data = RequerimientoPersonal::find($this->modelId);

        $this->nombre = $data->nombre;
        $this->sucursal_empresas_id = $data->sucursal_empresas_id;
        $this->personals_id = $data->personals_id;
        $this->destinatarios_id = $data->destinatarios_id;
        $this->numero_requerimiento = $data->numero_requerimiento;
        $this->descripcion = $data->descripcion;
        $this->fecha_pedido = $data->fecha_pedido;
        $this->estado = $this->getEstadoLetra($data->estado);;
    }


    public function resetVars_RP()
    {
        date_default_timezone_set('America/Lima');


        $this->nombre = null;
        $this->estado = 'Activo';
        $this->sucursal_empresas_id = null;
        $this->personals_id = null;
        $this->destinatarios_id = null;
        $this->numero_requerimiento = null;
        $this->descripcion = "";

        $this->fecha_pedido = Carbon::now()->format('Y-m-d');
        $this->estaEnRequerimiento = '';
        $this->estaEnArticulos = 'd-none';
        $this->modelId = null;
    }


    /* DATOS DE REQUERIMIENTO PERSONAL */




    /* DATOS DE ARTICULO DE REQUERIMEINTO PERSONAL */









    public function resetVars_ARP()
    {

        $this->cantidad = null;
        $this->codigo = null;
        $this->articulos_id = null;
        $this->stock_disnponible_articulo_requerimiento = null;
        $this->modelArticuloRequemientoId = null;
    }


    public function  editar_ARP($id)
    {
        $this->resetValidation();
        $this->resetVars_ARP();
        $this->modelArticuloRequemientoId = $id;

        $this->loadModal_ARP();
    }

    public function actualizar_ARP()
    {
        $this->validate([
            'articulos_id' => ['required'],
            'cantidad' => ['required'],
        ]);



        DB::beginTransaction(); //Iniciamos la reansaccion
        try {


            ArticuloRequerimientoPersonal::find($this->modelArticuloRequemientoId)->update($this->modelData_ARP());
            $this->resetVars_ARP();
            DB::commit();
            Util::getsuccessupdate($this);
            $this->emit('change-focus-codigo');
        } catch (\Exception $e) {
            Util::geterrorSistem($this);
            DB::rollback();
        } catch (\Throwable $e) {
            Util::geterrorSistem($this);
            DB::rollback();
        }
    }


    public function guardar_ARP()
    {
        $this->validate([
            'articulos_id' => ['required'],
            'cantidad' => ['required'],
        ]);



        DB::beginTransaction(); //Iniciamos la reansaccion
        try {


            /* $data = ArticuloRequerimientoPersonal::where('articulos_id', '=', $this->articulos_id)
                ->where('requerimiento_p_id', '=', $this->modelId)
                ->where('sucursal_empresas_id', '=', $this->empresa_id_seleccionado)->first();
 */
            $response = ArticuloRequerimientoPersonal::create($this->modelData_ARP());
            if ($response) {

                $this->resetVars_ARP();
            }
            /*   if ($data == null) {
                $response = ArticuloRequerimientoPersonal::create($this->modelData_ARP());

                if ($response) {

                    $this->resetVars_ARP();
                }
            } else {

                $data->cantidad = $data->cantidad + $this->cantidad;
                $respouesta = $data->update();

                if ($respouesta) {

                    $this->resetVars_ARP();
                }
            } */

            DB::commit();
            Util::getsuccesscreate($this);
            $this->emit('change-focus-codigo');
        } catch (\Exception $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        } catch (\Throwable $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        }
    }


    public function crear_ARP()
    {

        $this->resetVars_ARP();
        $this->emit('change-focus-codigo');
    }

    public function loadModal_ARP()
    {
        $data = ArticuloRequerimientoPersonal::find($this->modelArticuloRequemientoId);
        $this->articulo = $data->articulo;
        $this->cantidad = $data->cantidad;
        $this->articulos_id = $data->articulos_id;
        $dataArticulo = Articulo::find($this->articulos_id);
        $this->codigo = $dataArticulo->codigo;
        $this->emit('change-focus-cantidad');
    }
    public function modelData_ARP()
    {
        return [
            'cantidad' => $this->cantidad,
            'articulos_id' => $this->articulos_id,
            'requerimiento_p_id' => $this->modelId,
            'users_id' => Auth::user()->id,
            'sucursal_empresas_id' => Util::getSucursalEmpresaIdLocalStorage(),
        ];
    }


    public function cambiarEstadoBotones_ARP()
    {

        if (count($this->selectedArticulosRequerimientoPersonal) > 0) {
            $this->estaActivadoEliminar = 'enabled';
            $this->estaActivadorInactivo = 'enabled';
            $this->estaActivadorActivo = 'enabled';
        } else {
            $this->estaActivadoEliminar = 'disabled';
            $this->estaActivadorInactivo = 'disabled';
            $this->estaActivadorActivo = 'disabled';
        }
    }

    public function eliminar_ARP()
    {

        DB::beginTransaction(); //Iniciamos la reansaccion
        try {

            $hayProductos = false;

            foreach ($this->selectedArticulosRequerimientoPersonal as $aux) {

                //buscamos los articulos si estan en uso en requerimiento de compras

                $dataAux = ArticuloRequerimientoCompra::where('articulo_r_personals_id', '=', $aux)->count();

                if ($dataAux > 0) {
                    $hayProductos = true;
                } else {
                    ArticuloRequerimientoPersonal::find($aux)->delete();
                }
            }

            if ($hayProductos == true) {
                Util::geterrordefine($this, "Error al eliminar estan en uso en requerimiento de compras");
            }else{                
                Util::getsuccessdelete($this);
            }

            $this->resetearValores_ARP();
            $this->resetVars_ARP();

            DB::commit();
        } catch (\Exception $e) {
            Util::geterrorSistem($this);
            DB::rollback();
        } catch (\Throwable $e) {
            Util::geterrorSistem($this);
            DB::rollback();
        }
    }

    public function resetearValores_ARP()
    {
        $this->estaActivadoEliminar = 'disabled';
        $this->estaActivadorInactivo = 'disabled';
        $this->estaActivadorActivo = 'disabled';
        $this->selectedArticulosRequerimientoPersonal = [];
    }


    /* DATOS DE ARTICULO DE REQUERIMEINTO PERSONAL */
}
