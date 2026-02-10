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
                <p><b>Proporciona información básica del proveedor</b><br><span>Información del proveedor.</span></p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="txt_ruc" style="margin-bottom: 0px;">RUC</label><br>
                    <span class="small">Agregue RUC personal y/o empresa</span>
                    <input type="number" class="form-control apl-input-border" name="txt_ruc" id="txt_ruc" wire:model="ruc" maxlength="11" minlength="11">
                    @error('ruc')<span class="text-danger small">{{$message}}</span> @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="txt_razonSocial" style="margin-bottom: 0px;">Raz&oacute;n Social</label><br>
                    <span class="small">Agrega la raz&oacute;n social de la empresa</span>
                    <input type="text" class="form-control apl-input-border" wire:model="razon_social">
                    @error('razon_social')<span class="text-danger small">{{$message}}</span> @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="txt_correoElectronico" style="margin-bottom: 0px;">Correo Electrónico</label><br>
                    <span class="small">Agrega dirección de correo electrónico de la empresa</span>
                    <input type="text" class="form-control apl-input-border" wire:model="correo_electronico">
                    @error('correo_electronico')<span class="text-danger small">{{$message}}</span> @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="txt_celular" style="margin-bottom: 0px;">Celular</label><br>
                    <span class="small">Agrega el número de contacto de la empresa</span>
                    <input type="number" class="form-control apl-input-border" wire:model="celular" maxlength="9" minlength="9">

                    @error('celular')<span class="text-danger small">{{$message}}</span> @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="direccion" style="margin-bottom: 0px;">Dirección</label><br>
                    <span class="small">Agrega dirección donde se ubica la empresa</span>
                    <input type="text" class="form-control apl-input-border" wire:model="direccion">
                    @error('direccion')<span class="text-danger small">{{$message}}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="txt_correoElectronico" style="margin-bottom: 0px;">Referencia</label><br>
                    <span class="small">Agrega una referencia de la dirección.</span>
                    <input type="text" class="form-control apl-input-border" wire:model="referencia">
                    @error('referencia')<span class="text-danger small">{{$message}}</span> @enderror
                </div>
            </div>
        </div>

        <div class="row">
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
                    Agregar otro proveedor
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
                    Agregar otro proveedor
                </button>
            </div>
        </div>
    </div>

</div>