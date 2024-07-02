<?php
if (!isset($_GET["pedidonum"]) ||
	!isset($_GET["nitprovee"]))
{
	echo "No existe el pedido a visualizar";
	exit();
}

$pedidonum = $_GET["pedidonum"];
$nitprovee = $_GET["nitprovee"];
include_once "conexion.php";
$sentencia = $base_de_datos->prepare("SELECT d.codProduc, p.producNom, d.detPedCan, to_char(d.detPedCos, 'LFM9,999,999') AS detPedCos, 
										to_char(d.detPedValPar, 'LFM9,999,999') AS detPedValPar 
										FROM detallepedido d JOIN producto p ON d.codProduc=p.producCod 
										WHERE d.numPedido= ? AND d.nitProvee= ? ORDER BY p.producNom;");
$sentencia->execute([$pedidonum, $nitprovee]);
$detallesp = $sentencia->fetchAll(PDO::FETCH_OBJ);
if (!$detallesp)
{
    echo "¡No existe detalles para ese pedido";
    exit();
}

?>
<head>
	<title>Detalle de Pedido</title>	
</head>
<?php
	session_start();
	if(!isset($_SESSION['id']) ||
		!isset($_SESSION['username']))
	{
		echo "<script>
				localStorage.clear();
				window.location = 'login.php';
			</script>";
		exit();
	}
	$usua = $_SESSION['id'];
	$role = $_SESSION['username'];
	switch(true)
	{
		case ($role=='Administrador'):
			include_once "encabezado.php";
		break;
	
		default:
			echo "<script>
				localStorage.clear();
				alert('↩️ No tiene permisos para realizar esta operación');
				window.history.go(-1);
			</script>";
			exit();
	}
?>
<!-- AQUI INICIA EL NUEVO -->
<br><h1 id="titulo" class="text-center">DETALLES DEL PEDIDO</h1><br>
<div class="row">
	<div class="col-12"><br><br>
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-light">
				<thead class="thead-dark">
					<tr>
						<th>CÓDIGO PRODUCTO</th>
						<th>PRODUCTO</th>
						<th>CANTIDAD</th>
						<th>COSTO/UNIDAD($COP)</th>
                        <th>VALOR PARCIAL($COP)</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($detallesp as $det)
					{
						?>
						<tr>
							<td><?php echo $det->codproduc?></td>
							<td><?php echo $det->producnom ?></td>
							<td><?php echo $det->detpedcan ?></td>
							<td><?php echo $det->detpedcos ?></td>
                            <td><?php echo $det->detpedvalpar ?></td>
						</tr>
					<?php
					} ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<?php include_once "pie.php" ?>

<script src="../js/flechitaDetallePedido.js"></script>
