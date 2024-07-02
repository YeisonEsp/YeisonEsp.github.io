<?php
    include_once "conexion.php";

    // Consulta SQL

    $sentencia = $base_de_datos->query("SELECT contacId, contacNom, contacTel, contacEma, contacAsu, to_char(fec_insert, 'DD-MM-YYYY hh:MI:ss') AS fechacontac FROM contactenos WHERE contacRev = TRUE;");
    $contactenos = $sentencia->fetchAll(PDO::FETCH_OBJ);

    // Convierte el array de objetos a JSON
    
    $json = json_encode($contactenos);

    // Envia el JSON al archivo PHP de la tabla
    echo $json;

    $base_de_datos = null; 