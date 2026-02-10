<div>

    <div class="row">


        <div class="col-md-2" style="background: #f2f2f2;">
            <ul class="nav nav-tabs mt-4 " style="border-bottom: none;">


                <li class="active">
                    <button type="button" class="btn apl-tp-link" wire:click="cambiarEstaEnOrdenCompra">
                        <i class="fas fa-fas fa-adjust mr-2"></i>Solicitud cotizaci&oacute;n</button>
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
                        <i class="fas fa-fas fa-adjust mr-2"></i>Artículos solicitud de cotizaci&oacute;n</button>
                    @else
                    <button type="button" class="btn apl-tp-link btn-disabled" wire:click="cambiarEstaEnArticulosOrdenCompra" disabled>
                        <i class="fas fa-fas fa-adjust mr-2"></i>Artículos solicitud de cotizaci&oacute;n</button>
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
                                    <p><b> Articulos de solicitud de cotizaci&oacute;n</b><br><span>Detalle informacion del art&iacute;culo como guia, cantidad, precio unitario.</span></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="numero_solicitud_cotizacion" style="margin-bottom: 0px;">N&uacute;mero de solicitud</label><br>
                                        <span class="small">Agregue el n&uacute;mero de solicitud </span>
                                        <input type="text" class="form-control apl-input-border" wire:model="numero_solicitud_cotizacion">
                                        @error('numero_solicitud_cotizacion')<span class="text-danger small">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="numero_cotizacion" style="margin-bottom: 0px;">N&uacute;mero de cotizaci&oacute;n</label><br>
                                        <span class="small">Agregue el n&uacute;mero de cotizaci&oacute;n </span>
                                        <input type="text" class="form-control apl-input-border" wire:model="numero_cotizacion">
                                        @error('numero_cotizacion')<span class="text-danger small">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fecha_solicitud" style="margin-bottom: 0px;">Fecha requerimiento </label><br>
                                        <span class="small">Agregue fecha de requerimiento </span>
                                        <input type="date" class="form-control apl-input-border" wire:model="fecha_solicitud">
                                        @error('fecha_solicitud')<span class="text-danger small">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                
                                @if($modelId)

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="numero_requerimiento_compras" style="margin-bottom: 0px;">N&uacute;mero de requerimiento</label><br>
                                        <span class="small">Agregue el n&uacute;mero de requerimiento </span>
                                        <input type="text" class="form-control apl-input-border" wire:model="numero_requerimiento_compras" readonly>
                                        @error('numero_requerimiento_compras')<span class="text-danger small">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                @else

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="txt_proveedor" style="margin-bottom: 0px;">Requerimiento de compras</label><br>
                                        <span class="small">Seleccione el Nº de requerimeinto de compras.</span>


                                        <select class="form-control apl-input-border demo-default" id="requerimiento_compras_id" wire:model="requerimiento_compras_id" style="width: 100%;">


                                            <option value="">{{__('Selecciona proveedor')}}</option>
                                            @foreach($modeloRequerimientoCompras as $item)
                                            <option value="{{ $item->id }}"> [ {{$item->sucursal->nombre_sucursal}}] : Requerimiento {{ $item->numero_requerimiento_compra }} </option>
                                            @endforeach
                                        </select>
                                        @error('requerimiento_compras_id')<span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                @endif

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="proveedors_id" style="margin-bottom: 0px;">Proveedor</label><br>
                                        <span class="small">Seleccione el proveedor para la orden de compra.</span>
                                        <select class="form-control apl-input-border demo-default" id="proveedors_id" wire:model="proveedors_id" style="width: 100%;">
                                            <option value="">{{__('Selecciona proveedor')}}</option>
                                            @foreach($proveedores as $item)
                                            <option value="{{ $item->id }}">{{ $item->razon_social }}</option>
                                            @endforeach
                                        </select>
                                        @error('proveedors_id')<span class="text-danger">{{$message}}</span> @enderror
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

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="descripcion_solicitamos" class="mb-0">Descripci&oacute;n de solicitamos</label><br>
                                        <span class="small">Agregue una descripci&oacute;n de solicitamos</span>
                                        <textarea class="form-control apl-input-border" id="descripcion_solicitamos" cols="30" rows="2" wire:model="descripcion_solicitamos"></textarea>
                                        @error('descripcion_solicitamos')<span class="text-danger">{{$message}}</span> @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="descripcion" class="mb-0">Direcci&oacute;n de entrega zona</label><br>
                                        <span class="small">Agregue una direcci&oacute;n de entrega zona</span>
                                        <textarea class="form-control apl-input-border" id="descripcion" cols="30" rows="2" wire:model="descripcion"></textarea>
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
                                <p><b>Seleccione los articulos de la solicitud de cotizaci&oacute;n</b></p>
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
                                                    <div class="row ">


                                                        <div class="col-md-12">
                                                            <div class="float-right">
                                                                <button type="button" title="Item seleccionados" class="btn btn-default btn-sm apl-btn-border" disabled="true">
                                                                    {{count($selectedArticulosOrdenCompra)}} Seleccionados
                                                                </button>

                                                                <button type="button" title="Eliminar" class="btn btn-danger btn-sm apl-btn-border" wire:click="eliminar_ARP" {{$estaActivadoEliminar}}>
                                                                    Eliminar
                                                                </button>

                                                                <a href="{{url('imprimir-solicitud-cotizacion',['mes'=>$modelId])}}" target="_blank" class="btn btn-secondary btn-sm apl-btn-border" title="Imprimir todos los art&iacute;culos agregados a solicitud de cotizaci&oacute;n"><i class="fas fa fa-print"></i></a>

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
                                                    @if($articulosGeneralRequerimientoCompra->isNotEmpty())
                                                    @foreach ($articulosGeneralRequerimientoCompra as $item)


                                                    @if($item->id==$articuloRequerimientoPersonal)


                                                    <tr class="apl-table-body-tr pointer bg-gray ">

                                                        @else

                                                    <tr class="apl-table-body-tr pointer">
                                                        @endif
                                                        <!--<td class="d-none"></td>-->
                                                        <td>
                                                            <input type="checkbox" class="apl-border-checkbox" style="padding: .7rem;" value="{{ $item->id }}" wire:click="cambiarEstadoBotonesOrdenCompra_ARP" wire:model="selectedArticulosOrdenCompra">
                                                        </td>
                                                        <td class="text-center">{{ $item->articuloRequerimiento->articulo->codigo }}</td>
                                                        <td class="text-center">{{ \App\Models\Util::getCantidadLetras($item->articuloRequerimiento->articulo->articulo,25)}} </td>
                                                        <td class="text-center">{{ $item->articuloRequerimiento->articulo->tipoUnidad->nombre }}</td>
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
                                            {{ $articulosGeneralRequerimientoCompra->links()}}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>



                        <!-- Tabla ################################### -->


                        <div class="{{$estaOcultoFormularioArticuloOrdenCompra}}">

                            <div class="row">
                                <div class="col-md-12">
                                    <p><b>Detalle de requerimiento de art&iacute;culos de solicitud de cotizaci&oacute;n</b><br><span>Ingrese la cantidad.</span></p>
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


                                    @if($articuloOrdenCompra->isNotEmpty())
                                    <div class="row">
                                        <div class="col-md-12">

                                            <p><b>Art&iacute;culos agregados</b><br><span>Edite, elimine art&iacute;culo agregado a solicitud de cotizaci&oacute;n.</span></p>

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

                                                            <td class="text-center">{{ $item->articuloSolicitudCotizacion->articuloRequerimiento->articulo->codigo }}</td>
                                                            <td class="text-center"> {{ \App\Models\Util::getCantidadLetras($item->articuloSolicitudCotizacion->articuloRequerimiento->articulo->articulo,25)}}</td>
                                                            <td class="text-center">{{ $item->articuloSolicitudCotizacion->articuloRequerimiento->articulo->tipoUnidad->nombre }}</td>
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
                                                            <td colspan="6" class="text-center">No hay resultados</td>
                                                        </tr>
                                                        @endif
                                                    </tbody>

                                                </table>

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
                                    <p><b>Art&iacute;culos de requerimiento de compras</b><br><span>Seleccione todos los art&iacute;culos.</span></p>
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
                                                    Agregar a solicitud de cotizaci&oacute;n
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
                                                @if($articulosRequerimientoCompras->isNotEmpty())
                                                @foreach ($articulosRequerimientoCompras as $item)
                                                <tr class="apl-table-body-tr pointer">
                                                    <!--<td class="d-none"></td>-->
                                                    <td>
                                                        <input type="checkbox" class="apl-border-checkbox" style="padding: .7rem;" value="{{ $item->id }}" wire:click="cambiarEstadoBotonesRequerimientoPersonal_ARP" wire:model="selectedArticulosRequerimientoPersonal">
                                                    </td>
                                                    <td class="text-center">{{ $item->articuloRequerimiento->articulo->codigo }}</td>
                                                    <td class="text-center">{{ \App\Models\Util::getCantidadLetras($item->articuloRequerimiento->articulo->articulo,30)}}</td>
                                                    <td class="text-center">{{ $item->articuloRequerimiento->articulo->tipoUnidad->nombre }}</td>
                                                    <td class="text-center">{{ $item->cantidad }}</td>
                                                    <td class="text-center">{{ $item->stock_disponible }}</td>

                                                    <td class="text-center">
                                                        <button type="button" title="Agregar a solicitud de cotizaci&oacute;n" class="btn btn-primary btn-sm apl-btn-border" wire:click="enviarArticuloRequerimientoParaOrdenCompraItem({{ $item->id}})">
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
                                        {{ $articulosRequerimientoCompras->links()}}
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
            $('#requerimiento_compras_id').select2({
                placeholder: '{{ __("Seleccione un requerimiento personal") }}',
                allowClear: true
            });
        }
        initSelectRequerimientoPersonalDrop();
        $('#requerimiento_compras_id').on('change', function(e) {
            livewire.emit('selectedRequerimientoComprasItem', e.target.value)
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