<div class="content-wrapper">
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="apl-mdl-formulario " id="apl-mdl-formulario">


                        <div class="row">
                            <div class="col-md-12">
                                <p><b>Proporciona información básica del personal</b><br><span>Información del personal de su tienda.</span></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="ruc" class="mb-0">Información ruc de la empresa</label><br>
                            <span class="small">Usa el ruc de la empresa</span>
                            <input type="text" class="form-control apl-input-border" id="ruc" maxlength="11" minlength="10" wire:model="ruc">
                            @error('ruc')<span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="razon_social" class="mb-0">Razon social </label><br>
                            <span class="small">Usa la razon social de la empresa</span>
                            <input type="text" class="form-control apl-input-border" id="razon_social" wire:model="razon_social">
                            @error('razon_social')<span class="text-danger">{{$message}}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="descripcion" class="mb-0">Descripción</label><br>
                            <span class="small">A continuación detallanos brevemente acerca de tú negocio</span>
                            <textarea class="form-control apl-input-border" id="descripcion" cols="30" rows="10" wire:model="descripcion"></textarea>
                            @error('descripcion')<span class="text-danger">{{$message}}</span> @enderror
                        </div>

                        <div class="form-group">
                            <div class="alert apl-alert-info alert-dismissible mt-4">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Puedes agregar imágenes, información de contacto y otros detalles una vez que crees la página.
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-12 mt-3">
                                <a href="{{ route('informacion') }}" title="Cancelar" class="btn btn-default" wire:click="cerrarFormulario">
                                    Cancelar
                                </a>
                                @if($modelId)
                                <button type="button" title="Actualizar" class="btn btn-primary mr-2 float-right" wire:click="actualizar" wire:loading.attr="disabled">
                                    <div wire:loading.delay>
                                        <i class="fas fa-spinner fa-spin mr-2 mr-2"></i>
                                    </div>Actualizar
                                </button>
                                @else
                                <button type="button" title="Guardar" class="btn btn-primary mr-2 float-right" wire:click="guardar" wire:loading.attr="disabled">
                                    <div wire:loading.delay>
                                        <i class="fas fa-spinner fa-spin mr-2 mr-2"></i>
                                    </div>Guardar
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>





<!-- ===================================== -->