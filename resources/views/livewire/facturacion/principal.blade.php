<div class="content-wrapper gl-content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row cw-header">
                        <div class="col-12 intro-y">
                            <div class="text-center">
                                <h2><b>Planes</b></h2>
                                <h3 class="mt-4">Planes de Goslam Log&iacute;stico</h3>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 intro-y">
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <div class="row justify-content-center">
                                        @foreach($planes as $item)
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                                            <div class="card card-plan">
                                                <div class="card-body">
                                                    <div class="titulo" style="    text-align: center;" >
                                                        <h1 ><b>{{ $item->titulo }}</b></h1>
                                                        <h2><b>S/ {{ \App\Models\Util::darFormatoMoneda($item->monto) }}</b></h2>
                                                        <h3>{{ $item->descripcion }}</h3>
                                                    </div>

                                                    <div class="descripcion">
                                                        <ul>
                                                            @foreach($item->planesDetalle($item->id) as $plan)
                                                            <li></i><b>{{$plan->cantidad}}</b> {{$plan->descripcion}}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="card-footer">
                                                    
                                                    @if($item->tienePlanActivo($item->id,$empresas_id)==true)
                                                    <button type="button" class="btn btn-danger btn-md btn-block mb-2" wire:loading.attr="disabled" wire:click="cancelarPlan({{$item->id}})">
                                                        <div wire:loading wire:target="cancelarPlan({{$item->id}})">
                                                            <i class="fas fa-spinner fa-spin mr-2"></i>
                                                        </div>
                                                        <b>Cancelar</b>
                                                    </button>
                                                    @else
                                                    <a  href="https://wa.me/51920438989" target="_blank" class="btn btn-primary btn-md btn-block mb-2" >
                                                       
                                                        <b>Suscribirse</b>
                                                    </a>
                                                   <!--  <button type="button" class="btn btn-primary btn-md btn-block mb-2" wire:loading.attr="disabled" wire:target="nuevaSuscripcion" wire:click="ampliarPlan({{$item->id}})">
                                                        <div wire:loading wire:target="ampliarPlan({{$item->id}})">
                                                            <i class="fas fa-spinner fa-spin mr-2"></i>
                                                        </div>
                                                        <b>Renovar plan</b>
                                                    </button> -->
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>
</div>

@push('scripts')
<script>
    var btn_pagar = document.getElementById('btn_pagar')
    var btn_pagar = btn_pagar.getAttribute('href')

    var precio;
    var producto;

    $(document).ready(function() {

        /* ENTER */

        /* Livewire */

        window.livewire.on('suscribirse', ($precio, $descripcion) => {
            precio = $precio;
            producto = $descripcion;
            abrirCului();
        });
        /* Livewire */
    });

    function abrirCului() {
        precio = precio * 100;
        precio = Math.round(precio, 2);

        Culqi.publicKey = "pk_live_acd0879e00587517";
        Culqi.settings({
            title: 'GOSLAM',
            currency: 'PEN',
            description: producto,
            amount: precio,

        });

        Culqi.open();
    }


    function culqi() {
        if (Culqi.token) {
            // ¡Objeto Token creado exitosamente!
            var token = Culqi.token.id;
            var email = Culqi.token.email;

            //En esta linea de codigo debemos enviar el "Culqi.token.id"
            //hacia tu servidor con Ajax

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content'
                    )
                },
                type: 'GET',
                dataType: 'json',
                url: btn_pagar,
                async: false,
                data: {
                    token: token,
                    email: email,
                    precio: precio,
                    producto: producto
                },
                success: function(result) {
                    if (result.status == "successfull") {
                        console.log(result.id)
                        livewire.emit('enviarFormulario', result.id.reference_code)
                    } else {
                        console.log(result.status);

                        alert(result.status)

                    }

                }
            })
        } else {
            // ¡Hubo algún problema!
            // Mostramos JSON de objeto error en consola
            alert("Ocurrio un error inesperado al realizar el pago, intentelo otra vez");
        }
    };
</script>
@endpush