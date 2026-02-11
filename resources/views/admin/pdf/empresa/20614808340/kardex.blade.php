<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kardex</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }



        /* ================================================== */

        .plantilla .main-header {
            background: url({{$sucursalEmpresa->imagen}});
          background-size: 100% 200px;
          background-repeat: no-repeat;
            width: 100%;
            height: 240px;
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
            margin-top: 180px;

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
                                    <p><b>{{ \App\Models\Util::getMayuscula($sucursalEmpresa->empresa->razon_social) }}</b> </p>
                                </td>
                                <td align="right">
                                    <p>
                                        <b> KARDEX DE ART&Iacute;CULO</b>
                                        <br>
                                        <span>
                                            Fecha: {{ \Carbon\Carbon::now()->format('d/m/Y') }}
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

                    <tr class="text-center" style=" background: #017BFF;
                        color: white;
                        padding: 0.3rem 0rem;
                        text-transform: uppercase;">
                        <th colspan="4">Artículo:</th>
                        <td colspan="3" class="center-text"><b>{{$articulo->articulo}}</b></td>
                        <th colspan="2">Método:</th>
                        <td colspan="4" class="center-text"><b>Promedio ponderado</b></td>
                    </tr>

                    <tr class="text-center" style="background: #017BFF;">
                        <th rowspan="2">Fecha</th>
                        <th rowspan="2">Detalle</th>
                        <th colspan="3">Entradas</th>
                        <th colspan="3">Salidas</th>
                        <th colspan="5">Existencias</th>
                    </tr>
                    <tr class="text-center">
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
                        <td style="background: #d6dec9;"> {{ \Carbon\Carbon::parse($item['auxo'])->format('d-m-Y') }} {{ \Carbon\Carbon::parse($item['auxo'])->format('g:i A') }}</td>
                        <td class="text-left">{{$item['articulo']}}</td>
                        <td class="center-text">{{$item['cantidad-entrada']}}</td>
                        <td class="center-text">{{$item['precio-entrada']}}</td>
                        <td class="center-text">{{$item['total-entrada']}}</td>

                        <td class="center-text">{{$item['cantidad-salida']}}</td>
                        <td class="center-text">{{$item['precio-salida']}}</td>
                        <td class="center-text">{{$item['total-salida']}}</td>

                        <td class="center-text">{{$item['cantidad-existencia']}}</td>
                        <td class="center-text">{{$item['precio-existencia']}}</td>
                        <td class="center-text">{{$item['total-existencia']}}</td>

                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>

        <footer class="main-footer">
            <div class="pie-pagina">
                <div class="detalle center-text">
                    <table width="100%">
                        <thead>

                            <!--      <th></th> -->
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