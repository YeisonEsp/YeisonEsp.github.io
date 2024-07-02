<head>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
	<title>Productos</title>	
</head>

<?php include_once "encabezado.php" ?>
<br><h1 id="titulo" class="text-center">PRODUCTOS ACTIVOS</h1><br>
<div class="row">
	<div class="col-12">
		<button id="btninactivos" class="btn btn-danger">Inactivos</button>
		<button hidden id="btnactivos" style="margin-left: 7px;" class="btn btn-success">Activos</button>
		<div id="mostrar-activos" class="table-responsive">
			<table id="tablaproducto" class="table table-bordered table-striped table-light">
				<thead class="thead-dark">
					<tr>
						<th>CÓDIGO</th>
						<th>PRODUCTO</th>
						<th>MODELO</th>
						<th>STOCK</th>
						<th>PRECIO VENTA($COP)</th>
						<th>CATEGORÍA</th>
						<th>LÍNEA</th>
						<th>MARCA</th>
						<th>EDITAR</th>
						<th>ELIMINAR</th>
					</tr>
				</thead>
			</table>
		</div>

		<div hidden id="mostrar-inactivos">
			<div class="table-responsive">
				<table id="tablaproductoina" class="table table-bordered table-striped table-light">
					<thead class="thead-dark">
						<tr>
							<th>CÓDIGO</th>
							<th>PRODUCTO</th>
							<th>MODELO</th>
							<th>STOCK</th>
							<th>CATEGORÍA</th>
							<th>LÍNEA</th>
							<th>MARCA</th>
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
			$('#tablaproducto').DataTable().destroy();
				tablapro = $('#tablaproducto').DataTable({
				"language": {
					"url": 'https://cdn.datatables.net/plug-ins/2.0.0/i18n/es-ES.json',
				}, 
				"columnDefs": [{ "targets": [8, 9] , "sortable": false, "searchable": false}],
				"lengthMenu": [5, 10, 40, 100],
				"ajax":{
					"url": "obtenerProducto.php",
					"dataSrc": "",
				},
				"columns": [
					{"data": "produccod"},
					{"data": "producnom"},
					{"data": "producmod"},
					{"data": "producsto"},
					{"data": "producpre"},
					{"data": "tipopronom"},
					{"data": "lineanom"},
					{"data": "marcanom"},
					{   "data": null,
						render: function(data, type, row){
							return "<a class='btn btn-dark' href='formEditarProducto.php?produccod="+data['produccod']+"' > Editar 📝</a>"
						},
						"targets": -1
					},
					{   "data": null,
						render: function(data, type, row){
							return "<a class='btn btn-danger' href='eliminarProducto.php?produccod="+data['produccod']+"' > Eliminar 🗑️</a>"
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
			titulo.textContent = 'PRODUCTOS INACTIVOS';
			cargarInactivos();
		}
	});

	function cargarInactivos(){
			if(estBtnInactivos===true){
				$('#tablaproductoina').DataTable().destroy();
					tablaproina = $('#tablaproductoina').DataTable({
					"language": {
						"url": 'https://cdn.datatables.net/plug-ins/2.0.0/i18n/es-ES.json',
					},
					"columnDefs": [{ "targets": [7] , "sortable": false, "searchable": false}],
					"lengthMenu": [5, 10, 40, 100],
					"ajax":{
						"url": "obtenerProductoInac.php",
						"dataSrc": "",
					},
					"columns": [
						{"data": "produccod"},
						{"data": "producnom"},
						{"data": "producmod"},
						{"data": "producsto"},
						{"data": "tipopronom"},
						{"data": "lineanom"},
						{"data": "marcanom"},
						{   "data": null,
							render: function(data, type, row){
								return "<a class='btn btn-dark' href='activarProducto.php?produccod="+data['produccod']+"' >Activar ✅</a>"
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
			titulo.textContent = 'PRODUCTOS ACTIVOS';
			cargarActivos();
		}
	});
</script>

<?php include_once "pie.php" ?>