<head>
	<link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
	<title>Editar Ciudad</title>	
</head>

<?php
if (!isset($_GET["ciudadid"]))
{
	echo "No existe la ciudad a editar";
	exit();
}



$ciudadid = $_GET["ciudadid"];

include_once "conexion.php";

$sentencia = $base_de_datos->prepare(  "SELECT ci.ciudadId, ci.ciudadNom, ci.idDepart, d.departNom, ci.precioDom FROM ciudad ci 
										JOIN departamento d ON ci.idDepart=d.departId 
										WHERE ciudadId = ?;");
$sentencia->execute([$ciudadid]);
$ciudades = $sentencia->fetchObject();
if (!$ciudades)
{
    echo "¡No existe algúna Ciudad con ese código!";
    exit();
}

include_once 'encabezado.php';
?>
<h1 id="formularioEditar" class="text-center">EDITAR CIUDAD</h1>
<main>
	
	<form id="formulario" action="editarCiudad.php" method="POST" class="formulario">

		<input hidden name="ciudadid" id="ciudadid" value="<?php echo $ciudades->ciudadid; ?>">

		<div class="formulario__grupo" id="grupo__ciudadnom">
			<label for="ciudadnom" class="formulario__label">Nombre</label>
			<div class="formulario__grupo-input">
				<input readonly value="<?php echo $ciudades->ciudadnom; ?>" required name="ciudadnom" type="text" minlength="3" maxlength="20" id="ciudadnom" placeholder="Nombre de la Ciudad" class="formulario__input">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">El nombre de la ciudad no puede contener número, puntos, comas o signos</p> 
		</div>

		<div class="formulario__grupo form-select-ciu" id="grupo__iddepart">
			<label for="iddepart" class="formulario__label">Departamento</label>
			<div class="formulario__grupo-input">
				<select aria-readonly="true" name="iddepart" type="number" class="select-ciudad" id="iddepart">
					<?php
					$sentencia2 = $base_de_datos->prepare( "SELECT departId, departNom FROM departamento
															WHERE departId <> ? ORDER BY departNom;");
					$sentencia2->execute([$ciudades->iddepart]);
					$departamentos = $sentencia2->fetchAll(PDO::FETCH_OBJ);
					?>
					<option class="optselected" value="<?php echo $ciudades->iddepart; ?>"><?php echo $ciudades->departnom; ?></option>
					<?php foreach($departamentos as $depart)
					{?>
						<option value="<?php echo $depart->departid; ?>"><?php echo $depart->departnom; ?></option>
					<?php
					} ?>
				</select>
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">Debe seleccionar un departamento</p>
		</div>

		<div class="formulario__grupo" id="grupo__preciodom">
			<label for="preciodom" class="formulario__label">Domicilio</label>
			<div class="formulario__grupo-input">
				<input value="<?php echo $ciudades->preciodom; ?>" required name="preciodom" type="number" max="99999" id="preciodom" placeholder="Actualizar Precio del Domicilio" class="formulario__input">
				<i class="formulario__validacion-estado bi bi-x-circle-fill"></i>
			</div>
			<p class="formulario__input-error">El precio debe ser máximo de 5 cifras</p>
		</div>
	
		<div class="formulario__grupo formulario__grupo-btn-enviar">
			<button id="btnValidarForm" type="submit" class="formulario__btn">Actualizar</button>
		</div>
	</form>

</main>

<script src="../js/validarFormularioCiudad.js"></script>
