<head>
	<link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
	<title>Agregar Empresa Transporte</title>	
</head>

<?php
session_start();
if(!isset($_SESSION['id']) ||
    !isset($_SESSION['username']))
{
    header("location: login.php");
}

$usua = $_SESSION['id'];
$role = $_SESSION['username'];

switch(true)
{
	case ($role=='Administrador') || ($role=='Vendedor'):
		include_once "encabezado.php";
	break;

	default:
		echo "<script>
			alert('↩️ No tiene permisos para realizar esta operación');
			window.location = 'login.php';
		</script>";
	break;
}
?>
<h1 id="titulo" class="text-center">AGREGAR EMPRESA DE TRANSPORTE</h1>
<main>
	<form action="insertarEmpresa.php" method="POST" class="formulario" id="formulario">
		<!-- Grupo: Documento -->
		<div class="formulario__grupo" id="grupo__empretranit">
			<label for="empretranit" class="formulario__label">Nit</label>
			<div class="formulario__grupo-input">
				<input required type="number" min="10000000" max="9999999999" class="formulario__input" name="empretranit" id="empretranit" placeholder="Ingresar NIT Empresa" autofocus>
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">El Nit debe llevar 10 dígitos, incluyendo el dígito de verificación sin guión</p>
		</div>

		<!-- Grupo: Nombre -->
		<div class="formulario__grupo" id="grupo__empretranom">
			<label for="empretranom" class="formulario__label">Nombre</label>
			<div class="formulario__grupo-input">
				<input required type="text" class="formulario__input" name="empretranom" id="empretranom" minlength="4" maxlength="25" placeholder="Ingresar Nombre Empresa">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">El nombre debe tener mínimo 4 caracteres y máximo 25 caracteres</p>
		</div>

		<!-- Grupo: Teléfono -->
		<div class="formulario__grupo" id="grupo__empretratel">
			<label for="empretratel" class="formulario__label">Teléfono</label>
			<div class="formulario__grupo-input">
				<input required type="number" min="3002222222" max="6089999999" placeholder="Ingresar Telefono Empresa" class="formulario__input" name="empretratel" id="empretratel">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">El teléfono solo puede tener 10 dígitos y sin espacio</p>
		</div>
		
		<div class="formulario__grupo formulario__grupo-btn-enviar">
			<button id="btnValidarForm" type="submit" class="formulario__btn">Registrar</button>
		</div>
	</form>
</main>

<script src="../js/formularioEmpresa.js"></script>