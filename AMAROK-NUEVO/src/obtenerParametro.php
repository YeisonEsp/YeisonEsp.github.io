<?php
    include_once "conexion.php";

    // Consulta SQL

    $sentencia = $base_de_datos->query('SELECT empreNit, empreNom, empredir, empretel, emprecel, empreema, numFacIni, numFacFin, redPunDes, redPunDom, tiempoSalir FROM parametros;');
    $parametros = $sentencia->fetchAll(PDO::FETCH_OBJ);

    // Convierte el array de objetos a JSON
    
    $json = json_encode($parametros);

    // Envia el JSON al archivo PHP de la tabla
    echo $json;

    $base_de_datos = null;    