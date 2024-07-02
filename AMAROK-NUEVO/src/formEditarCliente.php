<!-- AQUI ESTÁ EL CAMBIO -->

<head>
	<link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
	<title>Editar Cliente</title>	
</head>

<?php

session_start();
if(!isset($_SESSION['id']) ||
    !isset($_SESSION['username']))
{
    echo "<script>
			alert('↩️ Debe iniciar sesión para entrar a esta página');
			window.location = 'login.php';
		</script>";
}

$usua = $_SESSION['id'];
$role = $_SESSION['username'];

$clientdoc = $_GET["clientdoc"];

if (!isset($_GET["clientdoc"]))
{
	echo "No existe el Cliente a editar";
	exit();
}

switch(true)
{
	case ($role=='Administrador') || ($role=='Vendedor'):
		include_once 'encabezado.php';
	break;

	case ($role=='Cliente'):
		include_once 'encabezado-cliente.php';
		if($usua!=$clientdoc)
		{
			echo "<script>
                alert('↩️ No tiene permisos para editar otro perfil que no sea el suyo');
                window.location = 'encabezado-cliente.php';
            </script>";
		}
	break;
}

include_once 'conexion.php';
$sentencia = $base_de_datos->prepare("SELECT clientdoc, clientnom, idCiudad, c.ciudadnom, d.departnom, clientdir, clienttel, clientema FROM cliente JOIN ciudad c ON idCiudad = c.ciudadId JOIN departamento d ON idDepart = d.departId WHERE clientdoc = ?;");
$sentencia->execute([$clientdoc]);
$clientes = $sentencia->fetchObject();
if (!$clientes)
{
    #No existe
    echo "¡No existe algún Cliente con ese documento!";
    exit();
}

$ciudadCli = $clientes -> idciudad;
?>
<h1 id="formularioEditar" class="text-center">EDITAR CLIENTE</h1>
<main>
	<form action="editarCliente.php" method="POST" class="formulario" id="formulario">
		<!-- Grupo: Documento -->
		<div class="formulario__grupo" id="grupo__clientdoc">
			<label for="clientdoc" class="formulario__label">Documento</label>
			<div class="formulario__grupo-input">
				<input value="<?php echo $clientes->clientdoc; ?>" readonly required type="number" min="10000000" max="9999999999" class="formulario__input" name="clientdoc" id="clientdoc" placeholder="Ej. 1005325768">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">El documento debe tener 8 o 10 dígitos sin (.) ni (,)</p>
		</div>

		<!-- Grupo: Ciudad -->
		<div class="formulario__grupo" id="grupo__idciudad">
			<label for="idciudad" class="formulario__label">Ciudad</label>
			<div class="formulario__grupo-input">
				<select name="idciudad" type="text" class="select-ciudad" id="idciudad">
					<?php
						$sentencia2 = $base_de_datos->prepare('SELECT c.ciudadid, c.ciudadnom, d.departnom FROM ciudad c JOIN departamento d ON c.iddepart = d.departid WHERE ciudadid <> ? ORDER BY d.departNom;');
						$sentencia2->execute([$ciudadCli]);
						$ciudades = $sentencia2->fetchAll(PDO::FETCH_OBJ);
                    ?>
                        <option class="optselected" value="<?php echo $clientes ->idciudad ?>"><?php echo $clientes ->departnom ?> , <?php echo $clientes ->ciudadnom ?></option>
                    <?php foreach($ciudades as $ciud)
                        { ?>
                        <option value="<?php echo $ciud ->ciudadid ?>"><?php echo $ciud->departnom ?> , <?php echo $ciud->ciudadnom ?></option>
                    <?php
                        } ?>
				</select>
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">No ha seleccionado la Ciudad</p>
		</div>

		<!-- Grupo: Nombre -->
		<div class="formulario__grupo" id="grupo__clientnom">
			<label for="clientnom" class="formulario__label">Nombre</label>
			<div class="formulario__grupo-input">
				<input value="<?php echo $clientes->clientnom; ?>" required type="text" class="formulario__input" name="clientnom" id="clientnom" maxlength="60" placeholder="Ej. Nombre Apellido">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">El nombre solo debe contener letras y puede tener máximo 60 caracteres</p>
		</div>

		<!-- Grupo: Dirección -->
		<div class="formulario__grupo" id="grupo__clientdir">
			<label for="clientdir" class="formulario__label">Dirección</label>
			<div class="formulario__grupo-input">
				<input value="<?php echo $clientes->clientdir; ?>" required type="text" class="formulario__input" name="clientdir" id="clientdir" minlength="12" maxlength="70" placeholder="Ej. cra 1 #23-45">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">La dirección debe contener las palabras completas; signos aceptados "#" y "-", "/", "°"; mínimo 12 y máximo 70 caracteres</p>
		</div>

		<!-- Grupo: Teléfono -->
		<div class="formulario__grupo" id="grupo__clienttel">
			<label for="clienttel" class="formulario__label">Teléfono</label>
			<div class="formulario__grupo-input">
				<input value="<?php echo $clientes->clienttel; ?>" required type="number" min="3002000000" max="3519999999" placeholder="Ej. 3214567890" class="formulario__input" name="clienttel" id="clienttel">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">Solo números; el teléfono solo puede tener 10 dígitos y sin espacio; si es fijo agregar el 607</p>
		</div>

		<!-- Grupo: Email -->
		<div class="formulario__grupo" id="grupo__clientema">
			<label for="clientema" class="formulario__label">Email</label>
			<div class="formulario__grupo-input">
				<input value="<?php echo $clientes->clientema; ?>" required type="text" min="3002000000" max="3519999999" placeholder="Ej. C.o_rr-3@ejemplo.com" class="formulario__input" name="clientema" id="clientema">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">El correo deber tener un @ y una dirección válida</p>
		</div>
		<div class="formulario__grupo formulario__grupo-btn-enviar">
			<button type="submit" id="btnEnviarCliente" class="formulario__btn">Actualizar</button>
		</div>
	</form>
</main>

<script src="../js/formularioCliente.js"></script>