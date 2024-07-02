<?php
    include_once "conexion.php";

    // Consulta SQL

    $sentencia = $base_de_datos->query('SELECT proveeNit, c.ciudadNom, proveeNom, proveeDir, proveeTel, proveeEma FROM proveedor, ciudad c WHERE idCiudad = ciudadId AND proveeAct = TRUE;');
    $proveedores = $sentencia->fetchAll(PDO::FETCH_OBJ);

    // Convierte el array de objetos a JSON
    
    $json = json_encode($proveedores);

    // Envia el JSON al archivo PHP de la tabla
    echo $json;

    $base_de_datos = null;    