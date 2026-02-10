<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="tipo_documento" style="margin-bottom: 0px;">Tipo documento</label><br>
            <span class="small">Seleccione el tipo documento </span>
            <select class="form-control apl-input-border" wire:model="tipo_documento" id="tipo_documento">
                <option value="">Seleccione el tipo de documento </option>
                @foreach($tipo_docuento_opciones as $item)
                <option value="{{ $item }}">{{ $item }}</option>
                @endforeach
            </select>
            @error('tipo_documento')<span class="text-danger">{{$message}}</span> @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="serie_documento" style="margin-bottom: 0px;">Series</label><br>
            <span class="small">Serie </span>
            <input type="text" class="form-control apl-input-border" id="serie_documento" wire:model="serie_documento">
            @error('serie_documento')<span class="text-danger small">{{$message}}</span> @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="numero_documento" style="margin-bottom: 0px;">N&uacute;mero de documento</label><br>
            <span class="small">Agregue el n&uacute;mero de documento </span>
            <input type="text" class="form-control apl-input-border" id="numero_documento" wire:model="numero_documento">
            @error('numero_documento')<span class="text-danger small">{{$message}}</span> @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="fecha_traslado" style="margin-bottom: 0px;">Fecha de traslado</label><br>
            <span class="small">Agregue fecha de traslado</span>
            <input type="date" class="form-control apl-input-border" id="fecha_traslado" wire:model="fecha_traslado">
            @error('fecha_traslado')<span class="text-danger small">{{$message}}</span> @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="serie_guia_remitente" style="margin-bottom: 0px;">Guia Remitente</label><br>
            <span class="small">serie </span>
            <input type="text" class="form-control apl-input-border" id="serie_guia_remitente" wire:model="serie_guia_remitente">
            @error('serie_guia_remitente')<span class="text-danger small">{{$message}}</span> @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="numero_documento_guia_remitente" style="margin-bottom: 0px;">Guia Remitente </label><br>
            <span class="small">N&uacute;mero de documento</span>
            <input type="text" class="form-control apl-input-border" id="numero_documento_guia_remitente" wire:model="numero_documento_guia_remitente">
            @error('numero_documento_guia_remitente')<span class="text-danger small">{{$message}}</span> @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="serie_guia_transportista" style="margin-bottom: 0px;">Guia Transportista </label><br>
            <span class="small">serie </span>
            <input type="text" class="form-control apl-input-border" id="serie_guia_transportista" wire:model="serie_guia_transportista">
            @error('serie_guia_transportista')<span class="text-danger small">{{$message}}</span> @enderror
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            <label for="numero_documento_guia_transportista" style="margin-bottom: 0px;">N&uacute;mero Transportista</label><br>
            <span class="small">N&uacute;mero de documento</span>
            <input type="text" class="form-control apl-input-border" id="numero_documento_guia_transportista" wire:model="numero_documento_guia_transportista">
            @error('numero_documento_guia_transportista')<span class="text-danger small">{{$message}}</span> @enderror
        </div>
    </div>




    <div class="col-md-4">
        <div class="form-group">
            <label for="transportes_id" style="margin-bottom: 0px;">Transportista</label><br>
            <span class="small">Eligir el transportista. </span>
            <select class="form-control apl-input-border demo-default" id="transportes_id" name="transportes_id" wire:model="transportes_id" style="width: 100%;">
                <option value="">{{__('Selecciona proveedor')}}</option>
                @foreach($transportistas as $item)
                <option value="{{ $item->id }}">{{ $item->razon_social }}: [{{ $item->ruc }}]</option>
                @endforeach
            </select>
            @error('transportes_id')<span class="text-danger">{{$message}}</span> @enderror
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <label for="cantidad" style="margin-bottom: 0px;">Cantidad</label><br>
            <span class="small">Art&iacute;culo</span>
            <input type="number" class="form-control apl-input-border" id="cantidad" wire:model="cantidad">
            @error('cantidad')<span class="text-danger small">{{$message}}</span> @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label for="precio_unitario" style="margin-bottom: 0px;">Precio unitario</label><br>
            <span class="small">Precio Unitario</span>
            <input type="number" class="form-control apl-input-border" id="precio_unitario" wire:model="precio_unitario">
            @error('precio_unitario')<span class="text-danger small">{{$message}}</span> @enderror
        </div>
    </div>


    <div class="col-md-3">
        <div class="form-group">
            <label for="fecha_ingreso" style="margin-bottom: 0px;">Fecha de ingreso</label><br>
            <span class="small">Agregue la fecha de ingreso</span>
            <input type="datetime-local" class="form-control apl-input-border" id="fecha_ingreso" wire:model="fecha_ingreso">
            @error('fecha_ingreso')<span class="text-danger small">{{$message}}</span> @enderror
        </div>
    </div>

</div>



