<div class="modal fade" id="modalFormError" data-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" title="Cerrar" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

                <div class="row text-center">
                    <div class="col-md-12">
                        <i class="fas fa-user-tie text-secondary" style="font-size: 5rem;"></i>
                    </div>

                    <div class="col-md-12">

                        <div class="card-body">
                            @if(count($almacenamientoNombreElimados)>0)
                            <h5 class="mt-2"><b>Elementos eliminados</b> <br> <span> Los elementos que se muestran a continuaci&oacute;n fueron eliminados</span> </h5>

                            <div class="col-sm-12">
                                @foreach($almacenamientoNombreElimados as $e)
                                <div class="form-check mb-2">
                                    <i class="fas fa-check text-primary"></i> <label class="form-check-label ml-2 mt-1">
                                        {{$e}}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>


                        <div class="card-body">
                            @if(count($almacenamientoNombreSinEliminar)>0)
                            <h5 class="mt-2"><b>Elementos sin eliminar</b> <br> <span> No se ha podido eliminar los elementos debido a que estan en uso en las habitaciones</span> </h5>

                            <div class="col-sm-12">
                                @foreach($almacenamientoNombreSinEliminar as $e)
                                <div class="form-check mb-2">
                                    <i class="fas fa-times text-danger"></i>
                                    <label class="form-check-label ml-2 mt-1">
                                        {{$e}}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        </p>
                    </div>


                    <div class="col-md-12">
                        <button type="button" title="Cerrar" class="btn btn-default apl-btn-border mr-1" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>