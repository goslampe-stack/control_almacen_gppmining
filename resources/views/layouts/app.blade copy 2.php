<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>{{ config('app.name', 'Laravel') }}</title>
	<link rel="icon" type="image/png" href="{{ asset('dist/img/GMaranonLogo.png') }}" />

	<!-- Fonts -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
	<!-- Styles -->
	<link rel="stylesheet" href="{{ mix('css/app.css') }}">

	@livewireStyles

	<!-- ========== APOLO CSS ========== -->
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&family=Open+Sans:wght@300;400;700&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
	</link>
	<!-- daterange picker -->
	<link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
	<!-- Select2 -->
	<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
	<!-- DataTables -->
	<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ asset('plugins/theme/css/adminlte.min.css') }}">
	<!-- iCheck -->
	<link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
	<!-- Dropzone -->
	<link rel="stylesheet" href="{{ asset('plugins/dropzone/css/dropzone.min.css') }}">
	<!-- Apolo -->
	<link rel="stylesheet" href="{{ asset('plugins/apolo/css/apolo.min.css') }}">
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<!-- ========== END APOLO CSS ========== -->
	<link rel="stylesheet" href="{{ asset('plugins/apolo/assets/alert/css/alert.css') }}">

	<!-- Scripts -->
	<script src="{{ mix('js/app.js') }}" defer></script>
</head>


<body class="hold-transition sidebar-mini sidebar-collapse layout-top-nav layout-footer-fixed">

	<div class="wrapper">
		<x-jet-banner />

		<div class="min-h-screen bg-gray-100">
			@livewire('navigation-menu')

			@if (isset($header))
			<header class="bg-white shadow">
				<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
					{{ $header }}
				</div>
			</header>
			@endif

			<main>

				@php
				$user = Auth::user();
				$module = $user->roles[0]->modules->sortBy('module_rank')->where('view_sidebar','=',1);

				@endphp

				@if(\App\Models\Util::getSucursalEmpresaIdLocalStorage()!='-10'
				&& !request()->routeIs('articulo')
				&& !request()->routeIs('tipo-unidad')
				&& !request()->routeIs('proveedor')
				&& !request()->routeIs('transporte')
				&& !request()->routeIs('role')
				&& !request()->routeIs('usuario')
				&& !request()->routeIs('empresa')
				&& !request()->routeIs('permission-asign')
				&& !request()->routeIs('role-module-asign')
				&& !request()->routeIs('ver-surcursales-empresa')
				)

				<!-- Navbar de Bootstrap -->
				<nav class="navbar navbar-expand-lg navbar-custom bg-primary">
					<!-- <a class="navbar-brand" href="#">MiSitio</a> -->
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"><i class="fa fa-bars" aria-hidden="true"></i></span>
					</button>
					<div class="collapse navbar-collapse" id="navbarNav">
						<ul class="navbar-nav">


							@foreach($module as $m)

							@if($m->identity=='informacion')

							<li class="nav-item active">
								<a class="nav-link {{ request()->routeIs($m->module_url) ? 'active' : '' }}" href="{{ route($m->module_url) }}">{{ $m->name }} <span class="sr-only">(actual)</span></a>
							</li>

							@endif
							@endforeach



							<!-- Entradas -->
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Entradas
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdown">

									@foreach($module as $m)

									@if($m->opcion=='entrada')

									@if($m->opcion=='entrada' && $m->identity=='tipo-unidad')
									@elseif($m->opcion=='entrada' && $m->identity=='articulo')
									@else

									<a class="dropdown-item {{ request()->routeIs($m->module_url) ? 'active' : '' }}" href="{{ route($m->module_url) }}">{{ $m->name }}</a>
									@endif
									@endif
									@endforeach

								</div>
							</li>


							<!-- Entradas -->

							<!-- Salida -->


							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Salida
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdown">

									@foreach($module as $m)

									@if($m->opcion=='salida')


									<a class="dropdown-item {{ request()->routeIs($m->module_url) ? 'active' : '' }}" href="{{ route($m->module_url) }}">{{ $m->name }}</a>

									@endif
									@endforeach

								</div>
							</li>
							<!-- Salida -->
							<!-- Otros -->


							<ltr class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Otros
								</a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdown">

									@foreach($module as $m)

									@if($m->opcion=='otros')

									@if($m->opcion=='otros' && $m->identity=='empresa')
									@elseif($m->opcion=='otros' && $m->identity=='proveedor')
									@elseif($m->opcion=='otros' && $m->identity=='transporte')
									@elseif($m->opcion=='otros' && $m->identity=='user')
									@elseif($m->opcion=='otros' && $m->identity=='role')
									@elseif($m->opcion=='otros' && $m->identity=='role')
									@else
									<a class="dropdown-item {{ request()->routeIs($m->module_url) ? 'active' : '' }}" href="{{ route($m->module_url) }}">{{ $m->name }}</a>

									@endif
									@endif
									@endforeach

								</div>
								</li>
								<!-- Otros -->
						</ul>
					</div>
				</nav>

				@endif





				{{ $slot }}

				<footer class="main-footer">
					@if (request()->routeIs('dashboard'))
					<div class="float-right d-none d-sm-block">
						<b>&nbsp;</b> &nbsp;
					</div>
					<strong>&nbsp;</strong> &nbsp;
					@else
					<div class="float-right d-none d-sm-block">
						<b>Sucursal:</b> {{ Auth::user()->sucursal_empresa_nombre}}
					</div>
					<strong>Empresa:</strong> {{ Auth::user()->empresa_seleccionada}}
					@endif
				</footer>
			</main>
		</div>

		<div class="apl-notificacion" id="apl-notificacion">
			<i id="apl-notificacion-icon"></i>
			<span id="apl-notificacion-titulo"></span>

			<div class="close float-right">
				<i class="fas fa-times"></i>
			</div>
		</div>

		@stack('modals')

		<!-- ========== APOLO JS ========== -->

		<!-- jQuery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<!-- Select2 -->
		<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
		<!-- Bootstrap 4 -->
		<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
		<!-- date-range-picker -->
		<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
		<!-- DataTables  & Plugins -->
		<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
		<!-- Theme style -->
		<script src="{{ asset('plugins/theme/js/adminlte.min.js') }}"></script>
		<!-- Dropzone -->
		<script src="{{ asset('plugins/dropzone/js/dropzone.js') }}"></script>
		<!-- Apolo -->
		<script src="{{ asset('plugins/apolo/js/apolo.min.js') }}"></script>
		<!-- -->
		<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
		<!-- -->
		<script src="{{ asset('plugins/apolo/assets/alert/js/alert.js') }}"></script>

		<script>
			$(function() {
				$('.select2').select2();
			});
		</script>

		<script>
			$(function() {
				$('#apl-table').DataTable({
					"responsive": true,
					"searching": false,
					"ordering": false,
					"paging": false,
					"bPaginate": false,
					"info": false,
					"autoWidth": false,
				});

			});
		</script>

		<script>
			$(function() {
				$('.toastsDefaultDefault').click(function() {
					$(document).Toasts('create', {
						title: 'Toast Title',
						body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
					})
				});

			});
		</script>

		<script>
			$(document).ready(function() {
				$("#apl-table-buscar").keyup(function() {
					_this = this;

					$.each($("#apl-table tbody tr"), function() {
						if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
							$(this).hide();
						else
							$(this).show();
					});
				});
			});
		</script>

		<script>
			/* MODAL */
			window.addEventListener('closeModal', event => {
				$('#modalForm').modal('hide');
			});
			window.addEventListener('openModal', event => {
				$('#modalForm').modal('show');
			});

			window.addEventListener('closeModalDetalle', event => {
				$('#modalFormDetalle').modal('hide');
			});
			window.addEventListener('openModalDetalle', event => {
				$('#modalFormDetalle').modal('show');
			});

			window.addEventListener('openDeleteModal', event => {
				$('#modalFormDelete').modal('show');
			});
			window.addEventListener('closeDeleteModal', event => {
				$('#modalFormDelete').modal('hide');
			});
			window.addEventListener('openInactivarModal', event => {
				$('#modalFormInactivar').modal('show');
			});
			window.addEventListener('closeInactivarModal', event => {
				$('#modalFormInactivar').modal('hide');
			});

			window.addEventListener('openActivarModal', event => {
				$('#modalFormActivar').modal('show');
			});
			window.addEventListener('closeActivarModal', event => {
				$('#modalFormActivar').modal('hide');
			});
			window.addEventListener('openErrorModal', event => {
				$('#modalFormError').modal('show');
			});
			window.addEventListener('closeErrorModal', event => {
				$('#modalFormError').modal('hide');
			});

			window.addEventListener('alert', event => {
				TerosAlert(event);
			});

			function cerrarMenuModal() {
				$('#menu-movilsss').modal('hide');
			}

			function mostrarMenuModal() {
				$('#menu-movilsss').modal('show');
			}
		</script>

		<!-- ========== END APOLO JS ========== -->

		@include('sweetalert::alert')
		@livewireScripts
		@stack('scripts')
	</div>
</body>

</html>