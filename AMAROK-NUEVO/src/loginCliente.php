<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login Cliente</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/style_login_cliente.css">
    <link rel="icon" href="../images/amarok.ico">
    
</head>
<body>
    <?php
        if(session_status()===PHP_SESSION_NONE)
        {
            session_start();
        }
	?>
    <section class="h-75 gradient-form" style="background-color: #ddd;">
        <div class="container py-5 h-75">
            <div class="row d-flex justify-content-center align-items-center h-75">
                <div class="col-xl-10">
                    <div class="card rounded-3" style="background-color: whitesmoke;">
                        <div class="row g-0">
                            <div class="col-lg-6">
                                <div class="card-body p-md-5 mx-md-4">
                                    <a href="../" class="back-button" style="font-size: 20px"><i class="fas fa-arrow-left"></i></a>
                                    <div class="text-center">
                                        <img src="../images/amarok.ico"
                                            style="width: 200px; height: 200px;" alt="logo">
                                    </div>
                                    <form action="loginProcess.php" method="POST">
                                        <div class="form-outline mb-4 text-secondary text-center">
                                            <label class="form-label" for="use">Usuario</label>
                                            <input type="text" name="use" id="use" class="form-control" autocomplete="off" required
                                            placeholder="Usuario o Documento" autofocus/>
                                        </div>

                                        <div class="form-outline mb-4 text-secondary text-center">
                                            <label class="form-label" for="con">Contraseña</label>
                                            <input type="password" class="form-control" name="con" id="con" placeholder="Contraseña" required autocomplete="off"/>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-center pb-4">
                                            <button class="btn btn-outline-dark" style="width: 100%" type="submit" id="iniciar">Ingresar</button>
                                        </div>

                                        <div class="d-flex align-items-center justify-content-center pb-4">
                                            <p class="mb-0 me-2 text-secondary">No tienes una cuenta?</p>
                                            <a href="formRegistrarse.php" type="button" class="btn btn-link" style="color: darkblue !important;">Regístrate aquí</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-6 d-flex align-items-end gradient-custom-2">
                                <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                    <h4 class="mb-4 text-light">
                                        Con nosotros vas a la segura. Encuentra repuestos 100% garantizados en cuánto a calidad-precio.
                                        Contáctanos y cotiza con expertos los repuestos que más te convengan para tu vehículo. Aprovecha!
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="../js/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/validarLogin.js"></script>
</body>
</html>