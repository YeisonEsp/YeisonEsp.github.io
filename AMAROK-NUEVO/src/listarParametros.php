<head>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
	<title>Parámetros</title>	
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
<br><h1 id="titulo" class="text-center">CONFIGURACIÓN GENERAL</h1><br><br>
<div class="row">
	<div class="col-12">
		<div id="mostrar-activos" class="table-responsive">
			<table id="tablaparametro" class="table table-bordered table-striped table-light">
				<thead class="thead-dark">
					<tr>
						<th>NIT</th>
						<th>EMPRESA</th>
						<th>DIRECCIÓN</th>
						<th>TELÉFONO</th>
						<th>CELULAR</th>
						<th>CORREO</th>
						<th>No. FACTURA INICIAL</th>
						<th>No. FACTURA FINAL</th>
						<th>PUNTAJE DESCUENTO</th>
						<th>PUNTAJE DOMICILIO</th>
						<th>TIEMPO_INACTIVIDAD(minutos)</th>
						<th>EDITAR</th>	
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>

<!-- DataTable -->
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
	var recargart;
	var tablapro;
	$(document).ready(function cargarActivos(){
		$('#tablaparametro').DataTable().destroy();
			tablapro = $('#tablaparametro').DataTable({
			"language": {
				"url": 'https://cdn.datatables.net/plug-ins/2.0.0/i18n/es-ES.json',
			}, 
			"columnDefs": [{ "targets": '_all' , "sortable": false, "searchable": false}],
			"lengthMenu": [5, 10, 40, 100],
			"ajax":{
				"url": "obtenerParametro.php",
				"dataSrc": "",
			},
			"columns": [
				{"data": "emprenit"},
				{"data": "emprenom"},
				{"data": "empredir"},
				{"data": "empretel"},
				{"data": "emprecel"},
				{"data": "empreema"},
				{"data": "numfacini"},
				{"data": "numfacfin"},
				{"data": "redpundes"},
				{"data": "redpundom"},
				{"data": "tiemposalir"},
				{   "data": null,
					render: function(data, type, row){
						return "<a class='btn btn-dark' href='formEditarParametros.php?emprenit="+data['emprenit']+"' > Editar 📝</a>"
					},
					"targets": -1
				}
			]
		});
		recargart = setInterval( function () {
			tablapro.ajax.reload(null, false);
		}, 4000 );
	
	});
</script>

<?php include_once "pie.php" ?>