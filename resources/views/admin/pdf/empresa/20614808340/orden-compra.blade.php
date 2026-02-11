<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden de compra</title>
    @php
    $marginTop = intval($contadorTotal);
    @endphp
      <style>
        * {
            margin: 1px;
            padding: 0;   
              font-family: '{{$sucursalEmpresa->tipografia_pdf}}', sans-serif;
        }

        body {
            font-family: '{{$sucursalEmpresa->tipografia_pdf}}', sans-serif;

            text-align: start;
        }



        /* ================================================== */

        .plantilla .main-header {
            background: url({{$sucursalEmpresa->imagen}});
          background-size: 100% 200px;
          background-repeat: no-repeat;
            width: 100%;
            height: 210px;
            z-index: 100;
            position: absolute;
            top: 0px;
            right: 0px;
        }

        .informacion {
            width: 100%;
            margin-top: 170px;
           /*  margin-left: 1.5rem;
            margin-right: 1.5rem; */
        }

        .informacion .ruc {
            width: 100%;
            text-align: center;
        }

        .informacion .orden {
            width: 100%;
        }

        .informacion .orden .left {
            width: 50%;
            float: left;
            text-align: center;
        }

        .informacion .orden .right {
            width: 50%;
            float: right;
            text-align: center;
        }

        .informacion .descripcion {
            width: 100%;
        }

        .informacion .descripcion p {
             margin-bottom: .5rem;
        }

        /* ================================================== */

        .plantilla .tableprincipal {
            width: 100%;
            margin-right: 1.5rem;
        }

        .tableprincipal .table {
            margin-left: 0rem;
        }

        .tableprincipal table {
            width: 100%;
            margin-top: 500px;

            font-size: 12px;
        }

        .tableprincipal table th {
           background: {{$sucursalEmpresa->colorPdf}};
            color: #fff;
            padding: 0.3rem 0rem;
            text-transform: uppercase;
        }





        /* ================================================== */

        .plantilla .main-footer {
            /* background: url({{$sucursalEmpresa->imagen}}); */
            background-size: cover;
            background-position: 50% 100%;
            width: 100%;
            height: 220px;
            z-index: 50;
            position: absolute;
            bottom: 0px;
            right: 0px;
            text-align: center;
        }

        .pie-pagina .firma {
            width: 120%;
          /*   margin-left: 1.5rem;
            margin-right: 1.5rem; */
        }

        .pie-pagina .detalle {
            width: 100%;
        /*     margin-left: 1.5rem;
            margin-right: 1.5rem; */

        }

        .pie-table {
            width: 100%;
        /*     margin-left: 1.5rem;
            margin-right: 1.5rem; */
        }

        .pie-pagina .detalle .left {
            width: 50%;
            float: left;
            text-align: center;
        }

        .pie-pagina .detalle .right {
            width: 50%;
            float: right;
            text-align: center;
        }

        .center-text {

            text-align: center;
        }
    </style>
</head>

<body>
    <div class="plantilla">
        <header class="main-header">
            <div class="informacion">
                <div class="ruc">
                    <h3>&nbsp;</h3>
                    <br>
                </div>



                <div class="orden">
                    <table width="100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                            </tr>

                        </thead>
                        <tbody>

                            <tr>
                                <td>
                                    <p><b>{{ \App\Models\Util::getMayuscula($sucursalEmpresa->empresa->razon_social) }}</b> <br><span>{{$sucursalEmpresa->nombre_sucursal }}</span><br><br></p>
                                </td>
                                <td align="right">
                                    <p>
                                        <b> ORDEN DE COMPRA</b>
                                        <br>
                                        <span>
                                           <b>Doc relacionados</b>
                                        </span>
                                        <br>
                                        <span>
                                            N° de orden: {{$orden->numero_orden_compra}}
                                        </span>
                                        <br>
                                        <span>
                                            N° de solicitud: {{$orden->solicitudCotizacion->numero_solicitud_cotizacion}}
                                        </span>
                                         <br>
                                        <span>
                                            N° de cotizacion: {{$orden->solicitudCotizacion->numero_cotizacion}}
                                        </span>
                                        <br>
                                        <span>
                                            Fecha: {{ \Carbon\Carbon::parse($orden->fecha_pedido)->format('d/m/Y') }} 
                                        </span>
                                    </p>

                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <div>
                    <table width="100%">
                        <thead>
                            <tr>
                                <th style="width: 50%;"></th>
                                <th style="width: 50%;"></th>
                            </tr>

                        </thead>
                        <tbody>

                        <tr>
                                <td style="width: 50%;"> <span><b>CLIENTE</b></span><br></td>
                                <td style="width: 50%;"> <span><b>DATOS DEL PROVEEDOR</b></span><br></td>


                            </tr>

                            <tr>

                                <td style="width: 50%; vertical-align: top;">

                                    <span>
                                        <b>Raz&oacute;n social: </b> {{$sucursalEmpresa->empresa->razon_social}}

                                    </span><br>
                                    <span>
                                        <b> RUC: </b>{{$sucursalEmpresa->empresa->ruc}}

                                    </span><br>
                                    <span>
                                        <b>Domicilio Fiscal: </b>{{$sucursalEmpresa->direccion}}

                                    </span><br>
                                    <span>
                                        <b>Email: </b>{{$sucursalEmpresa->empresa->correo_electronico}}

                                    </span><br>

                                </td>

                                <td style="width: 50%; vertical-align: top;">

                                    <span>
                                        <b> Raz&oacute;n social: </b>  {{$orden->proveedor->razon_social}}

                                    </span><br>
                                    <span>
                                        <b> RUC: </b> {{$orden->proveedor->ruc}}

                                    </span><br>
                                    <span>
                                        <b> Direcci&oacute;n: </b> {{$orden->proveedor->direccion}}

                                    </span><br>

                                    <span>
                                        <b> Email: </b> {{$orden->proveedor->correo_electronico}}

                                    </span><br>
                                    <span>
                                        <b> N° de contacto: </b> {{$orden->proveedor->celular}}

                                    </span><br>

                                </td>
                             

                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </header>

        <div class="tableprincipal">

            <table class="table">
                <thead>
                    <tr>
                        <th>C&oacute;digo</th>
                        <th>Unidad</th>
                        <th>Artículo</th>
                        <th>Cantidad</th>
                        <th>Precio unitario</th>
                        <th>Precio total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articulos as $item)
                    <tr>
                        <td align="center">{{ $item->articuloRequerimiento->articuloSolicitudCotizacion->articuloRequerimiento->articulo->codigo }}</td>
                        <td align="center">{{ $item->articuloRequerimiento->articuloSolicitudCotizacion->articuloRequerimiento->articulo->tipoUnidad->nombre;}}</td>
                        <td align="center">{{ $item->articuloRequerimiento->articuloSolicitudCotizacion->articuloRequerimiento->articulo->articulo }}</td>
                        <td align="center">{{ $item->cantidad }}</td>
                        <td align="center">S/ {{ $item->darFormatoMoneda($item->precio_unitario)  }}</td>
                        <td align="right">S/ {{ $item->calcularPrecioTotal($item->cantidad,$item->precio_unitario) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="margin-top: 30px;">
                        <td colspan="4"></td>
                        <td align="center"><b>SUB TOTAL</b> </td>
                        <td align="right">S/ {{$subTotal}}</td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td align="center"><b>IGV (18%)</b> </td>
                        <td align="right">S/ {{$igv}}</td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        <td align="center"><b>TOTAL</b></td>
                        <td align="right"><b>S/ {{$costoTotal}}</b></td>
                    </tr>
                </tfoot>
            </table>
        </div>



        <footer class="main-footer">
            <div class="pie-pagina">
                <div class="detalle center-text">
                <table width="100%">
                        <thead>
                            <th></th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                     <p style="margin-top: 15px;">Nota: {{$orden->descripcion_solicitamos}}

                                        <br>
                                        <span>
                                            <b>Direcci&oacute;n de entrega zona: </b>{{$orden->terminos_de_entrega}}
                                        </span>
                                    </p>
                                </td>
                            </tr>

                        </tbody>
                    </table>

                    <table width="100%" height="50px">
                        <thead>

                            @foreach ($arregloFirmas as $aux)
                            <th></th>
                            @endforeach
                        </thead>
                        <tbody>
                            <tr>
                                @foreach ($arregloFirmas as $nombre=> $datos)
                                <td align="center">

                                    <img src="{{$datos['imagen']}}" alt="" style="width: 100px;height: 50px; margin-bottom: 0px; margin-top: 20px;">
                                    <br>
                                    <p style="margin-top: -30px;">_____________________________</p>
                                    <p style="margin-top: -30px;">{{$nombre}}<br>{{$datos['tipo']}}</p>

                                </td>
                                @endforeach

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>