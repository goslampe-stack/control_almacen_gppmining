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
				<p><b>Proporciona información básica del transportista</b><br><span>Información para el transporte.</span></p>
			</div>
		</div>


		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="ruc" style="margin-bottom: 0px;">RUC</label><br>
					<span class="small">Agregue ruc del transportista </span>
					<input type="number" class="form-control apl-input-border" wire:model="ruc" maxlength="11" minlength="10">
					@error('ruc')<span class="text-danger small">{{$message}}</span> @enderror
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label for="razon_social" style="margin-bottom: 0px;">Raz&oacute;n social</label><br>
					<span class="small">Agregue raz&oacute;n social</span>
					<input type="text" class="form-control apl-input-border" wire:model="razon_social">
					@error('razon_social')<span class="text-danger small">{{$message}}</span> @enderror
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="direccion" class="mb-0">Direcci&oacute;n</label><br>
					<span class="small">Agregue la direcci&oacute;n</span>
					<textarea class="form-control apl-input-border" id="direccion" cols="30" rows="2" wire:model="direccion"></textarea>
					@error('direccion')<span class="text-danger">{{$message}}</span> @enderror
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group">
					<label for="celular" style="margin-bottom: 0px;">Celular</label><br>
					<span class="small">Agregue celular</span>
					<input type="number" class="form-control apl-input-border" wire:model="celular">
					@error('celular')<span class="text-danger small">{{$message}}</span> @enderror
				</div>
			</div>
			<div class="col-md-12">
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


		<div class="apl-spacing-top-2"></div>

		<div class="row">
			<div class="col-md-12 mt-3">
				<button type="button" class="btn btn-secondary" wire:click="cerrarFormulario" title="Cancelar">
					<i class="fas fa-ban"></i>
					Cancelar
				</button>
				@if($modelId)
				<button type="button" class="btn btn-primary mr-2 float-right" wire:click="actualizar" title="Actualizar" wire:loading.attr="disabled">
					<div wire:loading.delay>
						<i class="fas fa-spinner fa-spin mr-2"></i>
						<i class="fas fa-save"></i>
					</div> Actualizar
				</button>
				@else
				<button type="button" class="btn btn-primary mr-2 float-right" wire:click="guardar" title="Guardar" wire:loading.attr="disabled">
					<div wire:loading.delay>
						<i class="fas fa-spinner fa-spin mr-2"></i>
					</div>
					<i class="fas fa-save"></i>
					Guardar
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
					<p class="mt-3">Agregando proveedor a la lista</p>
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
				<button type="button" title="Agregar otro transportista" class="btn btn-primary btn-sm apl-btn-border mr-2 float-right" wire:click="crear" wire:loading.attr="disabled">
					Agregar otro transportista
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
				<button type="button" title="Agregar otro transportista" class="btn btn-primary btn-sm apl-btn-border mr-2 float-right" wire:click="crear" wire:loading.attr="disabled">
					Agregar otro transportista
				</button>
			</div>
		</div>
	</div>

</div>