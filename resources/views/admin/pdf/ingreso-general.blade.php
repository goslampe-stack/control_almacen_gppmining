<html>

<head>
    <style>
        /** 
                Set the margins of the page to 0, so the footer and the header
                can be of the full height and width !
             **/
        @page {
            margin: 0cm 0cm;
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 4.1cm;
            margin-left: 2cm;
            margin-right: 2cm;
            margin-bottom: 3.5cm;
        }

        /** Define the header rules **/
        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 4cm;

            /** Extra personal styles **/
            background: url({{$sucursalEmpresa->imagen}});
            background-size: cover;
            color: white;
            text-align: center;
            line-height: 1.5cm;
        }

        /** Define the footer rules **/
        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 3cm;

            /** Extra personal styles **/
            background: url({{$sucursalEmpresa->imagen}});
            background-size: cover;
            background-position: 50% 100%;
            color: white;
            text-align: center;
            line-height: 1.5cm;
        }

        /*  */
        main table {
            width: 100%;
            font-size: 8px;
        }

        main table th {
            background: #33498b;
            color: #fff;
            padding-bottom: .3rem;
            padding-left: .5rem;
            padding-right: .5rem;
            padding-top: .3rem;
            font-size: .6rem;
            text-transform: uppercase;
        }

        .informacion {
            width: 100%;
            margin-top: 1rem;
            font-size: 10px;
        }

        .informacion .orden {
            width: 100%;
        }

        .informacion .orden .left {
            width: 50%;
            float: left;
            padding-left: 2rem;
            text-align: center;
        }

        .informacion .orden .right {
            width: 50%;
            float: right;
            padding-right: 4rem;
            text-align: right;
        }

        .informacion .descripcion {
            width: 100%;
        }

        .informacion .descripcion p {
            margin-bottom: .5rem;
        }

        .firmas-sellos {
            width: 100%;
            padding-top: 1.5rem;
            padding-left: .1rem;
            padding-bottom: 8rem;
            font-size: 10px;
        }
    </style>
</head>

<body>
    <!-- Define header and footer blocks before your content -->
    <header></header>

    <footer></footer>

    <!-- Wrap the content of your PDF inside a main tag -->

    <main>

        <div class="informacion">
            <div class="orden">
                <div class="left"><b>INGRESO DE ART&Iacute;CULOS AL ALMAC&Eacute;N</b></div>
                <div class="right"><b>N° {{$formato_numero_serie}}</b></div>
            </div>

            <div class="descripcion">
                <p><b>Fecha de ingreso:</b> {{$fecha_ingreso}}</p>
                <p><b>Direcci&oacute;n de ingreso:</b> {{$sucursalEmpresa->direccion}}</p>
            </div>
        </div>

        <div>

            <table class="table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Cantidad</th>
                        <th>Unidad</th>
                        <th>Descripción</th>
                        <th>N° Requerimiento</th>
                        <th>N° Orden de Compra</th>
                        <th>N° Factura</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articulos as $item)

                    @if($item->articuloRequerimiento!=null) && $

                    <tr>

                        <td align="center">{{ $item->articuloRequerimiento->articulo->codigo }}</td>
                        <td align="center">{{ $item->cantidad }}</td>
                        <td align="center">{{ $item->articuloRequerimiento->articulo->tipoUnidad->nombre }}</td>
                        <td align="left">{{ $item->articuloRequerimiento->articulo->articulo }}</td>
                        <td align="center">{{ $item->articuloRequerimiento->requerimientoPersonal->numero_requerimiento}}</td>
                        <td align="center">{{$item->ordenCompra->numero_orden_compra}}</td>
                        <td align="center">{{ $item->numero_documento }}</td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="firmas-sellos">
            FIRMAS Y SELLOS
        </div>
    </main>
</body>

</html>