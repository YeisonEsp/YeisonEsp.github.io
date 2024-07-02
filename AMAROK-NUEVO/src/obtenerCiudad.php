<?php
    include_once "conexion.php";

    // Consulta SQL

    $sentencia = $base_de_datos->query("SELECT d.departNom, ciudadNom, to_char(precioDom, 'LFM9,999,999') AS precioDom, ciudadId FROM ciudad, departamento d WHERE idDepart = departId;");
    $ciudades = $sentencia->fetchAll(PDO::FETCH_OBJ);

    // Convierte el array de objetos a JSON
    
    $json = json_encode($ciudades);

    // Envia el JSON al archivo PHP de la tabla
    echo $json;

    $base_de_datos = null;    