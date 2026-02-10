<div class="content-wrapper">
	<section class="content mt-3">
		<div class="container-fluid">
			<div class="row justify-content-center mt-4 mb-2">
				<div class="col-md-7">
					<h5><b>Historial de ventas</b></h5>
					<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptate, molestias cupiditate earum vitae, quia, et voluptatibus.</p>
				</div>

				<div class="col-md-3">
					<div class="margin float-right">
						<div class="btn-group">
							<button type="button" class="btn btn-default">Filtrar por</button>

							<div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
								</button>
								<div class="dropdown-menu">
									<a class="dropdown-item" href="#">Día</a>
									<a class="dropdown-item" href="#">Mes</a>
								</div>
							</div>
						</div>

						<div class="btn-group">
							<div class="input-group">
								<button type="button" class="btn btn-default" id="daterange-btn">
									<i class="far fa-calendar"></i> {{ date('d F Y') }}
									<i class="fas fa-caret-down"></i>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row justify-content-center mb-2">
				<div class="col-md-10">
					<div class="callout apl-callout-secondary">
						<h5><i class="fas fa-list-alt mr-4"></i>Informes de métricas de mensajes no disponibles</h5>
						<p class="ml-5" style="font-size: .88rem;">Lorem ipsum dolor sit, amet consectetur adipisicing, elit. Ea, doloribus enim! Non dolorem atque nostrum, assumenda voluptatum debitis, praesentium deserunt alias, veniam quasi voluptatem doloribus? Optio, eligendi tempore voluptatem inventore.</p>
					</div>
				</div>
			</div>

			<div class="row justify-content-center">
				<div class="col-md-7">
					<div class="card">
						<div class="card-header">
							<button class="btn btn-default float-right">
								Imprimir<i class="fas fa-print ml-2"></i>
							</button>
						</div>

						<div class="card-body">
							<center><img src="{{ asset('dist/img/tienda-configuracion.png') }}" alt="Configuración"></center>
							<p class="text-center">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Eveniet aperiam ex, minima asperiores necessitatibus <br> explicabo odio voluptatibus dolore laudantium et nulla.</p>
						</div>
					</div>
				</div>

				<div class="col-md-3">
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-body">
									<div class="apl-card-header">
										<div>
											<button class="btn btn-default float-right">
												Agregar articulos
											</button>
											<h4>Catálogo</h4>
										</div>
									</div class="apl-card-body">

									<div>
										<font class="apl-display-6">2</font><br>
										<span class="text-muted">artículos en este catálogo</span>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<div class="card">
								<div class="card-body">
									<h4><i class="fas fa-users mr-2"></i>Clientes</h4>
									<font class="apl-display-6">2</font><br>
									<a href="#" class="float-right"><em>ver más</em> <i class="fas fa-arrow-circle-right"></i></a>
									<!--<a href="#" class="apl-card-link"><i class="fas fa-arrow-circle-right float-right"></i></a>-->
								</div>
							</div>							
						</div>

						<div class="col-md-6">
							<div class="card">
								<div class="card-body">
									<h4><i class="fas fa-users mr-2"></i>Proveedores</h4>
									<font class="apl-display-6">2</font><br>
									<a href="#" class="float-right"><em>ver más</em> <i class="fas fa-arrow-circle-right"></i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>