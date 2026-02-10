<div class="content-wrapper">
	<section class="content mt-3">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<h4 class="mb-3"><b>Salidas</b></h4>
				</div>
			</div>

			<div class="row {{$permiso_listar}}">
				<div class="col-md-2">
					<div class="card apl-border">
						<div class="card-header">
							<h6><b>Filtrar por</b></h6>
						</div>

						<!-- ===== FILTRAR ===== -->
						<div class="card-body">
							<div class="col-sm-12">
								<div class="form-check mb-2">
									<input type="radio" class="form-check-input apl-radio" name="filtro" id="filtro" wire:click="cambiarFiltrarPorEstado('1')">
									<label class="form-check-label ml-2 mt-1">
										Activos
									</label>
								</div>

								<div class="form-check mb-2">
									<input type="radio" class="form-check-input apl-radio" name="filtro" id="filtro" wire:click="cambiarFiltrarPorEstado('0')">
									<label class="form-check-label ml-2">
										Inactivos
									</label>
								</div>

								<div class="form-check mb-2">
									<input type="radio" class="form-check-input apl-radio" name="filtro" id="filtro" checked="true" wire:click="cambiarFiltrarPorEstado('')">
									<label class="form-check-label ml-2">
										Todo
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-10">
					<dv class="row">
						<div class="col-md-12">
							<!-- ===== BOX ===== -->
							<div class="card apl-border">
								<div class="card-header">
									<div class="row">
										<div class="col-md-6">
											<b>{{$data->count()}}</b><br>
											<font class="apl-text-gray">Artículos</font>
										</div>

										<div class="col-md-6">

										</div>
									</div>
								</div>

								<div class="card-body">
									<div class="row">
										<div class="col-md-3">

											<div class="input-group mt-5">
												<div class="input-group-prepend">
													<div class="input-group-text apl-input-search-icon"><i class="fas fa-search"></i></div>
												</div>
												<input type="text" class="form-control apl-input-border apl-input-search" id="apl-table-buscar" placeholder="Buscar artículo" wire:model.debounce.800ms="search">
											</div>
										</div>

										<div class="col-md-9">
											<div class="row ">
												<div class="col-md-3">
													<div class="form-group">
														<label for="rango_inicio" style="margin-bottom: 0px;">Fecha inicio</label><br>
														<span class="small">Seleccione el rango de fecha inicio </span>
														<input type="date" class="form-control apl-input-border" wire:model="rango_inicio">
														@error('rango_inicio')<span class="text-danger small">{{$message}}</span> @enderror
													</div>


												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label for="rango_fin" style="margin-bottom: 0px;">Fecha fin</label><br>
														<span class="small">Seleccione el rango de fecha fin</span>
														<input type="date" class="form-control apl-input-border" wire:model="rango_fin">
														@error('rango_fin')<span class="text-danger small">{{$message}}</span> @enderror
													</div>
												</div>

												<div class="col-md-3">
													<a href="{{url('imprimir-salida',['rango_inicio'=>$rango_inicio,'rango_fin'=>$rango_fin,])}}" target="_blank" class="btn btn-primary mr-2 mt-5">
														Imprimir
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</dv>

					@if($data->isNotEmpty())
					<dv class="row">
						<div class="col-md-12">
							<!-- ===== TABLA ===== -->
							<div class="card apl-border">

								<div class="card-body">
									<div class="row">

									<div class="col-md-1">
									<span class="small">Seleccione </span>

                                            @include('componentes.select-item-table')
                                        </div>

										<div class="col-md-2">
											<div class="form-group">
												<span class="small">Seleccione el orden compra </span>
												<select class="form-control apl-input-border" wire:model="orden_compras_id">
													<option value="">Seleccione </option>
													@foreach($ordenCompra as $item)
													<option value="{{ $item->id}}">{{ $item->numero_orden_compra }}</option>
													@endforeach
												</select>
												@error('orden_compras_id')<span class="text-danger">{{$message}}</span> @enderror
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<span class="small">Seleccione fecha </span>

												<select class="form-control apl-input-border" wire:model="fecha_imrpimir">
													<option value="">Seleccione estado </option>
													@foreach($fechas_salidas as $item)
													<option value="{{ $item}}">{{ \App\Models\Util::darFormatoFecha($item) }}</option>
													@endforeach
												</select>
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group ">

												<a href="{{url('imprimir-salida-general',['fecha_salida'=>$fecha_imrpimir])}}" target="_blank" title="Agregar nuevo ingreso" class="btn btn-primary mt-4" style="border-radius: .7rem;">
													Imprimir
												</a>

											</div>
										</div>
									</div>


									<div class="table-responsive">
										<table id="apl-table" class="table table-hover">
											<thead>
												<tr class="apl-table-header-tr">
													<!--<td class="d-none"></td>-->
													<td>Art&iacute;culo</td>
													<td>Fecha ingreso</td>
													<td>Fecha salida</td>
													<td>N° requerimiento</td>
													<td>Orden de compra</td>
													<td>N° Factura</td>
													<td>Cantidad salida</td>
												</tr>
											</thead>

											<tbody>
												@foreach ($data as $item)
												<tr class="apl-table-body-tr pointer">
													<!--<td class="d-none"></td>-->



													@if($orden_compras_id=="" && $fecha_imrpimir=="")


													@if($item->articuloRequerimiento!=null)

													<td wire:click="editar({{ $item->id}})" width="20%">{{$fecha_imrpimir}} {{$item->articuloRequerimiento->articulo->articulo}}</td>
													<td wire:click="editar({{ $item->id}})">{{$item->darFormatoFecha($item->fecha_ingreso)}}</td>
													<td wire:click="editar({{ $item->id}})">{{$item->darFormatoFecha($item->fecha_salida)}}</td>
													<td wire:click="editar({{ $item->id}})">{{$item->articuloRequerimiento->requerimientoPersonal->numero_requerimiento}}</td>
													<td wire:click="editar({{ $item->id}})">{{$item->ordenCompra->numero_orden_compra}}</td>
													<td wire:click="editar({{ $item->id}})">{{$item->numero_documento}}</td>
													<td wire:click="editar({{ $item->id}})">{{$item->cantidad_salida}}</td>

													@endif

													@elseif($orden_compras_id=="" && $fecha_imrpimir==\App\Models\Util::darFormatoFecha($item->fecha_salida))
													@if($item->articuloRequerimiento!=null)

													<td wire:click="editar({{ $item->id}})" width="20%"> {{$item->articuloRequerimiento->articulo->articulo}}</td>
													<td wire:click="editar({{ $item->id}})">{{$item->darFormatoFecha($item->fecha_ingreso)}}</td>
													<td wire:click="editar({{ $item->id}})">{{$item->darFormatoFecha($item->fecha_salida)}}</td>
													<td wire:click="editar({{ $item->id}})">{{$item->articuloRequerimiento->requerimientoPersonal->numero_requerimiento}}</td>
													<td wire:click="editar({{ $item->id}})">{{$item->ordenCompra->numero_orden_compra}}</td>
													<td wire:click="editar({{ $item->id}})">{{$item->numero_documento}}</td>
													<td wire:click="editar({{ $item->id}})">{{$item->cantidad_salida}}</td>

													@endif

													@elseif($item->ordenCompra!=null && $orden_compras_id==$item->ordenCompra->id &&$fecha_imrpimir=="")

													@if($item->articuloRequerimiento!=null)

													<td wire:click="editar({{ $item->id}})">{{$item->articuloRequerimiento->articulo->articulo}}</td>
													<td wire:click="editar({{ $item->id}})">{{$item->darFormatoFecha($item->fecha_ingreso)}}</td>
													<td wire:click="editar({{ $item->id}})">{{$item->darFormatoFecha($item->fecha_salida)}}</td>
													<td wire:click="editar({{ $item->id}})">{{$item->articuloRequerimiento->requerimientoPersonal->numero_requerimiento}}</td>
													<td wire:click="editar({{ $item->id}})">{{$item->ordenCompra->numero_orden_compra}}</td>
													<td wire:click="editar({{ $item->id}})">{{$item->numero_documento}}</td>
													<td wire:click="editar({{ $item->id}})">{{$item->cantidad_salida}}</td>

													@endif
													@elseif($item->ordenCompra!=null && $orden_compras_id==$item->ordenCompra->id &&$fecha_imrpimir==\App\Models\Util::darFormatoFecha($item->fecha_salida))

													@if($item->articuloRequerimiento!=null)

													<td wire:click="editar({{ $item->id}})">{{$item->articuloRequerimiento->articulo->articulo}}</td>
													<td wire:click="editar({{ $item->id}})">{{$item->darFormatoFecha($item->fecha_ingreso)}}</td>
													<td wire:click="editar({{ $item->id}})">{{$item->darFormatoFecha($item->fecha_salida)}}</td>
													<td wire:click="editar({{ $item->id}})">{{$item->articuloRequerimiento->requerimientoPersonal->numero_requerimiento}}</td>
													<td wire:click="editar({{ $item->id}})">{{$item->ordenCompra->numero_orden_compra}}</td>
													<td wire:click="editar({{ $item->id}})">{{$item->numero_documento}}</td>
													<td wire:click="editar({{ $item->id}})">{{$item->cantidad_salida}}</td>

													@endif


													@endif


												</tr>
												@endforeach
											</tbody>
										</table>

									</div>
								</div>
							</div>
						</div>
					</dv>
					@else
					<div class="row">
						<div class="col-12 text-center">
							<center><img src="{{ asset('dist/img/empty.png') }}" alt="Imagen" width="550"></center>
							<h4 class="text-muted">No hay resultados</h4>
						</div>
					</div>
					@endif
				</div>
			</div>


			@if($permiso_listar=='d-none')
			<div class="row">
				<div class="col-md-12">
					<p>No tiene permisos para usar esta funcion</p>
				</div>
			</div>
			@endif

			<!-- =============== MODAL =============== -->

			<div class="modal fade" id="modalForm" data-backdrop="static">
				<div class="modal-dialog modal-xl">
					<div class="modal-content">
						<div class="row">
							<div class="col-md-2" style="background: #f2f2f2;">
								<button class="btn apl-btn-skyblue btn-sm mt-3 ml-2"><i class="fas fa-adjust mr-2"></i>Información básica</button>
							</div>

							<div class="col-md-10 bg-white">
								<div class="modal-body">
									@livewire('salida-detallada.formulario')
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- ===================================== -->

			<div class="modal fade" id="modalFormInactivar" data-backdrop="static">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
							</div>

							<div class="row text-center">
								<div class="col-md-12">
									<i class="fas fa-user-alt-slash text-secondary" style="font-size: 5rem;"></i>
								</div>

								<div class="col-md-12">
									<h3 class="mt-3">¿Estás seguro?</h3>
									<p class="mt-4 mb-5">¿Realmente desea inactivar estos registros? Este proceso no se puede deshacer.
									</p>
								</div>

								<div class="col-md-12">
									<button class="btn btn-default apl-btn-border mr-1" data-dismiss="modal">Cancelar</button>
									<button class="btn btn-primary apl-btn-border ml-1" wire:click="inactivarTipoUnidades" wire:loading.attr="disabled">Inactivar</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- ===================================== -->

			<div class="modal fade" id="modalFormActivar" data-backdrop="static">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
							</div>

							<div class="row text-center">
								<div class="col-md-12">
									<i class="fas fa-user-tie text-secondary" style="font-size: 5rem;"></i>
								</div>

								<div class="col-md-12">
									<h3 class="mt-3">¿Estás seguro?</h3>
									<p class="mt-4 mb-5">¿Realmente desea activar estos registros? Este proceso no se puede deshacer.
									</p>
								</div>

								<div class="col-md-12">
									<button class="btn btn-default apl-btn-border mr-1" data-dismiss="modal">Cancelar</button>
									<button class="btn btn-primary apl-btn-border ml-1" wire:click="activarTipoUnidades" wire:loading.attr="disabled">Activar</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- ===================================== -->

			<div class="modal fade" id="modalFormDelete" data-backdrop="static">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
							</div>

							<div class="row text-center">
								<div class="col-md-12">
									<i class="far fa-times-circle text-danger" style="font-size: 5rem;"></i>
								</div>

								<div class="col-md-12">
									<h3 class="mt-3">¿Estás seguro?</h3>
									<p class="mt-4 mb-5">¿Realmente desea eliminar estos registros? Este proceso no se puede deshacer.
									</p>
								</div>

								<div class="col-md-12">
									<button class="btn btn-default apl-btn-border mr-1" data-dismiss="modal">Cancelar</button>
									<button class="btn btn-danger apl-btn-border ml-1" wire:click="destruir" wire:loading.attr="disabled">Eliminar</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- ===================================== -->



			<!-- ===================================== -->

			<div class="modal fade" id="modalFormError" data-backdrop="static">
				<div class="modal-dialog modal-xl">
					<div class="modal-content">
						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
							</div>

							<div class="row text-center">
								<div class="col-md-12">
									<i class="fas fa-user-tie text-secondary" style="font-size: 5rem;"></i>
								</div>

								<div class="col-md-12">

									<div class="card-body">
										@if(count($almacenamientoNombreElimados)>0)
										<h5 class="mt-2"><b>Elementos eliminados</b> <br> <span> Los elementos que se muestran a continuaci&oacute;n fueron eliminados</span> </h5>

										<div class="col-sm-12">
											@foreach($almacenamientoNombreElimados as $e)
											<div class="form-check mb-2">
												<i class="fas fa-check text-primary"></i> <label class="form-check-label ml-2 mt-1">
													{{$e}}
												</label>
											</div>
											@endforeach
										</div>
										@endif
									</div>


									<div class="card-body">
										@if(count($almacenamientoNombreSinEliminar)>0)
										<h5 class="mt-2"><b>Elementos sin eliminar</b> <br> <span> No se ha podido eliminar los elementos debido a que estan en uso en las habitaciones</span> </h5>

										<div class="col-sm-12">
											@foreach($almacenamientoNombreSinEliminar as $e)
											<div class="form-check mb-2">
												<i class="fas fa-times text-danger"></i>
												<label class="form-check-label ml-2 mt-1">
													{{$e}}
												</label>
											</div>
											@endforeach
										</div>
										@endif
									</div>
									</p>
								</div>

								<div class="col-md-12">
									<button class="btn btn-default apl-btn-border mr-1" data-dismiss="modal">Cerrar</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</section>
</div>