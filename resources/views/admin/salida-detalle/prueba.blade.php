<x-app-layout>
	<div class="content-wrapper">
		<section class="content mt-3">
			<div class="container-fluid">
				<div class="row justify-content-center">
					<div class="col-md-7">

						<div class="card">
							<div class="card-body">

								<div>
									<table width="100%">
										<tbody>
										<tr>
											<th colspan="5" class="text-center">GOLDEN MARAÑON SAC</th>
										</tr>
										<tr>
											<th colspan="5" class="text-center">RUC: 20605686274</th>
										</tr>
										<tr>
											<th width="10%"></th>
											<th width="46%" class="text-right">ORDEN DE COMPRA</th>
											<th width="16%"></th>
											<th width="15%" class="border text-center">N° 0001</th>
											<th width="10%"></th>
										</tr>
										<tr>
											<td colspan="5"><b>Proveedor:</b> FE LIZANA SAC</td>
										</tr>
										<tr>
											<td colspan="2"><b>Fecha del pedido:</b> 20/02/2021</td>
											<th colspan="2">Fecha estimada de Pago:</th>
											<td>31/03/2021</td>
										</tr>
										<tr>
											<td colspan="5"><b>Términos de la entrega:</b> En las instalaciones del proveedor</td>
										</tr>
										<tr>
											<td colspan="5">&nbsp;</td>
										</tr>
										<tr>
											<th colspan="5">Sírvanse por este medio suministrarnos los siguientes artículos</th>
										</tr>
										</tbody>
									</table>
								</div>
								
								<div>
									<table class="table-bordered" style="width: 100%;">
										<thead>
										<tr style="background: #00b0f0;">
											<th width="7%">NRO</th>
											<th width="61%">ARTICULO</th>
											<th width="10%">CANTIDAD</th>
											<th width="10%">P.UNITARIO</th>
											<th width="12%">PRECIO TOTAL</th>
										</tr>
										</thead>
										<tbody>
										<?php for ($i=0; $i < 10; $i++) : ?>
										<tr>
											<td class="text-right"><?php echo $i ?></td>
											<td>Aceite Blindax 10W30 1/4 Gl</td>
											<td class="text-center">500</td>
											<td class="text-right">S/. 26.90</td>
											<td class="text-right">S/. 13,450.00</td>
										</tr>
										<?php endfor ?>
										</tbody>
										<!--
										<tfoot>
										<tr>
											<th colspan="4" class="text-right">COSTO TOTAL</th>
											<td class="text-right">475,648.50</td>
										</tr>
										</tfoot>
										-->
									</table>
									<table width="100%">
										<tbody>
										<tr>
											<td width="68%" colspan="3"></td>
											<th width="20%" class="text-right"><font class="mr-3">COSTO TOTAL</font></th>
											<td width="12%" class="text-right" style="border-left: 1px solid #dee2e6;border-right: 1px solid #dee2e6;border-bottom: 1px solid #dee2e6;">475,648.50</td>
										</tr>
										</tbody>
									</table>	
								</div>

								<div class="mt-3">
									Elaborado y Autorizado por : Golden Marañon  SAC
								</div>


							</div>
						</div>

					</div>
				</div>

			</div>
		</section>
	</div>
</x-app-layout>