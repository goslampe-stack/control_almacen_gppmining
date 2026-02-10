@php
$user = Auth::user();
$module = $user->roles[0]->modules->sortBy('module_rank')->where('view_sidebar','=',1);

@endphp

<div class="content-wrapper">


    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-md-12  mb-2">
                    <div class="row">

                        @foreach($module as $m)

                        @if($m->opcion=='otros' && $m->identity=='empresa')


                        <div class="col-xs-2 col-md-1">
                            <a href="{{ route($m->module_url) }}">
                                <div class="card card-widget apl-card-hover">
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="description-block">
                                                    <h5 class="description-header text-dark">{{$m->name}}</h5>
                                                    <span class="description-text text-gray small"><i class="fas fa-arrow-right fa-lg"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>




                        @endif

                        @if($m->opcion=='entrada' && $m->identity=='tipo-unidad')

                        <div class="col-xs-2 col-md-1">
                            <a href="{{ route($m->module_url) }}">
                                <div class="card card-widget apl-card-hover">
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="description-block">
                                                    <h5 class="description-header text-dark">{{$m->name}}</h5>
                                                    <span class="description-text text-gray small"><i class="fas fa-arrow-right fa-lg"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>



                        @endif

                        @if($m->opcion=='entrada' && $m->identity=='articulo')
                        <div class="col-xs-2 col-md-1">
                            <a href="{{ route($m->module_url) }}">
                                <div class="card card-widget apl-card-hover">
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="description-block">
                                                    <h5 class="description-header text-dark">{{$m->name}} (Producto)</h5>
                                                    <span class="description-text text-gray small"><i class="fas fa-arrow-right fa-lg"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        @endif

                        @if($m->opcion=='otros' && $m->identity=='transporte')
                        <div class="col-xs-2 col-md-1">
                            <a href="{{ route($m->module_url) }}">
                                <div class="card card-widget apl-card-hover">
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="description-block">
                                                    <h5 class="description-header text-dark">{{$m->name}}</h5>
                                                    <span class="description-text text-gray small"><i class="fas fa-arrow-right fa-lg"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        @endif

                        @if($m->opcion=='otros' && $m->identity=='proveedor')
                        <div class="col-xs-2 col-md-1">
                            <a href="{{ route($m->module_url) }}">
                                <div class="card card-widget apl-card-hover">
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="description-block">
                                                    <h5 class="description-header text-dark">{{$m->name}}</h5>
                                                    <span class="description-text text-gray small"><i class="fas fa-arrow-right fa-lg"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                        @endif
                    

                        @endforeach


                      


                    </div>
                </div>

                <!-- =============== MODAL ===============  -->
                <div class=" modal " id="modalForm" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog ">
                        <div class="modal-content">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Crear una empresa</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        @livewire('tienda.crear')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>