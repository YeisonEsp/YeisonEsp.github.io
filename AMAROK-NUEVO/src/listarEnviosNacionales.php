
<head>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<title>Envíos Nacionales</title>	
</head>

<?php include_once "encabezado.php" ?>
<br><h1 id="titulo" class="text-center">ENVÍOS NACIONALES ENTREGADOS</h1><br>
<div class="row">
	<div class="col-12">
		<input readonly type="hidden" id="aggobs" value="xd">
		<input readonly type="hidden" id="enviofinalizar" value="xd">
		<input readonly type="hidden" id="comprobantever" value="xd">
		<input readonly type="hidden" id="envioeditar" value="xd">
		<button id="btnsinsalir" class="btn btn-danger">Sin Salir</button>
		<button hidden id="btnentregados" style="margin-left: 7px;" class="btn btn-success">Entregados</button>
		<button id="btndespachados" style="margin-left: 7px;" class="btn btn-info">Despachados</button>
		<br><br><div id="mostrar-entregados" class="table-responsive">
			<table id="tablaenvioent" class="table table-bordered table-striped table-light">
				<thead class="thead-dark">
					<tr>
						<th>NÚMERO ENVÍO</th>
						<th>VENTA</th>
						<th>DOC_MENSAJERO</th>
						<th>MENSAJERO</th>
						<th>EMPRESA DE TRANSPORTE</th>
						<th>DEPARTAMENTO DESTINO</th>
						<th>CIUDAD DESTINO</th>
						<th>DOCUMENTO DESTINARIO</th>
						<th>NOMBRE DESTINARIO</th>
						<th>DIRECCIÓN DESTINO</th>
						<th>TELÉFONO DESTINARIO</th>
						<th>PRECIO ENVÍO</th>
						<th>OBSERVACIONES</th>
						<th>FECHA SALIDA</th>
						<th>FECHA ENTREGA</th>
						<th>GUÍA</th>
					</tr>
				</thead>
			</table>
		</div>

		<div hidden id="mostrar-despachados">
			<div class="table-responsive">
				<table id="tablaenviodesp" class="table table-bordered table-striped table-light">
					<thead class="thead-dark">
						<tr>
							<th>NÚMERO ENVÍO</th>
							<th>VENTA</th>
							<th>DOC_MENSAJERO</th>
							<th>MENSAJERO</th>
							<th>DEPARTAMENTO DESTINO</th>
							<th>CIUDAD DESTINO</th>
							<th>DOCUMENTO DESTINARIO</th>
							<th>NOMBRE DESTINARIO</th>
							<th>DIRECCIÓN DESTINO</th>
							<th>TELÉFONO DESTINARIO</th>
							<th>PRECIO ENVÍO</th>
							<th>FECHA REGISTRO</th>
							<th>FECHA SALIDA</th>
							<th>FINALIZAR</th>
							<th>OBSERVACIÓN</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>

		<div hidden id="mostrar-sinsalir">
			<div class="table-responsive">
				<table id="tablaenviosinsalir" class="table table-bordered table-striped table-light">
					<thead class="thead-dark">
						<tr>
							<th>NÚMERO ENVÍO</th>
							<th>VENTA</th>
							<th>DEPARTAMENTO DESTINO</th>
							<th>CIUDAD DESTINO</th>
							<th>DOCUMENTO DESTINARIO</th>
							<th>NOMBRE DESTINARIO</th>
							<th>DIRECCIÓN DESTINO</th>
							<th>TELÉFONO DESTINARIO</th>
							<th>PRECIO ENVÍO</th>
							<th>FECHA REGISTRO</th>
							<th>DESPACHAR</th>
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
	
	var btnsinsalir = document.getElementById('btnsinsalir');
	var btnentregados = document.getElementById('btnentregados');
	var btndespachados = document.getElementById('btndespachados');
	let estBtnsinsalir = false;
	let estBtndespachados = false;
	var recargartent;
	var recargartsinsalir;
	var recargartdesp;
	var sinsalir = document.getElementById('mostrar-sinsalir');
	var despachados = document.getElementById('mostrar-despachados');
	var entregados = document.getElementById('mostrar-entregados');
	var tablaproent;
	var tablaprosinsalir;
	var tablaprodesp;
	var envioedit = document.getElementById('envioeditar');
	var enviofinalizar = document.getElementById('enviofinalizar');
	var comprobantever = document.getElementById('comprobantever');
	var aggobs = document.getElementById('aggobs');
	var titulo = document.getElementById('titulo');

	$(document).ready(
		cargarentregados()
	);

	function cargarentregados(){
		if(estBtnsinsalir===false || estBtndespachados===false){
			$('#tablaenvioent').DataTable().destroy();
				tablaproent = $('#tablaenvioent').DataTable({
				"language": {
					"url": 'https://cdn.datatables.net/plug-ins/2.0.0/i18n/es-ES.json',
				}, 
				"lengthMenu": [5, 10, 40, 100],
				"ajax":{
					"url": "obtenerEnvioNacionalEnt.php",
					"dataSrc": "",
				},
				"order": [[0, "desc"]],
				"columns": [
					{"data": "envionum"},
					{"data": "numventa"},
					{"data": "docusuario"},
					{"data": "usuarionom"},
					{"data": "empretranom"},
					{"data": "departnom"},
					{"data": "ciudadnom"},
					{"data": "enviodocdes"},
					{"data": "envionomdes"},
					{"data": "enviodirdes"},
					{"data": "envioteldes"},
					{"data": "enviopre"},
					{"data": "envioobs"},
					{"data": "fec_salida"},
					{"data": "fec_entrega"},
					{   "data": null,
						render: function(data, type, row){
							return "<button type='submit' id='"+data['envionum']+"' class='btn btn-dark vercomp'> 🧾</button>"
						},
						"targets": -1
					}
				],
				"drawCallback": function() {
					// Capturar los IDs de los botones por su clase
					var comprobantes = document.querySelectorAll(".vercomp");
					comprobantes.forEach((boton)=> {
						boton.addEventListener('click', function(){
							var idboton = $(this).attr('id');
							var idbo = parseInt(idboton, 10);
							comprobantever.value = idbo;
							$('#imagenModal').modal('show');
							var imagen = document.getElementById('imagenAMostrar');
							// Construye la ruta de la imagen usando el número de venta
							var rutaImagen = '../images/Guias_Envios/' + comprobantever.value + '.jpg';
							// Establece la ruta de la imagen en el atributo src
							imagen.src = rutaImagen;
						});
					});
				}
			});
			recargartent = setInterval( function () {
				tablaproent.ajax.reload(null, false);
			}, 4000 );
		}
	}

	btnsinsalir.addEventListener('click', () => {
		if(estBtnsinsalir === false) {
			estBtnsinsalir = true;
			estBtndespachados = false;
			btnentregados.hidden=false;
			btndespachados.hidden=false;
			btnsinsalir.hidden=true;
			entregados.hidden = true;
			despachados.hidden = true;
			sinsalir.hidden = false;
			clearInterval(recargartent);
			clearInterval(recargartdesp);
			titulo.textContent = 'ENVÍOS NACIONALES SIN SALIR';
			cargarsinsalir();
		}
	});

	btndespachados.addEventListener('click', () => {
		if(estBtndespachados === false) {
			estBtndespachados = true;
			estBtnsinsalir = false;
			btnentregados.hidden=false;
			btnsinsalir.hidden=false;
			btndespachados.hidden=true;
			entregados.hidden = true;
			despachados.hidden = false;
			sinsalir.hidden = true;
			clearInterval(recargartent);
			clearInterval(recargartsinsalir);
			titulo.textContent = 'ENVÍOS NACIONALES DESPACHADOS';
			cargardespachados();
		}
	});

	function cargarsinsalir(){
			if(estBtnsinsalir===true){
				$('#tablaenviosinsalir').DataTable().destroy();
					tablaprosinsalir = $('#tablaenviosinsalir').DataTable({
					"language": {
						"url": 'https://cdn.datatables.net/plug-ins/2.0.0/i18n/es-ES.json',
					},
					"columnDefs": [{ "targets": [9] , "sortable": false, "searchable": false}],
					"lengthMenu": [5, 10, 40, 100],
					"ajax":{
						"url": "obtenerEnvioNacionalSinSalir.php",
						"dataSrc": "",
					},
					"order": [[0, "desc"]],
					"columns": [
						{"data": "envionum"},
						{"data": "numventa"},
						{"data": "departnom"},
						{"data": "ciudadnom"},
						{"data": "enviodocdes"},
						{"data": "envionomdes"},
						{"data": "enviodirdes"},
						{"data": "envioteldes"},
						{"data": "enviopre"},
						{"data": "fec_insert"},
						{   "data": null,
							render: function(data, type, row){
								return "<button type='submit' id='"+data['envionum']+"' class='btn btn-dark editenvio'> Despachar 🛵</button>"
							},
							"targets": -1
						}
					],
					"drawCallback": function() {
						// Capturar los IDs de los botones por su clase
						var editores = document.querySelectorAll(".editenvio");
						editores.forEach((btn)=> {
							btn.addEventListener('click', function(){
								var idbtn = $(this).attr('id');
								var idb = parseInt(idbtn, 10);
								envioedit.value = idb;
								$('#exampleModal').modal('show');
							});
						});
					}
				});
				recargartsinsalir = setInterval( function () {
					tablaprosinsalir.ajax.reload(null, false);
				}, 4000 );
			}
	}

	function cargardespachados(){
			if(estBtndespachados===true){
				$('#tablaenviodesp').DataTable().destroy();
					tablaprodesp = $('#tablaenviodesp').DataTable({
					"language": {
						"url": 'https://cdn.datatables.net/plug-ins/2.0.0/i18n/es-ES.json',
					},
					"lengthMenu": [5, 10, 40, 100],
					"ajax":{
						"url": "obtenerEnvioNacionalDesp.php",
						"dataSrc": "",
					},
					"order": [[0, "desc"]],
					"columns": [
						{"data": "envionum"},
						{"data": "numventa"},
						{"data": "docusuario"},
						{"data": "usuarionom"},
						{"data": "departnom"},
						{"data": "ciudadnom"},
						{"data": "enviodocdes"},
						{"data": "envionomdes"},
						{"data": "enviodirdes"},
						{"data": "envioteldes"},
						{"data": "enviopre"},
						{"data": "fec_insert"},
						{"data": "fec_salida"},
						{   "data": null,
							render: function(data, type, row){
								return "<button type='submit' id='"+data['envionum']+"' class='btn btn-dark finalizar'>Finalizar <i class='bi bi-check-lg'></i> </button>"
							},
							"targets": -1
						},
						/*{"data": null,
							render: function(data, type, row){
								return "<a onclick='finalizarEnv("+data['envionum']+")' class='btn btnrevisado btn-dark'  >Finalizar <i class='bi bi-check-lg'></i> </a>"
							},
							"targets": -1
						},*/
						{   "data": null,
							render: function(data, type, row){
								return "<button type='submit' id='"+data['envionum']+"' class='btn btn-dark agregarobs'> Evento ❕</button>"
							},
							"targets": -1
						}
					],
					"drawCallback": function() {
						// Capturar los IDs de los botones por su clase
						var obs = document.querySelectorAll(".agregarobs");
						var fin = document.querySelectorAll(".finalizar");
						obs.forEach((boton)=> {
							boton.addEventListener('click', function(){
								var idboton = $(this).attr('id');
								var idbo = parseInt(idboton, 10);
								aggobs.value = idbo;
								$('#observModal').modal('show');
							});
						});
						fin.forEach((bton)=> {
							bton.addEventListener('click', function(){
								var idbton = $(this).attr('id');
								var idbot = parseInt(idbton, 10);
								enviofinalizar.value = idbot;
								$('#finalizarModal').modal('show');
							});
						});
					}
				});
				recargartdesp = setInterval( function () {
					tablaprodesp.ajax.reload(null, false);
				}, 4000 );
			}
	}

	/*function finalizarEnv(number){
		var parametros = {
        'envionum': number
		};
		$.ajax({
			data: parametros,
			url: 'finalizarEnvio.php',
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
		
		
	}*/

	btnentregados.addEventListener('click', () => {
		if(estBtnsinsalir === true || estBtndespachados === true) {
			estBtnsinsalir = false;
			estBtndespachados = false;
			btnentregados.hidden=true;
			btnsinsalir.hidden=false;
			btndespachados.hidden=false;
			entregados.hidden = false;
			sinsalir.hidden = true;
			despachados.hidden = true;
			clearInterval(recargartsinsalir);
			clearInterval(recargartdesp);
			titulo.textContent = 'ENVÍOS NACIONALES ENTREGADOS';
			cargarentregados();
		}
	});
</script>

<!-- Modal -->
<div class="modal fade" id="imagenModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document"> 
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Guía de envío</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Aquí se mostrará la imagen -->
                <img id="imagenAMostrar" class="img-fluid" src="" alt="No se ha encontrado la guía">
            </div>
            <div class="modal-footer">
				<a id="descargarImagen" href="#" class="btn btn-outline-dark">Descargar</a>
                <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="finalizarModal" tabindex="-1" role="dialog" aria-labelledby="finalizarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document"> 
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="finalizarModalLabel">Datos para finalizar el envío</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
				<form>
					<div class="mb-3 text-black">
						<label for="empresa">Empresa de transporte para envío:</label>
						<select class="form-control form-control-sm" id="empretranit">
						<?php
							include_once "conexion.php";
							$sentencia3 = $base_de_datos->query("SELECT empreTraNit, empreTraNom FROM empresatransporte WHERE empreTraAct = true ORDER BY empreTraNom");
							$empresatransporte = $sentencia3->fetchAll(PDO::FETCH_OBJ);
						?>
						<?php foreach($empresatransporte as $emp)
							{
						?>
						<option value="<?php echo $emp ->empretranit ?>"><?php echo $emp->empretranom ?> </option>
						<?php
							} 
						?>
						</select>
					</div>
					<div class="mb-3 text-center">
						<label for="archivo" style="color: black;">Cargar Guía de envío:</label>
					</div>
					<div class="mb-3 text-center">
						<input type="file" class="form-control-file" id="archivo">
					</div>
				</form>
			</div>
			<div class="d-flex align-items-center justify-content-center pb-4 text-center">
				<div class="modal-footer text-center">
					<button type="button" class="btn btn-outline-dark mx-2" data-dismiss="modal">Cerrar</button>
					<button type="button" class="btn btn-outline-primary mx-2" id="finalizarEnv">Finalizar</button>
				</div>
			</div>
		</div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="observModal" tabindex="-1" role="dialog" aria-labelledby="observModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document"> 
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="observModalLabel">Agregar la observación del envío</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
				<form>
					<div class="mb-3 text-black">
						<label for="envioobs">Evento:</label>
						<input type="text" class="form-control form-control-sm" id="envioobs" minlength="3" maxlength="80" placeholder="Ingrese observación">
					</div>
				</form>
			</div>
			<div class="d-flex align-items-center justify-content-center pb-4 text-center">
				<div class="modal-footer text-center">
					<button type="button" class="btn btn-outline-dark mx-2" data-dismiss="modal">Cerrar</button>
					<button type="button" class="btn btn-outline-primary mx-2" id="guardarObs">Guardar</button>
				</div>
			</div>
		</div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content" style="background-color: whitesmoke; opacity: 0.95;">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Asignación de Mensajero</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<form>
			<div class="mb-3 text-black">
				<label for="docusuario">Seleccione uno...</label>
				<select class="form-control form-control-sm" id="docusuario">
				<?php
					include_once "conexion.php";
					$sentencia2 = $base_de_datos->query("SELECT usuarioDoc, usuarioNom fROM usuario WHERE usuarioRol = 'Mensajero' AND usuarioAct = true ORDER BY usuarioNom");
					$mensajeros = $sentencia2->fetchAll(PDO::FETCH_OBJ);
				?>
				<?php foreach($mensajeros as $mens)
					{
				?>
				<option value="<?php echo $mens ->usuariodoc ?>"><?php echo $mens->usuarionom ?> </option>
				<?php
					} 
				?>
				</select>
			</div>
			</form>
		</div>
		<div class="d-flex align-items-center justify-content-center pb-4 text-center">
		<div class="modal-footer text-center">
			<button type="button" class="btn btn-outline-dark mx-2" data-dismiss="modal">Cerrar</button>
			<button type="button" class="btn btn-outline-primary mx-2" id="asignarMen">Asignar</button>
		</div>
		</div>
	</div>
</div>
<script src="../js/asignarMensajero.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php include_once "pie.php" ?>