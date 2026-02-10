<div class="content-wrapper">
	<section class="content mt-3">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<h4 class="mb-3"><b>Sucursales</b></h4>
				</div>
			</div>

			@if(\App\Models\Util::esUsuario())
			<div class="row {{$permiso_listar}}">
				<div class="col-md-2">
					<div class="row">
						<div class="col-md-12">
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
					</div>

					<div class="row">
						<div class="col-md-12">

							@if(\App\Models\Util::esUsuario())
							<button title="Agregar Sucursales" class="btn btn-primary btn-block {{$permiso_agregar}}" style="border-radius: .7rem;" wire:click.prevent="crear">
								<i class="fas fa-plus"></i>

								Agregar Sucursales
							</button>
						</div>

						@else
						<button title="Agregar Sucursales" class="btn btn-secondary btn-block " style="border-radius: .7rem;" title="No tiene permisos para agregar ">
							<i class="fas fa-plus"></i>

							Agregar Sucursales
						</button>
					</div>
					@endif

				</div>

			</div>
			@endif
			<div class="col-md-10">
				@if($data->isNotEmpty())
				<div class="row">

					@foreach ($data as $index=> $item)

					<?php
					$numero_aleatorio = rand(0, 3);

					?>
					<div class="col-md-3">
						<div class="sucursal{{$numero_aleatorio}} apl-card-hover">
							<div class="row">
								<div class="col-2">
									<h4><i class="fas fa-building mr-2" style="font-size: 2rem;"></i></h4>
								</div>

								<div class="col-9">
									<h4 class="mb-0"><em>{{ $item->nombre_sucursal }}</em></h4>
									<em class="small mt-0">{{ $item->direccion }} </em>
								</div>

								<div class="col-1">
									@if(\App\Models\Util::esUsuario())
									<a href="#" wire:click="editar({{ $item->id}})" title="Editar sucursal"><i class="fas fa-edit text-light"></i></a>
									<a href="#" wire:click="eliminar({{ $item->id}})" title="Eliminar sucursal"><i class="fas fa-trash text-light"></i></a>
									@endif
								</div>
							</div>

							<p class="mt-4 mb-2"><cite>— {{ $item->empresa->razon_social }}</cite></p>

							@if($item->estado=="1")

							<p class=" ">Estado: Activo</p>
							@else
							<p class=" ">Estado: Inactivo</p>

							@endif


							@if($item->estado == 1)

							<a href="#" wire:click="administrarSucural({{$item->id}})" title="Administrar sucursal" class="float-right text-light text-center"><i class="fas fa-arrow-circle-right" style="font-size: 20px;"></i><span style="margin-bottom: 15px; "> Administrar</span></a>
							@else

							<a href="#" class="float-right text-light" title="El estado de sucursal esta inactiva"><i class="fas fa-arrow-circle-right" style="font-size: 20px"></i> <span style="margin-bottom: 15px;">Administrar</span></a>
							@endif
						</div>
					</div>
					@endforeach
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

					@livewire('sucursal-empresa.formulario')

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
								<button type="button" title="Inactivar" class="btn btn-primary apl-btn-border ml-1" wire:click="inactivarTipoUnidades" wire:loading.attr="disabled">Inactivar</button>
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
								<button type="button" title="Activar" class="btn btn-primary apl-btn-border ml-1" wire:click="activarTipoUnidades" wire:loading.attr="disabled">Activar</button>
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