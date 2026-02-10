<?php

namespace App\Http\Livewire\Empresa;

use App\Models\Empresa;
use App\Models\PermisoUsuario;
use App\Models\SucursalEmpresa;
use App\Models\User;
use App\Models\Util;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class VerEmpresas extends Component
{
    protected $listeners = ['refreshParent' => '$refresh'];


    /* PERMISOS */

    public $permiso_agregar = 'd-none', $modeloId, $users_id, $puedeCrearEmpresas = "No", $empresas_id, $editar = false, $eliminar = false;

    public $cantidad;



    public function verificarPermisos()
    {
        if (Util::checkpermission('empresa-create')) {
            $this->permiso_agregar = '';
        } else {
            $this->permiso_agregar = 'd-none';
        }

        //ver empresas

        $data = Util::tienePermisoUsuario('Empresas');
        $estado = $data['estado'];
        $this->cantidad = $data['cantidad'];

        if ($estado == false) {
            return redirect()->route('facturacion');
        }
    }

    /* PERMISOS */

    public function mount()
    {
        $data = Auth::user();

        $this->verificarPermisos();
        $data = User::find(Auth::id());
        $data->empresa_seleccionada = null;
        $data->sucursal_empresa_nombre = null;
        $data->update();




        if ($data->tipoUsuario == "Trabajador") {
            $this->users_id = $data->empresas_id;
            $this->editar = false;
            $this->eliminar = false;
        } else {
            $this->editar = true;
            $this->eliminar = true;
            $this->users_id = $data->id;
        }

        Util::eliminarDatosSucursalEmpresa();
        Util::eliminarDatosEmpresa();

        $this->empresas_id =  $data->empresas_id;

    
    }


    public function render()
    {
        return view('livewire.empresa.ver-empresas', ['empresas' => $this->modelarDatos()]);
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

    public function eliminar($id)
    {
        $this->modeloId = $id;
        $this->dispatchBrowserEvent('openDeleteModal');
    }




    public function destruir()
    {

        DB::beginTransaction(); //Iniciamos la reansaccion
        try {


            Empresa::destroy($this->modeloId);


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


    /**
     * Modelas los datos de la base de datos
     *
     * @return void
     */
    public function modelarDatos()
    {
        //verificamos que empresa 

        $user = User::find(Auth::id());

        $data = Empresa::where('users_id', '=', $this->users_id)->get();

      /*   if ($data->count() < $this->cantidad && Util::esUsuario()) { */
            $this->puedeCrearEmpresas = "Si";
       /*  } else {
            $this->puedeCrearEmpresas = "No";
        } */


        if (Util::esUsuario() == false) {

            $auxiliar = PermisoUsuario::where('empresas_id', '=', Util::getEmpresasIngresada())->where('origen', '=', 'empresas')->where('personals_id', '=', Auth::id())->orderBy('id', 'asc')->get();

            foreach ($data as $index => $aux) {

                $estado = false;

                foreach ($auxiliar as  $item) {

                    if ($item->tipo_permiso == $aux->id) {
                        $estado = true;
                    }
                }

                if ($estado == false) {
                    unset($data[$index]);
                }
            }

            foreach ($data as $index => $aux) {

                $estado = false;
                if ($aux->estado == 0) {
                    unset($data[$index]);
                }
            }
        }






        return $data;
    }
}
