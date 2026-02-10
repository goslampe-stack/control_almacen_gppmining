<x-app-layout>
	<div class="content-wrapper">
		<section class="content mt-3">
			<div class="container-fluid">
				<div class="row justify-content-center">
					<div class="col-md-8">

						<div class="card">
							<div class="card-body">

								<style type="text/css">
									.apl-table-reporte-kardex table {
										border-collapse: collapse;
									}

									.apl-table-reporte-kardex td, th {
										border: 2px solid #000;
										padding-left: 0.3rem;
										padding-right: 0.3rem;
									}
								</style>

								<div class="apl-table-reporte-kardex">
									<table width="100%">
										<thead>
										<tr class="text-center" style="background: #c2d699;">
											<th colspan="13">
												<h2 class="mt-3"><b>KÁRDEX</b></h2>	
											</th>
										</tr>
										<tr class="text-center" style="background: #c2d699;">
											<th colspan="4">Artículo:</th>
											<td colspan="3">lavadoras</td>
											<th colspan="3">Excistencia mínima:</th>
											<td colspan="3">60</td>
										</tr>
										<tr class="text-center" style="background: #c2d699;">
											<th colspan="4">Método:</th>
											<td colspan="3">Promedio ponderado</td>
											<th colspan="3">Excistencia máxima:</th>
											<td colspan="3">495</td>
										</tr>
										<tr class="text-center" style="background: #75933d;">
											<th colspan="3">Fecha</th>
											<th rowspan="2">Detalle</th>
											<th colspan="3">Entras</th>
											<th colspan="3">Salidas</th>
											<th colspan="3">Existencias</th>
										</tr>
										<tr class="text-center" style="background: #75933d;">
											<th>D</th>
											<th>M</th>
											<th>A</th>
											<th>Cantidad</th>
											<th>V/ Unitario</th>
											<th>V/ Total</th>
											<th>Cantidad</th>
											<th>V/ Unitario</th>
											<th>V/ Total</th>
											<th>Cantidad</th>
											<th>V/ Unitario</th>
											<th>V/ Total</th>
										</tr>
										</thead>
										<tbody>
										<?php for ($i=0; $i < 12; $i++) : ?>
										<tr class="text-center">
											<td style="background: #d6dec9;">5</td>
											<td style="background: #d6dec9;">5</td>
											<td style="background: #d6dec9;">11</td>
											<td class="text-left">Comra según factura N°20</td>
											<td>18</td>
											<td>134</td>
											<td style="background: #d6dec9;">2412</td>
											<td>67</td>
											<td>100.21</td>
											<td style="background: #d6dec9;">6714.07</td>
											<td>48</td>
											<td>100.2</td>
											<td style="background: #d6dec9;">4909.93</td>
										</tr>
										<?php endfor ?>
										</tbody>
										<tfoot>
										<tr class="text-center">
											<td style="background: #d6dec9;"></td>
											<td style="background: #d6dec9;"></td>
											<td style="background: #d6dec9;"></td>
											<td class="text-danger text-left" style="background: #94d152;">Inventario final</td>
											<td style="background: #94d152;"></td>
											<td style="background: #94d152;"></td>
											<td style="background: #94d152;"></td>
											<td style="background: #94d152;"></td>
											<td style="background: #94d152;"></td>
											<td style="background: #94d152;"></td>
											<td class="text-danger" style="background: #94d152;">48</td>
											<td class="text-danger" style="background: #94d152;">100.2</td>
											<td class="text-danger" style="background: #94d152;">4909.93</td>
										</tr>
										<tr class="text-center">
											<td style="background: #d6dec9;"></td>
											<td style="background: #d6dec9;"></td>
											<td style="background: #d6dec9;"></td>
											<td class="text-left">&nbsp;</td>
											<td></td>
											<td></td>
											<td style="background: #d6dec9;"></td>
											<td></td>
											<td></td>
											<td style="background: #d6dec9;"></td>
											<td></td>
											<td></td>
											<td style="background: #d6dec9;"></td>
										</tr>
										</tfoot>
									</table>
								</div>

							</div>
						</div>

					</div>
				</div>

			</div>
		</section>
	</div>
</x-app-layout>