<?php
    include_once "conexion.php";

    // Consulta SQL

    $sentencia = $base_de_datos->query('SELECT empreTraNit, empreTraNom, empreTraTel FROM empresatransporte WHERE empreTraAct = TRUE;');
    $empresas = $sentencia->fetchAll(PDO::FETCH_OBJ);

    // Convierte el array de objetos a JSON
    
    $json = json_encode($empresas);

    // Envia el JSON al archivo PHP de la tabla
    echo $json;

    $base_de_datos = null;    
?>