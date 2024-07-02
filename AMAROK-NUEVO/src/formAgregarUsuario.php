<head>
	<link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
	<title>Agregar Usuario</title>	
</head>

<?php 
session_start();
if(!isset($_SESSION['id']) ||
    !isset($_SESSION['username']))
{
    echo "<script>
			alert('↩️ Debe iniciar sesión para hacer la operación solicitada');
			window.location = 'login.php';
		</script>";
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
?>

		
<h1 id="titulo" class="text-center">AGREGAR USUARIO</h1>
<main>
	<form id="formulario" class="formulario" action="insertarUsuario.php" method="POST">

		<div class="formulario__grupo" id="grupo__usuariodoc">
			<label for="usuariodoc" class="formulario__label">Documento del Usuario</label>
			<div class="formulario__grupo-input">
				<input required name="usuariodoc" type="number" min="10000000" max="9999999999" id="usuariodoc" placeholder="Documento del usuario" class="formulario__input" autofocus>
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">El documento debe tener de 7 a 10 dígitos sin (.) ni (,)</p>
		</div>

		<div class="formulario__grupo form-select-rol" id="grupo__usuariorol">
			<label for="usuariorol" class="formulario__label">Rol del usuario</label>
			<div class="formulario__grupo-input">
				<select name="usuariorol" type="text" class="form-select" id="usuariorol">
					<option value="Seleccione_rol">Seleccione rol</option>
					<option value="Vendedor">Vendedor</option>
					<option value="Bodeguero">Bodeguero</option>
					<option value="Mensajero">Mensajero</option>
				</select>
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">No ha seleccionado el rol</p>
		</div>

		<div class="formulario__grupo" id="grupo__usuarionom">
			<label for="usuarionom" class="formulario__label">Nombre</label>
			<div class="formulario__grupo-input">
				<input required name="usuarionom" type="text" maxlength="50" id="usuarionom" placeholder="Nombre del usuario" class="formulario__input">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">El nombre solo debe contener letras y puede tener máximo 60 caracteres</p>
		</div>

		<div class="formulario__grupo" id="grupo__usuariodir">
			<label for="usuariodir" class="formulario__label">Dirección</label>
			<div class="formulario__grupo-input">
				<input required name="usuariodir" type="text" minlength="12" maxlength="70" id="usuariodir" placeholder="Dirección del usuario" class="formulario__input">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">La dirección debe contener las palabras completas; signos aceptados "#" y "-", "/", "°"; mínimo 12 y máximo 70 caracteres</p>
		</div>

		<div class="formulario__grupo" id="grupo__usuariotel">
			<label for="usuariotel" class="formulario__label">Teléfono</label>
			<div class="formulario__grupo-input">
				<input required name="usuariotel" type="number" min="3002000000" max="3999999999" id="usuariotel" placeholder="Teléfono del usuario" class="formulario__input">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">Solo números; el teléfono solo puede tener 10 dígitos y sin espacio; si es fijo agregar el 607</p>
		</div>

		<div class="formulario__grupo" id="grupo__usuarioema">
			<label for="usuarioema" class="formulario__label">Email</label>
			<div class="formulario__grupo-input">
				<input required name="usuarioema" type="text" id="usuarioma" placeholder="Email del usuario" class="formulario__input">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">El correo deber tener un @ y una dirección válida</p>
		</div>

		<div class="formulario__grupo" id="grupo__usuariocon">
			<label for="usuariocon" class="formulario__label">Contraseña</label>
			<div class="formulario__grupo-input">
				<input required name="usuariocon" type="password" minlength="8" id="usuariocon" placeholder="Password del usuario" class="formulario__input">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">La contraseña deber mínimo 8 caracteres de cualquier tipo</p>
		</div>

		<div class="formulario__grupo formulario__grupo-btn-enviar">
			<button type="submit" id="btnValidarForm" class="formulario__btn">Guardar</button>
		</div>

	</form>

</main>

<script src="../js/validarFormularioUsuario.js"></script>

<?php include_once "pie.php" ?>