<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio-Cliente</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="../css/main.css">
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
                    alert('↩️ Debe logearse como cliente para entrar a esta página');
                    window.location = 'loginCliente.php';
                </script>";
        }
        if($_SESSION['username']!='Cliente'){
            echo "<script>
                    alert('↩️ No tiene permisos para entrar a esta página');
                    window.location = 'loginCliente.php';
                </script>";
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
    <div class="wrapper">
        <header class="header-mobile">
            <div class="logo">
                <img src="../images/amarok.ico" alt="logo">
            </div>
            <button class="open-menu" id="open-menu">
                <i class="bi bi-list"></i>
            </button>
        </header>
        <aside>
            <button class="close-menu" id="close-menu">
                <i class="bi bi-x"></i>
            </button>
            <header>
                <div class="logo">
                    <img src="../images/amarok.ico" alt="logo">
                </div>
            </header>
            <nav>
                <ul class="menu">
                    <li>
                        <a class="boton-menu boton-categoria active" href="javascript:void(0)">
                            <i class="bi bi-tools"></i> Repuestos
                        </a>
                    </li>
                    <li>
                        <a class="boton-menu" href="compras-cliente.php">
                            <i class="bi bi-bag-check-fill"></i> Mis Compras
                        </a>
                    </li>
                    <li>
                        <a class="boton-menu" href="cliente-perfil.php">
                            <i class="bi bi-person-circle"></i> Perfil
                        </a>
                    </li>
                    <li>
                        <a class="boton-menu boton-carrito" href="carrito.php">
                            <i class="bi bi-cart-fill"></i> Carrito <span id="numerito" class="numerito">0</span>
                        </a>
                    </li>
                    <li>
                        <a class="boton-menu boton-carrito" href="desactivarSesion.php">
                            <i class="bi bi-box-arrow-left"></i> Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </nav>
            <footer>
                <p class="texto-footer">© Todos los derechos reservados, 2024 Yeison Espinosa-Miguel Rodriguez SENA CSET ADSO Ficha 2619701</p>
            </footer>
        </aside>
        <main>
            <h2 class="titulo-principal" id="titulo-principal">REPUESTOS</h2>
            <div id="contenedor-filtros" class="contenedor-filtros">
                <label for="filtro-categoria">Filtrar por categoría:</label>
                <select id="filtro-categoria">
                <?php
                include_once "conexion.php";
                $sentencia2 = $base_de_datos->query('SELECT tipoProId, tipoProNom FROM tipoproducto ORDER BY tipoProNom;');
                $categorias = $sentencia2->fetchAll(PDO::FETCH_OBJ);
                ?>
                <option selected value="todos">Todos</option>
                <?php foreach($categorias as $cate)
                {
                    ?>
                    <option value="<?php echo $cate ->tipoproid ?>"><?php echo $cate->tipopronom ?></option>
                <?php
                } ?>
                <!-- Agrega más opciones según tus categorías -->
                </select>
            </div>
            <div id="contenedor-productos" class="contenedor-productos">
                <!-- Esto se va a rellenar con JS -->
            </div>
        </main>
    </div>
    <template class="pie-tabla" id="template-productos">
        <div class="producto">
            <img class="producto-imagen" alt="repuesto" style="width: 100%; height: 70%;">
            <div class="producto-detalles">
                <h3 class="producto-titulo">repuesto</h3>
                <p class="producto-precio">$100</p>
                <p class="producto-precio">Stock: <span class="producto-stock"></span></p>
                <button class="producto-agregar">Agregar</button>
            </div>
        </div>
    </template>
    <script src="../js/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="../js/menu.js"></script>
    <script src="../js/cargarProductos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/validarRefrescarCliente.js"></script>
</body>
</html>