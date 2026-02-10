<div class="content-wrapper">
	<section class="content mt-3">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<h4 class="mb-3"><b>Personales</b></h4>
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
											<font class="apl-text-gray">Personales</font>
										</div>

										<div class="col-md-6">
											<button title="Agregar personal" class="btn btn-primary float-right {{$permiso_agregar}}" style="border-radius: .7rem;" wire:click.prevent="crear">
											<i class="fa fa-plus" aria-hidden="true"></i> Agregar Personal
											</button>
										</div>
									</div>
								</div>

								<div class="card-body">
									<div class="row">
										<div class="col-md-3">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text apl-input-search-icon"><i class="fas fa-search"></i></div>
												</div>
												<input type="text" class="form-control apl-input-border apl-input-search" id="apl-table-buscar" placeholder="Buscar por apellidos" wire:model.debounce.800ms="search">
											</div>
										</div>

										<div class="col-md-9">
											<div class="float-right">
												<button type="button" title="Item seleccionados" class="btn btn-default btn-sm apl-btn-border" disabled="true">
													{{count($selectedPersonales)}} Seleccionados
												</button>

												<button type="button" title="Eliminar" class="btn btn-danger btn-sm apl-btn-border {{$permiso_eliminar}}" wire:click="eliminar()" {{$estaActivadoEliminar}}>
													Eliminar
												</button>

												<button type="button" title="Desactivar" class="btn btn-secondary btn-sm apl-btn-border" {{$estaActivadorInactivo}} wire:click="abrirModalInactivar">
													Desactivar
												</button>

												<button type="button" title="Activar" class="btn btn-primary btn-sm apl-btn-border" {{$estaActivadorActivo}} wire:click="abrirModalActivar">
													Activar
												</button>

												
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
									<div class="table-responsive">
										<table id="apl-table" class="table table-hover projects">
											<thead>
												<tr class="apl-table-header-tr">
													<td></td>
													<td width="15%">Personal</td>
													<td width="12%">Tipo documento</td>
													<td width="15%">N° documento</td>
													<td>Celular</td>
													<td>Tipo personal</td>
													<td>G&eacute;nero</td>
													<td>Estado</td>
													<td class="text-center">Opci&oacute;n</td>
												</tr>
											</thead>
											<tbody>
												@foreach ($data as $item)
												<tr class="apl-table-body-tr pointer">
													<td>
														<input type="checkbox" class="apl-border-checkbox" style="padding: .7rem;" value="{{ $item->id }}" wire:click="cambiarEstadoBotones" wire:model="selectedPersonales">
													</td>



													@if($permiso_actualizar=='')

													<td >{{ $item->apellidos }}, {{ $item->nombre }}</td>
													<td >{{ $item->tipo_documento }}</td>
													<td >{{ $item->numero_documento }}</td>
													<td >{{ $item->celular }}</td>
													<td >{{ $item->tipoPersonal->nombre }}</td>
													<td >{{ $item->genero }}</td>
													<td >
														@if($item->estado == 1)
														Activo
														@else
														Inactivo
														@endif
													</td>
													<td class="text-center">
													<button type="button" title="Editar" class="text-primary" wire:click="editar({{$item->id}})">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
													</td>

													@else


													<td>{{ $item->apellidos }}, {{ $item->nombre }}</td>
													<td>{{ $item->tipo_documento }}</td>
													<td>{{ $item->numero_documento }}</td>
													<td>{{ $item->celular }}</td>
													<td>{{ $item->genero }}</td>
													<td>
														@if($item->estado == 1)
														Activo
														@else
														Inactivo
														@endif
													</td>

													@endif




												</tr>
												@endforeach
											</tbody>
										</table>
										{{ $data->links()}}
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
									@livewire('personal.formulario')
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
									<button type="button" title="Cerrar" class="close" data-dismiss="modal" aria-label="Close">
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
									<button type="button" title="Cancelar" class="btn btn-default apl-btn-border mr-1" data-dismiss="modal">Cancelar</button>
									<button type="button" title="Eliminar" class="btn btn-danger apl-btn-border ml-1" wire:click="destruir" wire:loading.attr="disabled">Eliminar</button>
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
									<button type="button" title="Cerrar" class="close" data-dismiss="modal" aria-label="Close">
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
									<button type="button" title="Cancelar" class="btn btn-default apl-btn-border mr-1" data-dismiss="modal">Cancelar</button>
									<button type="button" title="Inactivar" class="btn btn-primary apl-btn-border ml-1" wire:click="inactivarPersonales" wire:loading.attr="disabled">Inactivar</button>
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
									<button type="button" title="Cerrar" class="close" data-dismiss="modal" aria-label="Close">
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
									<button type="button" title="Cancelar" class="btn btn-default apl-btn-border mr-1" data-dismiss="modal">Cancelar</button>
									<button type="button" title="Activar" class="btn btn-primary apl-btn-border ml-1" wire:click="activarPersonales" wire:loading.attr="disabled">Activar</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- ===================================== -->

			<div class="modal fade" id="modalFormError" data-backdrop="static">
				<div class="modal-dialog modal-xl">
					<div class="modal-content">
						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									<button type="button" title="Cerrar" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
							</div>

							<div class="row text-center">
								<div class="col-md-12">
									<i class="fas fa-user-tie text-secondary" style="font-size: 5rem;"></i>
								</div>

								<div class="col-md-12">
									<h3 class="mt-3">Error </h3>
									<p class="mt-4 mb-5">Ocurrio un error al actualizar los datos intentelo de nuevo.
									</p>
								</div>

								<div class="col-md-12">
									<button type="button" title="Cerrar" class="btn btn-default apl-btn-border mr-1" data-dismiss="modal">Cerrar</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</section>
</div>