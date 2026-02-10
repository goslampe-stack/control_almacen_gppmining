<div class="content-wrapper">
	<section class="content mt-3">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-12 col-md-12  mb-2">
					<div class="row">
						@foreach($tiendas as $item)
						<div class="col-md-3">
							<a href="{{ route('ventasDetalles',Crypt::encrypt($item->id)) }}">
								<div class="card card-widget widget-user apl-card-hover">
									<div class="widget-user-header text-white" style="background: url('{{ $item->imagen }}') center center;">
										<h3 class="widget-user-username text-right">&nbsp;</h3>
										<h5 class="widget-user-desc text-right">&nbsp;</h5>
									</div>

									<div class="widget-user-image">
										<img class="img-circle" src="{{ asset('dist/img/tienda-icono.png') }}" alt="User Avatar">
									</div>

									<div class="card-footer">
										<div class="row">
											<div class="col-sm-12">
												<div class="description-block">
													<h5 class="description-header text-dark">{{$item->ruc}}</h5>
													<span class="description-text text-gray small">{{$item->razon_social}}</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</a>
						</div>
						@endforeach

						@if($permiso_agregar=='asasdsasas')

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

					</div>
				</div>

				<!-- =============== MODAL ===============  -->
				<div class=" modal " id="modalForm" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
					<div class="modal-dialog ">
						<div class="modal-content">
							<div class="row">
								<div class="col-md-12">
									<div class="modal-header">
										<h4 class="modal-title">Crear una empresa</h4>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>

									<div class="modal-body">
										@livewire('tienda.crear')
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>