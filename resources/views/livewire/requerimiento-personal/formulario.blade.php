<div>

    <div class="row">


        <div class="col-md-2" style="background: #f2f2f2;">
            <ul class="nav nav-tabs mt-4" style="border-bottom: none;">
                <li class="active">
                    <button type="button" class="btn apl-tp-link" wire:click="cambiarEstaEnRequeremiento">
                        <i class="fas fa-fas fa-adjust mr-2"></i>Requerimiento</button>
                </li>
                <li class="apl-tp-item">
                    @if($modelId)

                    <button type="button" class="btn apl-tp-link btn-disabled" wire:click="cambiarEstaEnArticulos">
                        <i class="fas fa-fas fa-adjust mr-2"></i>Articulos</button>

                    @else
                    <button type="button" class="btn apl-tp-link btn-disabled" wire:click="cambiarEstaEnArticulos" disabled>
                        <i class="fas fa-fas fa-adjust mr-2"></i>Articulos</button>
                    @endif

                </li>

            </ul>
        </div>

        <div class="col-md-10 bg-white">

            <!-- ===================================== -->

            <div class="modal-body">

                <div class="tab-content">
                    <div class=" {{$estaEnRequerimiento}}" id="tp1">

                        <!-- ################################### -->

                        <div class="apl-mdl-formulario " id="apl-mdl-formulario">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" title="Cerrar" class="close" wire:click="cerrarFormulario">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <p><b>Proporciona información del requerimiento</b><br><span>Información de requerimiento.</span></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="numero_requerimiento" style="margin-bottom: 0px;">N&uacute;mero de requerimiento</label><br>
                                        <span class="small">Agregue el n&uacute;mero de requerimiento </span>
                                        <input type="text" class="form-control apl-input-border" wire:model="numero_requerimiento">
                                        @error('numero_requerimiento')<span class="text-danger small">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="txt_ruc" style="margin-bottom: 0px;">Fecha de pedido</label><br>
                                        <span class="small">Agregue la fecha del requerimiento </span>
                                        <input type="date" class="form-control apl-input-border" wire:model="fecha_pedido">
                                        @error('fecha_pedido')<span class="text-danger small">{{$message}}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="destinatario_id" style="margin-bottom: 0px;">Destinatario</label><br>
                                        <span class="small">Eligir Destinatario </span>
                                        <select class="form-control apl-input-border demo-default" id="destinatario_id" wire:model="destinatario_id" style="width: 100%;">
                                            <option value="">{{__('Selecciona Destinatario')}}</option>
                                            @foreach($personal as $item)
                                            <option value="{{ $item->id }}">{{ $item->apellidos }}, {{ $item->nombre }} [{{ $item->tipoPersonal->nombre }}]</option>
                                            @endforeach
                                        </select>
                                        @error('destinatario_id')<span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="descripcion" class="mb-0">Descripción</label><br>
                                        <span class="small">A continuación detallanos brevemente acerca del requerimiento</span>
                                        <textarea class="form-control apl-input-border" id="descripcion" cols="30" rows="2" wire:model="descripcion"></textarea>
                                        @error('descripcion')<span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>


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




                            <div class="row">
                                <div class="col-md-12 mt-3">
                                    <button type="button" class="btn btn-secondary" wire:click="cerrarFormulario" title="Cancelar">
                                        <div wire:loading wire:target="cerrarFormulario">
                                            <i class="fas fa-spinner fa-spin mr-2"></i>
                                        </div> <i class="fas fa-ban"></i>

                                        Cancelar
                                    </button>
                                    @if($modelId)
                                    <button type="button" class="btn btn-primary mr-2 float-right " wire:click="actualizar_RP" wire:loading.attr="disabled" title="Actualizar">
                                        <div wire:loading wire:target="actualizar_RP">
                                            <i class="fas fa-spinner fa-spin mr-2"></i>
                                        </div><i class="fas fa-save"></i> Actualizar
                                    </button>
                                    @else
                                    <button type="button" class="btn btn-primary mr-2 float-right" wire:click="guardar_RP" wire:loading.attr="disabled" title="Guardar">
                                        <div wire:loading wire:target="guardar_RP">
                                            <i class="fas fa-spinner fa-spin mr-2"></i>
                                        </div><i class="fas fa-save"></i>
                                        Guardar
                                    </button>

                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class=" {{$estaEnArticulos}}" id="tp2">

                        <div class="apl-mdl-formulario " id="apl-mdl-formulario">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" class="close" wire:click="cerrarFormulario">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>

                            <div class="card apl-border">
                                <div class="card-body">

                                    <div class="row">

                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="articulos_id" style="margin-bottom: 0px;">Art&iacute;culo</label><br>
                                                <span class="small">Eligir un art&iacute;culo </span>
                                                <select class="form-control apl-input-border demo-default" id="articulos_id" wire:model="articulos_id" style="width: 100%;">
                                                    <option value="">{{__('Selecciona un artículo')}}</option>
                                                    @foreach($articulos as $item)
                                                    <option value="{{ $item->id }}">[ {{ $item->codigo }} ]: {{ $item->articulo }}</option>
                                                    @endforeach
                                                </select>
                                                @error('articulos_id')<span class="text-danger">{{$message}}</span> @enderror
                                            </div>
                                        </div>
                                        @if($modelArticuloRequemientoId==null)

                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="stock_disnponible_articulo_requerimiento" style="margin-bottom: 0px;">Stock actual</label><br>
                                                <span class="small">Stock</span>
                                                <input type="number" class="form-control apl-input-border" readonly wire:model="stock_disnponible_articulo_requerimiento" id="stock_disnponible_articulo_requerimiento">

                                                @error('stock_disnponible_articulo_requerimiento')<span class="text-danger small">{{$message}}</span> @enderror
                                            </div>
                                        </div>
                                        @endif
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label for="cantidad" style="margin-bottom: 0px;">Cantidad</label><br>
                                                <span class="small">Agregue la cantidad </span>
                                                @if($modelArticuloRequemientoId)
                                                <input type="number" class="form-control apl-input-border" wire:model="cantidad" id="cantidad" wire:keydown.enter="actualizar_ARP">

                                                @else

                                                <input type="number" class="form-control apl-input-border" wire:model="cantidad" id="cantidad" wire:keydown.enter="guardar_ARP">
                                                @endif
                                                @error('cantidad')<span class="text-danger small">{{$message}}</span> @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            @if($modelArticuloRequemientoId)
                                            <button type="button" class="btn btn-secondary" wire:click="crear_ARP" title="Nuevo">
                                                <div wire:loading wire:target="crear_ARP">
                                                    <i class="fas fa-spinner fa-spin mr-2"></i>
                                                </div> <i class="fas fa-plus"></i>
                                                Nuevo
                                            </button>
                                            @else
                                            <button type="button" class="btn btn-secondary" wire:click="crear_ARP" title="Cancelar">
                                                <div wire:loading wire:target="crear_ARP">
                                                    <i class="fas fa-spinner fa-spin mr-2"></i>
                                                </div><i class="fas fa-ban"></i>
                                                Cancelar
                                            </button>

                                            @endif

                                            @if($modelArticuloRequemientoId)
                                            <button type="button" class="btn btn-primary mr-2 float-right " wire:click="actualizar_ARP" wire:loading.attr="disabled" title="Actualizar">
                                                <div wire:loading wire:target="actualizar_ARP">
                                                    <i class="fas fa-spinner fa-spin mr-2"></i>
                                                </div><i class="fas fa-save"></i> Actualizar
                                            </button>
                                            @else
                                            <button type="button" class="btn btn-primary mr-2 float-right" wire:click="guardar_ARP" wire:loading.attr="disabled" title="Guardar">
                                                <div wire:loading wire:target="guardar_ARP">
                                                    <i class="fas fa-spinner fa-spin mr-2"></i>
                                                </div><i class="fas fa-save"></i> Guardar
                                            </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card apl-border">
                                        <div class="card-body">
                                            <div class="row">

                                                <div class="col-md-6 mb-2">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            @include('componentes.select-item-table')
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="float-right ">
                                                        <button type="button" class="btn btn-default btn-sm apl-btn-border" title="Item seleccionados" disabled="true">
                                                            {{count($selectedArticulosRequerimientoPersonal)}} Seleccionados
                                                        </button>

                                                        <button type="button" class="btn btn-danger btn-sm apl-btn-border" title="Eliminar" wire:click="eliminar_ARP" {{$estaActivadoEliminar}}>
                                                            <div wire:loading wire:target="eliminar_ARP">
                                                                <i class="fas fa-spinner fa-spin mr-2"></i>
                                                            </div> Eliminar
                                                        </button>

                                                        <a href="{{url('imprimir-requerimiento-personal',['mes'=>$modelId])}}" target="_blank" class="btn btn-secondary btn-sm apl-btn-border" title="Imprimir todos los art&iacute;culos"><i class="fas fa fa-print"></i></a>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">

                                            <div class="table-responsive">
                                                <table id="apl-table" class="table table-hover">
                                                    <thead>
                                                        <tr class="apl-table-header-tr">
                                                            <!--<td class="d-none"></td>-->
                                                            <td class="text-center" width="3%"></td>
                                                            <td class="text-center">C&oacute;digo</td>
                                                            <td class="text-center">Art&iacute;culo</td>
                                                            <td class="text-center">Unidad</td>
                                                            <td class="text-center">Cantidad</td>
                                                            <td class="text-center">Opci&oacute;n</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if($articuloRequerimientos->isNotEmpty())
                                                        @foreach ($articuloRequerimientos as $item)
                                                        @if($modelArticuloRequemientoId==$item->id)

                                                        <tr class="apl-table-body-tr pointer bg-gray">

                                                            @else

                                                        <tr class="apl-table-body-tr pointer">
                                                            @endif
                                                            <!--<td class="d-none"></td>-->
                                                            <td>
                                                                <input type="checkbox" class="apl-border-checkbox" style="padding: .7rem;" value="{{ $item->id }}" wire:click="cambiarEstadoBotones_ARP" wire:model="selectedArticulosRequerimientoPersonal">
                                                            </td>
                                                            <td class="text-center">{{ $item->articulo->codigo }}</td>
                                                            <td class="text-center">{{ $item->articulo->articulo }}</td>
                                                            <td class="text-center">{{ $item->articulo->tipoUnidad->nombre }}</td>
                                                            <td class="text-center">{{ $item->cantidad }}</td>
                                                            <td class="text-center"> <button type="button" title="Editar" class="text-primary" wire:click="editar_ARP({{$item->id}})">
                                                                    <i class="fas fa-edit"></i>
                                                                </button></td>
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
                                                {{ $articuloRequerimientos->links()}}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="tab-pane" id="tp3">
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing, elit. Nulla impedit placeat illo recusandae, omnis fugiat, neque nostrum accusantium ex ducimus, at quo! Voluptates maiores, illum inventore sunt, debitis accusamus provident?</p>

                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing, elit. Nemo, id. Molestiae vitae autem tempore pariatur impedit, quisquam aliquid voluptatum voluptates reiciendis repellat eius, quae aliquam necessitatibus saepe quasi voluptas aspernatur?</p>
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
            $('#destinatario_id').select2({
                placeholder: '{{ __("Seleccione el Destinatario") }}',
                allowClear: true
            });
        }
        initSelectPersonalDrop();
        $('#destinatario_id').on('change', function(e) {
            livewire.emit('selectedDestinarioItem', e.target.value)
        });
        window.livewire.on('select2Destinartario', () => {

            initSelectPersonalDrop();
        });

        /* SELECT 2 PARA CATEGORIA PRODUCTO */

        /* SELECT 2 PARA TIPO UNIDAD */
        window.initSelectArticuloDrop = () => {
            $('#articulos_id').select2({
                placeholder: '{{ __("Seleccione un artículo") }}',
                allowClear: true
            });
        }
        initSelectArticuloDrop();
        $('#articulos_id').on('change', function(e) {
            livewire.emit('selectedArticuloItem', e.target.value)
        });
        window.livewire.on('select2Articulo', () => {
            initSelectArticuloDrop();
        });

        /* SELECT 2 PARA TIPO UNIDAD */

        window.livewire.on('change-focus-cantidad', function() {
            $("#cantidad").focus();

        });
        window.livewire.on('change-focus-codigo', function() {
            $("#codigo").focus();
        });

    });
</script>
@endpush