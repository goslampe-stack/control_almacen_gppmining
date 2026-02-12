<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingreso</title>
    <style>
      * {
            margin: 1px;
            font-size: 12px;
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
            background-size: 100% 100%;
            background-repeat: no-repeat;
            width: 100%;
            height: 220px;
            z-index: 100;
            position: absolute;
            top: 0px;
            right: 0px;
        }

        .informacion {
            width: 100%;
            margin-top: 170px;
        /*     margin-left: 1.5rem;
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
           /*  margin-bottom: .5rem; */
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
            margin-top: 280px;
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
            height: 110px;
            z-index: 50;
            position: absolute;
            bottom: 0px;
            right: 0px;
            text-align: center;
        }

        .pie-pagina .firma {
            width: 100%;
          /*   margin-left: 1.5rem; */
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
                                        <b> INGRESO DE ART&Iacute;CULOS AL ALMAC&Eacute;N</b>
                                        <br>
                                        <span>
                                            N° ingreso: {{$ingreso->numero_ingreso}}
                                        </span>
                                        <br>
                                        <span>
                                            Fecha de ingreso:  {{ \Carbon\Carbon::parse($articulos[0]->fecha_ingreso)->format('d/m/Y') }}
                                        </span>
                                    </p>

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
                        <th>Descripción</th>
                        <th>UND.</th>
                        <th>CANT.</th>
                        <th>Nº OC</th>
                        <th>GRR</th>
                        <th>GRT</th>
                        <th>N° Factura</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articulos as $item)
                    <tr>
                        <td align="center">{{ $item->articuloOrdenCompra->articuloRequerimiento->articuloSolicitudCotizacion->articuloRequerimiento->articulo->articulo }}</td>
                        <td align="center">{{ $item->articuloOrdenCompra->articuloRequerimiento->articuloSolicitudCotizacion->articuloRequerimiento->articulo->tipoUnidad->nombre }}</td>
                        <td align="center">{{ $item->cantidad }}</td>
                        <td align="center">{{$ingreso->ordenDeCompra->numero_orden_compra}}</td>
                        <td align="center">{{ $item->serie_guia_remitente }}-{{ $item->numero_documento_guia_remitente }}</td>
                        <td align="center">{{ $item->serie_guia_transportista }}-{{ $item->numero_documento_guia_transportista}}</td>
                        <td align="center">{{ $item->serie_documento }}-{{ $item->numero_documento }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>

                </tfoot>
            </table>

        </div>


        <footer class="main-footer">
            <div class="pie-pagina">
                <div class="detalle center-text">
                    <table width="100%">
                        <thead>

                            @foreach ($personalPdf as $aux)
                            <th></th>
                            @endforeach
                        </thead>
                        <tbody>
                            <tr>
                                @foreach ($personalPdf as $aux)
                                <td align="center">

                                    <img src="{{$aux->personal->imagen}}" alt="" style="width: 100px;height: 50px; margin-bottom: 0px;">
                                    <br>
                                    <p style="margin-top: -30px;">_____________________________</p>
                                    <p style="margin-top: -30px;">{{$aux->personal->apellidos}}, {{$aux->personal->nombre}}<br>{{$aux->personal->tipoPersonal->nombre}}</p>

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