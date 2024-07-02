<?php
    if(session_status()===PHP_SESSION_NONE)
    {
        session_start();                            //INICIALIZAR SESIÓN
    }

    include_once 'conexion.php';
    try{
        switch(true){
            case ($_SESSION['username'] == 'Administrador'):                                //VALIDAR QUE SE EJECUTE LO SIGUIENTE SOLO SI ES ADMINISTRADOR
                    $sentencia = $base_de_datos->query("SELECT fun_disable_sesion();");
                    $msg = $sentencia->fetchColumn();                   //QUERY BY EXAMPLE
                    $base_de_datos=null;
                    if($msg==='00000')                          //EVALUACIÓN DE RESULTADO DE LA OPERACIÓN
                    {
                        session_destroy();
                        echo "<script>
                                localStorage.clear();
                            </script>";
                    }else{
                        session_destroy();
                        echo "<script>
                                localStorage.clear();
                                alert('❌ Error: $msg');
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
                    session_destroy();
                    echo "<script>
                                localStorage.clear();
                            </script>";
                }else{
                    session_destroy();
                    echo "<script>
                                localStorage.clear();
                                alert('❌ Error: $msg');
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
                        session_destroy();
                        echo "<script>
                                localStorage.clear();
                            </script>";
                    }else{
                        session_destroy();
                        echo "<script>
                                localStorage.clear();
                                alert('❌ Error: $msg');
                            </script>";
                    }
                break;
        }
        
    }catch(PDOException $e){
        include_once 'conexion.php';
        $excepcod = $e->getCode();
        $sentencia = $base_de_datos->prepare("SELECT excepNom from excepciones WHERE excepCod = ?;");
        $sentencia->execute([$excepcod]);
        $excepciones = $sentencia->fetchObject();               //EN CASO DE EXCEPCIÓN, SE MUESTRA LA CAUSA
        $excep_nombre = $excepciones->excepnom;
        if (!$excepciones)
        {
            session_destroy();
            #No existe
            echo "¡No existe ninguna excepción con ese código!";
            exit();
        }
        session_destroy();
        echo "<script>
                localStorage.clear();
                alert('⚠️ Excepción: $excep_nombre');
            </script>";
    }

    echo "<script>
        localStorage.clear();
</script>";