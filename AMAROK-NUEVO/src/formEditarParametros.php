<head>
	<link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
	<title>Editar Parámetros</title>	
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

if (!isset($_GET["emprenit"]))
{
	echo "No existe el registro de parámetro a editar";
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

$emprenit = $_GET["emprenit"];

include_once "conexion.php";

$sentencia = $base_de_datos->prepare("SELECT empreNit, empreNom, empreDir, empreTel, empreCel, empreEma, numFacIni, redPunDes, redPunDom, tiemposalir FROM parametros WHERE empreNit = ?;");
$sentencia->execute([$emprenit]);
$parametros = $sentencia->fetchObject();

if (!$parametros)
{
    echo "¡No existe algún registro de parámetros con ese Nit!";
    exit();
}
?>


<h1 id="titulo" class="text-center">EDITAR PARÁMETROS</h1>
<main>
	<form id="formulario" action="editarParametros.php" method="POST" class="formulario">

		<input type="hidden" name="emprenit" value="<?php echo $parametros->emprenit; ?>">

		<!-- Grupo: Nombre empresa -->
		<div class="formulario__grupo" id="grupo__emprenom">
			<label for="emprenom" class="formulario__label">Nombre</label>
			<div class="formulario__grupo-input">
				<input value="<?php echo $parametros->emprenom; ?>" required name="emprenom" type="text" minlength="3" maxlength="50" id="emprenom" placeholder="Nombre de la empresa" class="formulario__input">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">El nombre debe tener mínimo 3 caracteres y máximo 50 caracteres</p>
		</div>

		<!-- Grupo: Dirección -->
		<div class="formulario__grupo" id="grupo__empredir">
			<label for="empredir" class="formulario__label">Dirección</label>
			<div class="formulario__grupo-input">
				<input value="<?php echo $parametros->empredir; ?>" required type="text" class="formulario__input" name="empredir" id="empredir" minlength="12" maxlength="70" placeholder="Ej. cra 1 #23-45">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">La dirección debe contener las palabras completas; signos aceptados "#" y "-", "/", "°"; mínimo 12 y máximo 70 caracteres</p>
		</div>

		<!-- Grupo: Teléfono -->
		<div class="formulario__grupo" id="grupo__empretel">
			<label for="empretel" class="formulario__label">Teléfono Fijo</label>
			<div class="formulario__grupo-input">
				<input value="<?php echo $parametros->empretel; ?>" required type="number" min="6011111111" max="6089999999" placeholder="Ej. 6013758935" class="formulario__input" name="empretel" id="empretel">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">Solo números; el teléfono fijo solo debe tener 10 dígitos y sin espacios</p>
		</div>

		<!-- Grupo: Celular -->
		<div class="formulario__grupo" id="grupo__emprecel">
			<label for="emprecel" class="formulario__label">Teléfono Celular</label>
			<div class="formulario__grupo-input">
				<input value="<?php echo $parametros->emprecel; ?>" required type="number" min="3002000000" max="3519999999" placeholder="Ej. 3214567890" class="formulario__input" name="emprecel" id="emprecel">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">Solo números; el teléfono celular solo puede tener 10 dígitos y sin espacios</p>
		</div>

		<!-- Grupo: Email -->
		<div class="formulario__grupo" id="grupo__empreema">
			<label for="empreema" class="formulario__label">Email</label>
			<div class="formulario__grupo-input">
				<input value="<?php echo $parametros->empreema; ?>" required type="text" maxlength="50" placeholder="Ej. C.o_rr-3@ejemplo.com" class="formulario__input" name="empreema" id="empreema">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">El correo deber tener un @ y una dirección válida</p>
		</div>

		<!-- Grupo: Contraseña -->
		<div class="formulario__grupo" id="grupo__admincon">
			<label for="admincon" class="formulario__label">Si desea cambiar la contraseña puede ingresar una nueva</label>
			<div class="formulario__grupo-input">
				<input name="admincon" type="password" maxlength="25" id="admincon" placeholder="Nueva Contraseña" class="formulario__input">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">La contraseña puede tener máximo 25 caracteres de cualquier tipo</p> 
		</div>

		<!-- Grupo: Numero factura inicial -->
		<div class="formulario__grupo" id="grupo__numfacini">
			<label for="numfacini" class="formulario__label">Número de factura actual</label>
			<div class="formulario__grupo-input">
				<input value="<?php echo $parametros->numfacini; ?>" required name="numfacini" type="number" min="0" max="99999" id="numfacini" placeholder="Número inicial de factura" class="formulario__input">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">El número mínimo es de 2 y 9 como máximo</p>
		</div>

		<!-- Grupo: Tiempo Inactividad -->
		<div class="formulario__grupo" id="grupo__tiemposalir">
			<label for="tiemposalir" class="formulario__label">Tiempo máximo de inactividad en el sistema (minutos)</label>
			<div class="formulario__grupo-input">
				<input value="<?php echo $parametros->tiemposalir; ?>" required name="tiemposalir" type="number" min="1" id="tiemposalir" placeholder="Tiempo de inactividad permitido" class="formulario__input">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">El tiempo debe ser mayor a 1 minuto y menor o igual a 99 minutos</p>
		</div>

		<!-- Grupo: Redención descuento -->
		<div class="formulario__grupo" id="grupo__redpundes">
			<label for="redpundes" class="formulario__label">Puntaje mínimo para redención de puntos de descuento</label>
			<div class="formulario__grupo-input">
				<input value="<?php echo $parametros->redpundes; ?>" required name="redpundes" type="number" min="0" max="9999" id="redpundes" placeholder="Puntaje mínimo para redención de descuento" class="formulario__input">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">El puntaje debe ser igual o superior a 4 cifras</p>
		</div>

		<!-- Grupo: Redención domicilio -->
		<div class="formulario__grupo" id="grupo__redpundom">
			<label for="redpundom" class="formulario__label">Puntaje mínimo para redención de puntos de domicilio</label>
			<div class="formulario__grupo-input">
				<input value="<?php echo $parametros->redpundom; ?>" required name="redpundom" type="number" min="0" max="9999" id="redpundom" placeholder="Puntaje mínimo para redención de domicilio" class="formulario__input">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">El puntaje debe ser igual o superior a 4 cifras</p>
		</div>

		<div class="formulario__grupo formulario__grupo-btn-enviar">
			<button id="btnValidarForm" type="submit" class="formulario__btn">Actualizar</button>
		</div>

	</form>
</main>

<script src="../js/validarFormularioParametro.js"></script>
<?php include_once "pie.php"?>