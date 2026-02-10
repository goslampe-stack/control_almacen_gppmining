<x-guest-layout>
	<div id="particles-js"></div>
	<div class="content-wrapper" style="background-color: inherit;">
		<section class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<div class="row justify-content-center">
							<div class="col-xs-12 col-sm-8 col-md-6 col-lg-3">
								<div style="margin-top: 50%;"></div>

								@if (session('status'))
								<div class="alert alert-danger" role="alert">
									{{ session('status') }}
								</div>
								@endif

								<form method="POST" action="{{ route('login') }}">
									@csrf
									<div class="card" style="background: url(https://res.cloudinary.com/velasquez-paz/image/upload/v1618330141/nnafckjwendwq4h50upc.png);">
										<div class="card-body">
											<div class="row">
												<div class="col-md-12">
													<div style="margin: auto;margin-top: -70px;margin-left: 38%;" class="circle2">
														<img src="{{ asset('dist/img/goslam_viajes.jpg') }}" width="100" alt="Logo">
													</div>
												</div>
												<div class="col-md-12">
													<br>
													<h3 class="text-white text-center">Inicie sesión</h3>
												</div>
											</div>

											<div class="row">
												<div class="col-md-12">
													<div class="input-group mt-4">
														<input type="email" class="form-control login-form-control" name="email" id="email" placeholder="Correo Electrónico" :value="old('email')">
														<div class="input-group-append">
															<div class="input-group-text login-icon-control">
																<span class="fas fa-envelope" style="color: #fff;"></span>
															</div>
														</div>
													</div>

													@error('email')
													<span class="text-warning">{{ $message }}</span>
													@enderror

													<div class="input-group mt-4">
														<input type="password" class="form-control login-form-control" name="password" id="password" placeholder="Contraseña" autocomplete="current-password">
														<div class="input-group-append">
															<div class="input-group-text login-icon-control">
																<span class="fas fa-lock" style="color: #fff;"></span>
															</div>
														</div>
													</div>

													@error('password')
													<span class="text-warning">{{ $message }}</span>
													@enderror

												</div>
											</div>

											<br>

											<div class="row">
												<div class="col-md-12">
													<button type="input" class="btn btn-primary btn-block login-btn-control">{{ __('INGRESAR') }}</button>
												</div>
											</div>

											<br>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</x-guest-layout>