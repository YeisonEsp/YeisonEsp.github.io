<?php
    include_once "conexion.php";

    // Consulta SQL

    $sentencia = $base_de_datos->query('SELECT usuarioDoc, usuariorol, usuarioNom, usuarioDir, usuarioTel, usuarioEma FROM usuario WHERE usuarioAct = TRUE;');
    $usuarios = $sentencia->fetchAll(PDO::FETCH_OBJ);

    // Convierte el array de objetos a JSON
    
    $json = json_encode($usuarios);

    // Envia el JSON al archivo PHP de la tabla
    echo $json;

    $base_de_datos = null;