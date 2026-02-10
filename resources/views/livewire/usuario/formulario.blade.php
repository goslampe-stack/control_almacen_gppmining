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
                <p><b>Proporciona información básica del usuario</b><br><span>Información del usuario.</span></p>
            </div>
        </div>

        <!--    <div class="row">


            <div class="col-md-12">
                <div class="form-group">
                    <label for="role_id" style="margin-bottom: 0px;">Rol</label><br>
                    <span class="small">Eligir el rol  </span>
                    <select class="form-control apl-input-border demo-default" id="role_id" wire:model="role_id" style="width: 100%;">
                        <option value="">{{__('Selecciona rol')}}</option>
                        @foreach($rol as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    @error('role_id')<span class="text-danger">{{$message}}</span> @enderror
                </div>
            </div>
        </div> -->

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name" style="margin-bottom: 0px;">Nombre</label><br>
                    <span class="small">Agregue nombre del usuario</span>
                    <input type="text" class="form-control apl-input-border" wire:model="name">
                    @error('name')<span class="text-danger small">{{$message}}</span> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="last_name" style="margin-bottom: 0px;">Apellidos</label><br>
                    <span class="small">Agregue apellidos del usuario</span>
                    <input type="text" class="form-control apl-input-border" wire:model="last_name">
                    @error('last_name')<span class="text-danger small">{{$message}}</span> @enderror
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group">
                    <label for="email" style="margin-bottom: 0px;">Correo elect&oacute;nico</label><br>
                    <span class="small">Agregue el correo electr&oacute;nico </span>
                    <input type="text" class="form-control apl-input-border" wire:model="email">
                    @error('email')<span class="text-danger small">{{$message}}</span> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="dni" style="margin-bottom: 0px;">N° Documento</label><br>
                    <span class="small">Agregue el N° documento </span>
                    <input type="text" class="form-control apl-input-border" wire:model="dni">
                    @error('dni')<span class="text-danger small">{{$message}}</span> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="descripcion" style="margin-bottom: 0px;">Descripci&oacute;n</label><br>
                    <span class="small">Agregue comentario</span>
                    <input type="text" class="form-control apl-input-border" wire:model="descripcion" placeholder="Usuario de llacuabamba">
                    @error('descripcion')<span class="text-danger small">{{$message}}</span> @enderror
                </div>
            </div>
            @if($modelId)

            @else

            <div class="col-md-6">
                <div class="form-group">
                    <label for="password" style="margin-bottom: 0px;">Contraseña</label><br>
                    <span class="small">Agregue la contraseña </span>
                    <input type="text" class="form-control apl-input-border" wire:model="password">
                    @error('password')<span class="text-danger small">{{$message}}</span> @enderror
                </div>
            </div>

            @endif

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



        <div class="apl-spacing-top-1"></div>

        <div wire:offline>
            You are now offline.
        </div>

        <div class="row">
            <div class="col-md-12 mt-3">
                <button type="button" title="Cancelar" class="btn btn-secondary" wire:click="cerrarFormulario">
                    <i class="fas fa-ban"></i> Cancelar
                </button>
                @if($modelId)
                <button type="button" title="Actualizar" class="btn btn-primary mr-2 float-right" wire:click="actualizar" wire:loading.attr="disabled">
                    <div wire:loading.delay>
                        <i class="fas fa-spinner fa-spin mr-2"></i>
                    </div><i class="fas fa-save"></i> Actualizar
                </button>
                @else
                <button type="button" title="Guardar" class="btn btn-primary mr-2 float-right" wire:click="guardar" wire:loading.attr="disabled">
                    <div wire:loading.delay>
                        <i class="fas fa-spinner fa-spin mr-2"></i>
                    </div><i class="fas fa-save"></i> Guardar
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
                    <p class="mt-3">Agregando usuario a la lista</p>
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
                <button type="button" title="Agregar otro usuario" class="btn btn-primary btn-sm apl-btn-border mr-2 float-right" wire:click="crear" wire:loading.attr="disabled">
                    Agregar otro usuario
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
                    Agregar otro usuario
                </button>
            </div>
        </div>
    </div>

</div>



@push('scripts')


<script>
    $(document).ready(function() {


        /* SELECT 2 PARA TIPO UNIDAD */
        window.initSelectRoleDrop = () => {
            $('#role_id').select2({
                placeholder: '{{ __("Seleccione Rol") }}',
                allowClear: true
            });
        }
        initSelectRoleDrop();
        $('#role_id').on('change', function(e) {
            livewire.emit('selectedRoleItem', e.target.value)
        });
        window.livewire.on('select2Role', () => {
            initSelectRoleDrop();
        });

        /* SELECT 2 PARA TIPO UNIDAD */



    });
</script>
@endpush