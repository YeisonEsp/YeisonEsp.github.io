<head>
	<link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
	<title>Agregar Proveedor</title>	
</head>

<?php
	session_start();
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
?>

<h1 id="titulo" class="text-center">AGREGAR PROVEEDOR</h1>
<main>
	<form id="formulario" class="formulario" action="insertarProveedor.php" method="POST">

		<div class="formulario__grupo" id="grupo__proveenit">
			<label for="proveenit" class="formulario__label">NIT</label>
			<div class="formulario__grupo-input">
				<input required name="proveenit" type="number" min="1000000000" max="9999999999" id="proveenit" placeholder="Ejm: 8901234562" class="formulario__input" autofocus>
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">El Nit debe llevar 10 dígitos, incluyendo el dígito de verificación sin guión</p>
		</div>
		
		<div class="formulario__grupo form-select-ciu" id="grupo__idciudad">
			<label for="idciudad" class="formulario__label">Ciudad</label>
			<div class="formulario__grupo-input">
				<select name="idciudad" type="text" class="select-ciudad" id="idciudad">
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
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">Seleccione una Ciudad</p> 
		</div>

		<div class="formulario__grupo" id="grupo__proveenom">
			<label for="proveenom" class="formulario__label">Nombre</label>
			<div class="formulario__grupo-input">
				<input required name="proveenom" type="text" minlength="6" maxlength="40" id="proveenom" placeholder="Nombre del Proveedor" class="formulario__input">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">El nombre solo debe contener letras y debe tener mínimo 6 caracteres</p>
		</div>

		<div class="formulario__grupo" id="grupo__proveedir">
			<label for="proveedir" class="formulario__label">Dirección</label>
			<div class="formulario__grupo-input">
				<input required name="proveedir" type="text" minlength="15" id="proveedir" placeholder="Dirección del Proveedor" class="formulario__input">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">La dirección debe tener mínimo 12 caracteres</p> 
		</div>

		<div class="formulario__grupo" id="grupo__proveetel">
			<label for="proveetel" class="formulario__label">Teléfono</label>
			<div class="formulario__grupo-input">
				<input required name="proveetel" type="number" min="3002222222" max="6089999999" id="proveetel" placeholder="Teléfono del Proveedor" class="formulario__input">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">El teléfono solo puede tener 10 dígitos y sin espacio</p>  
		</div>

		<div class="formulario__grupo" id="grupo__proveeema">
			<label for="proveeema" class="formulario__label">Email</label>
			<div class="formulario__grupo-input">
				<input required name="proveeema" type="text" id="proveeema" placeholder="Email del Proveedor" class="formulario__input">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">El correo deber tener un @ y una dirección válida</p> 
		</div>
		
		<div class="formulario__grupo formulario__grupo-btn-enviar">
			<button id="btnValidarForm" type="submit" class="formulario__btn">Registrar</button>
		</div>

	</form>
</main>

<script src="../js/validarFormularioProveedor.js"></script>
<?php include_once "pie.php" ?>