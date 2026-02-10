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
			<div class="col-md-6">
				<div class="form-group">
					<label for="txt_correoElectronico" style="margin-bottom: 0px;">Tipo persmiso</label><br>
					<span class="small">Seleccione tipo  persmiso</span>
					<select class="form-control apl-input-border" wire:model="tipo_opcion">
						<option value="">Seleccione persmiso </option>
						@foreach($tipo_opcion_opciones as $item)
						<option value="{{ $item }}">{{ $item }}</option>
						@endforeach
					</select>
					@error('tipo_opcion')<span class="text-danger small">{{$message}}</span> @enderror
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label for="personals_id" style="margin-bottom: 0px;">Personal</label><br>
					<span class="small">Eligir  personal </span>
					<select class="form-control apl-input-border demo-default" id="personals_id" wire:model="personals_id" style="width: 100%;">
						<option value="">{{__('Selecciona personal')}}</option>
						@foreach($tipoPersonales as $item)
						<option value="{{ $item->id }}">{{ $item->apellidos }}, {{ $item->nombre }} [{{ $item->tipoPersonal->nombre }}]</option>
						@endforeach
					</select>
					@error('personals_id')<span class="text-danger">{{$message}}</span> @enderror
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label for="txt_correoElectronico" style="margin-bottom: 0px;">Estado</label><br>
					<span class="small">Seleccione el estado </span>
					<select class="form-control apl-input-border" wire:model="estado">
						<option value="">Seleccione estado </option>
						@foreach($estado_opciones as $item)
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
	</div>

	<!-- ===================================== -->

	<div class="apl-mdl-procesando {{$estaEnProcesando}}" id="apl-mdl-procesando">
		<div class="row">
			<div class="col-md-12">
				<button type="button" title="Cerrar" class="close" wire:click="cerrarFormulario">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>

		<div class="row justify-content-center">
			<div class="col-md-4 ">
				<div class="apl-spacing-top-5"></div>

				<div class="form-group text-center">
					<i class="fas fa-redo fa-lg fa-spin"></i>
					<p class="mt-3">Agregando personal a la lista</p>
				</div>

				<div class="apl-spacing-bottom-12"></div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12 mt-3">

			</div>
		</div>
	</div>

	<!-- ===================================== -->

	<div class="apl-mdl-exito {{$estaEnCorrecto}}" id="apl-mdl-exito">
		<div class="row">
			<div class="col-md-12">
				<button type="button" title="Cerrar" class="close" wire:click="cerrarFormulario">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>

		<div class="row justify-content-center">
			<div class="col-md-4 ">
				<div class="apl-spacing-top-5"></div>

				<div class="form-group text-center">
					<i class="fas fa-check-circle fa-lg text-success"></i>
					@if($modelId)
					<p class="mt-3">Se actualizo correctamente a la lista</p>
					@else
					<p class="mt-3">Se agrego correctamente a la lista</p>
					@endif
				</div>

				<div class="apl-spacing-bottom-12"></div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12 mt-3">
				<button type="button" title="Cerrar" class="btn btn-default btn-sm apl-btn-border mr-2" wire:click="cerrarFormulario">
					Cerrar
				</button>
				@if($modelId)
				<button type="button" title="Ver lista" class="btn btn-primary btn-sm apl-btn-border mr-2 float-right" wire:click="cerrarFormulario" wire:loading.attr="disabled">
					Ver lista
				</button>
				@else
				<button type="button" title="Agregar otro personal" class="btn btn-primary btn-sm apl-btn-border mr-2 float-right" wire:click="crear" wire:loading.attr="disabled">
					Agregar otro personal
				</button>
				@endif
			</div>
		</div>
	</div>

	<!-- ===================================== -->

	<div class="apl-mdl-error {{$estaEnError}}" id="apl-mdl-error">
		<div class="row">
			<div class="col-md-12">
				<button type="button" title="Cerrar" class="close" wire:click="cerrarFormulario">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>

		<div class="row justify-content-center">
			<div class="col-md-4 ">
				<div class="apl-spacing-top-5"></div>

				<div class="form-group text-center">
					<i class="fas fa-times-circle fa-lg text-danger"></i>
					<p class="mt-3">Ocurrio un error al agregar a la lista</p>
				</div>

				<div class="apl-spacing-bottom-12"></div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12 mt-3">
				<button type="button" title="Cancelar" class="btn btn-default btn-sm apl-btn-border mr-2" wire:click="cerrarFormulario" wire:loading.attr="disabled">
					Cancelar
				</button>
				<button type="button" title="Agregar otro personal" class="btn btn-primary btn-sm apl-btn-border mr-2 float-right" wire:click="crear" wire:loading.attr="disabled">
					Agregar otro personal
				</button>
			</div>
		</div>
	</div>

</div>


@push('scripts')


<script>
	const CLOUDINARY_URL = 'https://api.cloudinary.com/v1_1/velasquez-paz/image/upload'
	const CLOUDINARY_UPLOAD_PRESET = 'jxnomlzd';
	const imageUploader = document.getElementById('imagen');


	imageUploader.addEventListener('change', async (e) => {

		const file = e.target.files[0];
		const formData = new FormData();
		formData.append('file', file);
		formData.append('upload_preset', CLOUDINARY_UPLOAD_PRESET);

		// Send to cloudianry
		const res = await axios.post(
			CLOUDINARY_URL,
			formData, {
				headers: {
					'Content-Type': 'multipart/form-data'
				},
				onUploadProgress(e) {

				}
			}
		);



		@this.agregarImagen(res.data.secure_url);
	});


	/* SELECT 2 PARA CATEGORIA PRODUCTO */
	window.initSelectPersonalDrop = () => {
		$('#personals_id').select2({
			placeholder: '{{ __("Seleccione el personal") }}',
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