<?php
    session_start();                //INICIALIZAR SESIÓN
    if(!isset($_POST['envio'])){
        if (!isset($_POST['envionum']) ||
            !isset($_POST['empretranit'])||
            !isset($_FILES['archivo']))
        {
            echo '❕ Cargue bien los datos mano';
            exit();
        }else{
            $empresa = $_POST['empretranit'];
            $archivo = $_FILES['archivo'];

            $tiposImagenPermitidos = array('image/jpeg', 'image/png');
            if (!in_array($archivo['type'], $tiposImagenPermitidos)) {
                echo '❕ Alerta: La guía debe ser una imagen (JPEG o PNG)';
                exit();
            }
        }   
    }else{
        if (!isset($_POST['envionum'])){
            echo '❕ Cargue bien los datos mano';
            exit();
        }else{
            $empresa = '';
        }
    }                                 
    
    $numero = $_POST['envionum'];
    

    $usua = $_SESSION['id'];
    $role = $_SESSION['username'];                                  //USUARIO Y ROL PARA LA AUDITORÍA

    include_once 'conexion.php';
    $base_de_datos->beginTransaction();                             //SE INICIA LA TRANSACCIÓN
    try{
        $sentencia = $base_de_datos->prepare("SELECT fun_finish_shipping( ?,? );");
        $sentencia->execute([$numero, $empresa]);    //SE HACE EL QUERY BY EXAMPLE
        $msg = $sentencia->fetchColumn();
        if (ctype_digit($msg)) {
            if($empresa!==''){
                $guia = intval($msg);                                   //SE VALIDA QUE HAYA SIDO EFECTIVA LA OPERACIÓN
                $rutaguia = '../images/Guias_Envios/' . $guia . '.jpg';
                move_uploaded_file($_FILES['archivo']['tmp_name'], $rutaguia); //SE CARGA EL COMPROBANTE EN EL SERVIDOR
            }
            $base_de_datos->commit();
            echo "✅ Envío finalizado con éxito";
        } else {
            $base_de_datos->rollBack();
            echo "❌ Error: $msg";
        }
        }catch(PDOException $e){                        //EN CASO DE EXCEPCIÓN, MOSTRARÁ CUÁL FUE EL MOTIVO
            $base_de_datos->rollBack();                 
            include_once 'conexion.php';
            $excepcod = $e->getCode();
            $sentencia = $base_de_datos->prepare("SELECT excepNom from excepciones WHERE excepCod = ?;");
            $sentencia->execute([$excepcod]);
            $excepciones = $sentencia->fetchObject();   
            $excep_nombre = $excepciones->excepnom;     //SE CONSULTA MEDIANTE EL CÓDIGO DE LA EXCEPCIÓN EN LA TABLA
            if (!$excepciones)                          //Y ASÍ, SE TRAE EL NOMBRE EN ESPAÑOL
            {
                #No existe
                echo "¡No existe ninguna excepción con ese código!";    //SI NO ENCUENTRA EL REGISTRO, SALE DEL PHP
                exit();
            }
            echo "⚠️ Excepción: $excep_nombre";                         //SE MUESTRA LA ALERTA CON LA EXCEPCIÓN CORRESPONDIENTE
        }