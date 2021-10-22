<input type="hidden" value="<?php echo $usuario["enlace_afiliado"]; ?>" id="enlace_afiliado">
<input type="hidden" value="<?php echo $usuario["id_usuario"]; ?>" id="id_usuario">


<div class="card card-info card-outline">

	<div class="card-header">
		
		<h3 class="card-title p-3">
			<i class="fas fa-table mr-1"></i>		
			Tabla de Ingresos
		</h3>

	</div>

	<div class="card-body">
		
		<table class="table table-bordered table-striped dt-responsive tablaIngresos-matriz" width="100%">
			
			<thead>

				<tr>

					<th style="width:10px">#</th> 
					<th>ID Pago Paypal</th>
					<th>Nombre</th>
					<th>Email Paypal</th>
					<th>Periodo</th>
					<th>Comisiones</th>				   
					<th>Ventas</th>					
					<th>Fecha de pago</th>
					<th>Notas</th>

				</tr>   

			</thead>

			<tbody>

				<!-- <tr>
					
					<td>1</td> 
					<td>LM46YZQVHWW74</td>
					<td>Jaime Carrillo</td>
					<td>tutorialesatualcance-buyer@hotmail.com</td>
					<td>2019-06-19 a 2019-07-19</td> 
					<td>$ 14,345</td>			  
					<td>$ 16,300</td>			
					<td>2019-07-19</td>
					<td>
						<h5><span class="badge badge-success">Pagada</span></h5>
					</td>

				</tr> -->


			</tbody>

		</table>

	</div>



</div>