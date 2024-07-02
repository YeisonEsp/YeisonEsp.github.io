
<head>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
	<title>Pedidos a Proveedores</title>	
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
<br><h1 id="titulo" class="text-center">PEDIDOS A PROVEEDORES PAGADOS</h1><br>
<div class="row">
	<div class="col-12">
		<button id="btninactivos" class="btn btn-danger">Sin Pagar</button>
		<button hidden id="btnactivos" style="margin-left: 7px;" class="btn btn-success">Pagados</button>
		<div id="mostrar-activos" class="table-responsive">
			<table id="tablapedido" class="table table-bordered table-striped table-light">
				<thead class="thead-dark">
					<tr>
						<th>NÚMERO</th>
						<th>PROVEEDOR</th>
						<th>MODO PAGO</th>
						<th>VALOR TOTAL($COP)</th>
						<th>FECHA PEDIDO</th>
						<th>DETALLE</th>
					</tr>
				</thead>
			</table>
		</div>

		<div hidden id="mostrar-inactivos">
			<div class="table-responsive">
				<table id="tablapedidoina" class="table table-bordered table-striped table-light">
					<thead class="thead-dark">
						<tr>
							<th>NÚMERO</th>
							<th>PROVEEDOR</th>
							<th>VALOR TOTAL($COP)</th>
							<th>FECHA PEDIDO</th>
							<th>DETALLE</th>
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
			$('#tablapedido').DataTable().destroy();
				tablapro = $('#tablapedido').DataTable({
				"language": {
					"url": 'https://cdn.datatables.net/plug-ins/2.0.0/i18n/es-ES.json',
				}, 
				"columnDefs": [{ "targets": [5] , "sortable": false, "searchable": false}],
				"lengthMenu": [5, 10, 40, 100],
				"ajax":{
					"url": "obtenerPedido.php",
					"dataSrc": "",
				},
				"order": [[0, "desc"]],
				"columns": [
					{"data": "pedidonum"},
					{"data": "proveenom"},
					{"data": "tipopago"},
					{"data": "pedidototal"},
					{"data": "fec_insert"},
					{   "data": null,
						render: function(data, type, row){
							return "<a class='btn btn-dark' href='detallePedido.php?pedidonum="+data['pedidonum']+"&nitprovee="+data['nitprovee']+"'> Detalle 📝</a>"
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
			titulo.textContent = 'PEDIDOS A PROVEEDORES NO PAGADOS';
			cargarInactivos();
		}
	});

	function cargarInactivos(){
			if(estBtnInactivos===true){
				$('#tablapedidoina').DataTable().destroy();
					tablaproina = $('#tablapedidoina').DataTable({
					"language": {
						"url": 'https://cdn.datatables.net/plug-ins/2.0.0/i18n/es-ES.json',
					},
					"columnDefs": [{ "targets": [4] , "sortable": false, "searchable": false}],
					"lengthMenu": [5, 10, 40, 100],
					"ajax":{
						"url": "obtenerPedidoInac.php",
						"dataSrc": "",
					},
					"order": [[0, "desc"]],
					"columns": [
						{"data": "pedidonum"},
						{"data": "proveenom"},
						{"data": "pedidototal"},
						{"data": "fec_insert"},
						{   "data": null,
							render: function(data, type, row){
								return "<a class='btn btn-dark' href='detallePedido.php?pedidonum="+data['pedidonum']+"&nitprovee="+data['nitprovee']+"'> Detalle 📝</a>"
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
			titulo.textContent = 'PEDIDOS A PROVEEDORES PAGADOS';
			cargarActivos();
		}
	});
</script>
<?php include_once "pie.php" ?>