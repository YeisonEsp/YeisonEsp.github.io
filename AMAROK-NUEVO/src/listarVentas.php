<head>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<title>Ventas Realizadas</title>	
</head>

<?php include_once "encabezado.php" ?>
<br><h1 id="titulo" class="text-center">VENTAS COBRADAS</h1><br>
<div class="row">
	<div class="col-12">
		<input readonly type="hidden" id="ventaeditar" value="xd">
		<input readonly type="hidden" id="comprobantever" value="xd">
		<a class="btn btn-primary lis"  href="agregarVenta.php">Agregar</a>
		<button id="btninactivos" class="btn btn-danger">Sin Recaudo</button>
		<button hidden id="btnactivos" style="margin-left: 7px;" class="btn btn-success">Recaudadas</button>
		<div id="mostrar-activos" class="table-responsive">
			<table id="tablaventa" class="table table-bordered table-striped table-light">
				<thead class="thead-dark">
					<tr>
						<th>NÚMERO</th>
						<th>CC CLIENTE</th>
						<th>CLIENTE</th>
						<th>DEPARTAMENTO</th>
						<th>CIUDAD</th>
						<th>MODO DE PAGO</th>
                        <th>DOMI</th>
						<th>TOTAL($COP)</th>
						<th>FECHA</th>
						<th>FACTURA</th>
						<th>COBRO</th>
					</tr>
				</thead>
			</table>
		</div>

		<div hidden id="mostrar-inactivos">
			<div class="table-responsive">
				<table id="tablaventaina" class="table table-bordered table-striped table-light">
					<thead class="thead-dark">
						<tr>
							<th>NÚMERO</th>
							<th>CC CLIENTE</th>
							<th>CLIENTE</th>
							<th>DEPARTAMENTO</th>
							<th>CIUDAD</th>
							<th>DOMICILIO</th>
							<th>CANCELADA</th>
							<th>TOTAL($COP)</th>
							<th>FECHA</th>
							<th>DETALLE</th>
							<th>EDITAR COBRO</th>
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
	var ventaedit = document.getElementById('ventaeditar');
	var comprobantever = document.getElementById('comprobantever');
	var titulo = document.getElementById('titulo');

	$(document).ready(
		cargarActivos()
	);

	function cargarActivos(){
		if(estBtnInactivos===false){
			$('#tablaventa').DataTable().destroy();
				tablapro = $('#tablaventa').DataTable({
				"language": {
					"url": 'https://cdn.datatables.net/plug-ins/2.0.0/i18n/es-ES.json',
				}, 
				"columnDefs": [{ "targets": [9,10] , "sortable": false, "searchable": false}],
				"lengthMenu": [5, 10, 40, 100],
				"ajax":{
					"url": "obtenerVenta.php",
					"dataSrc": "",
				},
				"order": [[0, "desc"]],
				"columns": [
					{"data": "ventanum"},
					{"data": "docclient"},
					{"data": "clientnom"},
					{"data": "departamento"},
					{"data": "ciudad"},
					{"data": "tipopago"},
					{"data": "ventadom"},
					{"data": "total"},
					{"data": "fechaventa"},
					{   "data": null,
						render: function(data, type, row){
							return "<button type='submit' id='"+data['ventanum']+"' class='btn btn-dark pdfventa'> Pdf 📝</button>"
						},
						"targets": -1
					},
					{   "data": null,
						render: function(data, type, row){
							return "<button type='submit' id='"+data['ventanum']+"' class='btn btn-dark vercomp'> Recibo 🧾</button>"
						},
						"targets": -1
					}
				],
				"drawCallback": function() {
					// Capturar los IDs de los botones por su clase
					var comprobantes = document.querySelectorAll(".vercomp");
					var pdfs = document.querySelectorAll(".pdfventa");
					comprobantes.forEach((boton)=> {
						boton.addEventListener('click', function(){
							var idboton = $(this).attr('id');
							var idbo = parseInt(idboton, 10);
							comprobantever.value = idbo;
							$('#imagenModal').modal('show');
							var imagen = document.getElementById('imagenAMostrar');
							// Construye la ruta de la imagen usando el número de venta
							var rutaImagen = '../images/Comprobantes_Cobros/' + comprobantever.value + '.jpg';
							// Establece la ruta de la imagen en el atributo src
							imagen.src = rutaImagen;
						});
					});
					pdfs.forEach((btnpdf)=>{
						btnpdf.addEventListener('click', function(){
							var idpdf = $(this).attr('id');
							var idp = parseInt(idpdf, 10);
							var param = {
							'ventanum': idp
							};
							$.ajax({
								data: param,
								url: 'verFacturaVenta.php',
								type: 'POST',
								success: function(){
									window.open("../images/Facturas_Ventas/Factura_"+idp+".pdf", '_blank');
								}
							});
						});
					});
				}
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
			titulo.textContent = 'VENTAS SIN COBRAR';
			cargarInactivos();
		}
	});

	function cargarInactivos(){
			if(estBtnInactivos===true){
				$('#tablaventaina').DataTable().destroy();
					tablaproina = $('#tablaventaina').DataTable({
					"language": {
						"url": 'https://cdn.datatables.net/plug-ins/2.0.0/i18n/es-ES.json',
					},
					"columnDefs": [{ "targets": [8,9] , "sortable": false, "searchable": false}],
					"lengthMenu": [5, 10, 40, 100],
					"ajax":{
						"url": "obtenerVentaInac.php",
						"dataSrc": "",
					},
					"order": [[0, "desc"]],
					"columns": [
						{ 
							"data": function(row) {
								return "----"; // Aquí especifica directamente "----"
							}
						},
						{"data": "docclient"},
						{"data": "clientnom"},
						{"data": "departamento"},
						{"data": "ciudad"},
						{"data": "ventadom"},
						{"data": "ventacan"},
						{"data": "total"},
						{"data": "fechaventa"},
						{   "data": null,
							render: function(data, type, row){
								return "<a class='btn btn-dark' href='detalleVenta.php?ventanum="+data['ventanum']+"' > Detalle 📝</a>"
							},
							"targets": -1
						},
						{   "data": null,
							render: function(data, type, row){
								return "<button type='submit' id='"+data['ventanum']+"' class='btn btn-dark editven'> Editar 💰</button>"
							},
							"targets": -1
						}
					],
					"drawCallback": function() {
						// Capturar los IDs de los botones por su clase
						var editores = document.querySelectorAll(".editven");
						editores.forEach((btn)=> {
							btn.addEventListener('click', function(){
								var idbtn = $(this).attr('id');
								var idb = parseInt(idbtn, 10);
								ventaedit.value = idb;
								$('#exampleModal').modal('show');
							});
						});
					}
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
			titulo.textContent = 'VENTAS COBRADAS';
			cargarActivos();
		}
	});
</script>

<!-- Modal -->
<div class="modal fade" id="imagenModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document"> 
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Comprobante de pago</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Aquí se mostrará la imagen -->
                <img id="imagenAMostrar" class="img-fluid" src="" alt="En efectivo no hay comprobantes">
            </div>
            <div class="modal-footer">
				<a id="descargarImagen" href="#" class="btn btn-outline-dark">Descargar</a>
                <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content" style="background-color: whitesmoke; opacity: 0.95;">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Selecciona un modo de cobro</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<form>
			<div class="mb-3 text-black">
				<label for="modoPago">Modo de cobro:</label>
				<select class="form-control form-control-sm" id="modoPago">
				<option value="Efectivo">Efectivo</option>
				<option value="Tarjeta">Tarjeta</option>
				<option value="Transferencia Banco">Transferencia Banco</option>
				</select>
			</div>
			<div class="mb-3 text-center">
				<label for="archivo" style="color: black;" class="font-weight-bold">Cargar soporte de cobro solo si este se efectúa en Tarjeta o Transferencia Banco</label>
			</div>
			<div class="mb-3 text-center">
				<input type="file" class="form-control-file" id="archivo">
			</div>
			</form>
		</div>
		<div class="d-flex align-items-center justify-content-center pb-4 text-center">
			<div class="modal-footer text-center">
				<button type="button" class="btn btn-outline-dark mx-2" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-outline-primary mx-2" id="guardarPago">Actualizar</button>
			</div>
		</div>
	</div>
</div>

<script src="../js/editarCobro.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php include_once "pie.php" ?>