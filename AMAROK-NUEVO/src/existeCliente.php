<?php
    if (!isset($_POST["clientdoc"]))    //VALIDAR QUE EL DOCUMENTO DEL CLIENTE ESTÉ DEFINIDO Y NO SEA NULO
    {
    exit();
    }

    $cliente = $_POST["clientdoc"];

    include_once 'conexion.php';

    $sentencia = $base_de_datos->query("SELECT clientDoc, clientAct FROM cliente WHERE clientdoc= '$cliente'");        //QUERY A LA BD
    $num_rows = $sentencia -> fetchObject();
    if(!$num_rows){                                   //EVALUACIÓN DE RESULTADO DE LA OPERACIÓN
        $clienteinv = "El cliente no existe ❕";
        $jsoninv = json_encode($clienteinv);
        echo $jsoninv;                                  //RETORNO DEL JSON EN CASO DE QUE NO EXISTA EL CLIENTE
        exit();
    }else{
        if($num_rows->clientact===false){
            $clienteact = "Cliente inactivo ❕";
            $jsonact = json_encode($clienteact);
            echo $jsonact;
            exit();
        }else{
            $sentencia2 = $base_de_datos->query("SELECT c.ciudadNom, d.departnom FROM cliente, ciudad c, departamento d WHERE clientDoc = '$cliente' AND idCiudad = ciudadId AND idDepart = departId;");
            $jcliente = $sentencia2->fetchAll(PDO::FETCH_OBJ);
            $json = json_encode($jcliente);                                 //RETORNO DEL JSON EN CASO DE QUE EXISTA EL CLIENTE
            echo $json;
            $base_de_datos = null;
            exit();
        }
    }