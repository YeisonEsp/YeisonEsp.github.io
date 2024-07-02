<?php
if (!isset($_GET["ventanum"]))
{
	echo "No existe la venta a visualizar";
	exit();
}

$ventanum = $_GET["ventanum"];
include_once "conexion.php";
$sentencia = $base_de_datos->prepare("SELECT d.codProduc, p.producNom, d.detVentaCan, 
									to_char(d.precioProduc, 'LFM9,999,999') AS precioProduc, 
									to_char(d.detVentaDes, 'LFM9,999,999') AS detVentaDes, 
									to_char(d.detVentaValPar, 'LFM9,999,999') AS detVentaValPar FROM detalleventa d 
									JOIN producto p ON d.codProduc=p.producCod WHERE d.numventa= ?;");
$sentencia->execute([$ventanum]);
$detalles = $sentencia->fetchAll(PDO::FETCH_OBJ);
if (!$detalles)
{
    echo "¡No existe detalles para esa venta";
    exit();
}

?>
<head>
	<title>Detalle de Venta</title>	
</head>
<?php include_once "encabezado.php" ?>
<br><h1 id="titulo" class="text-center">DETALLES DE LA VENTA</h1><br>
<div class="row">
	<div class="col-12"><br><br>
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-light">
				<thead class="thead-dark">
					<tr>
                        <th>CÓDIGO PRODUCTO</th>
						<th>PRODUCTO</th>
						<th>CANTIDAD</th>
						<th>PRECIO UNITARIO($COP)</th>
						<th>DESCUENTO($COP)</th>
                        <th>VALOR PARCIAL($COP)</th>
					</tr>
				</thead>
				<tbody>
					<!--
					Atención aquí, sólo esto cambiará
					Pd: no ignores las llaves de inicio y cierre {}
					-->
					<?php foreach($detalles as $det)
					{
						?>
						<tr>
							<td><?php echo $det->codproduc?></td>
							<td><?php echo $det->producnom ?></td>
							<td><?php echo $det->detventacan ?></td>
							<td><?php echo $det->precioproduc ?></td>
							<td><?php echo $det->detventades ?></td>
                            <td><?php echo $det->detventavalpar ?></td>
						</tr>
					<?php
					} ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>

</script>
<?php include_once "pie.php" ?>
<script src="../js/flechitaDetalleVenta.js"></script>