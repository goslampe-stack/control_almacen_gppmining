<x-app-layout>
	<div class="content-wrapper">
		<section class="content mt-3">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-12">
						<h4 class="mb-3"><b>Asignaciones Permisos</b></h4>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<form action="{{ route('permission-asign-actualizar', $roledetails->id) }}" method="post">
						<div class="card">
							<div class="card-body">
									{{ csrf_field() }}
									@foreach($current as $p)

									<div class="row">
										<div class="col-md-12">

											<div class="icheck-primary d-inline">
												<input type="checkbox" id="{{ $p->name }}" name="asignpermission[]" value="{{ $p->id }}" {{ $p->checked }}>
												<label for="{{ $p->name }}">
													{{ $p->name }}
												</label>
											</div>
										</div>
									</div>


									<!--
									<div class="w-full sm:w-auto flex items-center sm:ml-auto mt-3 sm:mt-1">
										<div class="mr-3">{{ $p->name }}</div>
										<input type="checkbox" data-target="#basic-accordion" id="{{ $p->name }}" name="asignpermission[]" value="{{ $p->id }}" class="show-code input input--switch border" {{ $p->checked }}>
									</div>
									-->
									@endforeach
							</div>

							<div class="card-footer">
								<button type="submit" title="Agregar empresa" class="btn btn-primary float-right" style="border-radius: .7rem;" id="btn_save">
								<i class="fas fa-save"></i> Guardar
								</button>
								<a href="{{ route('role') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Cancelar</a>
							</div>
						</div>
						</form>
					</div>
				</div>
			</div>
		</section>
	</div>
</x-app-layout>