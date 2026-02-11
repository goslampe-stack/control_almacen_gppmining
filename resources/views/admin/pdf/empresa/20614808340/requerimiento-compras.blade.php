<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requerimiento de compras</title>
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
            text-align: start;
           /*  margin-left: 1.5rem;
            margin-right: 1.5rem; */
        }

        .informacion .ruc {
            width: 100%;
            text-align: start;
        }

      .informacion .orden .left,
        .informacion .orden .right {
            width: 50%;
            float: left;
            text-align: start;
        }

        .informacion .descripcion {
            width: 100%;
            text-align: start;
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
            margin-left:0rem;
        }

        .tableprincipal table {
            width: 100%;
            margin-top: 365px;
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
            height: 130px;
            z-index: 50;
            position: absolute;
            bottom: 0px;
            right: 0px;
            text-align: center;
        }

        .pie-pagina .firma {
            width: 100%;
            margin-left: 1.5rem;
        }

        .pie-pagina .detalle {
            width: 100%;
            margin-left: 1.5rem;
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
                                        <b> REQUERIMIENTO DE COMPRAS</b>
                                        <br>
                                        <span>
                                            N° Requerimiento: {{$requerimiento->numero_requerimiento_compra}}
                                        </span>
                                        <br>
                                        <span>
                                            Fecha: {{ \Carbon\Carbon::parse($requerimiento->fecha_requerimiento)->format('d/m/Y') }} 
                                        </span>
                                    </p>

                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>



                <div class="descripcion" style="margin-top: 10px;">
                 

                    <p><b>DIRECCI&Oacute;N DE LA EMPRESA:</b> {{$sucursalEmpresa->direccion}}</p>

                    <p><b>N° DE REQUERIMIENTO INTERNO DE PRODUCTOS:</b> {{$requerimiento->requerimientoPersonal->numero_requerimiento}}</p>

                    <!-- <p style="margin-top: 15px;">Sírvanse por este medio suministrarnos los siguientes artículos</p> -->
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
                        <td align="center">{{ $item->articuloRequerimiento->articulo->codigo }}</td>
                        <td align="center">{{ $item->articuloRequerimiento->articulo->tipoUnidad->nombre;}}</td>
                        <td align="center">{{ $item->articuloRequerimiento->articulo->articulo }}</td>
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