<div>

	<!-- ===================================== -->

	<div class="apl-mdl-formulario {{$estaEnFormulario}}" id="apl-mdl-formulario">
		<div class="row">
			<div class="col-md-12">
				<button type="button" title="Cerrar" class="close" wire:click="cerrarFormulario">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<p><b>Proporciona información básica del personal</b><br><span>Información del personal.</span></p>
			</div>
		</div>



		<div class="row">


			@if($modelId==null)
			<div class="col-md-6">
				<div class="form-group">
					<label for="txt_correoElectronico" style="margin-bottom: 0px;">Tipo permiso</label><br>
					<span class="small">Seleccione tipo permiso </span>
					<select class="form-control apl-input-border" wire:model="tipo_permiso">
						<option value="">Seleccione tipo permiso </option>
						@foreach($modelarTipoPermiso as $index=>$item)

				
						<option value="{{ $index }}">{{ $item }}</option>
			
						@endforeach
					</select>
					@error('tipo_permiso')<span class="text-danger small">{{$message}}</span> @enderror
				</div>
			</div>

			@endif

			<div class="col-md-6">
				<div class="form-group">
					<label for="txt_correoElectronico" style="margin-bottom: 0px;">Estado</label><br>
					<span class="small">Seleccione el estado </span>
					<select class="form-control apl-input-border" wire:model="estado">
						<option value="">Seleccione estado </option>
						@foreach( $estado_opciones as $item)


						<option value="{{ $item }}">{{ $item }}</option>

						@endforeach
					</select>
					@error('estado')<span class="text-danger">{{$message}}</span> @enderror
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12 mt-3">
				<button type="button" title="Cancelar" class="btn btn-secondary" wire:click="cerrarFormulario">
					<i class="fa fa-times" aria-hidden="true"></i> Cancelar
				</button>
				@if($modelId)
				<button type="button" title="Actualizar" class="btn btn-primary mr-2 float-right" wire:click="actualizar" wire:loading.attr="disabled">
					<div wire:loading.delay>
						<i class="fas fa-spinner fa-spin mr-2"></i>
					</div><i class="fa fa-save" aria-hidden="true"></i> Actualizar
				</button>
				@else
				<button type="button" title="Guardar" class="btn btn-primary mr-2 float-right" wire:click="guardar" wire:loading.attr="disabled">
					<div wire:loading.delay>
						<i class="fas fa-spinner fa-spin mr-2"></i>
					</div><i class="fa fa-save" aria-hidden="true"></i> Guardar
				</button>
				@endif
			</div>
		</div>


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

										<td>Personal</td>
										<td>Tipo opci&oacute;n</td>
										<td>Estado</td>
										<td class="text-center">Opci&oacute;n</td>
									</tr>
								</thead>
								<tbody>
									@foreach ($data as $item)
									<tr class="apl-table-body-tr pointer">


										<td>{{ $item->personal->name }}, {{ $item->personal->last_name }}</td>
										<td>{{ $item->tipo_permiso }}</td>
										<td>
											@if($item->estado == 1)
											Activo
											@else
											Inactivo
											@endif
										</td>
										<td class="text-center">
											<button type="button" title="Editar" class="text-primary" wire:click="editarPermiso({{$item->id}})">
												<i class="fas fa-edit"></i>
											</button>
											<button type="button" title="Editar" class="text-danger" wire:click="eliminarPermiso({{$item->id}})">
												<i class="fas fa-trash"></i>
											</button>
										</td>
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

	<!-- ===================================== -->


</div>


@push('scripts')


<script>
	


	/* SELECT 2 PARA CATEGORIA PRODUCTO */
	window.initSelectPersonalDrop = () => {
		$('#personals_id').select2({
			placeholder: '{{ __("Seleccione el permiso") }}',
			allowClear: true
		});
	}
	initSelectPersonalDrop();
	$('#personals_id').on('change', function(e) {
		livewire.emit('selectedTipoPersonalItem', e.target.value)
	});
	window.livewire.on('select2TipoPersonal', () => {
		initSelectPersonalDrop();
	});

	/* SELECT 2 PARA CATEGORIA PRODUCTO */
</script>
@endpush