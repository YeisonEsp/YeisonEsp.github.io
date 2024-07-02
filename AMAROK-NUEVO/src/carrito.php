<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito-Cliente</title>
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
                <ul>
                    <li>
                        <a class="boton-menu boton-volver" href="homeCliente.php">
                            <i class="bi bi-arrow-return-left"></i> Seguir comprando
                        </a>
                    </li>
                    <li>
                        <a class="boton-menu boton-carrito active" href="javascript:void(0)">
                            <i class="bi bi-cart-fill"></i> Carrito
                        </a>
                    </li>
                </ul>
            </nav>
            <footer>
                <p class="texto-footer">© Todos los derechos reservados, 2024 Yeison Espinosa-Miguel Rodriguez SENA CSET ADSO Ficha 2619701</p>
            </footer>
        </aside>
        <main>
            <h2 id="carritophp" class="titulo-principal">CARRITO</h2>
            <div class="contenedor-carrito">
                <p id="carrito-vacio" class="carrito-vacio">Tu carrito está vacío. <i class="bi bi-emoji-frown"></i></p>

                <div id="carrito-productos" class="carrito-productos disabled">
                    <!-- Esto se va a completar con el JS -->
                </div>

                <div id="carrito-acciones" class="carrito-acciones disabled">
                    <div class="carrito-acciones-izquierda">
                        <button id="carrito-acciones-vaciar" class="carrito-acciones-vaciar">Vaciar carrito</button>
                    </div>
                    <div class="carrito-acciones-derecha">
                        <div class="carrito-acciones-total">
                            <p>Total:</p>
                            <p id="total">$3000</p>
                        </div>
                        <button id="carrito-acciones-comprar" class="carrito-acciones-comprar">Método de Entrega ✔️</button>
                    </div>
                </div>
                <p id="carrito-comprado" class="carrito-comprado disabled">Muchas gracias por tu compra. <i class="bi bi-emoji-laughing"></i></p>
            </div>
        </main>
    </div>
    <script src="../js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/menu.js"></script>
    <script src="../js/validarRefrescarCliente.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="../js/carrito.js"></script>
</body>
</html>