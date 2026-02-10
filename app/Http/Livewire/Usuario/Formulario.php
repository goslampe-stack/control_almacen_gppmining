<?php

namespace App\Http\Livewire\Usuario;

use App\Models\Role;
use App\Models\TipoUnidad;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Util;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class Formulario extends Component
{

    public $name, $password, $email, $estado, $tiendas_id, $tipoUsuario, $last_name, $dni,$descripcion;
    protected $listeners = ['crear', 'editar', 'selectedRoleItem'];
    public $modelId, $empresas_id;


    public $estaEnProcesando = "d-none";
    public $estaEnCorrecto = "d-none";
    public $estaEnError = "d-none";
    public $estaEnFormulario = "d-none";


    public $estado_opciones = [
        'Activo',
        'Inactivo'
    ];



    public function hydrate()
    {
        $this->emit('select2Role');
    }


    public function selectedRoleItem($item)
    {
        if ($item) {
            $this->tipoUsuario = $item;
        }
    }


    public $tiendas_id_seleccionado = '';

    public function mount()
    {
        $this->empresas_id = Auth::id();
    }



    public function render()
    {
        return view('livewire.usuario.formulario', ['rol' => $this->obtenerRoles()]);
    }



    public function obtenerRoles()
    {
        return Role::all();
    }

    public function rules()
    {
        return [
            'email' => ['required', Rule::unique('users', 'email')->ignore($this->modelId)],
            'name' => 'required',
            'tipoUsuario' => 'required',
            'last_name' => 'required',
            'password' => 'required',
            'estado' => 'required',
        ];
    }

    public function crear()
    {
        $this->resetValidation();
        $this->resetVars();
        $this->modelId = null;
        $this->dispatchBrowserEvent('openModal');
    }

    public function resetVars()
    {

        $this->name = null;
        $this->tipoUsuario = null;
        $this->last_name = null;
        $this->tipoUsuario = "Trabajador";
        $this->dni = null;
        $this->email = null;
        $this->password = null;
        $this->estado = 'Activo';
        $this->tiendas_id = null;
        $this->estaEnProcesando = "d-none";
        $this->estaEnCorrecto = "d-none";
        $this->estaEnError = "d-none";
        $this->estaEnFormulario = "";
        $this->descripcion = "";
        $this->modelId = null;
    }

    public function cerrarFormulario()
    {
     /*    $this->emit('refreshParent');
        $this->dispatchBrowserEvent('closeModal'); */
        return redirect()->route('usuario');

    }


    public function guardar()
    {
        $this->validate();


        DB::beginTransaction(); //Iniciamos la reansaccion
        try {
            User::create($this->modelData());

            DB::commit();
            Util::getsuccesscreate($this);
            $this->cerrarFormulario();
        } catch (\Exception $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        } catch (\Throwable $e) {
            Util::geterrorSistem($this);

            DB::rollback();
        }
    }


    public function modelData()
    {
        if ($this->modelId) {
            return [
                'name' => $this->name,
                'email' => $this->email,
                'last_name' => $this->last_name,
                'tipoUsuario' => $this->tipoUsuario,
                'dni' => $this->dni,
                'empresas_id' => $this->empresas_id,
                'descripcion' => $this->descripcion,
                'current_team_id' => 1,
                'estado' => $this->estado == 'Activo' ? 1 : 0,
            ];
        } else {
            return [
                'name' => $this->name,
                'last_name' => $this->last_name,
                'tipoUsuario' => $this->tipoUsuario,
                'descripcion' => $this->descripcion,
                'dni' => $this->dni,
                'empresas_id' => $this->empresas_id,
                'password' =>  bcrypt($this->password),
                'email' => $this->email,
                'current_team_id' => 1,
                'estado' => $this->estado == 'Activo' ? 1 : 0,
            ];
        }
    }


    public function editar($id)
    {
        $this->resetValidation();
        $this->resetVars();
        $this->modelId = $id;
        $this->loadModel();
        $this->dispatchBrowserEvent('openModal');
    }

    public function actualizar()
    {
        $this->validate();
        DB::beginTransaction(); //Iniciamos la reansaccion
        try {
            User::find($this->modelId)->update($this->modelData());

            DB::commit();
            Util::getsuccesscreate($this);
            $this->cerrarFormulario();
        } catch (\Exception $e) {
            Util::geterrorSistem($this);
            $this->estaEnError = "";

            DB::rollback();
        } catch (\Throwable $e) {
            Util::geterrorSistem($this);
            $this->estaEnError = "";
            DB::rollback();
        }
    }


    public function loadModel()
    {
        $data = User::find($this->modelId);
        $this->name = $data->name;
        $this->email = $data->email;
        $this->password = $data->password;
        $this->tipoUsuario = $data->tipoUsuario;
        $this->last_name = $data->last_name;
        $this->descripcion = $data->descripcion;
        $this->dni = $data->dni;
        $response = UserRole::where('user_id', '=', $this->modelId)->first();
        if ($response) {
            $this->tipoUsuario = $response->tipoUsuario;
        }
        $this->estado = $data->estado == 1 ? "Activo" : 'Inactivo';
    }
}
