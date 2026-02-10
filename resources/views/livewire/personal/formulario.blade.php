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



			<div class="col-md-12">

				<div class="form-group">
					<div class="row">
						<div class="col-md-2">
							<div class="apl-file-box-adicional-full">
								<img src="{{$imagen}}" alt="" style="width: 100%; height: 140px;">
							</div>
						</div>
						<div class="col-md-2">
							<div class="apl-file-box-adicional">
								<div class="img" align="center">

									<i class="far fa-plus-square fa-lg"></i>
								</div>

								<div class="descripcion">
									<label for="imagen" class="apl-pointer-label">
										<font>Cambiar<br>firma digital</font>
									</label>
									<input type="file" class="d-none" id="imagen">
								</div>
							</div>
						</div>
						<div class="col-md-2"></div>
						<div class="col-md-2"></div>
					</div>

				</div>

			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label for="txt_ruc" style="margin-bottom: 0px;">Nombre</label><br>
					<span class="small">Agregue el nombre de un personal</span>
					<input type="text" class="form-control apl-input-border" name="txt_ruc" id="txt_ruc" wire:model="nombre">
					@error('nombre')<span class="text-danger small">{{$message}}</span> @enderror
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label for="txt_razonSocial" style="margin-bottom: 0px;">Apellidos</label><br>
					<span class="small">Agrega el apellido del personal</span>
					<input type="text" class="form-control apl-input-border" wire:model="apellidos">
					@error('apellidos')<span class="text-danger small">{{$message}}</span> @enderror
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="txt_correoElectronico" style="margin-bottom: 0px;">Tipo de documento</label><br>
					<span class="small">Seleccione tipo de documento </span>
					<select class="form-control apl-input-border" wire:model="tipo_documento">
						<option value="">Seleccione estado </option>
						@foreach($tipo_documento_opciones as $item)
						<option value="{{ $item }}">{{ $item }}</option>
						@endforeach
					</select>
					@error('tipo_documento')<span class="text-danger small">{{$message}}</span> @enderror
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label for="txt_celular" style="margin-bottom: 0px;">N° Documento</label><br>
					<span class="small">Agrega el n&uacute;mero perteneciente a su identidad</span>
					<input type="number" class="form-control apl-input-border" wire:model="numero_documento">

					@error('numero_documento')<span class="text-danger small">{{$message}}</span> @enderror
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="txt_ruc" style="margin-bottom: 0px;">Correo electr&oacute;nico</label><br>
					<span class="small">Agregue el correo electr&oacute;nico del personal</span>
					<input type="text" class="form-control apl-input-border" name="txt_ruc" id="txt_ruc" wire:model="correo_electronico">
					@error('correo_electronico')<span class="text-danger small">{{$message}}</span> @enderror
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label for="txt_razonSocial" style="margin-bottom: 0px;">Tel&eacute;fono celular</label><br>
					<span class="small">Agrege un telefono para contacto</span>
					<input type="number" class="form-control apl-input-border" wire:model="celular">
					@error('celular')<span class="text-danger small">{{$message}}</span> @enderror
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="txt_correoElectronico" style="margin-bottom: 0px;">Direcci&oacute;n</label><br>
					<span class="small">Agrega la direcci&oacute;n del personal que esta siendo atendido</span>
					<input type="text" class="form-control apl-input-border" wire:model="direccion">
					@error('direccion')<span class="text-danger small">{{$message}}</span> @enderror
				</div>



			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="txt_correoElectronico" style="margin-bottom: 0px;">Referencia</label><br>
					<span class="small">Agrega referencia del personal.</span>
					<input type="text" class="form-control apl-input-border" wire:model="referencia">
					@error('referencia')<span class="text-danger small">{{$message}}</span> @enderror
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="txt_ruc" style="margin-bottom: 0px;">Fecha de nacimiento</label><br>
					<span class="small">Agregue fecha de nacimiento</span>
					<input type="date" class="form-control apl-input-border" name="txt_ruc" id="txt_ruc" wire:model="fecha_nacimiento">
					@error('fecha_nacimiento')<span class="text-danger small">{{$message}}</span> @enderror
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label for="txt_correoElectronico" style="margin-bottom: 0px;">G&eacute;nero</label><br>
					<span class="small">Seleccione el g&eacute;nero</span>

					<select class="form-control apl-input-border" wire:model="genero">
						<option value="">Seleccione el g&eacute;nero </option>
						@foreach($genero_opciones as $item)
						<option value="{{ $item }}">{{ $item }}</option>
						@endforeach
					</select>
					@error('genero')<span class="text-danger small">{{$message}}</span> @enderror
				</div>
			</div>
		</div>

		<div class="row">

		
			<div class="col-md-6">
				<div class="form-group">
					<label for="tipoPersonals_Id" style="margin-bottom: 0px;">Tipo personal</label><br>
					<span class="small">Eligir tipo personal </span>
					<select class="form-control apl-input-border demo-default" id="tipoPersonals_Id" wire:model="tipoPersonals_Id" style="width: 100%;">
						<option value="">{{__('Selecciona proveedor')}}</option>
						@foreach($tipoPersonales as $item)
						<option value="{{ $item->id }}">{{ $item->nombre }}</option>
						@endforeach
					</select>
					@error('tipoPersonals_Id')<span class="text-danger">{{$message}}</span> @enderror
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
            $('#tipoPersonals_Id').select2({
                placeholder: '{{ __("Seleccione el personal") }}',
                allowClear: true
            });
        }
        initSelectPersonalDrop();
        $('#tipoPersonals_Id').on('change', function(e) {
            livewire.emit('selectedTipoPersonalItem', e.target.value)
        });
        window.livewire.on('select2TipoPersonal', () => {
            initSelectPersonalDrop();
        });

        /* SELECT 2 PARA CATEGORIA PRODUCTO */

</script>
@endpush