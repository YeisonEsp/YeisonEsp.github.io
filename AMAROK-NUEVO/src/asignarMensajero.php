<?php
    session_start();                            //INICIALIZAR SESIÓN
    if(!isset($_SESSION['id']) ||
        !isset($_SESSION['username']))      //VALIDAR QUE LOS DATOS DE LA SESIÓN ESTÉN DEFINIDOS Y NO ESTÉN NULOS
    {
        echo "<script>
                localStorage.clear();
                window.history.go(-1);
            </script>";
    }

    if (!isset($_POST['envionum']) ||
        !isset($_POST['docusuario']))           //VALIDAR QUE EL NÚMERO DEL ENVÍO Y EL DOCUMENTO DEL MENSAJERO ESTÉN DEFINIDOS Y NO SEAN NULOS
    {
        exit();
    }
    $numero = $_POST['envionum'];
    $mensajero = $_POST['docusuario'];
    $usua = $_SESSION['id'];
    $role = $_SESSION['username'];

    include_once 'conexion.php';
    $base_de_datos->beginTransaction();
    try{
        $sentencia = $base_de_datos->prepare("SELECT fun_assign_mensajero( ?,?,?,? );");
        $sentencia->execute([$numero, $mensajero, $usua, $role]);                           //QUERY BY EXAMPLE
        $msg = $sentencia->fetchColumn();
        if($msg==='00000')                                              //EVALUACIÓN DE RESULTADO DE LA OPERACIÓN
                {
                    $base_de_datos->commit();
                    echo "✅ Mensajero asignado con éxito";
                    
                }else
                {
                    $base_de_datos->rollBack();
                    echo "❌ Error: $msg";
                }        
        }catch(PDOException $e){
            $base_de_datos->rollBack();                 #En caso de excepción, mostrará cual fue la excepción en la función
            include_once 'conexion.php';
            $excepcod = $e->getCode();
            $sentencia = $base_de_datos->prepare("SELECT excepNom from excepciones WHERE excepCod = ?;");
            $sentencia->execute([$excepcod]);
            $excepciones = $sentencia->fetchObject();   #Consulto la bd en la tabla de excepciones, y traigo el código que
            $excep_nombre = $excepciones->excepnom;     #corresponda con el obtenido de la función
            if (!$excepciones)
            {
                #No existe
                echo "¡No existe ninguna excepción con ese código!";    #Si no existe, queda en blanco la página
                exit();
            }
            echo "⚠️ Excepción: $excep_nombre";                         #Si coincide el código, lo mostrará en una alerta
        }