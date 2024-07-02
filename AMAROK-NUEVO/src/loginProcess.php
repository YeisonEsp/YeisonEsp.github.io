<?php
    if (!isset($_POST["use"])  ||
        !isset($_POST["con"]))
    {
        echo "❕ Debe llenar todos los campos";
        exit();
    }

    if(session_status()===PHP_SESSION_NONE)
    {
        session_start();
    }
    $user = $_POST['use'];
    $passw = $_POST['con'];
    $passw = substr($passw, 100, 32);
    $pagina_anterior=basename($_SERVER['HTTP_REFERER']);
    switch($pagina_anterior)
    {
        case 'login.php':
            if($user=='admin'){
                include_once 'conexion.php';
                $rol = 'Administrador';
                $sentencia = $base_de_datos->prepare("select sesionActiva from parametros where admincon=?");
                $sentencia->execute([$passw]);
                $rows = $sentencia -> fetchObject();
                if(!$rows){
                    echo "❕ Usuario y/o Contraseña incorrectos";
                    exit();
                }else{
                    if($rows->sesionactiva===false){
                        include_once 'conexion.php';
                        try{
                            $sentencia = $base_de_datos->query("SELECT fun_active_sesion_admin();");    #Preparo la consulta
                            $msg = $sentencia->fetchColumn();   #Obtengo el mensaje que viene de la función
                            if($msg==='00000')                  #Si salió bien, hace esta parte del código
                            {
                                echo "✔️ Todo bien admin";
                                $_SESSION['id'] = $user;
                                $_SESSION['username'] = $rol;
                                exit();
                            }else
                            {                                   #En caso de error, mostrará cual fue el error en la función
                                echo "❌ Error: $msg";
                                exit();
                            }
                        }catch(PDOException $e){
                                                                #En caso de excepción, mostrará cual fue la excepción en la función
                            $excepcod = $e->getCode();
                            $sentencia = $base_de_datos->prepare("SELECT excepNom from excepciones WHERE excepCod = ?;");
                            $sentencia->execute([$excepcod]);
                            $excepciones = $sentencia->fetchObject();   #Consulto la bd en la tabla de excepciones, y traigo el código que
                            $excep_nombre = $excepciones->excepnom;     #corresponda con el obtenido de la función
                            if (!$excepciones)
                            {
                                #No existe
                                echo "❗ No existe ninguna excepción con ese código";    #Si no existe, queda en blanco la página
                                exit();
                            }
                                                                                        #Si coincide el código, lo mostrará en una alerta
                            echo "⚠️ Excepción: $excep_nombre";
                            exit();
                        }
                    }else{
                        $_SESSION['id'] = $user;
                        $_SESSION['username'] = $rol;
                        echo "SESIÓN YA ACTIVA ⚠️";
                        include_once 'desactivarSesion.php';
                        exit();
                    }
                }
            }
            else
            {
                include_once 'conexion.php';
                $rol = 'Vendedor';
                $sentencia = $base_de_datos->prepare("select u.usuarioAct, u.sesionActiva, p.empreTel from usuario u, parametros p WHERE u.usuarioDoc=? AND u.usuarioRol=? AND u.usuarioCon=?");
                $sentencia->execute([$user, $rol, $passw]);
                $rows = $sentencia -> fetchObject();
                if(!$rows){
                    echo "❕ Usuario y/o Contraseña incorrectos";
                    exit();
                }else{
                    if($rows->usuarioact===false){
                        echo "❕ Usuario Inactivo, Contáctese con el administrador al número de teléfono: $rows->empretel";
                        exit();
                    }else{
                        if($rows->sesionactiva===false){
                            include_once "conexion.php";
                            try{
                                $sentencia = $base_de_datos->prepare("SELECT fun_active_sesion_otros(?, ?);");
                                $sentencia->execute([$user, $rol]);
                                $msg = $sentencia->fetchColumn();
                                if($msg==='00000')
                                {
                                    echo "✔️ Todo bien vendedor";
                                    $_SESSION['id'] = $user;
                                    $_SESSION['username'] = $rol;
                                    exit();
                                }else
                                {
                                    echo "❌ Error: $msg";
                                }
                            }catch(PDOException $e){
                                
                                $excepcod = $e->getCode();
                                $sentencia = $base_de_datos->prepare("SELECT excepNom from excepciones WHERE excepCod = ?;");
                                $sentencia->execute([$excepcod]);
                                $excepciones = $sentencia->fetchObject();
                                $excep_nombre = $excepciones->excepnom;
                                if (!$excepciones)
                                {
                                    #No existe
                                    echo "❗ No existe ninguna excepción con ese código";
                                    exit();
                                }
                                echo "⚠️ Excepción: $excep_nombre";
                                exit();
                            }
                        }else{
                            $_SESSION['id'] = $user;
                            $_SESSION['username'] = $rol;
                            echo "SESIÓN YA ACTIVA ⚠️";
                            include_once 'desactivarSesion.php';
                        }
                    }
                }
            }
        break;

        case 'loginCliente.php':
            include_once 'conexion.php';
            $rol = 'Cliente';
            $sentencia = $base_de_datos->prepare("select c.clientAct, c.sesionActiva, p.empreTel from cliente c, parametros p WHERE c.clientDoc=? AND c.clientCon=?");
            $sentencia->execute([$user, $passw]);
            $rows = $sentencia -> fetchObject();
            if(!$rows){
                echo "❕ Usuario y/o Contraseña incorrectos";
                exit();
            }else{
                if($rows->clientact===false){
                    echo "❕ Cliente Inactivo, Contáctese con el administrador al número de teléfono: $rows->empretel";
                    exit();
                }else{
                    if($rows->sesionactiva===false){
                        include_once "conexion.php";
                        try{
                            $sentencia = $base_de_datos->prepare("SELECT fun_active_sesion_cliente(?);");
                            $sentencia->execute([$user]);
                            $msg = $sentencia->fetchColumn();
                            if($msg==='00000')
                            {
                                echo "✔️ Todo bien";
                                $_SESSION['id'] = $user;
                                $_SESSION['username'] = $rol;
                                exit();
                            }else
                            {
                                echo "❌ Error: $msg";
                                exit();
                            }
                        }catch(PDOException $e){
                            
                            $excepcod = $e->getCode();
                            $sentencia = $base_de_datos->prepare("SELECT excepNom from excepciones WHERE excepCod = ?;");
                            $sentencia->execute([$excepcod]);
                            $excepciones = $sentencia->fetchObject();
                            $excep_nombre = $excepciones->excepnom;
                            if (!$excepciones)
                            {
                                #No existe
                                echo "❗ No existe ninguna excepción con ese código";
                                exit();
                            }
                            echo "⚠️ Excepción: $excep_nombre";
                            exit();
                        }
                    }else{
                        $_SESSION['id'] = $user;
                        $_SESSION['username'] = $rol;
                        echo "SESIÓN YA ACTIVA ⚠️";
                        include_once 'desactivarSesion.php';
                    }
                }
            }
        break; 
    }
    echo "↩️ No puedes ingresar de esta manera";
    exit();