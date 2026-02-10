<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requerimiento interno de productos</title>
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
			margin-top: 410px;
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
			/* background: url({{$sucursalEmpresa->imagen}}); */
			background-size: cover;
			background-position: 50% 100%;
			width: 100%;
			height: 110px;
			z-index: 50;
			position: absolute;
			bottom:0px;
			right:0px;
            text-align: center;
		}

        .pie-pagina .firma {
            width: 100%;
            margin-left: 2.5rem;
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
                    <div class="left"><b>REQUERIMIENTO PERSONAL</b></div>
                    <div class="right"><b>N° {{$requerimiento->numero_requerimiento}}</b></div>
                    <br><br>
                </div>

                <div class="descripcion">
                    <p><b>Personal:</b> {{$requerimiento->personal->apellidos}}, {{$requerimiento->personal->nombre}}</p>
                    <p><b>Fecha del pedido:</b> {{ \Carbon\Carbon::parse($requerimiento->fecha_pedido)->format('d/m/Y') }}</p>
                    <p><b>Términos del requerimiento:</b> {{$requerimiento->descripcion}}</p>
                    <p><b>Direcci&oacute;n:</b> {{$sucursalEmpresa->direccion}}</p>
                    <br>
                    <p><b>Sírvanse por este medio suministrarnos los siguientes artículos</b></p>
                </div>
            </div>
        </header>

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
                    <td align="left">{{ $item->articulo->articulo }} </td>
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

        <footer class="main-footer">
            <div class="pie-pagina">
                <div class="detalle center-text">

                    @foreach ($personalPdf as $aux)

                    <div class="left" style="display: inline-block; text-align: center; width:300px; margin-right: 20px;">

                        <img src="{{$aux->personal->imagen}}" alt="" style="width: 100px;height: 50px; margin-bottom: 0px;">


                        <br>
                        <span style="border-top: 1px solid #000; display: block; margin-top: 1px;"></span>
                        {{$aux->personal->apellidos}}, {{$aux->personal->nombre}}<br>{{$aux->personal->cargo}}
                    </div>

                    @endforeach

                </div>
            </div>
        </footer>
    </div>
</body>

</html>


<!-- asdasda -->

<table>
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
                                    <p style="margin-top: -30px;">{{$aux->personal->apellidos}}, {{$aux->personal->nombre}}<br>{{$aux->personal->cargo}}</p>

                                </td>
                                @endforeach

                            </tr>
                        </tbody>
                    </table>
<!-- asdasda -->