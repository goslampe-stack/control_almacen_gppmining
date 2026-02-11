<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud de cotizaci&oacute;n </title>

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
            background-size: cover;
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
          /*   margin-left: 1.5rem;
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
            margin-top: 480px;
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
           /*  margin-left: 1.5rem;
            margin-right: 1.5rem; */

        }

        .pie-table {
            width: 100%;
          /*   margin-left: 1.5rem;
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
                                        <b> SOLICITUD DE COTIZACI&Oacute;N</b>
                                        <br>
                                        <span>
                                            N° requerimiento interno: {{$solicitud->requerimientoCompras->requerimientoPersonal->numero_requerimiento}}
                                        </span>
                                        <br>
                                        <span>
                                            N° solicitud: {{$solicitud->numero_solicitud_cotizacion}}
                                        </span>
                                        <br>
                                        <span>
                                            Fecha: {{ \Carbon\Carbon::parse($solicitud->fecha_solicitud)->format('d/m/Y') }}
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
                                <td style="width: 50%;"> <span><b>PROVEEDOR</b></span><br></td>


                            </tr>

                            <tr>
                                <td style="width: 50%;vertical-align: top;">


                                    <span>
                                        <b>Raz&oacute;n social: </b>{{$sucursalEmpresa->empresa->razon_social}}

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
                                <td style="width: 50%;  vertical-align: top;">


                                    <span>
                                        <b> Raz&oacute;n social: </b>{{$solicitud->proveedor->razon_social}}

                                    </span><br>
                                    <span>
                                        <b> RUC: </b>{{$solicitud->proveedor->ruc}}

                                    </span><br>

                                    <span>
                                        <b> Email: </b> {{$solicitud->proveedor->correo_electronico}}

                                    </span><br>
                                  
                                    

                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <div class="descripcion">
                    <p style="margin-top: 15px;">  Solicitamos tenga a bien cotizarnos los productos requeridos lineas abajo, por ser necesario para nuestras operaci&oacute;nes.</p>
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
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articulos as $item)
                    <tr>
                        <td align="center">{{ $item->articuloSolicitudCotizacion->articuloRequerimiento->articulo->codigo }}</td>
                        <td align="center">{{ $item->articuloSolicitudCotizacion->articuloRequerimiento->articulo->tipoUnidad->nombre;}}</td>
                        <td align="center">{{ $item->articuloSolicitudCotizacion->articuloRequerimiento->articulo->articulo }}</td>
                        <td align="center">{{ $item->cantidad }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="1"></td>
                        <td colspan="2" align="right">TOTAL ART&Iacute;CULOS</td>
                        <td align="center">{{$costoTotal}}</td>
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
                                    <p style="margin-top: 15px;">Nota: {{$solicitud->descripcion_solicitamos}}

                                        <br>
                                        <span>
                                            <b>Direcci&oacute;n de entrega zona: </b>{{$solicitud->descripcion}}
                                        </span>
                                    </p>

                                </td>
                            </tr>

                        </tbody>
                    </table>
                    <table width="100%" style="margin-top: 0px;">
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