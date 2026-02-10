<div>

    <div class="row">


        <div class="col-md-2" style="background: #f2f2f2;">
            <ul class="nav nav-tabs mt-4" style="border-bottom: none;">


                <li class="active">
                    <button type="button" class="btn apl-tp-link" wire:click="cambiarEstaEnOrdenCompra">
                        <i class="fas fa-fas fa-adjust mr-2"></i>Nuevo Ingreso</button>
                </li>

                <li class="apl-tp-item">
                    @if($modelId)
                    <button type="button" class="btn apl-tp-link btn-disabled" wire:click="cambiarEstaEnArticulosOrdenCompra">
                        <i class="fas fa-fas fa-adjust mr-2"></i>Articulos orden compra</button>
                    @else
                    <button type="button" class="btn apl-tp-link btn-disabled" wire:click="cambiarEstaEnArticulosOrdenCompra" disabled>
                        <i class="fas fa-fas fa-adjust mr-2"></i>Articulos orden compra</button>
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
                                    <button type="button" title="Cerrar" class="close" wire:click="cerrarFormulario">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <p><b>Proporciona información del nuevo ingreso</b><br><span>Información del ingreso.</span></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="numero_ingreso" style="margin-bottom: 0px;">N&uacute;mero de ingreso</label><br>
                                        <span class="small">Agregue el n&uacute;mero de ingreso </span>
                                        <input type="text" class="form-control apl-input-border" wire:model="numero_ingreso">
                                        @error('numero_ingreso')<span class="text-danger small">{{$message}}</span> @enderror
                                    </div>
                                </div>
                            </div>



                            <div class="row">
                                @if($modelId)

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="ordenCompraNumero" style="margin-bottom: 0px;">N&uacute;mero de orden compra</label><br>
                                        <span class="small">selecciono el n&uacute;mero de compra </span>
                                        <input type="text" class="form-control apl-input-border" wire:model="ordenCompraNumero" readonly>
                                        @error('ordenCompraNumero')<span class="text-danger small">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                @else
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="txt_proveedor" style="margin-bottom: 0px;">Orden de compra</label><br>
                                        <span class="small">Eligir la orden de compra. </span>
                                        <select class="form-control apl-input-border demo-default" id="orden_de_compras_id" wire:model="orden_de_compras_id" style="width: 100%;">

                                            <option value="">{{__('Selecciona una orden de compra')}}</option>
                                            @foreach($ordenDeCompras as $item)
                                            <option value="{{ $item->id }}">[{{$item->sucursal->nombre_sucursal}}] : {{ $item->numero_orden_compra }}</option>
                                            @endforeach
                                        </select>
                                        @error('orden_de_compras_id')<span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                @endif




                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="descripcion" class="mb-0">Descripción</label><br>
                                        <span class="small">Agregue los terminos de la entrega</span>
                                        <textarea class="form-control apl-input-border" id="descripcion" cols="30" rows="3" wire:model="descripcion"></textarea>
                                        @error('descripcion')<span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                            </div>



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

                            <div class="row">
                                <div class="col-md-12 mt-3">
                                    <button type="button" title="Cancelar" class="btn btn-default" wire:click="cerrarFormulario">
                                        Cancelar
                                    </button>
                                    @if($modelId)
                                    <button type="button" title="Actualizar" class="btn btn-primary mr-2 float-right " wire:keydown.enter="actualizar_RP" wire:click="actualizar_RP" wire:loading.attr="disabled">
                                        <div wire:loading.delay>
                                            <i class="fas fa-spinner fa-spin mr-2"></i>
                                        </div> 
                                        <i class="fas fa-save"></i>
                                        
                                        Actualizar
                                    </button>
                                    @else
                                    <button type="button" title="Guardar" class="btn btn-primary mr-2 float-right" wire:keydown.enter="guardar_RP" wire:click="guardar_RP" wire:loading.attr="disabled">
                                        <div wire:loading.delay>
                                            <i class="fas fa-spinner fa-spin mr-2"></i>
                                        </div> 
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
                                    <button type="button" title="Cerrar" class="close" wire:click="cerrarFormulario">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>


                            <!-- Tabla general de articulos orden de compra -->
                            @if($articuloGeneralOrdenCompra->isNotEmpty())
                            <div class="row">




                                <div class="col-md-12">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <p><b> Articulos orden de compra</b><br><span>Detalle informacion del art&iacute;culo como guia, cantidad,transportista, fecha y precio unitario.</span></p>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-12">


                                            <div class="card apl-border">
                                                <div class="card-body">
                                                    <div class="table-responsive">

                                                        <div class="row mb-2 float-righ">


                                                            <div class="col-md-5">
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <div class="input-group-text apl-input-search-icon"><i class="fas fa-search"></i></div>
                                                                    </div>
                                                                    <input type="text" class="form-control apl-input-border apl-input-search" id="apl-table-buscar" placeholder="Buscar por art&iacute;culo" wire:model.debounce.800ms="buscarArticuloOrdenCompra">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-7 float-right">
                                                                <div class="float-right">
                                                                    <button type="button" title="Item seleccionados" class="btn btn-default btn-sm apl-btn-border" disabled="true">
                                                                        {{count($selectedArticulosOrdenCompra)}} Seleccionados
                                                                    </button>

                                                                    <!-- <button type="button" title="Eliminar" class="btn btn-default btn-sm apl-btn-border" wire:click="eliminar_ARP" {{$estaActivadoEliminar}}>
                                                                                Eliminar
                                                                            </button> -->

                                                                    <a href="{{url('imprimir-ingreso',['mes'=>$modelId])}}" target="_blank" class="btn btn-secondary btn-sm apl-btn-border" title="Imprimir"><i class="fas fa fa-print"></i></a>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <table id="apl-table" class="table table-hover">
                                                            <thead>
                                                                <tr class="apl-table-header-tr">
                                                                    <!--<td class="d-none"></td>-->
                                                                    <!--  <td>
                                                                        <input type="checkbox" class="apl-border-checkbox" style="padding: .7rem;" wire:model="selectAllArticuloOrdenCompra">
                                                                    </td> -->
                                                                    <th class="text-center">C&oacute;digo</th>
                                                                    <th class="text-center">Art&iacute;culo</th>
                                                                    <th class="text-center">Unidad</th>
                                                                    <th class="text-center">Cantidad</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @if($articuloGeneralOrdenCompra->isNotEmpty())
                                                                @foreach ($articuloGeneralOrdenCompra as $item)

                                                                @if($modelArticuloRequemientoId==$item->id)
                                                                <tr class="apl-table-body-tr pointer bg-gray">
                                                                    @else
                                                                <tr class="apl-table-body-tr pointer">
                                                                    @endif
                                                                    <!--<td class="d-none"></td>-->
                                                                    <!--  <td>
                                                                        <input type="checkbox" class="apl-border-checkbox" style="padding: .7rem;" value="{{ $item->id }}" wire:click="cambiarEstadoBotonesOrdenCompra_ARP" wire:model="selectedArticulosOrdenCompra">
                                                                    </td> -->
                                                                    <td wire:click="editar_ArticuloPersonal({{ $item->id}})" class="text-center">{{ $item->articulo->codigo }}</td>
                                                                    <td wire:click="editar_ArticuloPersonal({{ $item->id}})" class="text-center"> {{ \App\Models\Util::getCantidadLetras($item->articulo->articulo,25)}}</td>
                                                                    <td wire:click="editar_ArticuloPersonal({{ $item->id}})" class="text-center">{{ $item->articulo->tipoUnidad->nombre }}</td>
                                                                    <td wire:click="editar_ArticuloPersonal({{ $item->id}})" class="text-center">{{ $item->calcularFaltaArticuloOrdenCompraRequerimientoPersonal($item->id,$orden_de_compras_id) }} de {{ $item->cantidad }}</td>
                                                                </tr>
                                                                @endforeach
                                                                @else
                                                                <tr>
                                                                    <td colspan="6" class="text-center">No hay resultados</td>
                                                                </tr>
                                                                @endif
                                                            </tbody>

                                                            <tfoot>
                                                                <tr>
                                                                    <th></th>
                                                                    <th></th>
                                                                    <th></th>

                                                                    <th class="text-center">Cantidad total {{$totalCantidadOrdenCompraGeneral}}</th>
                                                                </tr>

                                                            </tfoot>
                                                        </table>
                                                        {{ $articuloGeneralOrdenCompra->links()}}
                                                    </div>
                                                </div>
                                            </div>

                                        </div>


                                    </div>
                                </div>
                            </div>


                            @else
                            <div class="row">
                                <div class="col-12 text-center">
                                    <center><img src="{{ asset('dist/img/empty.png') }}" alt="Imagen" width="550"></center>
                                    <h4 class="text-muted">No hay resultados</h4>
                                </div>
                            </div>
                            @endif
                            <!-- Tabla general de articulos orden de compra -->

                            <div class="row">
                                <div class="col-md-12">
                                    <p><b>Proporciona información de los articulos de Orden de Compra</b><br><span>Edite la informaci&oacute;n si es necesario.</span></p>
                                </div>
                            </div>

                            <div class="{{$estaOcultoFormularioArticuloOrdenCompra}}">






                                <div class="row">

                                    <div class="col-md-12">

                                        <div class="card apl-border">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="tipo_documento" style="margin-bottom: 0px;">Tipo documento</label><br>
                                                            <span class="small">Seleccione el tipo documento </span>
                                                            <select class="form-control apl-input-border" wire:model="tipo_documento" id="tipo_documento">
                                                                <option value="">Seleccione el tipo de documento </option>
                                                                @foreach($tipo_docuento_opciones as $item)
                                                                <option value="{{ $item }}">{{ $item }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('tipo_documento')<span class="text-danger">{{$message}}</span> @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="serie_documento" style="margin-bottom: 0px;">Series</label><br>
                                                            <span class="small">Serie </span>
                                                            <input type="text" class="form-control apl-input-border" id="serie_documento" wire:model="serie_documento">
                                                            @error('serie_documento')<span class="text-danger small">{{$message}}</span> @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="numero_documento" style="margin-bottom: 0px;">N&uacute;mero de documento</label><br>
                                                            <span class="small">Agregue el n&uacute;mero de documento </span>
                                                            <input type="text" class="form-control apl-input-border" id="numero_documento" wire:model="numero_documento">
                                                            @error('numero_documento')<span class="text-danger small">{{$message}}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="serie_guia_remitente" style="margin-bottom: 0px;">Guia Remitente</label><br>
                                                            <span class="small">serie </span>
                                                            <input type="text" class="form-control apl-input-border" id="serie_guia_remitente" wire:model="serie_guia_remitente">
                                                            @error('serie_guia_remitente')<span class="text-danger small">{{$message}}</span> @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="numero_documento_guia_remitente" style="margin-bottom: 0px;">Guia Remitente </label><br>
                                                            <span class="small">N&uacute;mero de documento</span>
                                                            <input type="text" class="form-control apl-input-border" id="numero_documento_guia_remitente" wire:model="numero_documento_guia_remitente">
                                                            @error('numero_documento_guia_remitente')<span class="text-danger small">{{$message}}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="serie_guia_transportista" style="margin-bottom: 0px;">Guia Transportista </label><br>
                                                            <span class="small">serie </span>
                                                            <input type="text" class="form-control apl-input-border" id="serie_guia_transportista" wire:model="serie_guia_transportista">
                                                            @error('serie_guia_transportista')<span class="text-danger small">{{$message}}</span> @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="numero_documento_guia_transportista" style="margin-bottom: 0px;">Guia Transportista</label><br>
                                                            <span class="small">N&uacute;mero de documento</span>
                                                            <input type="text" class="form-control apl-input-border" id="numero_documento_guia_transportista" wire:model="numero_documento_guia_transportista">
                                                            @error('numero_documento_guia_transportista')<span class="text-danger small">{{$message}}</span> @enderror
                                                        </div>
                                                    </div>

                                         <!--            <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="cantidad" style="margin-bottom: 0px;">Cantidad</label><br>
                                                            <span class="small">Agregue la cantidad del articulo</span>
                                                            <input type="number" class="form-control apl-input-border" id="cantidad" wire:model="cantidad">
                                                            @error('cantidad')<span class="text-danger small">{{$message}}</span> @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="precio_unitario" style="margin-bottom: 0px;">Precio unitario</label><br>
                                                            <span class="small">Agregue la precio unitario.</span>
                                                            @if($modelArticuloOrdenCompraId)
                                                            <input type="number" class="form-control apl-input-border" id="precio_unitario" wire:model="precio_unitario">
                                                            @else
                                                            <input type="number" class="form-control apl-input-border" id="precio_unitario" wire:model="precio_unitario">
                                                            @endif
                                                            @error('precio_unitario')<span class="text-danger small">{{$message}}</span> @enderror
                                                        </div>
                                                    </div> -->

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="transportes_id" style="margin-bottom: 0px;">Transportista</label><br>
                                                            <span class="small">Eligir el transportista. </span>
                                                            <select class="form-control apl-input-border demo-default" id="transportes_id" name="transportes_id" wire:model="transportes_id" style="width: 100%;">
                                                                <option value="">{{__('Selecciona proveedor')}}</option>
                                                                @foreach($transportistas as $item)
                                                                <option value="{{ $item->id }}">{{ $item->razon_social }}: [{{ $item->ruc }}]</option>
                                                                @endforeach
                                                            </select>
                                                            @error('transportes_id')<span class="text-danger">{{$message}}</span> @enderror
                                                        </div>
                                                    </div>


                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="fecha_traslado" style="margin-bottom: 0px;">Fecha de traslado</label><br>
                                                            <span class="small">Agregue fecha de traslado</span>
                                                            <input type="date" class="form-control apl-input-border" id="fecha_traslado" wire:model="fecha_traslado">
                                                            @error('fecha_traslado')<span class="text-danger small">{{$message}}</span> @enderror
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="fecha_ingreso" style="margin-bottom: 0px;">Fecha de ingreso</label><br>
                                                            <span class="small">Agregue la fecha de ingreso</span>
                                                            <input type="datetime-local" class="form-control apl-input-border" id="fecha_ingreso" wire:model="fecha_ingreso" wire:keydown.enter="actualizar_ARP">
                                                            @error('fecha_ingreso')<span class="text-danger small">{{$message}}</span> @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mt-3 mb-3">

                                                        @if($modelArticuloOrdenCompraId)
                                                        <button type="button" title="Actualizar" class="btn btn-primary mr-2 float-right " wire:click="actualizar_ARP" wire:loading.attr="disabled">
                                                            <div wire:loading.delay>
                                                                <i class="fas fa-spinner fa-spin mr-2"></i>
                                                            </div>
                                                            <i class="fas fa-save"></i>


                                                            Actualizar
                                                        </button>

                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>





                                </div>

                            </div>

                            <!-- table de sub articuslo -->

                            @if($articuloOrdenCompra->isNotEmpty())
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card apl-border">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <!--  <div class="col-md-3">
                                                    <div class="form-group">
                                                        <select class="form-control apl-input-border" wire:model="perPageArticuloOrdenCompra">
                                                            @foreach($opciones_perPage as $item)
                                                            <option value="{{ $item }}">{{ $item }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('perPage')<span class="text-danger">{{$message}}</span> @enderror
                                                    </div>
                                                </div> -->

                                                <table id="apl-table" class="table table-hover">
                                                    <thead>
                                                        <tr class="apl-table-header-tr">
                                                            <!--<td class="d-none"></td>-->

                                                            <th>C&oacute;digo</th>
                                                            <th class="text-center">Art&iacute;culo</th>
                                                            <th class="text-center">Unidad</th>
                                                            <th class="text-center">Cantidad</th>
                                                            <th class="text-center">Precio unitario</th>
                                                            <th class="text-center">Precio total</th>

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

                                                            <td wire:click="editar_ARP({{ $item->id}})" class="text-center">{{ $item->articuloRequerimiento->articulo->codigo }}</td>
                                                            <td wire:click="editar_ARP({{ $item->id}})" class="text-center"> {{ \App\Models\Util::getCantidadLetras($item->articuloRequerimiento->articulo->articulo,25)}}</td>
                                                            <td wire:click="editar_ARP({{ $item->id}})" class="text-center">{{ $item->articuloRequerimiento->articulo->tipoUnidad->nombre }}</td>
                                                            <td wire:click="editar_ARP({{ $item->id}})" class="text-center">{{ $item->cantidad }}</td>
                                                            <td wire:click="editar_ARP({{ $item->id}})" class="text-center">S/.{{ $item->darFormatoMoneda($item->precio_unitario) }}</td>
                                                            <td wire:click="editar_ARP({{ $item->id}})" class="text-center">S/.{{ $item->calcularPrecioTotal($item->precio_unitario,$item->cantidad) }}</td>
                                                        </tr>
                                                        @endforeach
                                                        @else
                                                        <tr>
                                                            <td colspan="6" class="text-center">No hay resultados</td>
                                                        </tr>
                                                        @endif
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th></th>
                                                            <th></th>
                                                            <th colspan="2">Cantidad total {{$totalCantidadOrdenCompraSubGeneral}} de {{$totalCantidadOrdenCompraSubGeneralArticuloRequerimiento}}</th>
                                                            <th></th>
                                                            <th>Precio total S/{{$totalPrecioOrdenCompraSubGeneral}}</th>
                                                        </tr>

                                                    </tfoot>
                                                </table>
                                                {{ $articuloOrdenCompra->links()}}
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>

                            @else
                            <div class="row">
                                <div class="col-12 text-center">
                                    <center><img src="{{ asset('dist/img/empty.png') }}" alt="Imagen" width="200" height="200"></center>
                                    <h4 class="text-muted">No hay resultados</h4>
                                </div>
                            </div>
                            @endif

                            <!-- table de sub articuslo -->


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
                                <div class="card apl-border">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <b>{{$articuloRequerimientosPersonal->count()}}</b><br>
                                                <font class="apl-text-gray">Requerimiento personal</font>
                                            </div>

                                            <div class="col-md-6">

                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3">

                                            </div>

                                            <div class="col-md-9">
                                                <div class="float-right">
                                                    <button type="button" title="Item seleccionados" class="btn btn-default btn-sm apl-btn-border" disabled="true">
                                                        {{count($selectedArticulosRequerimientoPersonal)}} Seleccionados
                                                    </button>

                                                    <button type="button" class="btn btn-default btn-sm apl-btn-border" wire:click="enviarArticuloRequerimientoParaOrdenCompra" {{$estaActivadoEnviar}}>
                                                        Enviar
                                                    </button>



                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default btn-sm apl-btn-border">
                                                            <i class="fas fa-bars"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($articuloRequerimientosPersonal->isNotEmpty())
                            <div class="col-md-12">

                                <div class="card apl-border">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="apl-table" class="table table-hover">
                                                <thead>
                                                    <tr class="apl-table-header-tr">
                                                        <!--<td class="d-none"></td>-->
                                                        <td>
                                                            <input type="checkbox" class="apl-border-checkbox" style="padding: .7rem;" wire:model="selectAllArticuloRequerimiento">
                                                        </td>
                                                        <td>C&oacute;digo</td>
                                                        <td>Art&iacute;culo</td>
                                                        <td>Unidad</td>
                                                        <td>Cantidad</td>
                                                        <td>Opcion</td>
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
                                                        <td wire:click="editar_ARP({{ $item->id}})">{{ $item->articulo->codigo }}</td>
                                                        <td wire:click="editar_ARP({{ $item->id}})">{{ $item->articulo->articulo }}</td>
                                                        <td wire:click="editar_ARP({{ $item->id}})">{{ $item->articulo->tipoUnidad->nombre }}</td>
                                                        <td wire:click="editar_ARP({{ $item->id}})">{{ $item->articulo->cantidad }}</td>
                                                        <td>
                                                            <button type="button" title="Enviar al siguiente formulario" class="btn btn-primary btn-sm apl-btn-border" wire:click="enviarArticuloRequerimientoParaOrdenCompraItem({{ $item->id}})">
                                                                Enviar
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    @else
                                                    <tr>
                                                        <td colspan="6" class="text-center">No hay resultados</td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                            {{ $articuloRequerimientosPersonal->links()}}
                                        </div>
                                    </div>
                                </div>

                            </div>

                            @else
                            <div class="col-md-12">
                                <div class="col-12 text-center">
                                    <center><img src="{{ asset('dist/img/empty.png') }}" alt="Imagen" width="550"></center>
                                    <h4 class="text-muted">No hay resultados</h4>
                                </div>
                            </div>
                            @endif
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
        window.initSelectTransporteDrop = () => {
            $('#transportes_id').select2({
                placeholder: '{{ __("Seleccione el transportista") }}',
                allowClear: true
            });
        }
        initSelectTransporteDrop();
        $('#transportes_id').on('change', function(e) {
            livewire.emit('selectedTransporteItem', e.target.value)
        });
        window.livewire.on('select2Transporte', () => {
            initSelectTransporteDrop();
        });

        /* SELECT 2 PARA CATEGORIA PRODUCTO */

        /* SELECT 2 PARA CATEGORIA PRODUCTO */
        window.initSelectTransporteRucDrop = () => {
            $('#transportes_ruc_id').select2({
                placeholder: '{{ __("Seleccione el ruc ") }}',
                allowClear: true
            });
        }
        initSelectTransporteRucDrop();
        $('#transportes_ruc_id').on('change', function(e) {
            livewire.emit('selectedTransporteRucItem', e.target.value)
        });
        window.livewire.on('select2TransporteRuc', () => {
            initSelectTransporteRucDrop();
        });

        /* SELECT 2 PARA CATEGORIA PRODUCTO */

        /* SELECT 2 PARA CATEGORIA PRODUCTO */
        window.initSelectOrdenDeCompraDrop = () => {
            $('#orden_de_compras_id').select2({
                placeholder: '{{ __("Seleccione una orden de compra") }}',
                allowClear: true
            });
        }
        initSelectOrdenDeCompraDrop();
        $('#orden_de_compras_id').on('change', function(e) {
            livewire.emit('selectedOrdenDeCompraItem', e.target.value)
        });
        window.livewire.on('select2OrdenDeCompra', () => {
            initSelectOrdenDeCompraDrop();
        });

        /* SELECT 2 PARA CATEGORIA PRODUCTO */

        /* SELECT 2 PARA TIPO UNIDAD */
        window.initSelectTipoUnidadDrop = () => {
            $('#tipo_unidads_id').select2({
                placeholder: '{{ __("Seleccione tipo unidad") }}',
                allowClear: true
            });
        }
        initSelectTipoUnidadDrop();
        $('#tipo_unidads_id').on('change', function(e) {
            livewire.emit('selectedTipoUnidadItem', e.target.value)
        });
        window.livewire.on('select2TipoUnidad', () => {
            initSelectTipoUnidadDrop();
        });

        /* SELECT 2 PARA TIPO UNIDAD */



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
                $("#serie_guia_transportista").focus();
                $('#serie_guia_transportista').select();

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
        $("#precio_unitario").on('keyup', function(e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                $("#transportes_id").focus();
                $('#transportes_id').select();

            }
        });
        $("#transportes_id").on('keyup', function(e) {
            alert("transportes_id");
            if (e.key === 'Enter' || e.keyCode === 13) {
                alert("transportes_id");
                $("#fecha_traslado").focus();
                $('#fecha_traslado').select();

            }
        });

        $("#fecha_traslado").on('keyup', function(e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                $("#fecha_ingreso").focus();
                $('#fecha_ingreso').select();

            }
        });

    });
</script>
@endpush