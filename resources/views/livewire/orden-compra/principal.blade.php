<div class="content-wrapper">
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="mb-3"><b>Orden de compra</b></h4>
                </div>
            </div>

            @if(\App\Models\Util::checkPermission('orden-compra-list'))

            <div class="row ">
                <div class="col-md-2">
                    <div class="card apl-border">
                        <div class="card-header">
                            <h6><b>Filtrar por</b></h6>
                        </div>

                        <!-- ===== FILTRAR ===== -->
                        <div class="card-body">
                            <div class="col-sm-12">
                                <div class="form-check mb-2">
                                    <input type="radio" class="form-check-input apl-radio" name="filtro" id="filtro" wire:click="cambiarFiltrarPorEstado('1')">
                                    <label class="form-check-label ml-2 mt-1">
                                        Activos
                                    </label>
                                </div>

                                <div class="form-check mb-2">
                                    <input type="radio" class="form-check-input apl-radio" name="filtro" id="filtro" wire:click="cambiarFiltrarPorEstado('0')">
                                    <label class="form-check-label ml-2">
                                        Inactivos
                                    </label>
                                </div>

                                <div class="form-check mb-2">
                                    <input type="radio" class="form-check-input apl-radio" name="filtro" id="filtro" checked="true" wire:click="cambiarFiltrarPorEstado('')">
                                    <label class="form-check-label ml-2">
                                        Todos
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- ===== BOX ===== -->
                            <div class="card apl-border">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <b>{{$data->count()}}</b><br>
                                            <font class="apl-text-gray">Orden de compra</font>
                                        </div>

                                        <div class="col-md-6">
                                            @if(\App\Models\Util::checkPermission('orden-compra-create'))

                                            <button type="button" title="Agregar nueva orden de compra" class="btn btn-primary float-right " style="border-radius: .7rem;" wire:click.prevent="crear">
                                                <i class="fas fa-plus"></i>

                                                Nuevo
                                            </button>

                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-1">
                                            @include('componentes.select-item-table')
                                        </div>

                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text apl-input-search-icon"><i class="fas fa-search"></i></div>
                                                </div>
                                                <input type="text" class="form-control apl-input-border apl-input-search" id="apl-table-buscar" placeholder="Buscar por Nª de orden" wire:model.debounce.800ms="search">
                                                <input type="date" class="form-control apl-input-border" wire:model="fecha_inicio">
                                                <input type="date" class="form-control apl-input-border" wire:model="fecha_fin">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="float-right">
                                                <button type="button" title="Item seleccionados" class="btn btn-default btn-sm apl-btn-border" disabled="true">
                                                    {{count($selectedItemsTable)}} Seleccionados
                                                </button>

                                                @if(\App\Models\Util::checkPermission('orden-compra-delete'))

                                                <button type="button" title="Eliminar" class="btn btn-danger btn-sm apl-btn-border " wire:click="eliminar()" {{$estaActivadoEliminar}}>
                                                    Eliminar
                                                </button>

                                                @endif




                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($data->isNotEmpty())
                    <div class="row">
                        <div class="col-md-12">
                            <!-- ===== TABLA ===== -->
                            <div class="card apl-border">
                                <div class="card-body">
                                    <div class="table-responsive">

                                        <table id="apl-table" class="table table-hover">
                                            <thead>
                                                <tr class="apl-table-header-tr">
                                                    <!--<td class="d-none"></td>-->
                                                    <td width="3%"></td>
                                                    <td  class="text-center">N° Orden Compra</td>
                                                    <td class="text-center"> N° Solicitud</td>
                                                    <td class="text-center"> N° Cotizaci&oacute;n proveedor</td>
                                                    <td  class="text-center">Fecha de Pedido</td>
                                                    <td class="text-center" >Proveedor</td>
                                                    <td class="text-center">Estado</td>
                                                    <td class="text-center"> Opci&oacute;n</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $item)
                                                <tr class="apl-table-body-tr pointer">
                                                    <!--<td class="d-none"></td>-->
                                                    <td>
                                                        <input type="checkbox" class="apl-border-checkbox" style="padding: .7rem;" value="{{ $item->id }}" wire:click="cambiarEstadoBotones" wire:model="selectedItemsTable">
                                                    </td>
                                                    @if(\App\Models\Util::checkPermission('orden-compra-edit'))
                                                    <td class="text-center">{{ $item->numero_orden_compra }}</td>
                                                    <td class="text-center">{{ $item->solicitudCotizacion->numero_solicitud_cotizacion }}</td>
                                                    <td class="text-center">{{ $item->cotizacion_proveedor }}</td>
                                                    <td class="text-center"> {{\Carbon\Carbon::parse($item->fecha_pedido)->format('d-m-Y')}}</td>
                                                    <td > {{ \App\Models\Util::getCantidadLetras($item->proveedor->razon_social ,70)}}</td>
                                                    <td class="text-center">
                                                        @if ($item->estado == 1)
                                                        <p class="text-green">Activo</p>

                                                        @elseif($item->estado == 2)
                                                        <p class="text-blue">Terminado</p>

                                                        @else
                                                        <p class="text-red">Inactivo</p>

                                                        @endif
                                                    </td>
                                                    <td class="text-center"><button type="button" title="Editar" class="text-primary" wire:click="editar_RP({{$item->id}})">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <a href="{{url('imprimir-orden-compra',['mes'=>$item->id])}}" target="_blank" class="text-secondary" title="Imprimir"><i class="fas fa fa-print"></i></a>
                                                    
                                                    </td>
                                                    @else
                                                    <td>{{ $item->numero_orden_compra }}</td>
                                                    <td>{{ $item->requerimientoPersonal->numero_requerimiento }}</td>
                                                    <td>{{ $item->fecha_pedido }}</td>
                                                    <td>{{ $item->fecha_estimada_pago }}</td>
                                                    <td>{{ $item->proveedor->razon_social }}</td>
                                                    <td>
                                                        @if ($item->estado == 1)
                                                        <p class="text-green">Activo</p>

                                                        @elseif($item->estado == 2)
                                                        <p class="text-blue">Terminado</p>

                                                        @else
                                                        <p class="text-red">Inactivo</p>

                                                        @endif
                                                    </td>
                                                    @endif
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{ $data->links()}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="row">
                        <div class="col-12 text-center">
                            <center><img src="{{ asset('dist/img/empty.png') }}" alt="Imagen" width="550"></center>
                            <h4 class="text-muted">No hay resultados</h4>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            @else
            <div class="row">
                <div class="col-md-12">
                    <p>No tiene permisos para usar esta funcion</p>
                </div>
            </div>
            @endif







            <!-- =============== MODAL =============== -->

            <div class="modal fade" id="modalForm" data-backdrop="static">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">

                        @livewire('orden-compra.formularios')

                    </div>
                </div>
            </div>



            <!-- ===================================== -->
            @include('componentes.modal-eliminar-items')
            <!-- ===================================== -->



        </div>
    </section>
</div>