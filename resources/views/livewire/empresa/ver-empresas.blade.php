<div class="content-wrapper">
	<section class="content mt-3">
		<div class="container-fluid">
			<div class="row">

				<div class="col-md-12">
					<p><b>Empresas registradas</b><br><span>Edite, elimine o administre cada empresa seleccionada.</span></p>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-md-12  mb-2">
					<div class="row">
						@forelse($empresas as $item)

						<div class="col-md-3" title="Editar empresa">
							<a href="#">
								<div class="card card-widget widget-user apl-card-hover">
									<div class="widget-user-header text-white color-empresa">
										<h3 class="widget-user-username text-right">&nbsp;</h3>
										<h5 class="widget-user-desc text-right">&nbsp;
											@if($editar==true )
											<a href="#" wire:click="editar({{ $item->id}})" title="Editar empresa"><i class="fas fa-edit text-light"></i></a>
											@endif
											@if($eliminar==true )

											<a href="#" wire:click="eliminar({{ $item->id}})" title="Eliminar empresa"><i class="fas fa-trash text-light"></i></a>
											@endif
										</h5>
									</div>

									<div class="widget-user-image">
										<!-- <img class="img-circle" src="{{ asset('dist/img/tienda-icono.png') }} " alt="User Avatar"> -->
										<img class="img-circle" src="{{ $item->imagen }}  " alt="User Avatar" style="width: 80px; height: 80px;">
									</div>

									<div class="card-footer">
										<div class="row">
											<div class="col-sm-12">
												<div class="description-block">
													@if($item->estado=="1")

													<h5 class="description-text text-success small">Activo</h5>
													@else
													<h5 class="description-text text-danger small">Inactivo</h5>

													@endif
													<h5 class="description-header text-dark">{{$item->ruc}}</h5>
													<span class="description-text text-gray small">{{$item->razon_social}}</span>
													@if($item->estado=="1")

													<a href="{{ route('ver-surcursales-empresa',$item->id) }}" title="Administrar empresa" class="float-right text-dark"><i class="fas fa-arrow-circle-right" style="font-size: 2rem;"></i></a>
													@endif

												</div>
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>
						@empty


						@endforelse


						@if($puedeCrearEmpresas=="Si")
						<div class="col-md-3">
							<a href="#" wire:click="crear">
								<div class="nueva-tienda">
									<div class="contenido">
										<i class="far fa-plus-square"></i>
										<font class="text-gray small">Agregar empresa</font>
									</div>
								</div>
							</a>
						</div>
						@endif


						@if($empresas->count()<=0)
						 <div class="row">
							<div class="col-12 text-center">
								<center><img src="{{ asset('dist/img/empty.png') }}" alt="Imagen" width="550"></center>
								<h4 class="text-muted">No hay empresas disponibles</h4>
							</div>
							</div>
					@endif


				</div>
			</div>

			<!-- =============== MODAL ===============  -->
			<div class="modal fade" id="modalForm" data-backdrop="static">
				<div class="modal-dialog modal-xl">
					<div class="modal-content">
						@livewire('empresa.formulario')
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

		</div>
</div>
</section>
</div>