<head>
	<link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
	<title>Editar Usuario</title>	
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

if (!isset($_GET["usuariodoc"]) ||
	!isset($_GET["usuariorol"]))
{
	echo "No existe el usuario a editar";
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
	break;
}

$usuariodoc = $_GET["usuariodoc"];
$usuariorol = $_GET["usuariorol"];

include_once "conexion.php";

$sentencia = $base_de_datos->prepare("SELECT usuariodoc, usuariorol, usuarionom, usuariodir, usuariotel, usuarioema FROM usuario WHERE usuariodoc = ? AND usuariorol = ?;");
$sentencia->execute([$usuariodoc, $usuariorol]);
$usuarios = $sentencia->fetchObject();

if (!$usuarios)
{
    echo "¡No existe este usuario!";
    exit();
}
?>

<h1 id="formularioEditar" class="text-center">EDITAR USUARIO</h1>
<main>
	<form id="formulario" action="editarUsuario.php" class="formulario" method="POST">

		<input type="hidden" name="usuariodoc" value="<?php echo $usuarios->usuariodoc; ?>">
		<input type="hidden" name="usuariorol" value="<?php echo $usuarios->usuariorol; ?>">

		<div class="formulario__grupo" id="grupo__usuarionom">
			<label for="usuarionom" class="formulario__label">Nombre</label>
			<div class="formulario__grupo-input">
				<input value="<?php echo $usuarios->usuarionom; ?>" required name="usuarionom" type="text" maxlength="60" id="mensajnom" placeholder="Nombre del Usuario" class="formulario__input
				">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">El nombre solo debe contener letras y debe tener mínimo 7 caracteres</p>
		</div>

		<div class="formulario__grupo" id="grupo__usuariodir">
			<label for="usuariodir" class="formulario__label">Dirección</label>
			<div class="formulario__grupo-input">
				<input value="<?php echo $usuarios->usuariodir; ?>" required name="usuariodir" type="text" minlength="12" maxlength="70" id="mensajdir" placeholder="Dirección del Usuario" class="formulario__input
				">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">La dirección debe contener las palabras completas; signos aceptados "#" y "-", "/", "°"; mínimo 12 y máximo 70 caracteres</p> 
		</div>

		<div class="formulario__grupo" id="grupo__usuariotel">
			<label for="usuariotel" class="formulario__label">Teléfono</label>
			<div class="formulario__grupo-input">
				<input value="<?php echo $usuarios->usuariotel; ?>" required name="usuariotel" type="number" min="3002000000" max="3999999999" id="mensajtel" placeholder="Teléfono del Usuario" class="formulario__input
				">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">Solo números; el teléfono solo puede tener 10 dígitos y sin espacio; si es fijo agregar el 607</p>
		</div>

		<div class="formulario__grupo" id="grupo__usuarioema">
			<label for="usuarioema" class="formulario__label">Email</label>
			<div class="formulario__grupo-input">
				<input value="<?php echo $usuarios->usuarioema; ?>" required name="usuarioema" type="text" id="mensajema" placeholder="Email del Usuario" class="formulario__input
				">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">El correo deber tener un @ y una dirección de correo válida</p> 
		</div>

		<div class="formulario__grupo formulario__grupo-btn-enviar">
			<button id="btnValidarForm" type="submit" class="formulario__btn">Guardar</button>
		</div>

	</form>
</main>

<script src="../js/validarFormularioUsuario.js"></script>

<?php include_once "pie.php"?>