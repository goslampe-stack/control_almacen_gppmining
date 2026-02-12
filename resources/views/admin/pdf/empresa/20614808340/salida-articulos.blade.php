<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salida</title>
	<link rel="icon" type="image/png" href="{{ asset('dist/img/goslam_viajes.jpg') }}" />

   <!--  asdas -->
    <style>
       * {
            margin: 1px;
            padding: 0;
              font-size: 12px;

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
            height: 100px;
            z-index: 50;
            position: absolute;
            bottom: 0px;
            right: 0px;
            text-align: center;
        }

        .pie-pagina .firma {
            width: 100%;
           /*  margin-left: 1.5rem;
            margin-right: 1.5rem; */
        }

        .pie-pagina .detalle {
            width: 100%;
           /*  margin-left: 1.5rem;
            margin-right: 1.5rem; */

        }

        .pie-table {
            width: 100%;
           /*  margin-left: 1.5rem;
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
                                        <b> SALIDA DE ART&Iacute;CULOS DEL ALMAC&Eacute;N</b>
                                      
                                        <br>
                                        <span>
                                            Fecha: {{ \Carbon\Carbon::parse($salida->fecha_salida)->format('d/m/Y') }}  {{ \Carbon\Carbon::parse($salida->fecha_salida)->format('g:i A') }}
                                        </span>
                                    </p>

                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>


                <div class="descripcion">
                    <p><b>Direcci&oacute;n de sucursal salida:</b> {{$sucursalEmpresa->direccion}}</p>
                    <br>
                </div>
            </div>
        </header>

        <div class="tableprincipal">

            <table class="table">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Art&iacute;culo</th>
                        <th>Cantidad</th>
                        <th>Comentario</th>
                        <th>Fecha salida</th>
                        <th>N° requerimiento</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articulos as $item)
                    <tr>
                        <td align="center">{{ $item->articulo->codigo }}</td>
                        <td align="center">{{ $item->articulo->articulo }}</td>
                        <td align="center">{{ $item->cantidad}}</td>
                        <td align="center">{{ $item->comentario}}</td>
                        <td align="center">{{ $item->fecha_salida_detalle}}</td>
                        <td align="center">{{ $item->numero_requerimiento }}</td>
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
                            <th></th>
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