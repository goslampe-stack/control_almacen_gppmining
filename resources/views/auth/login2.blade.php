<x-guest-layout>
	<div id="particles-js"></div>

	<style type="text/css">
	.apl-form-control {
		background: url(https://res.cloudinary.com/velasquez-paz/image/upload/v1618333387/l7oqsb2ucmvcimhrvy6n.png);
		background-color: inherit;
		color: #fff;
		padding: 1.5rem 1rem 1.5rem 1rem;
		border-radius: 1rem 0rem 0rem 1rem;
		border-right: inherit;
		border-color: #385c7f;
	}

	.apl-icon-control {
		background: url(https://res.cloudinary.com/velasquez-paz/image/upload/v1618333387/l7oqsb2ucmvcimhrvy6n.png);
		background-color: inherit;
		padding: 0rem 1rem 0rem 1rem;
		border-radius: 0rem 1rem 1rem 0rem;
		border-left: inherit;
		border-color: #385c7f;
	}

	.apl-form-control::placeholder {
		font-style: oblique;
	}

	.apl-btn-control {
		padding: .5rem;
		border-radius: .6rem .6rem .6rem .6rem;
	}
	</style>
	<!-- 4e7193-->

	<div class="content-wrapper" style="background-color: inherit;">
		<section class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<div class="row justify-content-center">
							<div class="col-xs-12 col-sm-8 col-md-6 col-lg-3">
								<div style="margin-top: 50%;"></div>

								<div class="card" style="background: url(https://res.cloudinary.com/velasquez-paz/image/upload/v1618330141/nnafckjwendwq4h50upc.png);">
									<div class="card-body">

										<div class="row">
											<div class="col-md-12">
												<br>
												<h3 class="text-white text-center">Login</h3>
												<br>
											</div>
										</div>

										<div class="row">
											<div class="col-md-12">
												<div class="input-group mb-4">
													<input type="email" class="form-control apl-form-control" name="email" id="email" placeholder="Correo Electrónico" :value="old('email')">
													<div class="input-group-append">
														<div class="input-group-text apl-icon-control">
															<span class="fas fa-envelope" style="color: #5d80a2;"></span>
														</div>
													</div>
												</div>

												<div class="input-group mb-3">
													<input type="password" class="form-control apl-form-control" name="password" id="password" placeholder="Contraseña" autocomplete="current-password">
													<div class="input-group-append">
														<div class="input-group-text apl-icon-control">
															<span class="fas fa-lock" style="color: #5d80a2;"></span>
														</div>
													</div>
												</div>
											</div>
										</div>

										<br>

										<div class="row">
											<div class="col-md-12">
												<button type="button" class="btn btn-primary btn-block apl-btn-control">{{ __('INGRESAR') }}</button>
											</div>
										</div>

										<br>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</x-guest-layout>