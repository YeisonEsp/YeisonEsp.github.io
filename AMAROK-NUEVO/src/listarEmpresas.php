<head>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
	<title>Empresas de Transporte</title>	
</head>

<?php include_once "encabezado.php" ?>
<br><h1 id="titulo" class="text-center">EMPRESAS DE TRANSPORTE ACTIVAS</h1><br>
<div class="row">
	<div class="col-12">
		<a class="btn btn-primary lis"  href="formAgregarEmpresa.php">Agregar</a>
		<button id="btninactivos" class="btn btn-danger">Inactivas</button>
		<button hidden id="btnactivos" style="margin-left: 7px;" class="btn btn-success">Activas</button>
		<div id="mostrar-activos" class="table-responsive">
			<table id="tablaempresas" class="table table-bordered table-striped table-light">
				<thead class="thead-dark">
					<tr>
						<th>NIT</th>
						<th>NOMBRE</th>
						<th>TELÉFONO</th>
						<th>EDITAR</th>
						<th>ELIMINAR</th>
					</tr>
				</thead>
			</table>
		</div>

		<div hidden id="mostrar-inactivos">
			<div class="table-responsive">
				<table id="tablaempresasina" class="table table-bordered table-striped table-light">
					<thead class="thead-dark">
						<tr>
							<th>NIT</th>
							<th>NOMBRE</th>
							<th>TELÉFONO</th>
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
			$('#tablaempresas').DataTable().destroy();
				tablapro = $('#tablaempresas').DataTable({
				"language": {
					"url": 'https://cdn.datatables.net/plug-ins/2.0.0/i18n/es-ES.json',
				}, 
				"columnDefs": [{ "targets": [3, 4] , "sortable": false, "searchable": false}],
				"lengthMenu": [5, 10, 40, 100],
				"ajax":{
					"url": "obtenerEmpresa.php",
					"dataSrc": "",
				},
				"columns": [
					{"data": "empretranit"},
					{"data": "empretranom"},
					{"data": "empretratel"},
					{   "data": null,
						render: function(data, type, row){
							return "<a class='btn btn-dark' href='formEditarEmpresa.php?empretranit="+data['empretranit']+"' > Editar 📝</a>"
						},
						"targets": -1
					},
					{   "data": null,
						render: function(data, type, row){
							return "<a class='btn btn-danger' href='eliminarEmpresa.php?empretranit="+data['empretranit']+"' > Eliminar 🗑️</a>"
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
			titulo.textContent = 'EMPRESAS DE TRANSPORTE INACTIVAS';
			cargarInactivos();
		}
	});

	function cargarInactivos(){
			if(estBtnInactivos===true){
				$('#tablaempresasina').DataTable().destroy();
					tablaproina = $('#tablaempresasina').DataTable({
					"language": {
						"url": 'https://cdn.datatables.net/plug-ins/2.0.0/i18n/es-ES.json',
					},
					"columnDefs": [{ "targets": [3] , "sortable": false, "searchable": false}],
					"lengthMenu": [5, 10, 40, 100],
					"ajax":{
						"url": "obtenerEmpresaInac.php",
						"dataSrc": "",
					},
					"columns": [
						{"data": "empretranit"},
						{"data": "empretranom"},
						{"data": "empretratel"},
						{   "data": null,
							render: function(data, type, row){
								return "<a class='btn btn-dark' href='activarEmpresa.php?empretranit="+data['empretranit']+"' >Activar ✅</a>"
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
			titulo.textContent = 'EMPRESAS DE TRANSPORTE ACTIVAS';
			cargarActivos();
		}
	});
</script>

<?php include_once "pie.php" ?>