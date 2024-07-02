<head>
	<link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
	<title>Editar Proveedor</title>
</head>

<?php
session_start();
if (!isset($_GET["proveenit"]))
{
	echo "No existe el Proveedor a editar";
	exit();
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
			localStorage.clear();
			alert('↩️ No tiene permisos para realizar esta operación');
			window.history.go(-1);
		</script>";
	break;
}

$proveenit = $_GET["proveenit"];

include_once "conexion.php";

$sentencia = $base_de_datos->prepare(  "SELECT proveeNit, proveeNom, idCiudad, c.ciudadNom, d.departNom, proveeDir, proveeTel, proveeEma FROM proveedor 
										JOIN ciudad c ON idCiudad = c.ciudadId 
										JOIN departamento d ON idDepart = d.departId 
										WHERE proveeNit = ?;");
$sentencia->execute([$proveenit]);
$proveedores = $sentencia->fetchObject();
if (!$proveedores)
{
    echo "¡No existe algún Cliente con ese documento!";
    exit();
}
$ciudadPro = $proveedores -> idciudad;
?>


<br>

<h1 id="formularioEditar" class="text-center">EDITAR PROVEEDOR</h1>
<main>
	<form id="formulario" action="editarProveedor.php" method="POST" class="formulario">

		<input type="hidden" name="proveenit" value="<?php echo $proveedores->proveenit; ?>">

		<div class="formulario__grupo" id="grupo__proveenom">
			<label for="proveenom" class="formulario__label">Nombre</label>
			<div class="formulario__grupo-input">
				<input value="<?php echo $proveedores->proveenom; ?>" required name="proveenom" type="text" minlength="6" maxlength="40" id="proveenom" placeholder="Nombre del Proveedor" class="formulario__input">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">El nombre solo debe contener letras y debe tener mínimo 6 caracteres</p>
		</div>

		<div class="formulario__grupo form-select-ciu" id="grupo__idciudad">
			<label for="idciudad" class="formulario__label">Ciudad</label>
			<div class="formulario__grupo-input">
				<select name="idciudad" type="text" class="select-ciudad" id="idciudad">
					<?php
					$sentencia2 = $base_de_datos->prepare( "SELECT c.ciudadid, c.ciudadnom, d.departnom FROM ciudad c 
															JOIN departamento d ON c.iddepart = d.departid 
															WHERE ciudadid <> ? ORDER BY d.departNom ;");
					$sentencia2->execute([$ciudadPro]);
					$ciudades = $sentencia2->fetchAll(PDO::FETCH_OBJ);
					?>
					<option class="optselected" value="<?php echo $proveedores ->idciudad ?>"><?php echo $proveedores ->departnom ?>, <?php echo $proveedores ->ciudadnom ?></option>
					<?php foreach($ciudades as $ciud)
					{
						?>
						
						<option value="<?php echo $ciud ->ciudadid ?>"><?php echo $ciud->departnom ?> , <?php echo $ciud->ciudadnom ?></option>
					<?php
					} ?>
				</select>
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">Seleccione una Ciudad</p> 
		</div>

		<div class="formulario__grupo" id="grupo__proveedir">
			<label for="proveedir" class="formulario__label">Dirección</label>
			<div class="formulario__grupo-input">
				<input value="<?php echo $proveedores->proveedir; ?>" required name="proveedir" type="text" minlength="15" id="proveedir" placeholder="Dirección del Proveedor" class="formulario__input">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">La dirección debe tener mínimo 12 caracteres</p> 
		</div>

		<div class="formulario__grupo" id="grupo__proveetel">
			<label for="proveetel" class="formulario__label">Teléfono</label>
			<div class="formulario__grupo-input">
				<input value="<?php echo $proveedores->proveetel; ?>" required name="proveetel" type="number" min="3000000000" max="3999999999" id="proveetel" placeholder="Teléfono del Proveedor" class="formulario__input">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">El teléfono solo puede tener 10 dígitos y sin espacio</p>
		</div>

		<div class="formulario__grupo" id="grupo__proveeema">
			<label for="proveeema" class="formulario__label">Email</label>
			<div class="formulario__grupo-input">
				<input value="<?php echo $proveedores->proveeema; ?>" required name="proveeema" type="text" id="proveeema" placeholder="Email del Proveedor" class="formulario__input">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">El correo deber tener un @ y una dirección válida</p>
		</div>
		
		<div class="formulario__grupo formulario__grupo-btn-enviar">
			<button id="btnValidarForm" type="submit" class="formulario__btn">Actualizar</button>
		</div>

	</form>
</main>


<script src="../js/validarFormularioProveedor.js"></script>
<?php include_once "pie.php"?>