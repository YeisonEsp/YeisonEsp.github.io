<?php
    if (!isset($_POST["idcontac"]))     //VALIDAR QUE EL ID DEL CONTACTENOS ESTÉ DEFINIDO Y NO ESTÉ NULO
    {
    exit();
    }

    $idconctac = $_POST["idcontac"];

    include_once 'conexion.php';

    try{
        $sentencia = $base_de_datos->prepare("SELECT fun_update_contactenos(?);");
        $sentencia->execute([$idconctac]);                      //QUERY BY EXAMPLE
        $msg = $sentencia->fetchColumn();               
        if($msg==='00000')                                      //VALIDACIÓN DEL RESULTADO DE LA OPERACIÓN
        {
            echo "✅ Mensaje revisado";
        }else
        {
            echo "❌ Error: $msg";
        }
    }catch(PDOException $e){
        
        $excepcod = $e->getCode();
        $sentencia = $base_de_datos->prepare("SELECT excepNom from excepciones WHERE excepCod = ?;");
        $sentencia->execute([$excepcod]);
        $excepciones = $sentencia->fetchObject();
        $excep_nombre = $excepciones->excepnom;                 //EN CASO DE EXCEPCIÓN, SE MUESTRA LA CAUSA
        if (!$excepciones)
        {
            echo "¡No existe ninguna excepción con ese código!";    #Si no existe, queda en blanco la página
            exit();
        }
    
        echo "⚠️ Excepción: $excep_nombre";
    }
    