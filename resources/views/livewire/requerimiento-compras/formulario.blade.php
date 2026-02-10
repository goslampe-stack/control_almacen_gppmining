<div>

    <div class="row">


        <div class="col-md-2" style="background: #f2f2f2;">
            <ul class="nav nav-tabs mt-4 " style="border-bottom: none;">


                <li class="active">
                    <button type="button" class="btn apl-tp-link" wire:click="cambiarEstaEnOrdenCompra">
                        <i class="fas fa-fas fa-adjust mr-2"></i>Requerimiento de compras</button>
                </li>
                <li class="apl-tp-item ">
                    @if($modelId)
                    <button type="button" class="btn apl-tp-link btn-disabled " wire:click="cambiarEstaEnArticulosRequerimientoPersonal">
                        <i class="fas fa-fas fa-adjust mr-2"></i>Artículos Requerimiento</button>
                    @else
                    <button type="button" class="btn apl-tp-link btn-disabled" wire:click="cambiarEstaEnArticulosRequerimientoPersonal" disabled>
                        <i class="fas fa-fas fa-adjust mr-2"></i>Artículos Requerimiento</button>
                    @endif

                </li>
                <li class="apl-tp-item float-right">
                    @if($modelId)
                    <button type="button" class="btn apl-tp-link btn-disabled" wire:click="cambiarEstaEnArticulosOrdenCompra">
                        <i class="fas fa-fas fa-adjust mr-2"></i>Artículos requerimiento de compras</button>
                    @else
                    <button type="button" class="btn apl-tp-link btn-disabled" wire:click="cambiarEstaEnArticulosOrdenCompra" disabled>
                        <i class="fas fa-fas fa-adjust mr-2"></i>Artículos requerimiento de compras</button>
                    @endif

                </li>

            </ul>
        </div>

        <div class="col-md-10 ">

            <!-- ===================================== -->

            <div class="modal-body">

                <div class="tab-content">
                    <div class=" {{$estaEnOrdenCompra}}" id="tp1">

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
                                    <p><b> Articulos de requerimiento de compras</b><br><span>Detalle informacion del art&iacute;culo como guia, cantidad.</span></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="numero_requerimiento_compra" style="margin-bottom: 0px;">N&uacute;mero de documento</label><br>
                                        <span class="small">Agregue el n&uacute;mero de documento </span>
                                        <input type="text" class="form-control apl-input-border" wire:model="numero_requerimiento_compra">
                                        @error('numero_requerimiento_compra')<span class="text-danger small">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                  <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="fecha_requerimiento" style="margin-bottom: 0px;">Fecha requerimiento </label><br>
                                        <span class="small">Agregue fecha de requerimiento </span>
                                        <input type="date" class="form-control apl-input-border" wire:model="fecha_requerimiento">
                                        @error('fecha_requerimiento')<span class="text-danger small">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                
                                @if($modelId)

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="numero_requerimiento_personal" style="margin-bottom: 0px;">N&uacute;mero de requerimiento interno de productos</label><br>
                                        <span class="small">Agregue el n&uacute;mero de requerimiento interno de productos</span>
                                        <input type="text" class="form-control apl-input-border" wire:model="numero_requerimiento_personal" readonly>
                                        @error('numero_requerimiento_personal')<span class="text-danger small">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                @else

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="txt_proveedor" style="margin-bottom: 0px;">Requerimiento interno de productos</label><br>
                                        <span class="small">Seleccione el Nº de requerimeinto interno de productos.</span>


                                        <select class="form-control apl-input-border demo-default" id="requerimiento_personals_id" wire:model="requerimiento_personals_id" style="width: 100%;">


                                            <option value="">{{__('Selecciona proveedor')}}</option>
                                            @foreach($requerimientoRersonales as $item)
                                            <option value="{{ $item->id }}"> [ {{$item->sucursal->nombre_sucursal}}] : Requerimiento {{ $item->numero_requerimiento }} </option>
                                            @endforeach
                                        </select>
                                        @error('requerimiento_personals_id')<span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                @endif







                                <div class="col-md-6">
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

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="descripcion" class="mb-0">Descripción</label><br>
                                        <span class="small">Agregue una descripci&oacute;n al requerimiento de compras</span>
                                        <textarea class="form-control apl-input-border" id="descripcion" cols="30" rows="1" wire:model="descripcion"></textarea>
                                        @error('descripcion')<span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                            </div>






                        </div>


                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <button type="button" title="Cancelar" class="btn btn-secondary" wire:click="cerrarFormulario">
                                    <i class="fas fa-ban"></i> Cancelar
                                </button>
                                @if($modelId)
                                <button type="button" title="Actualizar" class="btn btn-primary mr-2 float-right " wire:click="actualizar_RP" wire:loading.attr="disabled">
                                    <div wire:loading.delay>
                                        <i class="fas fa-spinner fa-spin mr-2"></i>
                                    </div><i class="fas fa-save"></i> Actualizar
                                </button>
                                @else
                                <button type="button" title="Guardar" class="btn btn-primary mr-2 float-right" wire:click="guardar_RP" wire:loading.attr="disabled">
                                    <div wire:loading.delay>
                                        <i class="fas fa-spinner fa-spin mr-2"></i>
                                    </div> <i class="fas fa-save"></i> Guardar
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
                                <button type="button" title="Cerrar" class="close" wire:click="cerrarFormulario">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <p><b>Seleccione el articulo y agregar su detalle</b><br><span>Información de articulos.</span></p>
                            </div>
                        </div>


                        <div class="row">

                            <div class="col-md-12">
                                <div class="card apl-border">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <div class="row">

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <select class="form-control apl-input-border" wire:model="perPageArticuloOrdenCompra">
                                                            @foreach($opciones_perPage as $item)
                                                            <option value="{{ $item }}">{{ $item }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('perPageArticuloOrdenCompra')<span class="text-danger">{{$message}}</span> @enderror
                                                    </div>
                                                </div>

                                                <div class="col-md-10 float-right">
                                                    <div class="row float-right">
                                                        <div class="col-md-5">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text apl-input-search-icon"><i class="fas fa-search"></i></div>
                                                                </div>
                                                                <input type="text" class="form-control apl-input-border apl-input-search" id="apl-table-buscar" placeholder="Buscar por articulo" wire:model.debounce.800ms="buscarArticuloOrdenCompra">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-7">
                                                            <div class="float-right">
                                                                <button type="button" title="Item seleccionados" class="btn btn-default btn-sm apl-btn-border" disabled="true">
                                                                    {{count($selectedArticulosOrdenCompra)}} Seleccionados
                                                                </button>

                                                                <button type="button" title="Eliminar" class="btn btn-danger btn-sm apl-btn-border" wire:click="eliminar_ARP" {{$estaActivadoEliminar}}>
                                                                    Eliminar
                                                                </button>

                                                                <a href="{{url('imprimir-requerimiento-compras',['mes'=>$modelId])}}" target="_blank" class="btn btn-secondary btn-sm apl-btn-border" title="Imprimir art&iacute;culos agregados a requerimiento de compras"><i class="fas fa fa-print"></i></a>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                            <table id="apl-table" class="table table-hover">
                                                <thead>
                                                    <tr class="apl-table-header-tr">
                                                        <!--<td class="d-none"></td>-->
                                                        <td>
                                                            <input type="checkbox" class="apl-border-checkbox" style="padding: .7rem;" wire:model="selectAllArticuloOrdenCompra">

                                                        </td>
                                                        <th class="text-center">C&oacute;digo</th>
                                                        <th class="text-center">Art&iacute;culo</th>
                                                        <th class="text-center">Unidad</th>
                                                        <th class="text-center">Cantidad requerida</th>
                                                        <th class="text-center">Stock disponible</th>
                                                        <th class="text-center">Opci&oacute;n</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if($articuloGeneralOrdenCompra->isNotEmpty())
                                                    @foreach ($articuloGeneralOrdenCompra as $item)


                                                    @if($item->id==$articuloRequerimientoPersonal)


                                                    <tr class="apl-table-body-tr pointer bg-gray ">

                                                        @else

                                                    <tr class="apl-table-body-tr pointer">
                                                        @endif
                                                        <!--<td class="d-none"></td>-->
                                                        <td>
                                                            <input type="checkbox" class="apl-border-checkbox" style="padding: .7rem;" value="{{ $item->id }}" wire:click="cambiarEstadoBotonesOrdenCompra_ARP" wire:model="selectedArticulosOrdenCompra">
                                                        </td>
                                                        <td class="text-center">{{ $item->articulo->codigo }}</td>
                                                        <td class="text-center">{{ \App\Models\Util::getCantidadLetras($item->articulo->articulo,25)}} </td>
                                                        <td class="text-center">{{ $item->articulo->tipoUnidad->nombre }}</td>
                                                        <td class="text-center">{{ $item->calcularFaltaArticuloRequerimeintoComprasRequerimientoPersonal($item->id,$modelId) }} de {{ $item->cantidad }}</td>
                                                        <td class="text-center">{{ $item->stock_disponible }}</td>

                                                        <td class="text-center">
                                                            <button type="button" title="Ver detalle de art&iacute;culo" class="text-primary" wire:click="editar_ArticuloRequerimiento({{$item->id}})">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    @else
                                                    <tr>
                                                        <td colspan="7" class="text-center">
                                                            <center><img src="{{ asset('dist/img/empty.png') }}" alt="Imagen" width="30%"></center>
                                                            <h4 class="text-muted">No hay resultados</h4>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                </tbody>

                                            </table>
                                            {{ $articuloGeneralOrdenCompra->links()}}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>




                        <!-- Tabla ################################### -->


                        <div class="{{$estaOcultoFormularioArticuloOrdenCompra}}">

                            <div class="row">
                                <div class="col-md-12">
                                    <p><b>Detalle de art&iacute;culo de Requerimiento de compras</b></p>
                                </div>
                            </div>

                            <div class="card apl-border">
                                <div class="card-body">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="cantidad" style="margin-bottom: 0px;">Cantidad</label><br>
                                                <span class="small">Agregue la cantidad del articulo</span>
                                                <input type="number" class="form-control apl-input-border" id="cantidad" wire:model="cantidad">
                                                @error('cantidad')<span class="text-danger small">{{$message}}</span> @enderror
                                            </div>
                                        </div>


                                    </div>

                                    <div class="row">
                                        <div class="col-md-12  mb-3">
                                            <button type="button" title="Cancelar" class="btn btn-secondary" wire:click="cancelar_articuloOrdenCompra">
                                                <i class="fas fa-ban"></i>

                                                Cancelar
                                            </button>

                                            @if($modelArticuloOrdenCompraId)
                                            <button type="button" title="Actualizar" class="btn btn-primary mr-2 float-right " wire:click="actualizar_ARP" wire:loading.attr="disabled">
                                                <div wire:loading.delay>
                                                    <i class="fas fa-spinner fa-spin mr-2"></i>
                                                </div>
                                                <i class="fas fa-save"></i>

                                                Actualizar
                                            </button>
                                            <!--                         <button type="button" title="Actualizar" class="btn btn-danger mr-2 float-right " wire:click="eliminar_ArticuloOrdenCompra" wire:loading.attr="disabled">
                                                <div wire:loading.delay>
                                                    <i class="fas fa-spinner fa-spin mr-2"></i>
                                                </div>
                                                <i class="fas fa-trash"></i>

                                                Eliminar
                                            </button> -->
                                            @else
                                            <button type="button" title="Actualizar" class="btn btn-primary mr-2 float-right " wire:click="guardar_ArticuloordenCompra" wire:loading.attr="disabled">
                                                <div wire:loading.delay>
                                                    <i class="fas fa-spinner fa-spin mr-2"></i>
                                                </div>
                                                <i class="fas fa-save"></i>

                                                Guardar
                                            </button>
                                            @endif
                                            @if($modelArticuloRequemientoId)
                                            <button type="button" title="Nuevo articulo" class="btn btn-success mr-2 float-right" wire:click="nuevoArticuloOrdenCompra">
                                                <i class="fas fa-plus"></i>
                                                Nuevo
                                            </button>

                                            @endif
                                        </div>
                                    </div>



                                    <div class="row">
                                        <div class="col-md-12">

                                            <p><b>Art&iacute;culos agregados</b><br><span>Edite, elimine art&iacute;culo agregado a requerimiento de compras.</span></p>

                                        </div>
                                        <div class="col-md-12">
                                            <div class="table-responsive">

                                                <table id="apl-table" class="table table-hover">
                                                    <thead>
                                                        <tr class="apl-table-header-tr">
                                                            <!--<td class="d-none"></td>-->

                                                            <th class="text-center">C&oacute;digo</th>
                                                            <th class="text-center">Art&iacute;culo</th>
                                                            <th class="text-center">Unidad</th>
                                                            <th class="text-center">Cantidad</th>
                                                            <th class="text-center">Opci&oacute;n</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if($articuloOrdenCompra->isNotEmpty())
                                                        @foreach ($articuloOrdenCompra as $item)

                                                        @if($modelArticuloOrdenCompraId==$item->id)

                                                        <tr class="apl-table-body-tr pointer bg-gray">

                                                            @else

                                                        <tr class="apl-table-body-tr pointer">
                                                            @endif
                                                            <!--<td class="d-none"></td>-->

                                                            <td class="text-center">{{ $item->articuloRequerimiento->articulo->codigo }}</td>
                                                            <td class="text-center"> {{ \App\Models\Util::getCantidadLetras($item->articuloRequerimiento->articulo->articulo,25)}}</td>
                                                            <td class="text-center">{{ $item->articuloRequerimiento->articulo->tipoUnidad->nombre }}</td>
                                                            <td class="text-center">{{ $item->cantidad }}</td>

                                                            <td class="text-center">

                                                                <button type="button" title="Eliminar art&iacute;culo" class="text-danger" wire:click="eliminarArticuloOrdenCompra({{$item->id}})">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>

                                                                <button type="button" title="Editar  art&iacute;culo" class="text-primary" wire:click="editar_ARP({{$item->id}})">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
                                                            </td>
                                                        </tr>

                                                        @endforeach
                                                        @else
                                                        <tr>
                                                            <td colspan="6" class="text-center">
                                                                <center><img src="{{ asset('dist/img/empty.png') }}" alt="Imagen" width="200" height="200"></center>
                                                                <h4 class="text-muted">No hay resultados</h4>
                                                            </td>
                                                        </tr>
                                                        @endif
                                                    </tbody>

                                                </table>

                                            </div>

                                        </div>
                                    </div>


                                </div>

                            </div>



                        </div>
                    </div>

                </div>

                <div class="{{$estaEnArticulosOrdenCompraRequerimiento}}" id="tp3">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" title="Cerrar" class="close" wire:click="cerrarFormulario">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                            <!-- ===== BOX ===== -->
                            <div class="row">
                                <div class="col-md-12">
                                    <p><b>Art&iacute;culos de requerimiento personal</b><br><span>Seleccione todos los art&iacute;culos a para agregar a requerimientos de compras.</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">

                            <div class="card apl-border">
                                <div class="card-body">
                                    <div class="row mb-1">
                                        <div class="col-md-3">

                                        </div>

                                        <div class="col-md-9">
                                            <div class="float-right">
                                                <button type="button" title="Item seleccionados" class="btn btn-default btn-sm apl-btn-border" disabled="true">
                                                    {{count($selectedArticulosRequerimientoPersonal)}} Seleccionados
                                                </button>

                                                <button type="button" class="btn btn-primary btn-sm apl-btn-border" wire:click="enviarArticuloRequerimientoParaOrdenCompra" {{$estaActivadoEnviar}}>
                                                    Agregar a requerimiento de compras
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="apl-table" class="table table-hover">
                                            <thead>
                                                <tr class="apl-table-header-tr">
                                                    <!--<td class="d-none"></td>-->
                                                    <td>
                                                        <input type="checkbox" class="apl-border-checkbox" style="padding: .7rem;" wire:model="selectAllArticuloRequerimiento">
                                                    </td>
                                                    <td class="text-center">C&oacute;digo</td>
                                                    <td class="text-center">Art&iacute;culo</td>
                                                    <td class="text-center">Unidad</td>
                                                    <td class="text-center">Cantidad requerida</td>
                                                    <td class="text-center">Stock disponible</td>
                                                    <td class="text-center">Opcion</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if($articuloRequerimientosPersonal->isNotEmpty())
                                                @foreach ($articuloRequerimientosPersonal as $item)
                                                <tr class="apl-table-body-tr pointer">
                                                    <!--<td class="d-none"></td>-->
                                                    <td>
                                                        <input type="checkbox" class="apl-border-checkbox" style="padding: .7rem;" value="{{ $item->id }}" wire:click="cambiarEstadoBotonesRequerimientoPersonal_ARP" wire:model="selectedArticulosRequerimientoPersonal">
                                                    </td>
                                                    <td class="text-center">{{ $item->articulo->codigo }}</td>
                                                    <td class="text-center">{{ \App\Models\Util::getCantidadLetras($item->articulo->articulo,30)}}</td>
                                                    <td class="text-center">{{ $item->articulo->tipoUnidad->nombre }}</td>
                                                    <td class="text-center">{{ $item->cantidad }}</td>
                                                    <td class="text-center">{{ $item->stock_disponible }}</td>
                                                    <td class="text-center">
                                                        <button type="button" title="Agregar a requerimiento de compras" class="btn btn-primary btn-sm apl-btn-border" wire:click="enviarArticuloRequerimientoParaOrdenCompraItem({{ $item->id}})">
                                                            Agregar
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <tr>
                                                    <td colspan="7" class="text-center">
                                                        <center><img src="{{ asset('dist/img/empty.png') }}" alt="Imagen" width="30%"></center>
                                                        <h4 class="text-muted">No hay resultados</h4>
                                                    </td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                        {{ $articuloRequerimientosPersonal->links()}}
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
        window.initSelectProveedorDrop = () => {
            $('#proveedors_id').select2({
                placeholder: '{{ __("Seleccione el proveedor") }}',
                allowClear: true
            });
        }
        initSelectProveedorDrop();
        $('#proveedors_id').on('change', function(e) {
            livewire.emit('selectedProveedorItem', e.target.value)
        });
        window.livewire.on('select2Proveedor', () => {
            initSelectProveedorDrop();
        });


        /* SELECT 2 PARA CATEGORIA PRODUCTO */
        /* SELECT 2 PARA CATEGORIA PRODUCTO */
        window.initSelectProveedorRucDrop = () => {
            $('#proveedors_ruc_id').select2({
                placeholder: '{{ __("Seleccione el ruc") }}',
                allowClear: true
            });
        }
        initSelectProveedorRucDrop();
        $('#proveedors_ruc_id').on('change', function(e) {
            livewire.emit('selectedProveedorRucItem', e.target.value)
        });
        window.livewire.on('select2ProveedorRuc', () => {
            initSelectProveedorRucDrop();
        });

        /* SELECT 2 PARA CATEGORIA PRODUCTO */

        /* SELECT 2 PARA CATEGORIA PRODUCTO */
        window.initSelectRequerimientoPersonalDrop = () => {
            $('#requerimiento_personals_id').select2({
                placeholder: '{{ __("Seleccione un requerimiento personal") }}',
                allowClear: true
            });
        }
        initSelectRequerimientoPersonalDrop();
        $('#requerimiento_personals_id').on('change', function(e) {
            livewire.emit('selectedRequerimientoPersonalItem', e.target.value)
        });
        window.livewire.on('select2RequerimientoPersonal', () => {
            initSelectRequerimientoPersonalDrop();
        });

        /* SELECT 2 PARA CATEGORIA PRODUCTO */


        /* SELECT 2 PARA CATEGORIA PRODUCTO */
        window.initSelectElaboradoPorDrop = () => {
            $('#elaboradoPor_id').select2({
                placeholder: '{{ __("Seleccione el personal") }}',
                allowClear: true
            });
        }
        initSelectElaboradoPorDrop();
        $('#elaboradoPor_id').on('change', function(e) {
            livewire.emit('selectedElaboradoPorItem', e.target.value)
        });
        window.livewire.on('select2ElaboradoPor', () => {

            initSelectElaboradoPorDrop();
        });

        /* SELECT 2 PARA CATEGORIA PRODUCTO */


        $("#tipo_documento").on('keyup', function(e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                $("#serie_documento").focus();
                $('#serie_documento').select();
            }
        });
        $("#serie_documento").on('keyup', function(e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                $("#numero_documento").focus();
                $('#numero_documento').select();
            }
        });

        $("#numero_documento").on('keyup', function(e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                $("#serie_guia_remitente").focus();
                $('#serie_guia_remitente').select();

            }
        });
        $("#serie_guia_remitente").on('keyup', function(e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                $("#numero_documento_guia_remitente").focus();
                $('#numero_documento_guia_remitente').select();

            }
        });

        $("#numero_documento_guia_remitente").on('keyup', function(e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                $("#cantidad").focus();
                $('#cantidad').select();

            }
        });
        $("#serie_guia_transportista").on('keyup', function(e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                $("#numero_documento_guia_transportista").focus();
                $('#numero_documento_guia_transportista').select();

            }
        });
        $("#numero_documento_guia_transportista").on('keyup', function(e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                $("#cantidad").focus();
                $('#cantidad').select();

            }
        });
        $("#cantidad").on('keyup', function(e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                $("#precio_unitario").focus();
                $('#precio_unitario').select();

            }
        });




    });
</script>
@endpush