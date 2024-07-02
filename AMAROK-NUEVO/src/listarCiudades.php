<head>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
	<title>Ciudades</title>	
</head>

<?php include_once "encabezado.php" ?>
<br><h1 id="titulo" class="text-center">CIUDADES</h1><br>
<br>
<div class="row">
	<div class="col-12">
		<div id="mostrar-activos" class="table-responsive">
			<table id="tablaciudad" class="table table-bordered table-striped table-light">
				<thead class="thead-dark">
					<tr>
                        <th>DEPARTAMENTO</th>
						<th>NOMBRE</th>
                        <th>PRECIO DOMICILIO($COP)</th>
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
		$('#tablaciudad').DataTable().destroy();
			tablapro = $('#tablaciudad').DataTable({
			"language": {
				"url": 'https://cdn.datatables.net/plug-ins/2.0.0/i18n/es-ES.json',
			}, 
			"columnDefs": [{ "targets": [3] , "sortable": false, "searchable": false}],
			"lengthMenu": [5, 10, 40, 100],
			"ajax":{
				"url": "obtenerCiudad.php",
				"dataSrc": "",
			},
			"columns": [
				{"data": "departnom"},
				{"data": "ciudadnom"},
				{"data": "preciodom"},
				{   "data": null,
					render: function(data, type, row){
						return "<a class='btn btn-dark' href='formEditarCiudad.php?ciudadid="+data['ciudadid']+"' > Editar 📝</a>"
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