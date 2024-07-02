<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PERFIL CLIENTE</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
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
        include_once 'conexion.php';

        $sentencia = $base_de_datos->query("select tiemposalir from parametros");
        $paramet = $sentencia->fetchObject();
        $tiemposalida = $paramet -> tiemposalir;

        include_once 'conexion.php';

        $sentencia = $base_de_datos->prepare("SELECT clientdoc, clientnom, idCiudad, c.ciudadnom, d.departnom, clientdir, clientpun, clienttel, clientema FROM cliente JOIN ciudad c ON idCiudad = c.ciudadId JOIN departamento d ON idDepart = d.departId WHERE clientdoc = ?;");
        $sentencia->execute([$_SESSION['id']]);
        $clientes = $sentencia->fetchObject();
        $ciudadCli = $clientes -> idciudad;

        if (!$clientes)
        {
            #No existe
            echo "¡No existe algún Cliente con ese documento!";
            exit();
        }
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
                        <a class="boton-menu boton-categoria" href="homeCliente.php">
                            <i class="bi bi-tools"></i> Repuestos
                        </a>
                    </li>
                    <li>
                        <a class="boton-menu" href="compras-cliente.php">
                            <i class="bi bi-bag-check-fill"></i> Mis Compras
                        </a>
                    </li>
                    <li>
                        <a class="boton-menu active" href="javascript:void(0)">
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
            <h2 class="titulo-principal tlo" id="titulo-principal">PERFIL CLIENTE</h2>
            <form action="editarCliente.php" method="POST">
                <input hidden value="<?php echo $clientes->clientdoc; ?>" readonly required type="number" class="formulario__input" name="clientdoc" id="clientdoc">
                <!-- AQUI COMIENZA -->
                <!-- Grupo: Ciudad -->
                <div class="formulario__grupo" id="grupo__idciudad">
                    <label for="idciudad" class="formulario__label">Ciudad</label>
                    <div class="formulario__grupo-input">
                        <select disabled name="idciudad" type="text" class="select-ciudad cl" id="idciudad">
                            <?php
                                $sentencia2 = $base_de_datos->prepare('SELECT c.ciudadid, c.ciudadnom, d.departnom FROM ciudad c JOIN departamento d ON c.iddepart = d.departid WHERE ciudadid <> ? ORDER BY d.departNom;');
                                $sentencia2->execute([$ciudadCli]);
                                $ciudades = $sentencia2->fetchAll(PDO::FETCH_OBJ);
                            ?>
                            <option class="optselected" value="<?php echo $clientes ->idciudad ?>"><?php echo ' &nbsp&nbsp'. $clientes ->departnom ?> , <?php echo $clientes ->ciudadnom ?></option>
                            <?php foreach($ciudades as $ciud)
                                { ?>
                            <option value="<?php echo $ciud ->ciudadid ?>"><?php echo ' &nbsp&nbsp'. $ciud->departnom ?> , <?php echo $ciud->ciudadnom ?></option>
                            <?php
                                } ?>
                        </select>
                    </div>
                    <p class="formulario__input-error inperfil">No ha seleccionado la Ciudad</p>
                </div>

                <!-- Grupo: Nombre -->
                <div class="formulario__grupo" id="grupo__clientnom">
                    <label for="clientnom" class="formulario__label">Nombre</label>
                    <div class="formulario__grupo-input">
                        <input value="<?php echo $clientes->clientnom; ?>" readonly required type="text" class="formulario__input" name="clientnom" id="clientnom">
                        <i class="formulario__validacion-estado ico bi bi-x-circle-fill"></i>
                    </div>
                    <p class="formulario__input-error inperfil">El nombre solo debe contener letras y puede tener máximo 60 caracteres</p>
                </div>

                <!-- Grupo: Dirección -->
                <div class="formulario__grupo" id="grupo__clientdir">
                    <label for="clientdir" class="formulario__label">Dirección</label>
                    <div class="formulario__grupo-input">
                        <input value="<?php echo $clientes->clientdir; ?>" readonly required type="text" class="formulario__input" name="clientdir" id="clientdir">
                        <i class="formulario__validacion-estado ico bi bi-x-circle-fill"></i>
                    </div>
                    <p class="formulario__input-error inperfil">La dirección debe contener las palabras completas; signos aceptados "#" y "-", "/", "°"; mínimo 12 y máximo 70 caracteres</p>
                </div>

                <div class="ambosinputs">
                    <!-- Grupo: Puntos -->
                    <div class="formulario__grupo" id="grupo__clientpun">
                        <label for="clientpun" class="formulario__label tlopun">Puntos</label>
                        <div class="formulario__grupo-input">
                            <input value="<?php echo $clientes->clientpun; ?>" readonly required type="number" class="formulario__input pun" name="clientpun" id="clientpun">
                        </div>
                    </div>
                    <!-- Grupo: Teléfono -->
                    <div class="formulario__grupo" id="grupo__clienttel">
                        <label for="clienttel" class="formulario__label tlotel">Teléfono</label>
                        <div class="formulario__grupo-input">
                            <input value="<?php echo $clientes->clienttel; ?>" readonly required type="number" class="formulario__input tel" name="clienttel" id="clienttel">
                            <i class="formulario__validacion-estado ico ico-tel bi bi-x-circle-fill"></i>
                        </div>
                        <p class="formulario__input-error inpperfil-tel">Solo números; el teléfono solo puede tener 10 dígitos y sin espacio; si es fijo agregar el 607</p>
                    </div>
                </div>

                <!-- Grupo: Email -->
                <div class="formulario__grupo" id="grupo__clientema">
                    <label for="clientema" class="formulario__label">Email</label>
                    <div class="formulario__grupo-input">
                        <input value="<?php echo $clientes->clientema; ?>" readonly required type="text" class="formulario__input" name="clientema" id="clientema">
                        <i class="formulario__validacion-estado ico bi bi-x-circle-fill"></i>
                    </div>
                    <p class="formulario__input-error inperfil">El correo deber tener un @ y una dirección válida</p>
                </div>
                <!--AQUI TERMINA -->
                <button disabled hidden id="btn-actualizar" class="btn btn-success" type="submit">Guardar</button>
            </form>
            <button id="btn-perfil" class="btn btn-dark">Editar</button>
        </main>
    </div>
    <script src="../js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/validarRefrescarCliente.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="../js/menu.js"></script>
    <script src="../js/formularioPerfil.js"></script>
</body>
</html>