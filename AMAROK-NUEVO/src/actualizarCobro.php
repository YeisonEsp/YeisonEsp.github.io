<?php
    session_start();                                    //INICIALIZAR SESIÓN
    if (!isset($_POST['ventanum']) ||
        !isset($_POST['modopago']))
    {
        echo '❕ Cargue bien los datos mano';
        exit();
    }
    $numero = $_POST['ventanum'];
    $modopago = $_POST['modopago'];
    // Acceder al archivo enviado
                                                 //SE TOMAN LOS DATOS EN VARIABLES
    switch(true){
    case ($modopago == 'Tarjeta') || ($modopago == 'Transferencia Banco'):
        if(!isset($_FILES['archivo'])){
            echo '❕ Alerta: Debe cargar comprobante';
            exit();
        }
        $archivo = $_FILES['archivo'];
        $tiposImagenPermitidos = array('image/jpeg', 'image/png');
        if (!in_array($archivo['type'], $tiposImagenPermitidos)) {
            echo '❕ Alerta: El comprobante debe ser una imagen (JPEG o PNG)';
            exit();
        }
        break;
    }

    $usua = $_SESSION['id'];
    $role = $_SESSION['username'];                                  //USUARIO Y ROL PARA LA AUDITORÍA

    include_once 'conexion.php';
    $base_de_datos->beginTransaction();                             //SE INICIA LA TRANSACCIÓN
    try{
        $sentencia = $base_de_datos->prepare("SELECT fun_update_cobro( ?,?,?,? );");
        $sentencia->execute([$numero, $modopago, $usua, $role]);    //SE HACE EL QUERY BY EXAMPLE
        $msg = $sentencia->fetchColumn();
        if (ctype_digit($msg)) {
            if($modopago!=='Efectivo' && $modopago!=='Ninguno'){
                $fact = intval($msg);                                   //SE VALIDA QUE HAYA SIDO EFECTIVA LA OPERACIÓN
                $rutacobro = '../images/Comprobantes_Cobros/' . $fact . '.jpg';
                move_uploaded_file($_FILES['archivo']['tmp_name'], $rutacobro); //SE CARGA LA GUÍA EN EL SERVIDOR
            }
            $base_de_datos->commit();
            echo "✅ Cobro actualizado con éxito";
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