<div>

	<!-- ===================================== -->

	<div class="apl-mdl-formulario " id="apl-mdl-formulario">
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
			<div class="col-md-6">
				<div class="form-group">
					<label for="txt_ruc" style="margin-bottom: 0px;">Nombre</label><br>
					<span class="small">Agregue nombre de la unidad de medida </span>
					<input type="text" placeholder="METROS" class="form-control apl-input-border" wire:model="nombre">
					@error('nombre')<span class="text-danger small">{{$message}}</span> @enderror
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



		<div class="apl-spacing-top-5"></div>

		<div wire:offline>
			You are now offline.
		</div>

		<div class="row">
			<div class="col-md-12 mt-3">
				<button type="button" title="Cancelar" class="btn btn-secondary" wire:click="cerrarFormulario">
				<i class="fas fa-ban"></i> 	
				Cancelar
				</button>
				@if($modelId)
				<button type="button" title="Actualizar" class="btn btn-primary mr-2 float-right" wire:click="actualizar" wire:loading.attr="disabled">
					<div wire:loading.delay>
						<i class="fas fa-spinner fa-spin mr-2"></i>
					</div> <i class="fas fa-save"></i>  Actualizar
				</button>
				@else
				<button type="button" title="Guardar" class="btn btn-primary mr-2 float-right" wire:click="guardar" wire:loading.attr="disabled">
					<div wire:loading.delay>
						<i class="fas fa-spinner fa-spin mr-2"></i>
					</div><i class="fas fa-save"></i>  Guardar
				</button>
				@endif
			</div>
		</div>
	</div>



</div>