<div>

	<!-- ===================================== -->

	<div class="apl-mdl-formulario {{$estaEnFormulario}}" id="apl-mdl-formulario">
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
			<div class="col-md-12">
				<div class="form-group">
					<label for="articulo" style="margin-bottom: 0px;">Art&iacute;culo</label><br>
					<span class="small">Agregue el Art&iacute;culo del requerimiento </span>
					<input type="text" class="form-control apl-input-border" wire:model="articulo">
					@error('articulo')<span class="text-danger small">{{$message}}</span> @enderror
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="fecha_ingreso" style="margin-bottom: 0px;">Fecha ingreso</label><br>
					<span class="small">Fecha de ingreso </span>
					<input type="datetime-local" class="form-control apl-input-border" wire:model="fecha_ingreso" >
					@error('fecha_ingreso')<span class="text-danger small">{{$message}}</span> @enderror
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="fecha_salida" style="margin-bottom: 0px;">Fecha salida</label><br>
					<span class="small">Agregue la fecha de salida </span>
					<input type="datetime-local" class="form-control apl-input-border" wire:model="fecha_salida" wire:keydown.enter="actualizar">
					@error('fecha_salida')<span class="text-danger small">{{$message}}</span> @enderror
				</div>
			</div>
		</div>

		<div class="row">

			<div class="col-md-6">
				<div class="form-group">
					<div class="form-group">
						<label for="stock_disponible" style="margin-bottom: 0px;">Stock disponible</label><br>
						<span class="small">Agregue la cantidad </span>
						<input type="text" class="form-control apl-input-border" readonly="true" wire:model="stock_disponible">
						@error('stock_disponible')<span class="text-danger small">{{$message}}</span> @enderror
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<div class="form-group">
						<label for="cantidad_salida" style="margin-bottom: 0px;">Cantidad</label><br>
						<span class="small">Agregue la cantidad </span>
						<input type="text" class="form-control apl-input-border" wire:model="cantidad_salida" wire:keyup="verificarCantidadIngresada" wire:keydown.enter="actualizar">
						@error('cantidad_salida')<span class="text-danger small">{{$message}}</span> @enderror
					</div>
				</div>
			</div>
			<!-- <div class="col-md-4">
				<div class="form-group">
					<div class="form-group">
						<label for="saldo" style="margin-bottom: 0px;">Saldo</label><br>
						<span class="small">Saldo restante </span>
						<input type="text" class="form-control apl-input-border" wire:model="saldo">
						@error('saldo')<span class="text-danger small">{{$message}}</span> @enderror
					</div>
				</div>
			</div> -->
		</div>





		<div class="apl-spacing-top-2"></div>

		<div class="row">
			<div class="col-md-12 mt-3">
				<button type="button" class="btn btn-default" wire:click="cerrarFormulario">
					Cancelar
				</button>
				 
				<button type="button" class="btn btn-primary mr-2 float-right " wire:click="actualizar" wire:loading.attr="disabled">
					<div wire:loading.delay>
						<i class="fas fa-spinner fa-spin mr-2"></i>
					</div> Actualizar
				</button>
				
			</div>
		</div>
	</div>

	<!-- ===================================== -->

	<div class="apl-mdl-procesando {{$estaEnProcesando}}" id="apl-mdl-procesando">
		<div class="row">
			<div class="col-md-12">
				<button type="button" class="close" wire:click="cerrarFormulario">
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
				<button type="button" class="close" wire:click="cerrarFormulario">
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
				<button type="button" class="btn btn-default btn-sm apl-btn-border mr-2" wire:click="cerrarFormulario">
					Cerrar
				</button>
				@if($modelId)
				<button type="button" class="btn btn-primary btn-sm apl-btn-border mr-2 float-right" wire:click="cerrarFormulario" wire:loading.attr="disabled">
					Ver lista
				</button>
				@else
				<button type="button" class="btn btn-primary btn-sm apl-btn-border mr-2 float-right" wire:click="crear" wire:loading.attr="disabled">
					Agregar otro art&iacute;culo
				</button>
				@endif
			</div>
		</div>
	</div>

	<!-- ===================================== -->

	<div class="apl-mdl-error {{$estaEnError}}" id="apl-mdl-error">
		<div class="row">
			<div class="col-md-12">
				<button type="button" class="close" wire:click="cerrarFormulario">
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
				<button type="button" class="btn btn-default btn-sm apl-btn-border mr-2" wire:click="cerrarFormulario" wire:loading.attr="disabled">
					Cancelar
				</button>
				<button type="button" class="btn btn-primary btn-sm apl-btn-border mr-2 float-right" wire:click="crear" wire:loading.attr="disabled">
					Agregar otro unidad
				</button>
			</div>
		</div>
	</div>

</div>