<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requerimiento internos de productos</title>

    @php
    $marginTop = intval($contadorTotal);
    $alturaEmcabezado = intval($alturaEmcabezado);
    @endphp


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
          
          background-size: cover;
            width: 100%;
            height: 0px;
            z-index: 100;
            position: absolute;
            top: 0px;
            right: 0px;
        }

        .informacion {
            width: 100%;
            margin-top: 0px;
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
            margin-top: 350px;

            font-size: 12px;
        }

        .tableprincipal table th {
           background: goldenrod;
            color: #fff;
            padding: 0.3rem 0rem;
            text-transform: uppercase;
        }



        
        .tablePrimerTable table th {
           background: goldenrod;
            color: #fff;
            padding: 0.3rem 0rem;
            text-transform: uppercase;
        }

 .tablePrimerTable table {
            width: 100%;
           

            font-size: 12px;
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
             <!--    <div class="ruc">
                    <h3>&nbsp;</h3>
                    <br>
                </div> -->

                    <div class="orden">
                    <table width="100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>

                        </thead>
                        <tbody>

                            <tr>
                                <td width="200px">
                                <img src="{{ asset('dist/empresa/logo_grupo_alfa_dorado.jpg') }}" alt="" width="150px" height="150px">
                                 </td>
                                <td align="right">
                                    <p>
                                        <b> REQUERIMIENTO DE ALMACEN</b>
                                        <br>                                      
                                        <span>
                                            N°: {{$requerimiento->numero_requerimiento}}
                                        </span>
                                        <br>
                                                                            
                                    </p>

                                </td>
                            </tr>

                        </tbody>
                    </table>



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
                                    <p>
                                        <b>{{ \App\Models\Util::getMayuscula($sucursalEmpresa->empresa->razon_social) }}</b>
                                     <br><b>RUC: {{$sucursalEmpresa->empresa->ruc }}</b>
                                     <br><b>DOM. FISCAL: CAL.28 DE JULIO NRO. 325 P.J. FLORENCIA DE MORA BA. 12 LA LIBERTAD - TRUJILLO - FLORENCIA DE MORA</b>
                                     <br><br><b>CEL 950791647</b><br>
                                    </p>
                                </td>
                                <td width="250px">
                                    <p>
                                        
                                       
                                     
                                        <span>
                                            Fecha de pedido: {{$requerimiento->fecha_pedido}}
                                        </span>                                     
                                         <br>
                                        <span>
                                            Condici&oacute;n de pago: Al cr&eacute;dito
                                        </span>
                                        <br>
                                    </p>

                                </td>
                            </tr>

                        </tbody>
                    </table>

                     <div class="tablePrimerTable">
                    <table  class="table">
                        <thead>
                            <tr>
                                <th style="width: 50%;">DESTINARIO</th>
                                <th style="width: 50%;"></th>
                            </tr>

                        </thead>
                        <tbody>
                      

                            <tr>

                                <td style="width: 50%; vertical-align: top;">

                                  <span>
                                        <b> {{$requerimiento->destinatario->apellidos}}, {{$requerimiento->destinatario->nombre}}</b>  

                                    </span><br>
                                    <span>
                                        <b> {{$requerimiento->destinatario->tipo_documento}}: </b> {{$requerimiento->destinatario->numero_documento}}

                                    </span><br>
                                    <span>
                                        <b> &Aacute;REA: </b> COMPRAS

                                    </span><br>
                                 
                                    <span>
                                        <b> Email: </b> {{$requerimiento->destinatario->correo_electronico}}

                                    </span><br>

                                </td>

                                <td style="width: 50%; vertical-align: middle;" >

                                    <span>
                                        <b> Los productos seran usados para las actividades de la empresa.</b>  

                                    </span><br>
                                   
                                </td>
                             

                            </tr>

                        </tbody>
                    </table>
                </div>

                
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
                     <table width="100%">
                        <thead>
                            <th></th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                     <p style="margin-top: 15px;"><b>ESPESIFICACIONES: </b> {{$requerimiento->descripcion}}

                                      
                                    </p>
                                </td>
                            </tr>

                        </tbody>
                    </table>
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