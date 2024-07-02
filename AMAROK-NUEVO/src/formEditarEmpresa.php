<head>
	<link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
	<title>Editar Empresa Transporte</title>	
</head>


<?php

if (!isset($_GET["empretranit"]))
{
	echo "No existe la Empresa a editar";
	exit();
}

include_once 'encabezado.php';

$empretranit = $_GET["empretranit"];

include_once "conexion.php";

$sentencia = $base_de_datos->prepare("SELECT empretranit, empretranom, empretratel FROM empresatransporte WHERE empretranit = ?;");
$sentencia->execute([$empretranit]);
$empresas = $sentencia->fetchObject();
if (!$empresas)
{
    echo "¡No existe alguna Empresa con ese Nit!";
    exit();
}
?>


<h1 id="formularioEditar" class="text-center">EDITAR EMPRESA DE TRANSPORTE</h1>
<main>
	<form id="formulario" action="editarEmpresa.php" method="POST" class="formulario">

		<input type="hidden" name="empretranit" value="<?php echo $empresas->empretranit; ?>">

		<div class="formulario__grupo" id="grupo__empretranom">
			<label for="empretranom" class="formulario__label">Nombre de la Empresa</label>
			<div class="formulario__grupo-input">
				<input value="<?php echo $empresas->empretranom; ?>" required name="empretranom" type="text"  maxlength="25" id="empretranom" placeholder="Actualizar Nombre Empresa" class="formulario__input">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">el nombre debe tener mínimo 4 caracteres y máximo 25 caracteres</p>
		</div>

		<div class="formulario__grupo" id="grupo__empretratel">
			<label for="empretratel" class="formulario__label">Telefono de la Empresa</label>
			<div class="formulario__grupo-input">
				<input value="<?php echo $empresas->empretratel; ?>" required name="empretratel" type="number" min="3002000000" max="6019999999" id="empretratel" placeholder="Actualizar Telefono Empresa" class="formulario__input">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">El teléfono solo puede tener 10 dígitos y sin espacio</p>
		</div>

		<div class="formulario__grupo formulario__grupo-btn-enviar">
			<button id="btnValidarForm" type="submit" class="formulario__btn">Actualizar</button>
		</div>
	</form>
</main>


<script src="../js/formularioEmpresa.js"></script>