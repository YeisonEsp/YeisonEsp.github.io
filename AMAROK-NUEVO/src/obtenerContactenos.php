<?php
    include_once "conexion.php";

    // Consulta SQL

    $sentencia2 = $base_de_datos->query("SELECT contacId, contacNom, contacTel, contacEma, contacAsu, to_char(fec_insert, 'DD-MM-YYYY hh:MI:ss') AS fechacontac FROM contactenos WHERE contacRev = FALSE;");
    $contactenos2 = $sentencia2->fetchAll(PDO::FETCH_OBJ);

    // Convierte el array de objetos a JSON
    
    $json = json_encode($contactenos2);

    // Envia el JSON al archivo PHP de la tabla
    echo $json;

    $base_de_datos = null; 