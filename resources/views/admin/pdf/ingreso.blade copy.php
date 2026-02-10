<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        .plantilla {
        }

        /* ================================================== */

        .plantilla .main-header {
            background: url({{$sucursalEmpresa->imagen}});
            background-size: cover;
            width: 100%;
            height: 200px;
            z-index: 100;
            position: absolute;
            top:0px;
            right:0px;
        }

        .informacion {
            width: 100%;
            margin-top: 130px;
            margin-left: 2.5rem;
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

        .plantilla .table {
            margin-left: 2.5rem;
        }

        .plantilla table {
            width: 95%;
            margin-top: 390px;
            font-size: 12px;
        }

        .plantilla table th {
            background: #33498b;
            color: #fff;
            padding: 0.3rem 0rem;
            text-transform: uppercase;
        }

        .plantilla table td {
        }

        /* ================================================== */

        .plantilla .main-footer {
            background: url({{$sucursalEmpresa->imagen}});
            background-size: cover;
            background-position: 50% 100%;
            width: 100%;
            height: 140px;
            z-index: 100;
            position: absolute;
            bottom:0px;
            right:0px;
        }

        .pie-pagina .firma {
            width: 100%;
            margin-left: 2.5rem;
        }

        .pie-pagina .detalle {
            width: 100%;
            margin-left: 2.5rem;
        }

        .pie-pagina .detalle .left {
            width: 50%;
            float: left;
            text-align: left;
        }
        .pie-pagina .detalle .right {
            width: 50%;
            float: right;
            text-align: left;
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
                    <div class="left"><b>INGRESO DE ART&Iacute;CULOS AL ALMAC&Eacute;N</b></div>
                    <div class="right"><b>N° {{$ingreso->numero_ingreso}}</b></div>
                    <br><br>
                </div>

                <div class="descripcion">
                    <p><b>Proveedor:</b> {{$ingreso->transporte->razon_social}}</p>
                    <p><b>Fecha de ingreso:</b> {{ \Carbon\Carbon::parse($ingreso->fecha_ingreso)->format('d/m/Y') }}</p>
                    <p><b>N° de requerimiento personal:</b> N° {{$ingreso->ordenDeCompra->requerimientoPersonal->numero_requerimiento}}</p>
                    <p><b>N° orden de compra:</b> N° {{$ingreso->ordenDeCompra->numero_orden_compra}}</p>
                    <p><b>Direcci&oacute;n de ingreso:</b> {{$sucursalEmpresa->direccion}}</p>
                    <p><b>Sírvanse por este medio suministrarnos los siguientes artículos</b></p>
                </div>
            </div>
        </header>

        <table class="table">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Unidad</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>N° Requerimiento</th>
                    <th>N° Orden de Compra</th>
                    <th>N° Factura</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articulos as $item)
                    <tr>
                        <td align="center">{{ $item->articuloRequerimiento->articulo->codigo }}</td>
                        <td align="center">{{ $item->articuloRequerimiento->articulo->tipoUnidad->nombre }}</td>
                        <td align="center">{{ $item->articuloRequerimiento->articulo->articulo }}</td>
                        <td align="center">{{ $item->cantidad }}</td>
                        <td align="center">{{ $ingreso->ordenDeCompra->requerimientoPersonal->numero_requerimiento }}</td>
                        <td align="center">{{$ingreso->ordenDeCompra->numero_orden_compra}}</td>
                        <td align="center">{{ $item->numero_documento }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                
            </tfoot>
        </table>

        <footer class="main-footer">
            <div class="pie-pagina">
                <div class="firma">
                    Firma y sellos
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                </div>

                <div class="detalle">
                    <div class="left">
                        ALMACENERO
                    </div>
                    <div class="right">
                        JEFE DE LOGISTICA
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>