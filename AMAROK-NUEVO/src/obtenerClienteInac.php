<?php
    include_once "conexion.php";

    // Consulta SQL

    $sentencia = $base_de_datos->query('SELECT clientDoc, d.departNom, c.ciudadNom, clientNom, clientDir, clientTel, clientEma, clientPun FROM cliente, departamento d, ciudad c WHERE clientAct = FALSE AND idCiudad = ciudadId AND idDepart = departId;');
    $clientes = $sentencia->fetchAll(PDO::FETCH_OBJ);

    // Convierte el array de objetos a JSON
    
    $json = json_encode($clientes);

    // Envia el JSON al archivo PHP de la tabla
    echo $json;

    $base_de_datos = null;    
?>