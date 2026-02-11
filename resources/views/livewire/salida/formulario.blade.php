<div>

    <div class="row">


        <div class="col-md-2" style="background: #f2f2f2;">
            <ul class="nav nav-tabs mt-4" style="border-bottom: none;">


                <li class="active">
                    <button type="button" class="btn apl-tp-link" wire:click="cambiarEstaEnOrdenCompra">
                        <i class="fas fa-fas fa-adjust mr-2"></i>Salida</button>
                </li>

                <li class="apl-tp-item">
                    @if($modelId)
                    <button type="button" class="btn apl-tp-link btn-disabled" wire:click="cambiarEstaEnArticulosOrdenCompra">
                        <i class="fas fa-fas fa-adjust mr-2"></i>Articulos salida</button>
                    @else
                    <button type="button" class="btn apl-tp-link btn-disabled" wire:click="cambiarEstaEnArticulosOrdenCompra" disabled>
                        <i class="fas fa-fas fa-adjust mr-2"></i>Articulos salida</button>
                    @endif

                </li>

            </ul>
        </div>

        <div class="col-md-10 bg-white">

            <!-- ===================================== -->

            <div class="modal-body">

                <div class="tab-content">
                    <div class=" {{$estaEnOrdenCompra}}" id="tp1">

                        <!-- ################################### -->

                        <div class="apl-mdl-formulario " id="apl-mdl-formulario">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" class="close" wire:click="cerrarFormulario">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <p><b>Proporciona información de la nueva salidsa</b><br><span>Información de salida.</span></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="numero_salida" style="margin-bottom: 0px;">N&uacute;mero de salida</label><br>
                                        <span class="small">Agregue el n&uacute;mero de salida </span>
                                        <input type="text" class="form-control apl-input-border" wire:model="numero_salida">
                                        @error('numero_salida')<span class="text-danger small">{{$message}}</span> @enderror
                                    </div>
                                </div>


                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="descripcion" class="mb-0">Descripción</label><br>
                                        <span class="small">Agregue los términos de la salida</span>
                                        <textarea class="form-control apl-input-border" id="descripcion" cols="30" rows="3" wire:model="descripcion"></textarea>
                                        @error('descripcion')<span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                            </div>

                          <!--   <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="personals_id" style="margin-bottom: 0px;">Personal</label><br>
                                        <span class="small">Eligir el personal quien recibira los articulos. </span>
                                        <select class="form-control apl-input-border demo-default" id="personals_id" wire:model="personals_id" style="width: 100%;">
                                            <option value="">{{__('Selecciona personal')}}</option>
                                            @foreach($personales as $item)
                                            <option value="{{ $item->id }}">{{ $item->apellidos }}, {{ $item->nombre }} : [ {{$item->tipoPersonal->nombre}} ]</option>
                                            @endforeach
                                        </select>
                                        @error('personals_id')<span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                            </div>
 -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="txt_correoElectronico" style="margin-bottom: 0px;">Estado</label><br>
                                        <span class="small">Seleccione el estado </span>
                                        <select class="form-control apl-input-border" wire:model="estado">
                                            <option value="">Seleccione estado </option>
                                            @foreach($estado_opciones as $item)
                                            <option value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                        @error('estado')<span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="apl-spacing-top-1"></div>

                            <div class="row">
                                <div class="col-md-12 mt-3">
                                    <button type="button" class="btn btn-secondary" wire:click="cerrarFormulario">
                                        <i class="fas fa-ban"></i>
                                        Cancelar
                                    </button>
                                    @if($modelId)
                                    <button type="button" class="btn btn-primary mr-2 float-right " wire:click="actualizar_RP" wire:loading.attr="disabled">
                                        <i class="fas fa-save"></i>
                                        Actualizar
                                    </button>
                                    @else
                                    <button type="button" class="btn btn-primary mr-2 float-right" wire:click="guardar_RP" wire:loading.attr="disabled">
                                        <i class="fas fa-save"></i>
                                        Guardar
                                    </button>

                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class=" {{$estaEnArticulosOrdenCompra}}" id="tp2">


                        <div class="apl-mdl-formulario " id="apl-mdl-formulario">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" class="close" wire:click="cerrarFormulario">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <p><b>Proporciona información de los articulos</b><br><span>Información de los articulos.</span></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="articulos_id" style="margin-bottom: 0px;">Art&iacute;culo</label><br>
                                        <span class="small">Eligir un art&iacute;culo </span>
                                        <select class="form-control apl-input-border demo-default" id="articulos_id" wire:model="articulos_id" style="width: 100%;">
                                            <option value="">{{__('Selecciona proveedor')}}</option>
                                            @foreach($producto as $item)
                                            <option value="{{ $item->articulo->id }}">{{ $item->articulo->codigo }}: {{ $item->articulo->articulo }}</option>
                                            @endforeach
                                        </select>
                                        @error('articulos_id')<span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <label for="articulos_id" style="margin-bottom: 0px;"></label><br>
                                    <span class="small"></span>
                                    <div class="input-group-append pointer mt-4" style="height:40px;" wire:click="buscarArticuloRequerimiento">
                                        <span class="input-group-text" id="basic-addon2">
                                            <div wire:loading.delay>
                                                <i class="fas fa-spinner fa-spin mr-2"></i>
                                            </div> <i class="fas fa-search"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="stock_disnponible_articulo_requerimiento" style="margin-bottom: 0px;">Stock disponible</label><br>
                                        <span class="small">Stock disponible que tiene el producto</span>
                                        <input type="number" class="form-control apl-input-border" wire:model="stock_disnponible_articulo_requerimiento" disabled>
                                        @error('stock_disnponible_articulo_requerimiento')<span class="text-danger small">{{$message}}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="cantidad" style="margin-bottom: 0px;">Cantidad</label><br>
                                        <span class="small">Agregue la cantidad del articulo</span>
                                        @if($modelArticuloRequemientoId)
                                        <input type="number" class="form-control apl-input-border" wire:model="cantidad" readonly wire:keyup="verificarCantidadIngresada">

                                        @else
                                        <input type="number" class="form-control apl-input-border" wire:model="cantidad" wire:keyup="verificarCantidadIngresada">


                                        @endif
                                        @error('cantidad')<span class="text-danger small">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <!--   <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fecha_salida_detalle" style="margin-bottom: 0px;">Fecha salida</label><br>
                                        <span class="small">Agregue la fecha salida</span>
                                        <input type="datetime-local" class="form-control apl-input-border" wire:model="fecha_salida_detalle">
                                        @error('fecha_salida_detalle')<span class="text-danger small">{{$message}}</span> @enderror
                                    </div>
                                </div> -->

                               <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="numero_requerimiento" style="margin-bottom: 0px;">N° Requerimiento</label><br>
                                        <span class="small">Agregue el N° requerimiento</span>
                                        <input type="text" class="form-control apl-input-border" wire:model="numero_requerimiento">
                                        @error('numero_requerimiento')<span class="text-danger small">{{$message}}</span> @enderror
                                    </div>
                                </div> 
                               <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fecha_salida_detalle" style="margin-bottom: 0px;">Fecha y Hora de salida</label><br>
                                        <span class="small">Agregue el N° requerimiento</span>
                                        <input type="datetime-local" class="form-control apl-input-border" wire:model="fecha_salida_detalle">
                                        @error('fecha_salida_detalle')<span class="text-danger small">{{$message}}</span> @enderror
                                    </div>
                                </div> 
                              
                            </div>

                            <div class="row">
                                <div class="col-md-12 mt-3 mb-3">
                                    <button type="button" class="btn btn-secondary" wire:click="resetVars_ARP">
                                        <i class="fas fa-ban"></i>
                                        Cancelar
                                    </button>
                                    @if($modelArticuloRequemientoId)
                                    <button type="button" class="btn btn-primary mr-2 float-right " wire:click="actualizar_ARP" wire:loading.attr="disabled">
                                        <div wire:loading.delay>
                                            <i class="fas fa-spinner fa-spin mr-2"></i>
                                        </div>
                                        <i class="fas fa-save"></i> Actualizar
                                    </button>
                                    @else
                                    <button type="button" class="btn btn-primary mr-2 float-right {{$estaActivadoBotonGuardarSalidaDetalle}}" wire:click="guardar_ARP">
                                        <div wire:loading.delay>
                                            <i class="fas fa-spinner fa-spin mr-2"></i>
                                            <i class="fas fa-save"></i>
                                        </div>
                                        <i class="fas fa-save"></i>

                                        Guardar
                                    </button>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card apl-border">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <b>{{$articuloDetalleSalidas->count()}}</b><br>
                                                    <font class="apl-text-gray">Art&iacute;culos de salidas</font>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="float-right mt-2">
                                                        <button type="button" class="btn btn-default btn-sm apl-btn-border" disabled="true">
                                                            {{count($selectedArticulosOrdenCompra)}} Seleccionados
                                                        </button>

                                                        <button type="button" class="btn btn-danger btn-sm apl-btn-border" wire:click="eliminar_ARP" {{$estaActivadoEliminar}}>
                                                            Eliminar
                                                        </button>

                                                        <a href="{{url('imprimir-salida',['mes'=>$modelId])}}" target="_blank" class="btn btn-secondary btn-sm apl-btn-border" title="Imprimir"><i class="fas fa fa-print"></i></a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card apl-border">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="apl-table" class="table table-hover">
                                                    <thead>
                                                        <tr class="apl-table-header-tr">
                                                           <!--  <td class="d-none"></td> -->
                                                            <td width="3%"></td>
                                                            <td>Art&iacute;culo</td>
                                                            <td>Fecha salida</td>
                                                            <td>N° requerimiento</td>
                                                            <td>Cantidad</td>
                                                          <!--  <td>Opci&oacute;n</td>  -->

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if($articuloDetalleSalidas->isNotEmpty())
                                                        @foreach ($articuloDetalleSalidas as $item)
                                                        <tr class="apl-table-body-tr pointer">
                                                            <!--<td class="d-none"></td>-->
                                                            <td>
                                                                <input type="checkbox" class="apl-border-checkbox" style="padding: .7rem;" value="{{ $item->id }}" wire:click="cambiarEstadoBotonesOrdenCompra_ARP" wire:model="selectedArticulosOrdenCompra">
                                                            </td>
                                                            <td >{{ $item->articulo->articulo }}</td>
                                                            <td >{{ $item->fecha_salida_detalle }}</td>
                                                            <td >{{ $item->numero_requerimiento }}</td>
                                                            <td >{{ $item->cantidad }}</td>
                                                          <!--   <td>

                                                                <div class="row">
                                                                 
                                                                    <div class="col-12">
                                                                        <div class="pointer" wire:click="incrementarCantidad({{ $item->id}})"><i class="fas fa-arrow-up fa-xs"></i></div>

                                                                        <div class="pointer" wire:click="decrementarCantidad({{ $item->id}})"><i class="fas fa-arrow-down fa-xs"></i></div>
                                                                    </div>
                                                                </div>
                                                            </td> -->
                                                            <!--  <td>
                                                                <i class="fas fa-trash-alt pointer" wire:click="eliminarSalidaDettale({{ $item->id}})"></i>
                                                            </td> -->
                                                        </tr>
                                                        @endforeach
                                                        @else
                                                        <tr>
                                                            <td colspan="6" class="text-center">
                                                                <center><img src="{{ asset('dist/img/empty.png') }}" alt="Imagen" width="350"></center>
                                                                <p class="text-muted">No hay resultados</p>
                                                            </td>
                                                        </tr>
                                                        @endif
                                                    </tbody>
                                                </table>
                                                {{ $articuloDetalleSalidas->links()}}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===================================== -->

        </div>
    </div>
</div>





@push('scripts')


<script>
    $(document).ready(function() {

        /* SELECT 2 PARA CATEGORIA PRODUCTO */
        window.initSelectPersonalDrop = () => {
            $('#personals_id').select2({
                placeholder: '{{ __("Seleccione el personal") }}',
                allowClear: true
            });
        }
        initSelectPersonalDrop();
        $('#personals_id').on('change', function(e) {
            livewire.emit('selectedPersonalItem', e.target.value)
        });
        window.livewire.on('select2Personal', () => {
            initSelectPersonalDrop();
        });

        /* SELECT 2 PARA CATEGORIA PRODUCTO */

        /* SELECT 2 PARA CATEGORIA PRODUCTO */
        window.initSelectArticuloRequerimientoDrop = () => {
            $('#articulos_id').select2({
                placeholder: '{{ __("Seleccione el artículo") }}',
                allowClear: true
            });
        }
        initSelectArticuloRequerimientoDrop();
        $('#articulos_id').on('change', function(e) {
            livewire.emit('selectedArticuloRequerimientItem', e.target.value)
        });
        window.livewire.on('select2ArticuloRequerimient', () => {
            initSelectArticuloRequerimientoDrop();
        });

        /* SELECT 2 PARA CATEGORIA PRODUCTO */



    });
</script>
@endpush