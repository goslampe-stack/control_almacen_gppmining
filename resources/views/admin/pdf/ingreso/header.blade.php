<header class="main-header">
            <div class="informacion">
                <div class="ruc">
                    <h3>&nbsp;</h3>
                    <br>
                </div>

                <div class="orden">
                    <div class="left"><b>INGRESO DE ART&Iacute;CULOS AL ALMAC&Eacute;N</b></div>
                    <div class="right"><b>N° {{$formato_numero_serie}}</b></div>

                    <br><br>
                </div>

                <div class="descripcion">
                    <p><b>Fecha de ingreso:</b> {{$fecha_ingreso}}</p>
                    <p><b>Direcci&oacute;n de ingreso:</b> {{$sucursalEmpresa->direccion}}</p>
                    <p><b>Sírvanse por este medio suministrarnos los siguientes artículos</b></p>
                </div>
            </div>
        </header>

        <section>
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
                        <td align="left">{{ $item->articuloRequerimiento->articulo->articulo }}</td>
                        <td align="center">{{ $item->cantidad }}</td>
                        <td align="center">{{ $item->articuloRequerimiento->requerimientoPersonal->numero_requerimiento}}</td>
                        <td align="center">{{$item->ordenCompra->numero_orden_compra}}</td>
                        <td align="center">{{ $item->numero_documento }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </section>