<?php

namespace App\Http\Livewire\Facturacion;

use App\Models\Mensualidad;
use App\Models\MensualidadUsuario;
use App\Models\Util;
use Livewire\Component;

class Principal extends Component
{
    public $plans_id_seleccionado;
    public $users_id, $F_monto, $F_token, $empresas_id;

    public $total_dias_ampliar = 0;


    public function render()
    {
        return view('livewire.facturacion.principal', ['planes' => $this->modelarPlanes(), 'planActual' => $this->obtenerPlanUsuarioActual()]);
    }

    protected $listeners = ['procesarPago', 'enviarFormulario'];

    public function mount()
    {
        $this->users_id = Auth()->user()->id;
        $this->total_dias_ampliar = 0;
        $this->empresas_id = Util::getEmpresasIngresada();
    }

    public function irAPrincipal()
    {
        return redirect()->route('minero.empresa.principal');
    }



    public function obtenerPlanUsuarioActual()
    {
        return MensualidadUsuario::where('estado', '=', '1')->where('users_id', '=', $this->users_id)->first();
    }

    public function obtenerPlanUsuarioPendiente()
    {
        return MensualidadUsuario::where('estado', '=', 'Pendiente')->where('users_id', '=', $this->users_id)->first();
    }

    public function obtenerPlanUsuarioCancelado()
    {
        return MensualidadUsuario::where('estado', '=', 'Cancelado')->where('users_id', '=', $this->users_id)->first();
    }







    public function enviarFormulario($codigo)
    {
        $this->generarFacturacion($codigo);
        return redirect()->route('minero.facturacion.confirmacion-plan-correcto');
    }



    public function modelarPlanes()
    {
        $data = Mensualidad::where('estado', '=', 1)->orderBy('orden', 'asc')->get();

        return $data;
    }
    public function cancelarPlan($id)
    {
        $data = MensualidadUsuario::where('estado', '=', 1)->where('users_id', '=', $this->empresas_id)->get();

        foreach ($data as $item) {
            $item->estado = "0";
            $item->update();
        }

        Util::getsuccessDefine($this, "Se cancelo correctamente");
    }
}
