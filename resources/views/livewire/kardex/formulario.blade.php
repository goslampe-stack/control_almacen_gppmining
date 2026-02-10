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
                                    border: 2px solid white;
                                    padding-left: 0.3rem;
                                    padding-right: 0.3rem;
                                }

                                .color-azul {
                                    background: #017BFF;
                                    color: white;
                                    padding: 0.3rem 0rem;
                                    text-transform: uppercase;
                                }
                            </style>

                            <div class="div">
                                <div class="row">
                                    <!--  <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="criterioBusqueda" style="margin-bottom: 0px;">Criterio de búsqueda</label><br>
                                            <span class="small">Seleccione el criterio </span>
                                            <select class="form-control apl-input-border" wire:model="criterioBusqueda">
                                                <option value="">Seleccione el criterio </option>
                                               
                                                <option value="rango">Por rango</option>

                                            </select>
                                            @error('criterioBusqueda')<span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                    </div> -->
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="articulo_id" style="margin-bottom: 0px;">Artículo</label><br>
                                            <span class="small">Eligir el artículo para obtener datos. </span>
                                            <select class="form-control apl-input-border demo-default" id="articulo_id" name="articulo_id" wire:model="articulo_id" style="width: 100%;">
                                                <option value="">{{__('Selecciona proveedor')}}</option>
                                                @foreach($articulos as $item)
                                                <option value="{{ $item->id }}">[{{ $item->codigo }}] {{ $item->articulo }}</option>
                                                @endforeach
                                            </select>
                                            @error('articulo_id')<span class="text-danger">{{$message}}</span> @enderror
                                        </div>
                                    </div>

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

                            </div>

                            <div class="apl-table-reporte-kardex">
                                <table width="100%">
                                    <thead>
                                        <tr class="text-center color-azul" >
                                            <th colspan="13">
                                                <h2 class="mt-3"><b>KÁRDEX</b></h2>
                                            </th>
                                        </tr>
                                        <tr class="text-center color-azul" >
                                            <th colspan="4">Artículo:</th>
                                            <td colspan="3">{{$articulo->articulo}}</td>
                                            <th colspan="3">Método:</th>
                                            <td colspan="3">Promedio ponderado</td>
                                        </tr>

                                        <tr class="text-center color-azul" >
                                            <th rowspan="2">Fecha</th>
                                            <th rowspan="2">Detalle</th>
                                            <th colspan="3">Entras</th>
                                            <th colspan="3">Salidas</th>
                                            <th colspan="3">Existencias</th>
                                        </tr>
                                        <tr class="text-center color-azul" >
                                            <th>cantidad</th>
                                            <th>precio</th>
                                            <th>total </th>

                                            <th>cantidad</th>
                                            <th>precio</th>
                                            <th>total </th>

                                            <th>cantidad</th>
                                            <th>precio</th>
                                            <th>total </th>


                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($auxiliar as $item)

                                        <tr class="text-center">
                                            <td style="background: #d6dec9;"> {{ \Carbon\Carbon::parse($item['auxo'])->format('d-m-Y') }} {{ \Carbon\Carbon::parse($item['auxo'])->format('g:i A') }}</td>

                                            <td class="text-left">{{$item['articulo']}}</td>
                                            <td>{{$item['cantidad-entrada']}}</td>
                                            <td>{{$item['precio-entrada']}}</td>
                                            <td>{{$item['total-entrada']}}</td>

                                            <td>{{$item['cantidad-salida']}}</td>
                                            <td>{{$item['precio-salida']}}</td>
                                            <td>{{$item['total-salida']}}</td>

                                            <td>{{$item['cantidad-existencia']}}</td>
                                            <td>{{$item['precio-existencia']}}</td>
                                            <td>{{$item['total-existencia']}}</td>


                                        </tr>


                                        @endforeach
                                    </tbody>

                                </table>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mt-3">
                                    <button type="button" class="btn btn-primary" wire:click="volverAtras">
                                        Ver lista de art&iacute;culos
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