<?php
    if (!isset($_POST["sql"]))
    {
        echo '❕ El sql viene vacío';
        exit();
    }
    if(isset($_POST['tipopago']))
    {
        $modopago = trim($_POST['tipopago']);
        switch(true){
            case ($modopago == 'Tarjeta') || ($modopago == 'Transferencia Banco'):
                if(!isset($_FILES['archivo'])){
                    echo '❕ Alerta: Debe cargar comprobante';
                    exit();
                }
                $archivo = $_FILES['archivo'];
                $tiposImagenPermitidos = array('image/jpeg', 'image/jpg', 'image/png');
                if (!in_array($archivo['type'], $tiposImagenPermitidos)) {
                    echo '❕ Alerta: El archivo debe ser una imagen (JPEG o PNG)';
                    exit();
                }
                break;
        }
    }

    $consult = $_POST["sql"];
    include_once 'conexion.php';
    $base_de_datos->beginTransaction();
    try{
        $sentencia = $base_de_datos->query($consult);
        $msg = $sentencia->fetchColumn();
        
        if (ctype_digit($msg)) {
            if(isset($_POST['tipopago']) &&
                isset($_FILES['archivo']) && 
                $_POST['tipopago']!=='Efectivo' && $_POST['tipopago']!=='Ninguno')
            {
                $fact = intval($msg);                                   //SE VALIDA QUE HAYA SIDO EFECTIVA LA OPERACIÓN
                $rutacobro = '../images/Comprobantes_Cobros/' . $fact . '.jpg';
                move_uploaded_file($_FILES['archivo']['tmp_name'], $rutacobro); //SE CARGA EL COMPROBANTE EN EL SERVIDOR
            }
            $base_de_datos->commit();
            echo "✅ Venta guardada con éxito";
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
