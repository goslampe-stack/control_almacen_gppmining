<div class="row">


    <div class="col-md-2" style="background: #f2f2f2;">
        <button class="btn apl-btn-skyblue btn-sm mt-3 ml-2" wire:click="cambiarInformacionBasica()"><i class="fas fa-adjust mr-2"></i>Información básica</button>
        <button class="btn apl-btn-skyblue btn-sm mt-3 ml-2" wire:click="cambiarAccesoUsuario()"><i class="fas fa-user mr-2"></i>Acceso usuario</button>
    </div>

    <div class="col-md-10 bg-white">
        <div class="modal-body">

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
                            <p><b>Proporciona información básica de la empresa</b><br><span>Información de la empresa.</span></p>
                        </div>
                    </div>

                    <div class="row {{$visibleImagenPrincipal}}">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="txt_titulo" style="margin-bottom: 0px;">Imagen</label><br>
                                <span class="small">Agrega un título para describir el artículo. Los títulos pueden tener hasta 150 carácteres, pero recomendamos usar menos de 65.</span>

                                <div class="apl-file-box">
                                    <div class="img" align="center">
                                        <img src="{{ asset('dist/img/dropzone.png') }}" alt="Imagen">
                                    </div>

                                    <div class="descripcion">
                                        Arrastra y suelta un archivo para subirlo
                                        <div class="input-group justify-content-center">
                                            <label for="imagen">O <font>elige archivos de tu dispositivo</font></label>
                                            <input type="file" class="d-none" id="imagen">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row {{$visibleImagenAdicional}}">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="txt_titulo" style="margin-bottom: 0px;">Logo de la empresa </label>

                                <div class="row">
                                    @foreach($imagenes_producto as $item)
                                    <div class="col-md-2">
                                        <div class="apl-file-box-adicional-full">
                                            <img src="{{$item}}" alt="" style="width: 100%; height: 130px;">
                                        </div>
                                    </div>
                                    @endforeach
                                    <div class="col-md-2">
                                        <div class="apl-file-box-adicional">
                                            <div class="img" align="center">

                                                <i class="far fa-plus-square fa-lg"></i>
                                            </div>

                                            <div class="descripcion">
                                                <label for="imagen-adicional" class="apl-pointer-label">
                                                    <font>Cambiar<br>logo</font>
                                                </label>
                                                <input type="file" class="d-none" id="imagen-adicional">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-2"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @error('imagenes_producto')<span class="text-danger">{{$message}}</span> @enderror




                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="ruc" style="margin-bottom: 0px;">Ruc</label><br>
                                <span class="small">Agregue ruc de la empresa </span>
                                <input type="number" class="form-control apl-input-border" maxlength="11" minlength="11" wire:model="ruc">
                                @error('ruc')<span class="text-danger small">{{$message}}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="razon_social" style="margin-bottom: 0px;">Razon Social</label><br>
                                <span class="small">Agregue razon social de la empresa </span>
                                <input type="text" class="form-control apl-input-border" wire:model="razon_social">
                                @error('razon_social')<span class="text-danger small">{{$message}}</span> @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="celular" style="margin-bottom: 0px;">Tel&eacute;fono</label><br>
                                <span class="small">Agregue telefono de la empresa </span>
                                <input type="text" class="form-control apl-input-border" wire:model="celular">
                                @error('celular')<span class="text-danger small">{{$message}}</span> @enderror
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="direccion" style="margin-bottom: 0px;">Direcci&oacute;n</label><br>
                                <span class="small">Agregue irecci&oacute;n de la empresa </span>
                                <textarea class="form-control apl-input-border" id="descripcion" cols="30" rows="2" wire:model="direccion"></textarea>
                                @error('direccion')<span class="text-danger small">{{$message}}</span> @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="correo_electronico" style="margin-bottom: 0px;">Correo electr&oacute;nico</label><br>
                                <span class="small">Agregue correo electr&oacute;nico </span>
                                <input type="text" class="form-control apl-input-border" wire:model="correo_electronico">
                                @error('correo_electronico')<span class="text-danger small">{{$message}}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="encargado" style="margin-bottom: 0px;">Encargado</label><br>
                                <span class="small">Agregue el encargado de la empresa </span>
                                <input type="text" class="form-control apl-input-border" wire:model="encargado">
                                @error('encargado')<span class="text-danger small">{{$message}}</span> @enderror
                            </div>
                        </div>


                        <div class="col-md-4">
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

                <div class="apl-mdl-procesando {{$estaAccesoUsuario}}" id="apl-mdl-procesando">
				<div class="row">
						<div class="col-md-12">
							<button type="button" title="Cerrar" class="close" wire:click="cerrarFormulario">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="txt_correoElectronico" style="margin-bottom: 0px;">Usuario</label><br>
								<span class="small">Seleccione el usuario </span>
								<select class="form-control apl-input-border" wire:model="usuarios_id">
									<option value="">Seleccione usuario </option>
									@foreach($usuarios as $item)
									<option value="{{ $item->id }}">{{ $item->last_name }}, {{ $item->name }} [ {{ $item->email }} ]</option>
									@endforeach
								</select>
								@error('usuarios_id')<span class="text-danger">{{$message}}</span> @enderror
							</div>
						</div>

						<div class="col-md-2 ">

							<div class="form-group">
								<button type="button" title="Guardar" class="btn btn-primary mt-5 " wire:click="guardarUsuarioPermiso" wire:loading.attr="disabled">
									<div wire:loading.delay>
										<i class="fas fa-spinner fa-spin mr-2"></i>
									</div> <i class="fas fa-save"></i> Guardar
								</button>
							</div>



						</div>

						<div class="col-md-12">

							<div class="card apl-border">
								<div class="card-body">
									<div class="table-responsive">
										<table id="apl-table" class="table table-hover projects">
											<thead>
												<tr class="apl-table-header-tr">
												
													<td>Usuario</td>
													<td>Estado</td>
													<td class="text-center"> Opci&oacute;n</td>
												</tr>
											</thead>
											<tbody>
												@if($permisoUsuarios->isNotEmpty())
												@foreach ($permisoUsuarios as $item)
												<tr class="apl-table-body-tr pointer">
												


													<td>
														@if($item->estado == 1)
														Activo
														@else
														Inactivo
														@endif
													</td>

													<td>{{ $item->personal->last_name }},{{ $item->personal->name }}</td>
													<td class="text-center">
														<button type="button" title="Editar" class="text-danger" wire:click="eliminarPermisoUsuario({{$item->id}})">
															<i class="fas fa-trash"></i>
														</button>
													</td>

												</tr>
												@endforeach

												@else
												<tr>
													<td colspan="6" class="text-center">
														<center><img src="{{ asset('dist/img/empty.png') }}" alt="Imagen" width="30%"></center>
														<h4 class="text-muted">No hay resultados</h4>
													</td>
												</tr>
												@endif
											</tbody>
										</table>
										{{ $permisoUsuarios->links()}}
									</div>
								</div>
							</div>
						</div>
					</div>


				</div>





            </div>

        </div>
    </div>
</div>



@push('scripts')


<script>
    const CLOUDINARY_URL = 'https://api.cloudinary.com/v1_1/velasquez-paz/image/upload'
    const CLOUDINARY_UPLOAD_PRESET = 'jxnomlzd';
    const imageUploader = document.getElementById('imagen');
    const imageUploaderAdicional = document.getElementById('imagen-adicional');

    imageUploader.addEventListener('change', async (e) => {

        const file = e.target.files[0];
        const formData = new FormData();
        formData.append('file', file);
        formData.append('upload_preset', CLOUDINARY_UPLOAD_PRESET);

        // Send to cloudianry
        const res = await axios.post(
            CLOUDINARY_URL,
            formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
                onUploadProgress(e) {

                }
            }
        );



        @this.agregarImagen(res.data.secure_url);
    });

    imageUploaderAdicional.addEventListener('change', async (e) => {
        const file = e.target.files[0];
        const formData = new FormData();
        formData.append('file', file);
        formData.append('upload_preset', CLOUDINARY_UPLOAD_PRESET);

        // Send to cloudianry
        const res = await axios.post(
            CLOUDINARY_URL,
            formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
                onUploadProgress(e) {

                }
            }
        );


        @this.agregarImagen(res.data.secure_url);
    });
</script>
@endpush