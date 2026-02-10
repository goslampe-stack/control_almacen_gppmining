<div>

    <div class="row">


        <div class="col-md-2" style="background: #f2f2f2;">
            <ul class="nav nav-tabs mt-4" style="border-bottom: none;">




                <li class="apl-tp-item">

                    <button type="button" class="btn apl-tp-link" wire:click="cambiarEstaEnArticulosOrdenCompra">
                        <i class="fas fa-fas fa-adjust mr-2"></i>Articulo Devuelto</button>

                </li>

            </ul>
        </div>

        <div class="col-md-10 bg-white">

            <!-- ===================================== -->

            <div class="modal-body">

                <div class="tab-content">


                    <div id="tp2">


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
                                    <p><b>Proporciona información de la devoluci&oacute;n</b><br><span>Información b&aacute;sica.</span></p>
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
                                            <option value="{{ $item->id }}">{{ $item->codigo }}: {{ $item->articulo }}</option>
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
                                        <span class="small">Agregue la cantidad a devolver</span>

                                        <input type="number" class="form-control apl-input-border" wire:model="cantidad">



                                        @error('cantidad')<span class="text-danger small">{{$message}}</span> @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="txt_correoElectronico" style="margin-bottom: 0px;">Tipo de salida </label><br>
                                        <span class="small">Seleccione tipo </span>
                                        <select class="form-control apl-input-border" wire:model="tipoDevolucion">
                                            <option value="">Seleccione tipo </option>
                                            @foreach($tipo_salida_opciones as $item)
                                            <option value="{{ $item }}">{{ $item }}</option>
                                            @endforeach
                                        </select>
                                        @error('tipoDevolucion')<span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>


                              


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="comentario" style="margin-bottom: 0px;">Comentario</label><br>
                                        <span class="small">Agregue un comentario</span>
                                        <input type="text" class="form-control apl-input-border" wire:model="comentario">
                                        @error('comentario')<span class="text-danger small">{{$message}}</span> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mt-3 mb-3">
                                    <button type="button" class="btn btn-secondary" wire:click="resetVars_ARP">
                                        <i class="fas fa-ban"></i> Cancelar
                                    </button>

                                    @if($ModeloId)
                                    <button type="button" title="Actualizar" class="btn btn-primary mr-2 float-right" wire:click="actualizar" wire:loading.attr="disabled">
                                        <div wire:loading.delay>
                                            <i class="fas fa-spinner fa-spin mr-2"></i>
                                        </div> <i class="fas fa-save"></i> Actualizar
                                    </button>
                                    @else
                                    <button type="button" title="Guardar" class="btn btn-primary mr-2 float-right" wire:click="guardar" wire:loading.attr="disabled">
                                        <div wire:loading.delay>
                                            <i class="fas fa-spinner fa-spin mr-2"></i>
                                        </div><i class="fas fa-save"></i> Guardar
                                    </button>
                                    @endif





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