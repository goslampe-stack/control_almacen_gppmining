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

                                .text-center {
                                    text-align: center;
                                }
                            </style>

                            <div class="">
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
                                            <th colspan="2">Método:</th>
                                            <td colspan="4">Promedio ponderado</td>
                                        </tr>

                                        <tr class="text-center" style="background: #75933d;">
                                            <th rowspan="2">Fecha</th>
                                            <th rowspan="2">Detalle</th>
                                            <th colspan="3">Entras</th>
                                            <th colspan="3">Salidas</th>
                                            <th colspan="5">Existencias</th>
                                        </tr>
                                        <tr class="text-center" style="background: #75933d;">
                                            <th>cantidad</th>
                                            <th>precio</th>
                                            <th>total </th>
                                            <th>cantidad</th>
                                            <th>precio</th>
                                            <th>total </th>
                                            <th>cantidad</th>
                                            <th>precio</th>
                                            <th colspan="3">total </th>


                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($auxiliarGeneral as $item)

                                        <tr class="text-center">
                                            <td style="background: #d6dec9;">{{ \Carbon\Carbon::parse($item['auxo']) }}</td>
                                            <td class="text-left">{{$item['articulo']}}</td>
                                            <td>{{$item['cantidad-entrada']}}</td>
                                            <td>{{$item['precio-entrada']}}</td>
                                            <td>{{$item['total-entrada']}}</td>

                                            <td>{{$item['cantidad-salida']}}</td>
                                            <td>{{$item['precio-salida']}}</td>
                                            <td>{{$item['total-salida']}}</td>

                                            <td>{{$item['cantidad-existencia']}}</td>
                                            <td style="text-align: center;">{{$item['precio-existencia']}}</td>
                                            <td colspan="3">{{$item['total-existencia']}}</td>


                                        </tr>


                                        @endforeach
                                    </tbody>

                                </table>
                            </div>

                            <div class="mt-3">
                                Elaborado y Autorizado por : {{$sucursalEmpresa->nombre_sucursal}} <br>
                                Imprimido por : {{$usuario->last_name}}, {{$usuario->name}}


                            </div>


                        </div>
                    </div>

                </div>


            </div>
    </section>
</div>