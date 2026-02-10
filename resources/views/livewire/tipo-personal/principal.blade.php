<div class="content-wrapper">
	<section class="content mt-3">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<h4 class="mb-3"><b>Tipo personal</b></h4>
				</div>
			</div>


			@if(\App\Models\Util::checkPermission('tipo-unidad-list'))
			<div class="row ">
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
					<div class="row">
						<div class="col-md-12">
							<!-- ===== BOX ===== -->
							<div class="card apl-border">
								<div class="card-header">
									<div class="row">
										<div class="col-md-6">
											<b>{{$data->count()}}</b><br>
											<font class="apl-text-gray">Tipo personal</font>
										</div>

										<div class="col-md-6">
											@if(\App\Models\Util::checkPermission('tipo-unidad-create'))
											<button title="Agregar tipo personal" class="btn btn-primary float-right " style="border-radius: .7rem;" wire:click.prevent="crear">
												<i class="fas fa-plus"></i>
												Agregar
											</button>
											@endif
										</div>
									</div>
								</div>

								<div class="card-body">
									<div class="row">

										<div class="col-md-1">
											@include('componentes.select-item-table')
										</div>
										<div class="col-md-5">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text apl-input-search-icon"><i class="fas fa-search"></i></div>
												</div>
												<input type="text" class="form-control apl-input-border apl-input-search" id="apl-table-buscar" placeholder="Buscar unidad de medida" wire:model.debounce.800ms="search">
											</div>
										</div>

										<div class="col-md-6">
											<div class="float-right">
												<button type="button" title="Item seleccionados" class="btn btn-default btn-sm apl-btn-border" disabled="true">
													{{count($selectedItemsTable)}} Seleccionados
												</button>

												@if(\App\Models\Util::checkPermission('tipo-unidad-delete'))
												<button type="button" title="Eliminar" class="btn btn-danger btn-sm apl-btn-border " wire:click="eliminar()" {{$estaActivadoEliminar}}>
													Eliminar
												</button>
												@endif

												<button type="button" title="Inactivar" class="btn btn-secondary btn-sm apl-btn-border" {{$estaActivadorInactivo}} wire:click="abrirModalInactivar">
													Inactivar
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
					</div>

					@if($data->isNotEmpty())
					<div class="row">
						<div class="col-md-12">
							<!-- ===== TABLA ===== -->
							<div class="card apl-border">
								<div class="card-body">
									<div class="table-responsive">
										<table id="apl-table" class="table table-hover">
											<thead>
												<tr class="apl-table-header-tr">
													<!--<td class="d-none"></td>-->
													<td width="3%"></td>
													<td >Unidad de medida</td>
													<td > Fecha creaci&oacute;n</td>
													<td > Estado</td>
													<td  class="text-center">Opci&oacute;n</td>
												</tr>
											</thead>
											<tbody>
												@foreach ($data as $item)
												<tr class="apl-table-body-tr pointer">
													<!--<td class="d-none"></td>-->
													<td>
														<input type="checkbox" class="apl-border-checkbox" style="padding: .7rem;" value="{{ $item->id }}" wire:click="cambiarEstadoBotones" wire:model="selectedItemsTable">
													</td>
													@if(\App\Models\Util::checkPermission('tipo-unidad-edit'))
													<td >{{ $item->nombre }}</td>
													<td >{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:m:s') }}</td>
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
													<td>{{ $item->nombre }}</td>
													<td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:m:s') }}</td>
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
					</div>
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
			@else
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
									@livewire('tipo-personal.formulario')
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- ===================================== -->
			@include('componentes.modal-inactivar-items')
			<!-- ===================================== -->

			<!-- ===================================== -->
			@include('componentes.modal-activar-items')
			<!-- ===================================== -->

			<!-- ===================================== -->
			@include('componentes.modal-eliminar-items')
			<!-- ===================================== -->

			<!-- ===================================== -->
			@include('componentes.modal-error-items')
			<!-- ===================================== -->

		</div>
	</section>
</div>