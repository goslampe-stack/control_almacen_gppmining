<div class="row">
    <div class="col-md-12">
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

        <div class="form-group mt-4">
            <button class="btn btn-primary btn-block mt-4" wire:click="guardar" wire:loading.attr="disabled">
                <div wire:loading.delay>
                    <i class="fas fa-spinner fa-spin mr-2"></i>
                </div>Crear negocio
            </button>
        </div>
    </div>
</div>