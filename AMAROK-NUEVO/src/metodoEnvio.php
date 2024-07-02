<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Método de Entrega</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="icon" href="../images/amarok.ico|">
  <style>
    body{
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: url(../images/contactanos.png);
        image-rendering: optimizeQuality;
        background-size: cover;
        background-repeat: no-repeat;
    }
    /* Estilos personalizados */
    .form-container {
      max-width: 500px;
      margin-top: 0px;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      background-color: whitesmoke;
      opacity: 0.9;
    }
    .icon-container {
      text-align: center;
      margin-bottom: 20px;
    }
    .icon-container img {
      width: 100px;
      height: 100px;
    }
  </style>
</head>
<body>
  <?php
      if(session_status()===PHP_SESSION_NONE)
      {
          session_start();
      }

      if(!isset($_SESSION['id']) ||
          !isset($_SESSION['username']))
      {
          echo "<script>
                  localStorage.clear();
                  window.location = 'loginCliente.php';
              </script>";
      }
      if($_SESSION['username']!=='Cliente'){
          echo "<script>
                  localStorage.clear();
                  window.history.go(-1);
              </script>";
      }
  ?>
  <script type='text/javascript'>
        document.oncontextmenu = function(){return false}
  </script>
  <input readonly type="hidden" id="id-usuario" value="<?php echo $_SESSION['id']; ?>">
  <input readonly type="hidden" id="rol-usuario" value="<?php echo $_SESSION['username']; ?>">
  <div class="container">
    <div class="form-container">
        <div class="d-flex align-items-center justify-content-center pb-4">
            <div class="icon-container">
                <button onclick="volver()" type="button" class="btn btn-outline-dark">Volver</button>
                <img src="../images/amarok.ico" alt="Logo de tu empresa" style="height: 100px; width: 110px;">
            </div>
        </div>
        <div class="text-center mb-4">
          <h2>Métodos de Pago</h2>
          <div class="row justify-content-center">
            <!-- <div class="col-md-4">
              <img src="https://cdn-icons-png.freepik.com/512/1727/1727720.png" alt="Ícono de datáfono" style="height: 80px; width: 80px;">
              <p>Número de cuenta para enviar el dinero: <strong>[Número de cuenta]</strong></p>
            </div> -->
            <div class="col-md-4">
              <img src="https://cdn-icons-png.flaticon.com/512/1770/1770992.png" alt="Ícono de transferencia de banco" style="height: 80px; width: 80px;">
            </div>
          </div>
          <p>Número de cuenta para transferir: <strong>[12487380129]</strong></p>
        </div>
      <h2 class="text-center mb-4">Método de Entrega</h2>
      <form>
        <div class="form-group">
          <label for="metodoRetiro">Seleccionar Método de Entrega</label>
          <select class="form-control" id="metodoRetiro" onchange="toggleDireccion()">
            <option value="tienda" selected>Recoger en Tienda</option>
            <option value="domicilio">Envío a Domicilio</option>
          </select>
        </div>
        <div class="form-group" id="municipioEnvioGroup" style="display: none;">
          <label for="idCiudad">Seleccionar Municipio de Envío</label>
          <select class="form-control" id="idCiudad">
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
        </div>
        <div class="form-group" id="documentoGroup" style="display: none;">
          <label for="nombre">Documento de Persona que Recibe</label>
          <input type="text" class="form-control" id="documento" placeholder="Ingrese documento" minlength="8" maxlength="10">
        </div>
        <div class="form-group" id="nombreGroup" style="display: none;">
          <label for="nombre">Nombre de Persona que Recibe</label>
          <input type="text" class="form-control" id="nombre" placeholder="Ingrese nombre">
        </div>
        <div class="form-group" id="telefonoGroup" style="display: none;">
          <label for="telefono">Número de Teléfono</label>
          <input type="tel" class="form-control" id="telefono" placeholder="Ingrese teléfono" minlength="10" maxlength="10">
        </div>
        <div class="form-group" id="direccionEnvioGroup" style="display: none;">
          <label for="direccion">Dirección de Envío</label>
          <input type="text" class="form-control" id="direccion" placeholder="Ingrese dirección">
        </div>
        <button id="btnFinalizar" class="btn btn-outline-primary btn-block">Solicitar Compra</button>
      </form>
    </div>
  </div>

  <!-- Bootstrap JS (jQuery is required) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
    function toggleDireccion() {
      var metodoRetiro = document.getElementById("metodoRetiro").value;
      if (metodoRetiro === "domicilio") {
        document.getElementById("documentoGroup").style.display = "block";
        document.getElementById("nombreGroup").style.display = "block";
        document.getElementById("telefonoGroup").style.display = "block";
        document.getElementById("direccionEnvioGroup").style.display = "block";
        document.getElementById("municipioEnvioGroup").style.display = "block";
      } else {
        document.getElementById("documentoGroup").style.display = "none";
        document.getElementById("nombreGroup").style.display = "none";
        document.getElementById("telefonoGroup").style.display = "none";
        document.getElementById("direccionEnvioGroup").style.display = "none";
        document.getElementById("municipioEnvioGroup").style.display = "none";
      }
    }
    function volver(){
        window.history.go(-1);
    }
  </script>
  <script src="../js/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../js/metodoEnvio.js"></script>
</body>
</html>
