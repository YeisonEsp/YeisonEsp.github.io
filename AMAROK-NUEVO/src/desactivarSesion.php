<?php
if(session_status()===PHP_SESSION_NONE)
{
    session_start();                        //INICIALIZAR SESIÓN
}
if(!isset($_SESSION['id']) ||
!isset($_SESSION['username']))              //VALIDAR QUE LOS DATOS DE LA SESIÓN ESTÉN DEFINIDOS Y NO ESTÉN NULOS
{
    echo "<script>
                localStorage.clear();
                window.location = '../';
            </script>";
}

include_once 'conexion.php';
try{

    switch(true){
        case ($_SESSION['username'] == 'Administrador'):                                //VALIDAR QUE SE EJECUTE LO SIGUIENTE SOLO SI ES ADMINISTRADOR
                $sentencia = $base_de_datos->query("SELECT fun_disable_sesion();");
                $msg = $sentencia->fetchColumn();
                $base_de_datos=null;
                if($msg==='00000')
                {
                    $base_de_datos=null;
                    session_destroy();
                    echo "<script>
                            localStorage.clear();
                            window.location = 'login.php';
                        </script>";
                }else{
                    $base_de_datos=null;
                    session_destroy();
                    echo "<script>
                            localStorage.clear();
                            alert('❌ Error: $msg');
                            window.location = 'login.php';
                        </script>";
                }
            break;
            case ($_SESSION['username'] == 'Cliente'):                                      //VALIDAR QUE SE EJECUTE LO SIGUIENTE SOLO SI ES CLIENTE
                $sentencia = $base_de_datos->prepare("SELECT fun_disable_sesion_cliente(?);");
                $sentencia->execute([$_SESSION['id']]);
                $msg = $sentencia->fetchColumn();
                $base_de_datos=null;
                if($msg==='00000')
                {
                    $base_de_datos=null;
                    session_destroy();
                    echo "<script>
                            localStorage.clear();
                            window.location = 'loginCliente.php';
                        </script>";
                }else{
                    $base_de_datos=null;
                    session_destroy();
                    echo "<script>
                            localStorage.clear();
                            alert('❌ Error: $msg');
                            window.location = 'loginCliente.php';
                        </script>";
                }
            break;
        case ($_SESSION['username']=='Vendedor'):                                                   //VALIDAR QUE SE EJECUTE LO SIGUIENTE SOLO SI ES VENDEDOR
                $sentencia = $base_de_datos->prepare("SELECT fun_disable_sesion_otros(?, ?);");
                $sentencia->execute([$_SESSION['id'], $_SESSION['username']]);
                $msg = $sentencia->fetchColumn();
                $base_de_datos=null;
                if($msg==='00000')
                {
                    $base_de_datos=null;
                    session_destroy();
                    echo "<script>
                            localStorage.clear();
                            window.location = 'login.php';
                        </script>";
                }else{
                    $base_de_datos=null;
                    session_destroy();
                    echo "<script>
                            localStorage.clear();
                            alert('❌ Error: $msg');
                            window.location = 'login.php';
                        </script>";
                }
            break;
    }
    
}catch(PDOException $e){
    include_once 'conexion.php';
    $excepcod = $e->getCode();
    $sentencia = $base_de_datos->prepare("SELECT excepNom from excepciones WHERE excepCod = ?;");
    $sentencia->execute([$excepcod]);                   //QUERY BY EXAMPLE
    $excepciones = $sentencia->fetchObject();                   
    $excep_nombre = $excepciones->excepnom;             //EVALUACIÓN DE RESULTADO DE LA OPERACIÓN
    if (!$excepciones)
    {
        $base_de_datos=null;
        session_destroy();
        #No existe
        echo "¡No existe ninguna excepción con ese código!";
        exit();
    }
    $base_de_datos=null;
    session_destroy();
    echo "<script>
            alert('La locura excepción');
            localStorage.clear();
            alert('⚠️ Excepción: $excep_nombre');
            window.history.go(-1);
        </script>";
}

