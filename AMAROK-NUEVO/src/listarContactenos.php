<head>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
	<title>Contactos</title>	
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
<br><h1 id="titulo" class="text-center">MENSAJES NO REVISADOS</h1><br>

<div class="row">
	<div class="col-12">
		<button id="btninactivos" class="btn btn-danger">Leídos</button>
		<button hidden id="btnactivos" style="margin-left: 7px;" class="btn btn-success">No leídos</button>
		
		<div id="mostrar-activos" class="table-responsive">
			<table id="tablacontactenos" class="table table-bordered table-striped table-light">
				<thead class="thead-dark">
					<tr>
						<th style="width: 15%;">NOMBRE</th>
						<th style="width: 15%;">TELÉFONO</th>
						<th style="width: 15%;">EMAIL</th>
                        <th style="width: 15%;">ASUNTO</th>
                        <th style="width: 15%;">FECHA</th>
						<th style="width: 12,5%;">REVISADO</th>
						<th style="width: 12,5%;">ELIMINAR</th>
					</tr>
				</thead>
			</table>
		</div>

		<div hidden id="mostrar-inactivos">
			<div class="table-responsive">
				<table id="tablacontactenosina" class="table table-bordered table-striped table-light">
					<thead class="thead-dark">
						<tr>
						<th style="width: 18%;">NOMBRE</th>
						<th style="width: 18%;">TELÉFONO</th>
						<th style="width: 18%;">EMAIL</th>
                        <th style="width: 18%;">ASUNTO</th>
                        <th style="width: 18%;">FECHA</th>
						<th style="width: 10%;">ELIMINAR</th>
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


<script>
	var btninactivos = document.getElementById('btninactivos');
	var btnactivos = document.getElementById('btnactivos');
	var inactivos = document.getElementById('mostrar-inactivos');
	var activos = document.getElementById('mostrar-activos');
	let estBtnInactivos = false;
	var titulo = document.getElementById('titulo');

	$(document).ready(
		cargarActivos()
	);

	function cargarActivos(){
		$('#tablacontactenos').DataTable().destroy();
			tablapro = $('#tablacontactenos').DataTable({
			"language": {
				"url": 'https://cdn.datatables.net/plug-ins/2.0.0/i18n/es-ES.json',
			}, 
			"columnDefs": [{ "targets": [5, 6] , "sortable": false, "searchable": false}],
			"lengthMenu": [5, 10, 40, 100],
			"ajax":{
				"url": "obtenerContactenos.php",
				"dataSrc": "",
			},
			"columns": [
				{"data": "contacnom"},
				{"data": "contactel"},
				{"data": "contacema"},
				{"data": "contacasu"},
				{"data": "fechacontac"},
				{"data": null,
					render: function(data, type, row){
						return "<a onclick='actualizarRev("+data['contacid']+")' class='btn btnrevisado btn-dark'  >Revisado <i class='bi bi-check-lg'></i> </a>"
					},
					"targets": -1
				},
				{"data": null,
					render: function(data, type, row){
						return "<a class='btn btn-danger' href='eliminarContactenos.php?contacid="+data['contacid']+"' > Eliminar 🗑️</a>"
					},
					"targets": -1
				}
			]
		});
		recargart = setInterval( function () {
			tablapro.ajax.reload(null, false);
		}, 3000 );
	
	}

	function actualizarRev(number){
		var parametros = {
        'idcontac': number
		};
		$.ajax({
			data: parametros,
			url: 'actualizarEstConct.php',
			type: 'POST',
			dataType: "text",
			success: function(mensaje){
				Swal.fire({
					position: "top-end",
					title: mensaje,
					showConfirmButton: false,
					timer: 2500,
				});
			}
		});
		
		
	}

	btninactivos.addEventListener('click', () => {
		if(estBtnInactivos === false) {
			estBtnInactivos = true;
			btnactivos.hidden=false;
			btninactivos.hidden=true;
			activos.hidden = true;
			inactivos.hidden = false;
			clearInterval(recargart);
			titulo.textContent = 'MENSAJES REVISADOS';
			cargarInactivos();
		}
	});

	btnactivos.addEventListener('click', () => {
		if(estBtnInactivos === true) {
			estBtnInactivos = false;
			btnactivos.hidden=true;
			btninactivos.hidden=false;
			activos.hidden = false;
			inactivos.hidden = true;
			clearInterval(recargartInac);
			titulo.textContent = 'MENSAJES NO REVISADOS';
			cargarActivos();
		}
	});

	function cargarInactivos(){
			if(estBtnInactivos===true){
				$('#tablacontactenosina').DataTable().destroy();
					tablaproina = $('#tablacontactenosina').DataTable({
					"language": {
						"url": 'https://cdn.datatables.net/plug-ins/2.0.0/i18n/es-ES.json',
					},
					"columnDefs": [{ "targets": [5] , "sortable": false, "searchable": false}],
					"lengthMenu": [5, 10, 40, 100],
					"ajax":{
						"url": "obtenerContactenosInac.php",
						"dataSrc": "",
					},
					"columns": [
						{"data": "contacnom"},
						{"data": "contactel"},
						{"data": "contacema"},
						{"data": "contacasu"},
						{"data": "fechacontac"},
						{"data": null,
							render: function(data, type, row){
								return "<a class='btn btn-danger' href='eliminarContactenos.php?contacid="+data['contacid']+"' > Eliminar 🗑️</a>"
							},
							"targets": -1
						}
					]
				});
				recargartInac = setInterval( function () {
					tablaproina.ajax.reload(null, false);
				}, 3000 );
			}
	}

</script>

<?php include_once "pie.php" ?>