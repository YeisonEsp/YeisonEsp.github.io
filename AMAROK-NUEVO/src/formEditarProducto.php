<head>
	<link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
	<title>Editar Producto</title>	
</head>

<?php

if (!isset($_GET["produccod"]))
{
	echo "No existe el Producto a editar";
	exit();
}

include_once 'encabezado.php';

$produccod = $_GET["produccod"];

include_once 'conexion.php';

$sentencia = $base_de_datos->prepare("SELECT produccod, producnom, producsto, producpre FROM producto WHERE produccod = ?;");
$sentencia->execute([$produccod]);
$productos = $sentencia->fetchObject();
if (!$productos)
{
    echo "¡No existe algún Producto con ese código!";
    exit();
}
?>
	
<h1 id="formularioEditar" class="text-center">EDITAR PRODUCTO</h1>
<main>
	<form id="formulario" action="editarProducto.php" method="POST" class="formulario">		

		<input type="hidden" name="produccod" value="<?php echo $productos->produccod; ?>">

		<div class="formulario__grupo" id="grupo__produccod">
			<label for="produccod" class="formulario__label">Código del Producto</label>
			<div class="formulario__grupo-input">
				<input value="<?php echo $productos->produccod; ?>" readonly name="produccod" type="text" minlength="5" maxlength="5" id="produccod" placeholder="Código Producto" class="formulario__input" autofocus>
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">El código solo debe contener letras y números; mínimo y máximo 5 caracteres</p>
		</div>

		<div class="formulario__grupo" id="grupo__producnom">
			<label for="producnom" class="formulario__label">Nombre del Producto</label>
			<div class="formulario__grupo-input">
				<input value="<?php echo $productos->producnom; ?>" required name="producnom" type="text" minlength="10" maxlength="50" id="producnom" placeholder="Actualizar Nombre Producto" class="formulario__input">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">El nombre solo puede contener números y letras; mínimo 10 caracteres y máximo 50</p>
		</div>

		<div class="formulario__grupo" id="grupo__producsto">
			<label for="producsto" class="formulario__label">Stock del Producto</label>
			<div class="formulario__grupo-input">
				<input value="<?php echo $productos->producsto; ?>" name="producsto" type="number" min="1" max="999" id="producsto" placeholder="Actualizar Stock Producto" class="formulario__input">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">El stock solo puede contener números; mínimo 1 y máximo 999</p>
		</div>

		<div class="formulario__grupo" id="grupo__producpre">
			<label for="producpre" class="formulario__label">Precio del Producto</label>
			<div class="formulario__grupo-input">
				<input value="<?php echo $productos->producpre; ?>" required name="producpre" type="number" min="100" max="9999999" id="producpre" placeholder="Actualizar Precio Producto" class="formulario__input">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">El precio solo puede contener números; mínimo 100 de valor y máximo 99'999.999</p>
		</div>

		<div class="formulario__grupo formulario__grupo-btn-enviar">
			<button id="btnValidarForm" type="submit" class="formulario__btn">Actualizar</button>
		</div>
	</form>
</main>	


<script src="../js/validarFormularioProducto.js"></script>

<?php include_once "pie.php"?>