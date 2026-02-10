<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requerimiento internos de productos</title>

    @php
    $marginTop = intval($contadorTotal);
    @endphp


    <style>
        * {
            margin:1px;
            padding: 0;
             
        }

        body {        

            text-align: start;
        }




        /* ================================================== */

        .plantilla .main-header {
            background: url({{$sucursalEmpresa->imagen}});
            background-size: cover;
            width: 100%;
            height: 150px;
            z-index: 100;
            position: absolute;
            top: 0px;
            right: 0px;
        }

        .informacion {
            width: 100%;
            margin-top: 110px;
         /*    margin-left: 1.5rem;
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
           /*  margin-right: 1.5rem; */
        }

        .tableprincipal .table {
            /* margin-left: 1.5rem; */
        }

        .tableprincipal table {
            width: 100%;

            margin-top: {{ $marginTop }}px;
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
            height: 140px;
            z-index: 50;
            position: absolute;
            bottom: 0px;
            right: 0px;
            text-align: center;
        }

        .pie-pagina .firma {
            width: 100%;
           /*  margin-left: 1.5rem; */
        }

        .pie-pagina .detalle {
            width: 100%;
           /*  margin-left: 1.5rem; */
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
                    <table width="100%" style="table-layout: fixed;">
                        <thead>
                            <tr>
                                <th ></th>
                                <th width="25%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr >
                                <td class="center-text" colspan="2"><b>REQUERIMIENTO INTERNO</b></td>
                            </tr>
                            <tr>
                                <td colspan="2" style=" padding-top: 10px;"><p></p></td>
                            </tr>
                            <tr>
                                <td>
                                   <b>N° requerimiento:</b> {{$requerimiento->numero_requerimiento}}
                                </td>
                                <td >
                                    <b>&Aacute;rea solicitante:</b> Almac&eacute;n
                                </td>
                            </tr>
                            <tr>
                                <td >
                                    <b>Fecha:</b> {{ \Carbon\Carbon::parse($requerimiento->fecha_pedido)->format('d/m/Y') }}
                                </td>
                                 <td >
                                        <p><b>&Aacute;rea destino:</b> Log&iacute;stica</p>
                                </td>

                            </tr>
                            <tr>
                                <td >
                                    <p><b>Concesi&oacute;n minera:</b> Estrella de pataz Nº. 6</p>
                                </td>
                                  <td  >
                                    <b>C&oacute;digo &uacute;nico:</b>15008259X01 
                                </td>
                            </tr>
                        

                            <tr>
                                <td colspan="2"> 
                                    <b>Ubicaci&oacute;n geogr&aacute;fica:</b>{{$sucursalEmpresa->direccion}} 
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
                        <th>Código</th>
                        <th>Artículo</th>
                        <th>Tipo unidad</th>
                        <th>Cantidad</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                    <tr>
                        <td align="center">{{ $item->articulo->codigo }}</td>
                        <td align="center">{{ $item->articulo->articulo }} </td>
                        <td align="center">{{ $item->articulo->tipoUnidad->nombre }}</td>
                        <td align="center">{{ $item->cantidad }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2"></td>
                        <td align="right"><b>TOTAL ARTÍCULOS</b></td>
                        <td align="center"><b>{{$total_articulos}}</b></td>
                    </tr>
                </tfoot>
            </table>
        </div>


        <footer class="main-footer">
            <div class="pie-pagina">
                <div class="detalle center-text">
                    <table width="100%" >
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