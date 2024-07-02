<head>
	<title>Venta Nueva</title>	
</head>

<?php 
    include_once "encabezado.php";
?>

<br><h1 id="titulo" class="text-center">VENTA NUEVA</h1><br>
<br>
<div class="container mt-4 contenedor-de-todo position-relative">
    <button type="submit" class="btn btn-info opcven position-absolute" style="left: 0; top: -50px;" id="dom">Entrega</button>
    <div class="contenedor-cli-val-pro row">
    <div style="width: 25%;" class="contenedor-cliente col-lg-4 col-md-6">
                <input hidden id="depa" name="depa" class="form-control input-cliente" type="text">
                <input hidden id="ciud" name="ciud" class="form-control input-cliente" type="text">
                <input hidden value="<?php echo $_SESSION['id']; ?>" id="usr" name="usr" class="input-cliente" type="text">
                <input hidden value="<?php echo $_SESSION['username']; ?>" id="rol" name="rol" class="input-cliente" type="text">
                <label class="inputi" for="clientdoc">Documento Cliente</label>
                <input id="clientdoc" name="clientdoc" class="form-control-sm input-cliente" type="number" autofocus>
                <span id="mostrar-mensaje"></span>
                <div class="col-lg-4 col-md-6 d-flex align-items-center">
                    <div class="btn-group mr-2" role="group" aria-label="Botones de navegación">
                        <button id="btncontinuar" class="btn btn-light" style="left:-14;">Iniciar</button>
                        <button hidden id="btnvolverventa" class="btn btn-secondary" style="left:-14;">Volver</button>
                    </div>
                </div>
                <br>
                <label for="idciudad">Ciudad Cliente</label>
                <input id="idciudad" name="idciudad" class="form-control-sm input-cliente" type="text" readonly>
            </div>

            <div style="width: 45%;"  class="contenedor-producto col-lg-6 col-md-6" id="seccionProducto">
                <span id="mostrar-mensaje-producto"></span>
                
                <br>
                <span class="border-span">
                    <label class ="label-producto-1" for="producto">Código:</label>
                    <input class="input-producto-1 idcod form-control-sm" for="producto" type="text" id="codigo-producto" readonly>
                    <button disabled id="matacho" class="btn btn-dark">🕵️‍♀️</button>
                </span>

                <span class="border-span">
                    <label class ="label-producto label-stock" for="can-dis">Stock:</label>
                    <input class="input-producto cantdis form-control-sm" id="stock-producto" type="number" readonly>
                </span>
                <br> <br>

                <span class="border-span">
                    <label class ="label-producto label-nombre" for="producto">Nombre:</label>
                    <input class="input-producto nom form-control-sm" type="text" id="nombre-producto" readonly>
                </span>
                <br> <br>

                <span class="border-span">
                    <label class ="label-producto" for="valor-par">Precio Venta($COP):</label>
                    <input class="input-producto valpar form-control-sm" id="valpar" type="number" readonly>
                </span>

                <span class="border-span">
                    <label class ="label-producto" for="valor-par">Modelo:</label>
                    <input class="input-producto model form-control-sm" id="modelo" type="text" readonly>
                </span>
                <br> <br>

                <span class="border-span">
                    <label class ="label-producto" for="can-req">Cantidad:</label>
                    <input class="input-producto cantreq form-control-sm" id="cantreq" type="number" readonly>
                </span>
                
                <span class="border-span">
                    <label class ="label-producto" for="valor-net">Bruto($COP):</label>
                    <input class="input-producto valnet form-control-sm" type="number" id="precio-neto-producto" readonly >
                </span>
                <br>
                <div id="mostrar-mensaje-cantidad"></div>
                
                <div class="imagen">
                    
                </div>
                
                <button disabled id="btnAgregarProd" class="btn btn-warning mas">➕</button>
                <button disabled id="cancelarProd" class="btn reinicar">⟲</button>    
            </div>
        
        <div style="width: 30%;" class="contenedor-valor-venta col-md-6">
            <h5 class="text-center text-light mt-3">Valor Total ($COP)</h5>
            <input id="valor-total" type="number" class="form-control" readonly>
            <h5 class="text-center text-light mt-3">Puntos a Obtener:</h5>
            <input id="puntos-obtener" type="number" class="form-control" readonly><hr>
            <h5 class="text-center text-light mt-3">Modo de pago:</h5>
            <select name="tipopago" type="text" class="form-control-sm select-ciudad" id="tipopago">
                <option value="Seleccione una opcion">Seleccione una opción</option>
                <option value="Efectivo">Efectivo</option>
                <option value="Transferencia Banco">Transferencia Banco</option>
                <option value="Tarjeta">Tarjeta</option>
                <option value="Ninguno">Ninguno</option>
            </select>
        </div>
    </div>
    <div class="contenedor-tabla-venta col-md-12 mt-4">
        <div class="table-responsive">
            <table class="table tabla-venta">
                <thead class="encabezado-tabla">
                    <tr>
                        <th style="width: 10%;">CÓDIGO</th>
                        <th style="width: 40%;">PRODUCTO</th>
                        <th style="width: 15%;">CANTIDAD</th>
                        <th style="width: 15%;">PRECIO UNITARIO($COP)</th>
                        <th style="width: 15%;">VALOR PARCIAL($COP)</th>
                        <th style="width: 5%;"></th>
                    </tr>
                </thead>
                <tbody class="cuerpo-tabla" id="cuerpo-tabla">
                    <!-- Contenido de la tabla generada dinámicamente -->
                </tbody>
                <tfoot class="pie-tabla" id="pie-tabla">
                    <tr>
                        <th class="pie-tabla" scope="row" colspan="5">Carrito Vacío - ¡Compra algo, por favor!</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Templates -->
<template class="pie-tabla" id="template-footer">
    <th scope="row" colspan="2">Total productos</th>
    <td class="cantiTotal" style="text-align: center;">10</td>
    <td>Precio Total($COP)</td>
    <td class="precio-total-footer-tabla" colspan="2">$ <span class="total-compra">5000</span></td>
</template>

<template id="template-carrito">
    <tr>
        <th class="idpro" for="producto" type="text">código</th>
        <td class="producto-nombre nombrep">nombreProducto</td>
        <td class="cantidadp">cantidad</td>
        <td class="preciounip">precio unitario($cop)</td>
        <td class="precionetop">precio neto($cop)</td>
        <td><button class="btn btn-warning btnpro">❌</button></td>
    </tr>
</template>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content" style="background-color: whitesmoke; opacity: 0.95;">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Selecciona un método de entrega</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<form>
                <div class="mb-3 text-center">
                    <label for="archivo" style="color: black;" class="font-weight-bold">Cargar soporte de cobro solo si este se efectúa en Tarjeta o Transferencia Banco</label>
                    <input type="file" class="form-control-file" id="archivo">
                </div>
                <div class="mb-3 text-black">
                    <label for="modoEntrega">Modo de entrega:</label>
                    <select class="form-control form-control-sm" id="modoEntrega" onchange="toggleDireccion()">
                        <option value="tienda" selected>Recoger en Tienda</option>
                        <option value="domicilio">Envío a Domicilio</option>
                    </select>
                </div>
                <div class="mb-3 text-black" id="municipioEnvioGroup" style="display: none;">
                    <label for="idCiudad">Seleccionar Municipio de Envío</label>
                    <select class="form-control form-control-sm" id="idCiudad">
                        <?php
                        include_once "conexion.php";
                        $sentencia2 = $base_de_datos->query('SELECT c.ciudadid, c.ciudadnom, d.departnom FROM ciudad c JOIN departamento d ON c.iddepart = d.departid ORDER BY d.departNom;');
                        $ciudades = $sentencia2->fetchAll(PDO::FETCH_OBJ);
                        ?>
                        <option selected >Seleccionar una Ciudad</option>
                        <?php foreach($ciudades as $ciud)
                        {
                        ?>
                        <option value="<?php echo $ciud ->ciudadid ?>"><?php echo $ciud->departnom ?> , <?php echo $ciud->ciudadnom ?></option>
                        <?php
                        } ?>
                    </select>
                    </div>
                    <div class="mb-3 text-black" id="documentoGroup" style="display: none;">
                        <label for="documento">Documento de Persona que Recibe</label>
                        <input type="number" class="form-control form-control-sm" id="documento" minlength="8" maxlength="10" min="10000000" max="9999999999" placeholder="Ingrese número de documento">
                    </div>
                    <div class="mb-3 text-black" id="nombreGroup" style="display: none;">
                        <label for="nombre">Nombre de Persona que Recibe</label>
                        <input type="text" class="form-control form-control-sm" id="nombre" minlength="3" maxlength="70" placeholder="Ingrese nombre">
                    </div>
                        <div class="mb-3 text-black" id="telefonoGroup" style="display: none;">
                        <label for="telefono">Número de Teléfono</label>
                        <input type="number" class="form-control form-control-sm" id="telefono" minlength="10" maxlength="10" min="3002000000" max="3519999999" placeholder="Ingrese teléfono">
                    </div>
                    <div class="mb-3 text-black" id="direccionEnvioGroup" style="display: none;">
                        <label for="direccion">Dirección de Envío</label>
                        <input type="text" class="form-control form-control-sm" id="direccion" minlength="12" maxlength="80" placeholder="Ingrese dirección">
                </div>
                <div class="d-flex align-items-center justify-content-center pb-4 text-center">
                    <div class="modal-footer text-center">
                        <button type="button" class="btn btn-outline-dark mx-2" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-outline-primary mx-2" id="finalizar">Finalizar</button>
                    </div>
                </div>
			</form>
		</div>
	</div>
</div>

<!-- Bootstrap JS (jQuery is required) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function toggleDireccion() {
        var metodoRetiro = document.getElementById("modoEntrega").value;
        if (metodoRetiro === "domicilio") {
            document.getElementById("documentoGroup").style.display = "block";
            document.getElementById("nombreGroup").style.display = "block";
            document.getElementById("telefonoGroup").style.display = "block";
            document.getElementById("direccionEnvioGroup").style.display = "block";
            document.getElementById("municipioEnvioGroup").style.display = "block";
        } else {
            document.getElementById("documentoGroup").style.display = "none";
            document.getElementById("nombreGroup").style.display = "none";
            document.getElementById("telefonoGroup").style.display = "none";
            document.getElementById("direccionEnvioGroup").style.display = "none";
            document.getElementById("municipioEnvioGroup").style.display = "none";
        }
}
</script>

<script src="../js/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/agregarVenta.js"></script>
<script src="../js/tablaAgregarVenta.js"></script>
<script src="../js/agregarProducto.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php include_once "pie.php" ?>