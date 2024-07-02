<head>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
	<title>Clientes</title>	
</head>

<?php include_once "encabezado.php" ?>
<br><h1 id="titulo" class="text-center">CLIENTES ACTIVOS</h1><br>
<div class="row">
	<div class="col-12">
		<a class="btn btn-primary lis"  href="formAgregarCliente.php">Agregar</a>
		<button id="btninactivos" class="btn btn-danger">Inactivos</button>
		<button hidden id="btnactivos" style="margin-left: 7px;" class="btn btn-success">Activos</button>
		<div id="mostrar-activos" class="table-responsive">
			<table id="tablacliente" class="table table-bordered table-striped table-light">
				<thead class="thead-dark">
					<tr>
						<th>DOCUMENTO</th>
						<th>DEPARTAMENTO</th>
						<th>CIUDAD</th>
						<th>NOMBRE</th>
						<th>DIRECCIÓN</th>
						<th>TELÉFONO</th>
						<th>EMAIL</th>
						<th>PUNTOS</th>
						<th>EDITAR</th>
						<th>ELIMINAR</th>
					</tr>
				</thead>
			</table>
		</div>

		<div hidden id="mostrar-inactivos">
			<div class="table-responsive">
				<table id="tablaclienteina" class="table table-bordered table-striped table-light">
					<thead class="thead-dark">
						<tr>
							<th>DOCUMENTO</th>
							<th>DEPARTAMENTO</th>
							<th>CIUDAD</th>
							<th>NOMBRE</th>
							<th>DIRECCIÓN</th>
							<th>TELÉFONO</th>
							<th>EMAIL</th>
							<th>PUNTOS</th>
							<th>ACTIVAR</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>

	</div>
</div>

<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>

<!-- DataTable -->
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
	
	var btninactivos = document.getElementById('btninactivos');
	var btnactivos = document.getElementById('btnactivos');
	let estBtnInactivos = false;
	var recargart;
	var recargartInac;
	var inactivos = document.getElementById('mostrar-inactivos');
	var activos = document.getElementById('mostrar-activos');
	var tablapro;
	var tablaproina;
	var titulo = document.getElementById('titulo');

	$(document).ready(
		cargarActivos()
	);

	function cargarActivos(){
		if(estBtnInactivos===false){
			$('#tablacliente').DataTable().destroy();
				tablapro = $('#tablacliente').DataTable({
				"language": {
					"url": 'https://cdn.datatables.net/plug-ins/2.0.0/i18n/es-ES.json',
				}, 
				"columnDefs": [{ "targets": [8, 9] , "sortable": false, "searchable": false}],
				"lengthMenu": [5, 10, 40, 100],
				"ajax":{
					"url": "obtenerCliente.php",
					"dataSrc": "",
				},
				"columns": [
					{"data": "clientdoc"},
					{"data": "departnom"},
					{"data": "ciudadnom"},
					{"data": "clientnom"},
					{"data": "clientdir"},
					{"data": "clienttel"},
					{"data": "clientema"},
					{"data": "clientpun"},
					{   "data": null,
						render: function(data, type, row){
							return "<a class='btn btn-dark' href='formEditarCliente.php?clientdoc="+data['clientdoc']+"' > Editar 📝</a>"
						},
						"targets": -1
					},
					{   "data": null,
						render: function(data, type, row){
							return "<a class='btn btn-danger' href='eliminarCliente.php?clientdoc="+data['clientdoc']+"' > Eliminar 🗑️</a>"
						},
						"targets": -1
					}
				]
			});
			recargart = setInterval( function () {
				tablapro.ajax.reload(null, false);
			}, 4000 );
		}
	}
	

	btninactivos.addEventListener('click', () => {
		if(estBtnInactivos === false) {
			estBtnInactivos = true;
			btnactivos.hidden=false;
			btninactivos.hidden=true;
			activos.hidden = true;
			inactivos.hidden = false;
			clearInterval(recargart);
			titulo.textContent = 'CLIENTES INACTIVOS';
			cargarInactivos();
		}
	});

	function cargarInactivos(){
			if(estBtnInactivos===true){
				$('#tablaclienteina').DataTable().destroy();
					tablaproina = $('#tablaclienteina').DataTable({
					"language": {
						"url": 'https://cdn.datatables.net/plug-ins/2.0.0/i18n/es-ES.json',
					},
					"columnDefs": [{ "targets": [8] , "sortable": false, "searchable": false}],
					"lengthMenu": [5, 10, 40, 100],
					"ajax":{
						"url": "obtenerClienteInac.php",
						"dataSrc": "",
					},
					"columns": [
						{"data": "clientdoc"},
						{"data": "departnom"},
						{"data": "ciudadnom"},
						{"data": "clientnom"},
						{"data": "clientdir"},
						{"data": "clienttel"},
						{"data": "clientema"},
						{"data": "clientpun"},
						{   "data": null,
							render: function(data, type, row){
								return "<a class='btn btn-dark' href='activarCliente.php?clientdoc="+data['clientdoc']+"' >Activar ✅</a>"
							},
							"targets": -1
						}
					]
				});
				recargartInac = setInterval( function () {
					tablaproina.ajax.reload(null, false);
				}, 4000 );
			}
	}

	btnactivos.addEventListener('click', () => {
		if(estBtnInactivos === true) {
			estBtnInactivos = false;
			btnactivos.hidden=true;
			btninactivos.hidden=false;
			activos.hidden = false;
			inactivos.hidden = true;
			clearInterval(recargartInac);
			titulo.textContent = 'CLIENTES ACTIVOS';
			cargarActivos();
		}
	});
</script>
<?php include_once "pie.php" ?>