<!doctype html>
<html lang="es">
    
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema de Ejemplo de Conexión y SP">
    <meta name="author" content="ADSO 2024">
    <title>Inicio - Administrador</title>
    <!-- Cargar el CSS de Boostrap-->
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Cargar estilos propios -->
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/styles-tabla.css" rel="stylesheet">
    <link href="../css/style_menu.css" rel="stylesheet">
	
    <link rel="icon" href="../images/amarok.ico">
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
                    window.location = 'login.php';
                </script>";
            exit();
        }
        if($_SESSION['username']=='Cliente'){
            echo "<script>
                    localStorage.clear();
                    window.history.go(-1);
                </script>";
            exit();
        }
        include 'conexion.php';

        $sentencia = $base_de_datos->query("select tiemposalir from parametros");
        $paramet = $sentencia->fetchObject();
        $tiemposalida = $paramet -> tiemposalir;
    ?>
    <script type='text/javascript'>
        document.oncontextmenu = function(){return false}
    </script>
    <input readonly type="hidden" id="parametro" value="<?php echo $tiemposalida; ?>">
    <input readonly type="hidden" id="id-usuario" value="<?php echo $_SESSION['id']; ?>">
    <input readonly type="hidden" id="rol-usuario" value="<?php echo $_SESSION['username']; ?>">
<div class="div-menu">
    <ul>
        <a  class="enlace">
			<img src="../images/amarok.ico" alt="Logo de la casa de la amarok" class="enc-ico logo">
		</a>
        <li class="cs"><a href="desactivarSesion.php">Cerrar Sesión <i class="bi bi-box-arrow-right"></i></a></li>
        <li class="cs"><a id="grupo__manualAdmin" href="manualAdmin.php">Manual <i class="bi bi-question-octagon"></i></a></li>
        <li id="menu-gesti" class="dropdown">
            <a href="javascript:void(0)" class="dropbtn ges">Gestiones <i class="bi bi-arrow-down-square"></i></a>
            <div class="dropdown-content ges">
                <a id="grupo__listarClientes" href="listarClientes.php">Clientes</a>
                <a id="grupo__listarProductos" href="listarProductos.php">Productos</a>
                <a id="grupo__listarCiudades" href="listarCiudades.php">Ciudades</a>
                <a id="grupo__listarEmpresas" href="listarEmpresas.php">Empresas<br>Transporte</a>
                <a id="grupo__listarProveedores" id="op-prov" href="listarProveedores.php">Proveedores</a>
                <a id="grupo__listarParametros" id="op-para" href="listarParametros.php">Parámetros</a>
            </div>
        </li>
        <li id="menu-usua" class="dropdown">
            <a href="javascript:void(0)" class="dropbtn usu">Usuarios <i class="bi bi-arrow-down-square"></i></a>
            <div class="dropdown-content usu">
                <a id="grupo__listarUsuarios" href="listarUsuarios.php">Listar</a>
                <a id="grupo__formAgregarUsuario" href="formAgregarUsuario.php">Agregar</a>
            </div>
        </li>
        <li id="menu-vent" class="dropdown">
            <a href="javascript:void(0)" class="dropbtn ven">Ventas <i class="bi bi-arrow-down-square"></i></a>
            <div class="dropdown-content ven">
                <a id="grupo__listarVentas" href="listarVentas.php">Listar</a>
                <a id="grupo__agregarVenta" href="agregarVenta.php">Agregar</a>
            </div>
        </li>
        <li id="menu-pe"><a id="grupo__listarPedidos" href="listarPedidos.php">Pedidos Proveedores <i class="bi bi-box-seam"></i></a></li>
        <li><a id="grupo__listarEnviosLocales" href="listarEnviosLocales.php">Envíos Locales <i class="bi bi-truck"></i></a></li>
        <li><a id="grupo__listarEnviosNacionales" href="listarEnviosNacionales.php">Envíos Nacionales <i class="bi bi-truck-flatbed"></i></a></li>
        <li id="menu-cont"><a id="grupo__listarContactenos" href="listarContactenos.php">Contáctenos <i class="bi bi-telephone-inbound"></i></a></li>
    </ul>
</div>
<a id="flechita-back" class="arrow-back" href="javascript:void(0)">
    <i class="bi bi-arrow-left-circle"></i>
</a>
<script src="../js/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/validarRefrescar.js"></script>
<script src="../js/validarEncabezado.js"></script>
    <main role="main" class="container-fluid"><br>