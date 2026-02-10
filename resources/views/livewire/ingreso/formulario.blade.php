<div>

    <div class="row">


        <div class="col-md-2" style="background: #f2f2f2;">
            <ul class="nav nav-tabs mt-4" style="border-bottom: none;">


                <li class="active">
                    <button type="button" class="btn apl-tp-link" wire:click="cambiarEstaEnOrdenCompra">
                        <i class="fas fa-fas fa-adjust mr-2"></i>Ingreso</button>
                </li>

                <li class="apl-tp-item float-right">
                    @if($modelId)
                    <button type="button" class="btn apl-tp-link btn-disabled text-start" wire:click="cambiarEstaEnArticulosOrdenCompra">
                        <i class="fas fa-fas fa-adjust mr-2"></i>Articulos orden compra</button>
                    @else
                    <button type="button" class="btn apl-tp-link btn-disabled text-start" wire:click="cambiarEstaEnArticulosOrdenCompra" disabled>
                        <i class="fas fa-fas fa-adjust mr-2"></i>Articulos orden compra</button>
                    @endif

                    @if($modelId)
                    <button type="button" class="btn apl-tp-link btn-disabled text-start w-100" wire:click="cambiarEstaEnArticulosIngreso">
                        <i class="fas fa-fas fa-adjust mr-2"></i>Articulos ingresados</button>
                    @else
                    <button type="button" class="btn apl-tp-link btn-disabled text-start" wire:click="cambiarEstaEnArticulosIngreso" disabled>
                        <i class="fas fa-fas fa-adjust mr-2"></i>Articulos ingresados</button>
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
                                        <span class="small">Elegir la orden de compra. </span>
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




                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="descripcion" class="mb-0">Descripción</label><br>
                                        <span class="small">Agregue los terminos de la entrega</span>
                                        <textarea class="form-control apl-input-border" id="descripcion" cols="30" rows="2" wire:model="descripcion"></textarea>
                                        @error('descripcion')<span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>





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

                            </div>




                            <div class="row">
                                <div class="col-md-12 mt-3">
                                    <button type="button" title="Cancelar" class="btn btn-secondary" wire:click="cerrarFormulario">
                                        <i class="fas fa-ban"></i>
                                        Cancelar
                                    </button>
                                    @if($modelId)
                                    <button type="button" title="Actualizar" class="btn btn-primary mr-2 float-right " wire:keydown.enter="actualizarIngreso" wire:click="actualizarIngreso" wire:loading.attr="disabled">
                                        <div wire:loading.delay>
                                            <i class="fas fa-spinner fa-spin mr-2"></i>
                                        </div>
                                        <i class="fas fa-save"></i>

                                        Actualizar
                                    </button>
                                    @else
                                    <button type="button" title="Guardar" class="btn btn-primary mr-2 float-right" wire:keydown.enter="guardarIngreso" wire:click="guardarIngreso" wire:loading.attr="disabled">
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



                            <div class="row">

                                <div class="col-md-12">
                                    <p><b> Art&iacute;culos orden de compra</b><br><span>Detalle informacion del art&iacute;culo como guia, cantidad,transportista, fecha y precio unitario.</span></p>
                                </div>
                                <div class="col-md-12">


                                    <div class="card apl-border">
                                        <div class="card-body">
                                            <div class="table-responsive">


                                                <div class="row">

                                                    <!--      <div class="col-md-2">
                                                        <div class="form-group">
                                                            <select class="form-control apl-input-border" wire:model="perPageArticuloOrdenCompra">
                                                                @foreach($opciones_perPage as $item)
                                                                <option value="{{ $item }}">{{ $item }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('perPageArticuloOrdenCompra')<span class="text-danger">{{$message}}</span> @enderror
                                                        </div>
                                                    </div> -->

                                                    <div class="col-md-12">
                                                        <!-- table de sub articuslo -->



                                                        <table id="apl-table" class="table table-hover">
                                                            <thead>
                                                                <tr class="apl-table-header-tr">
                                                                    <!--<td class="d-none"></td>-->

                                                                    <th>C&oacute;digo</th>
                                                                    <th class="text-center">Art&iacute;culo</th>
                                                                    <th class="text-center">Unidad</th>
                                                                    <th class="text-center">Cantidad</th>
                                                                    <th class="text-center">S/ Unitario</th>
                                                                    <th class="text-center">S/ Total</th>
                                                                    <th class="text-center">Estado</th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>


                                                                @foreach ($articuloOrdenCompra as $item)


                                                                @if($modelArticuloOrdenCompraId==$item->id)


                                                                <tr class="apl-table-body-tr pointer bg-gray">
                                                                    @else

                                                                <tr class="apl-table-body-tr pointer">
                                                                    @endif
                                                                    <!--<td class="d-none"></td>-->

                                                                    <td wire:click="editarArticuloOrdenCompra({{ $item->id}})" class="text-center">{{ $item->articuloRequerimiento->articuloSolicitudCotizacion->articuloRequerimiento->articulo->codigo }}</td>
                                                                    <td wire:click="editarArticuloOrdenCompra({{ $item->id}})" class="text-center"> {{ \App\Models\Util::getCantidadLetras($item->articuloRequerimiento->articuloSolicitudCotizacion->articuloRequerimiento->articulo->articulo,25)}}</td>
                                                                    <td wire:click="editarArticuloOrdenCompra({{ $item->id}})" class="text-center">{{ $item->articuloRequerimiento->articuloSolicitudCotizacion->articuloRequerimiento->articulo->tipoUnidad->nombre }}</td>
                                                                    <td wire:click="editarArticuloOrdenCompra({{ $item->id}})" class="text-center">{{ $item->cantidad }}</td>
                                                                    <td wire:click="editarArticuloOrdenCompra({{ $item->id}})" class="text-center">S/.{{ $item->darFormatoMoneda($item->precio_unitario) }}</td>
                                                                    <td wire:click="editarArticuloOrdenCompra({{ $item->id}})" class="text-center">S/.{{ $item->calcularPrecioTotal($item->precio_unitario,$item->cantidad) }}</td>
                                                                    @if(\App\Models\Util::estaAgregaEnArticuloOrdenCompraElArticuloIngreso($listaArticulosOridenCompra,$item->id)==true)

                                                                    <td wire:click="editarArticuloOrdenCompra({{ $item->id}})" class="text-center text-green">Agregado</td>
                                                                    @else

                                                                    <td wire:click="editarArticuloOrdenCompra({{ $item->id}})" class="text-center text-red">Por Agregar</td>
                                                                    @endif
                                                                </tr>
                                                                @endforeach

                                                            </tbody>

                                                        </table>
                                                        {{ $articuloOrdenCompra->links()}}



                                                    </div>

                                                </div>





                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>




                            <!-- Tabla general de articulos orden de compra -->




                            <div class="{{$estaOcultoFormularioArticuloOrdenCompra}}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p><b>Proporciona información de los articulos de Orden de Compra</b><br><span>Edite la informaci&oacute;n si es necesario.</span></p>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="col-md-12">

                                                <div class="card apl-border">
                                                    <div class="card-body">

                                                        <div class="row">
                                                            <div class="col-md-3">
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

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="serie_documento" style="margin-bottom: 0px;">Series</label><br>
                                                                    <span class="small">Serie </span>
                                                                    <input type="text" class="form-control apl-input-border" id="serie_documento" wire:model="serie_documento">
                                                                    @error('serie_documento')<span class="text-danger small">{{$message}}</span> @enderror
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="numero_documento" style="margin-bottom: 0px;">N&uacute;mero de documento</label><br>
                                                                    <span class="small">Agregue el n&uacute;mero de documento </span>
                                                                    <input type="text" class="form-control apl-input-border" id="numero_documento" wire:model="numero_documento">
                                                                    @error('numero_documento')<span class="text-danger small">{{$message}}</span> @enderror
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
                                                                    <label for="numero_documento_guia_transportista" style="margin-bottom: 0px;">N&uacute;mero Transportista</label><br>
                                                                    <span class="small">N&uacute;mero de documento</span>
                                                                    <input type="text" class="form-control apl-input-border" id="numero_documento_guia_transportista" wire:model="numero_documento_guia_transportista">
                                                                    @error('numero_documento_guia_transportista')<span class="text-danger small">{{$message}}</span> @enderror
                                                                </div>
                                                            </div>




                                                            <div class="col-md-4">
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

                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="cantidad" style="margin-bottom: 0px;">Cantidad</label><br>
                                                                    <span class="small">Art&iacute;culo</span>
                                                                    <input type="number" class="form-control apl-input-border" id="cantidad" wire:model="cantidad">
                                                                    @error('cantidad')<span class="text-danger small">{{$message}}</span> @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="precio_unitario" style="margin-bottom: 0px;">Precio unitario</label><br>
                                                                    <span class="small">Precio Unitario</span>
                                                                    <input type="number" class="form-control apl-input-border" id="precio_unitario" wire:model="precio_unitario">
                                                                    @error('precio_unitario')<span class="text-danger small">{{$message}}</span> @enderror
                                                                </div>
                                                            </div>


                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="fecha_ingreso" style="margin-bottom: 0px;">Fecha de ingreso</label><br>
                                                                    <span class="small">Agregue la fecha de ingreso</span>
                                                                    <input type="datetime-local" class="form-control apl-input-border" id="fecha_ingreso" wire:model="fecha_ingreso">
                                                                    @error('fecha_ingreso')<span class="text-danger small">{{$message}}</span> @enderror
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="col-md-12 mt-3 mb-3">

                                                            <button type="button" title="Actualizar" class="btn btn-primary mr-2 float-right " wire:click="agregarArticuloIngreso" wire:loading.attr="disabled">
                                                                <div wire:loading.delay>
                                                                    <i class="fas fa-spinner fa-spin mr-2"></i>
                                                                </div>
                                                                <i class="fas fa-save"></i>
                                                                Agregar
                                                            </button>

                                                            <button type="button" title="Actualizar" class="btn btn-secondary mr-2 float-right " wire:click="resetVars_ARP" wire:loading.attr="disabled">
                                                                <div wire:loading.delay>
                                                                    <i class="fas fa-spinner fa-spin mr-2"></i>

                                                                </div>
                                                                <i class="fas fa-ban"></i>


                                                                Cancelar
                                                            </button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                            </div>




                        </div>

                    </div>
                    <div class="{{$estaIngreso}}" id="tp2">


                        <div class="apl-mdl-formulario " id="apl-mdl-formulario">
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" title="Cerrar" class="close" wire:click="cerrarFormulario">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>


                            <!-- Tabla general de articulos orden de compra -->
                            @if($articuloIngresos->isNotEmpty())
                            <div class="row">

                                <div class="col-md-11">
                                    <p><b> Art&iacute;culos ingresados</b><br><span>Elimine los articulos que desea modificar otra vez.</span></p>
                                </div>
                                <div class="col-md-1">
                                    <a href="{{url('imprimir-ingreso',['mes'=>$modelId])}}" target="_blank" class="btn btn-secondary btn-sm apl-btn-border" title="Imprimir"><i class="fas fa fa-print"></i></a>

                                </div>

                                <div class="col-md-12">


                                    <div class="card apl-border">
                                        <div class="card-body">
                                            <div class="table-responsive">


                                                <!-- table de sub articuslo -->

                                                @if($articuloIngresos->isNotEmpty())
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
                                                            <th class="text-center">Opci&oacute;n</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if($articuloIngresos->isNotEmpty())
                                                        @foreach ($articuloIngresos as $item)

                                                        @if($modelIdArticuloIngreso==$item->id)

                                                        <tr class="apl-table-body-tr pointer bg-gray">
                                                            @else

                                                        <tr class="apl-table-body-tr pointer">
                                                            @endif

                                                            <!--<td class="d-none"></td>-->

                                                            <td class="text-center">{{ $item->articuloOrdenCompra->articuloRequerimiento->articuloSolicitudCotizacion->articuloRequerimiento->articulo->codigo }}</td>
                                                            <td class="text-center"> {{ \App\Models\Util::getCantidadLetras($item->articuloOrdenCompra->articuloRequerimiento->articuloSolicitudCotizacion->articuloRequerimiento->articulo->articulo,25)}}</td>
                                                            <td class="text-center">{{ $item->articuloOrdenCompra->articuloRequerimiento->articuloSolicitudCotizacion->articuloRequerimiento->articulo->tipoUnidad->nombre }}</td>
                                                            <td class="text-center">{{ $item->cantidad }}</td>
                                                            <td class="text-center">S/.{{ $item->darFormatoMoneda($item->precio_unitario) }}</td>
                                                            <td class="text-center">S/.{{ $item->calcularPrecioTotal($item->precio_unitario,$item->cantidad) }}</td>
                                                            <td class="text-center">
                                                                <button type="button" title="Eliminar" class="text-red" wire:click="eliminar_ARP({{$item->id}})">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                                <button type="button" title="Editar" class="text-primary" wire:click="editarArticuloIngreso({{$item->id}})">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>

                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        @else
                                                        <tr>
                                                            <td colspan="7" class="text-center">No hay resultados</td>
                                                        </tr>
                                                        @endif
                                                    </tbody>

                                                </table>


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




                        </div>

                        <div class="{{$estaOcultoFormularioArticuloIngreso}}">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p><b>Proporciona información de los articulos de Orden de Compra</b><br><span>Edite la informaci&oacute;n si es necesario.</span></p>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="col-md-12">

                                            <div class="card apl-border">
                                                <div class="card-body">
                                                    @include('componentes.datos-articulo-ingreso')

                                                    <div class="col-md-12 mt-3 mb-3">

                                                        <button type="button" title="Actualizar" class="btn btn-primary mr-2 float-right " wire:click="actualizarArticuloIngreso" wire:loading.attr="disabled">
                                                            <div wire:loading.delay>
                                                                <i class="fas fa-spinner fa-spin mr-2"></i>
                                                            </div>
                                                            <i class="fas fa-save"></i>


                                                            Actualizar
                                                        </button>

                                                        <button type="button" title="Actualizar" class="btn btn-secondary mr-2 float-right " wire:click="resetArticuloIngreso" wire:loading.attr="disabled">
                                                            <div wire:loading.delay>
                                                                <i class="fas fa-spinner fa-spin mr-2"></i>

                                                            </div>
                                                            <i class="fas fa-ban"></i>


                                                            Cancelar
                                                        </button>


                                                    </div>

                                                </div>
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








        /* ===================OPCIONE==================== */
        window.livewire.on('refresacarComponentes', () => {


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



        });



    });
</script>
@endpush