<div class="content-wrapper">
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-body">
                            <style type="text/css">
                                .apl-table-reporte-kardex table {
                                    border-collapse: collapse;
                                }

                                .apl-table-reporte-kardex td,
                                th {
                                    border: 2px solid #000;
                                    padding-left: 0.3rem;
                                    padding-right: 0.3rem;
                                }
                            </style>

                            <div class="div">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="criterioBusqueda" style="margin-bottom: 0px;">Criterio de búsqueda</label><br>
                                            <span class="small">Seleccione el criterio </span>
                                            <select class="form-control apl-input-border" wire:model="criterioBusqueda">
                                                <option value="">Seleccione el criterio </option>
                                               
                                                <option value="rango">Por rango</option>

                                            </select>
                                            @error('criterioBusqueda')<span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="articulo_id" style="margin-bottom: 0px;">Artículo</label><br>
                                            <span class="small">Eligir el artículo para obtener datos. </span>
                                            <select class="form-control apl-input-border demo-default" id="articulo_id" name="articulo_id" wire:model="articulo_id" style="width: 100%;">
                                                <option value="">{{__('Selecciona proveedor')}}</option>
                                                @foreach($articulos as $item)
                                                <option value="{{ $item->id }}">{{ $item->articulo }}</option>
                                                @endforeach
                                            </select>
                                            @error('articulo_id')<span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row {{$estaHabilitadoCriterioRango}}">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="rango_inicio" style="margin-bottom: 0px;">Fecha inicio</label><br>
                                            <span class="small">Seleccione el rango de fecha inicio </span>
                                            <input type="date" class="form-control apl-input-border" wire:model="rango_inicio">
                                            @error('rango_inicio')<span class="text-danger small">{{$message}}</span> @enderror
                                        </div>


                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="rango_fin" style="margin-bottom: 0px;">Fecha fin</label><br>
                                            <span class="small">Seleccione el rango de fecha fin</span>
                                            <input type="date" class="form-control apl-input-border" wire:model="rango_fin">
                                            @error('rango_fin')<span class="text-danger small">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="txt_correoElectronico" style="margin-bottom: 0px;"></label><br>
                                            <span class="small"> </span>

                                            <a href="{{url('imprimir-kardex',[
                                            'criterioBusqueda'=>$criterioBusqueda,
                                            'rango_inicio'=>$rango_inicio,
                                            'rango_fin'=>$rango_fin,
                                            'mes'=>$mesSeleccionado,
                                            'anio'=>$anio_seleccionado,
                                            'articulo'=>$articulo_id                                            
                                            ])}}" target="_blank" class="btn btn-primary mr-2 mt-4">
                                                Imprimir
                                            </a>
                                           

                                        </div>
                                    </div>
                                </div>

                                <div class="row {{$estaHabilitadoCriterioMeses}}">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="anio_seleccionado" style="margin-bottom: 0px;">Anio</label><br>
                                            <span class="small">Seleccione el anio </span>
                                            <select class="form-control apl-input-border" wire:model="anio_seleccionado">
                                                <option value="">Seleccione estado </option>
                                                @foreach($opcionesAnio as $item)
                                                <option value="{{ $item->identificador }}">{{ $item->anio }}</option>
                                                @endforeach
                                            </select>
                                            @error('anio_seleccionado')<span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="mesSeleccionado" style="margin-bottom: 0px;">Mes</label><br>
                                            <span class="small">Seleccione el mes </span>
                                            <select class="form-control apl-input-border" wire:model="mesSeleccionado">
                                                <option value="">Seleccione estado </option>
                                                @foreach($opcionesMes as $item)
                                                <option value="{{ $item->identificador }}">{{ $item->mes }}</option>
                                                @endforeach
                                            </select>
                                            @error('mesSeleccionado')<span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="txt_correoElectronico" style="margin-bottom: 0px;"></label><br>
                                            <span class="small"> </span>

                                            <a href="{{url('imprimir-kardex',[
                                            'criterioBusqueda'=>$criterioBusqueda,
                                            'rango_inicio'=>$rango_inicio,
                                            'rango_fin'=>$rango_fin,
                                            'mes'=>$mesSeleccionado,
                                            'anio'=>$anio_seleccionado,
                                            'articulo'=>$articulo_id,                                            
                                            ])}}" class="btn btn-primary mr-2 mt-4">
                                                Imprimir
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="apl-table-reporte-kardex">
                                <table width="100%">
                                    <thead>
                                        <tr class="text-center" style="background: #c2d699;">
                                            <th colspan="13">
                                                <h2 class="mt-3"><b>KÁRDEX</b></h2>
                                            </th>
                                        </tr>
                                        <tr class="text-center" style="background: #c2d699;">
                                            <th colspan="4">Artículo:</th>
                                            <td colspan="3">{{$articulo->articulo}}</td>
                                            <th colspan="3">Excistencia mínima:</th>
                                            <td colspan="3">0</td>
                                        </tr>
                                        <tr class="text-center" style="background: #c2d699;">
                                            <th colspan="4">Método:</th>
                                            <td colspan="3">Promedio ponderado</td>
                                            <th colspan="3">Excistencia máxima:</th>
                                            <td colspan="3">0</td>
                                        </tr>
                                        <tr class="text-center" style="background: #75933d;">
                                            <th colspan="3">Fecha</th>
                                            <th rowspan="2">Detalle</th>
                                            <th colspan="3">Entras</th>
                                            <th colspan="3">Salidas</th>
                                            <th colspan="3">Existencias</th>
                                        </tr>
                                        <tr class="text-center" style="background: #75933d;">
                                            <th>D</th>
                                            <th>M</th>
                                            <th>A</th>
                                            <th>Cantidad</th>
                                            <th>V/ Unitario</th>
                                            <th>V/ Total</th>
                                            <th>Cantidad</th>
                                            <th>V/ Unitario</th>
                                            <th>V/ Total</th>
                                            <th>Cantidad</th>
                                            <th>V/ Unitario</th>
                                            <th>V/ Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-center">
                                            <td style="background: #d6dec9;"></td>
                                            <td style="background: #d6dec9;"></td>
                                            <td style="background: #d6dec9;"></td>
                                            <td class="text-left">Saldo anterior</td>
                                            <td></td>
                                            <td></td>
                                            <td style="background: #d6dec9;"></td>
                                            <td></td>
                                            <td></td>
                                            <td style="background: #d6dec9;"></td>
                                            <td>{{$cantidad_existencia_total_inicial}}</td>
                                            <td>{{$valor_unitario_total_inicial}}</td>
                                            <td style="background: #d6dec9;">S/{{$valor_total_total_inicial}}</td>
                                        </tr>
                                        @foreach ($articuloRequerimientoPersonal as $item)

                                        @if($item->operacion == 'entrada_detalle')
                                        <tr class="text-center">
                                            <td style="background: #d6dec9;">{{ \Carbon\Carbon::parse($item->fecha_ingreso)->format('d') }}</td>
                                            <td style="background: #d6dec9;">{{ \Carbon\Carbon::parse($item->fecha_ingreso)->format('m') }}</td>
                                            <td style="background: #d6dec9;">{{ \Carbon\Carbon::parse($item->fecha_ingreso)->format('Y') }}</td>
                                            <td class="text-left">Según factura N° {{$item->numero_documento}}</td>
                                            <td>{{$item->cantidad}}</td>
                                            <td>S/{{$item->darFormatoMoneda($item->precio_unitario)}}</td>
                                            <td style="background: #d6dec9;">S/{{$item->calcularPrecioTotal($item->cantidad,$item->precio_unitario)}}</td>
                                            <td></td>
                                            <td></td>
                                            <td style="background: #d6dec9;"></td>
                                            <td>{{$item->cantidad_existencia}}</td>
                                            <td>{{$item->valor_unitario_existencias}}</td>
                                            <td style="background: #d6dec9;">S/{{$item->darFormatoMoneda($item->valor_existencia)}}</td>
                                        </tr>
                                        @else

                                        <tr class="text-center">
                                            <td style="background: #d6dec9;">{{ \Carbon\Carbon::parse($item->fecha_salida)->format('d') }}</td>
                                            <td style="background: #d6dec9;">{{ \Carbon\Carbon::parse($item->fecha_salida)->format('m') }}</td>
                                            <td style="background: #d6dec9;">{{ \Carbon\Carbon::parse($item->fecha_salida)->format('Y') }}</td>
                                            <td class="text-left">Según requerimiento N° {{$item->articuloRequerimiento->requerimientoPersonal->numero_requerimiento}} </td>
                                            <td></td>
                                            <td></td>
                                            <td style="background: #d6dec9;"></td>
                                            <td>{{$item->cantidad}}</td>
                                            <td>{{$item->valor_unitario_salida}}</td>
                                            <td style="background: #d6dec9;">S/{{$item->calcularPrecioTotal($item->cantidad,$item->valor_unitario_salida)}}</td>
                                            <td>{{$item->cantidad_existencia}}</td>
                                            <td>{{$item->valor_unitario_existencias}}</td>
                                            <td style="background: #d6dec9;">S/{{$item->darFormatoMoneda($item->valor_existencia)}}</td>
                                        </tr>
                                        @endif

                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="text-center">
                                            <td style="background: #d6dec9;"></td>
                                            <td style="background: #d6dec9;"></td>
                                            <td style="background: #d6dec9;"></td>
                                            <td class="text-danger text-left" style="background: #94d152;">Inventario final</td>
                                            <td style="background: #94d152;"></td>
                                            <td style="background: #94d152;"></td>
                                            <td style="background: #94d152;"></td>
                                            <td style="background: #94d152;"></td>
                                            <td style="background: #94d152;"></td>
                                            <td style="background: #94d152;"></td>
                                            <td class="text-danger" style="background: #94d152;">{{$cantidad_existencia_total}}</td>
                                            <td class="text-danger" style="background: #94d152;">{{$valor_unitario_total}}</td>
                                            <td class="text-danger" style="background: #94d152;">{{$valor_total_total}}</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td style="background: #d6dec9;"></td>
                                            <td style="background: #d6dec9;"></td>
                                            <td style="background: #d6dec9;"></td>
                                            <td class="text-left">&nbsp;</td>
                                            <td></td>
                                            <td></td>
                                            <td style="background: #d6dec9;"></td>
                                            <td></td>
                                            <td></td>
                                            <td style="background: #d6dec9;"></td>
                                            <td></td>
                                            <td></td>
                                            <td style="background: #d6dec9;"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mt-3">
                                    <button type="button" class="btn btn-default" wire:click="volverAtras">
                                        Ver lista
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>




@push('scripts')


<script>
    $(document).ready(function() {

        /* SELECT 2 PARA CATEGORIA PRODUCTO */
        window.initSelectArticuloDrop = () => {
            $('#articulo_id').select2({
                placeholder: '{{ __("Seleccione el articulo") }}',
                allowClear: true
            });
        }
        initSelectArticuloDrop();
        $('#articulo_id').on('change', function(e) {
            livewire.emit('selectedArticuloItem', e.target.value)
        });
        window.livewire.on('select2Articulo', () => {
            initSelectArticuloDrop();
        });

        /* SELECT 2 PARA CATEGORIA PRODUCTO */


    });
</script>
@endpush