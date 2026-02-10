<div>

	<!-- ===================================== -->

	<div class="apl-mdl-formulario" id="apl-mdl-formulario">
		<div class="row">
			<div class="col-md-12">
				<button type="button" class="close" wire:click="cerrarFormulario">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<p><b>Proporciona información básica del artículo</b><br><span>Información del artículo.</span></p>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="codigo" style="margin-bottom: 0px;">C&oacute;digo</label><br>
					<span class="small">Agregue el C&oacute;digo del articulo </span>
					<input type="text" placeholder="0001" class="form-control apl-input-border" wire:model="codigo">
					@error('codigo')<span class="text-danger small">{{$message}}</span> @enderror
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="articulo" style="margin-bottom: 0px;">Art&iacute;culo</label><br>
					<span class="small">Agregue el Art&iacute;culo del requerimiento </span>
					<input type="text" placeholder="Carretilla" class="form-control apl-input-border" wire:model="articulo">
					@error('articulo')<span class="text-danger small">{{$message}}</span> @enderror
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="tipo_unidads_id" style="margin-bottom: 0px;">Unidad de medida</label><br>
					<span class="small">Eligir la unidad de medida </span>
					<select class="form-control apl-input-border demo-default" id="tipo_unidads_id" wire:model="tipo_unidads_id" style="width: 100%;">
						<option value="">{{__('Selecciona unidad de medidad')}}</option>
						@foreach($tipoUnidad as $item)
						<option value="{{ $item->id }}">{{ $item->nombre }}</option>
						@endforeach
					</select>
					@error('tipo_unidads_id')<span class="text-danger">{{$message}}</span> @enderror
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

		<div class="row">
			<div class="col-md-12 mt-3">
				<button type="button" class="btn btn-secondary" wire:click="cerrarFormulario">
					<i class="fas fa-ban"></i>
					Cancelar
				</button>
				@if($modelId)
				<button type="button" class="btn btn-primary mr-2 float-right" wire:click="actualizar" wire:loading.attr="disabled">
					<div wire:loading.delay>
						<i class="fas fa-spinner fa-spin mr-2"></i>
						<i class="fas fa-save"></i>
					</div> Actualizar
				</button>
				@else
				<button type="button" class="btn btn-primary mr-2 float-right" wire:click="guardar" wire:loading.attr="disabled">
					<i class="fas fa-save"></i>

					Guardar
				</button>
				@endif
			</div>
		</div>
	</div>
	<!-- ===================================== -->


</div>




@push('scripts')


<script>
	$(document).ready(function() {


		/* SELECT 2 PARA TIPO UNIDAD */
		window.initSelectTipoUnidadDrop = () => {
			$('#tipo_unidads_id').select2({
				placeholder: '{{ __("Seleccione unidad de medida") }}',
				allowClear: true
			});
		}
		initSelectTipoUnidadDrop();
		$('#tipo_unidads_id').on('change', function(e) {
			livewire.emit('selectedTipoUnidadItem', e.target.value)
		});
		window.livewire.on('select2TipoUnidad', () => {
			initSelectTipoUnidadDrop();
		});

		/* SELECT 2 PARA TIPO UNIDAD */



	});
</script>
@endpush