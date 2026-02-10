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
				<p><b>Proporciona información básica de la unidad de medida</b><br><span>Información de la unidad de medida.</span></p>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="txt_ruc" style="margin-bottom: 0px;">name</label><br>
					<span class="small">Agregue name de la unidad de medida </span>
					<input type="text" class="form-control apl-input-border" wire:model="name">
					@error('name')<span class="text-danger small">{{$message}}</span> @enderror
				</div>
			</div>
		</div>


		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="txt_correoElectronico" style="margin-bottom: 0px;">Estado</label><br>
					<span class="small">Seleccione el estado </span>
					<select class="form-control apl-input-border" wire:model="state">
						<option value="">Seleccione estado </option>
						@foreach($estado_opciones as $item)
						<option value="{{ $item }}">{{ $item }}</option>
						@endforeach
					</select>
					@error('state')<span class="text-danger">{{$message}}</span> @enderror
				</div>
			</div>
		</div>

		<div class="apl-spacing-top-5"></div>

		<div wire:offline>
			You are now offline.
		</div>

		<div class="row">
			<div class="col-md-12 mt-3">
				<button type="button" title="Cancelar" class="btn btn-secondary" wire:click="cerrarFormulario">
				<i class="fas fa-times"></i>
				 Cancelar
				</button>
				@if($modelId)
				<button type="button" title="Actualizar" class="btn btn-primary mr-2 float-right" wire:click="actualizar" wire:loading.attr="disabled">
					<div wire:loading.delay>
						<i class="fas fa-spinner fa-spin mr-2"></i>
					</div>
                    <i class="fas fa-save"></i>
					
					Actualizar
				</button>
				@else
				<button type="button" title="Guardar" class="btn btn-primary mr-2 float-right" wire:click="guardar" wire:loading.attr="disabled">
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
					<p class="mt-3">Agregando tipo unidad a la lista</p>
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
				<button type="button" title="Agregar otra unidad" class="btn btn-primary btn-sm apl-btn-border mr-2 float-right" wire:click="crear" wire:loading.attr="disabled">
					Agregar otra unidad
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
				<button type="button" title="Agregar otra unidad" class="btn btn-primary btn-sm apl-btn-border mr-2 float-right" wire:click="crear" wire:loading.attr="disabled">
					Agregar otra unidad
				</button>
			</div>
		</div>
	</div>

</div>