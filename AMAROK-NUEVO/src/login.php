<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar sesión</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../css/style_login.css">
  <link rel="icon" href="../images/amarok.ico">
</head>
<body>
<?php
	if(session_status()===PHP_SESSION_NONE)
    {
        session_start();
    }
	?>
<div class="container">
  <div class="login-container">
    <a href="../" class="back-button" style="font-size: 20px"><i class="fas fa-arrow-left"></i></a>
    <img src="../images/amarok.ico" style="width: 200px; height: 200px;" alt="logo" class="img-fluid mx-auto d-block mb-4">
    <h2>Inicio de sesión</h2>
    <form action="loginProcess.php" method="POST">
      <input type="text" name="use" id="use" placeholder="Usuario o Documento" autocomplete="off" required>
      <input type="password" name="con" id="con" placeholder="Contraseña" required autocomplete="off">
      <button class="btn btn-outline-dark" type="submit" id="iniciar">Iniciar sesión</button>
    </form>
    <div class="text-center">
      <a href="javascript:void(0)" type="button" id="btnOlvido">¿Olvidaste tu contraseña?</a>
    </div>
  </div>
</div>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/validarLogin.js"></script>
</body>
</html>
