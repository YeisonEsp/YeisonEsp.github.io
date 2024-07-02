<?php
    include_once "conexion.php";
    // Consulta SQL
    
    $sentencia = $base_de_datos->query("SELECT producCod, producSto, producNom, to_char(producPre, 'LFM9,999,999') AS producPre, tipoProId, tipoProNom FROM producto JOIN tipoproducto ON idTipoPro=tipoProId WHERE producSto > 0 ORDER BY producNom DESC;");
    $productos = $sentencia->fetchAll(PDO::FETCH_OBJ);

    // Convierte el array de objetos a JSON
    
    $json = json_encode($productos);

    // Envia el JSON al archivo PHP de la tabla
    echo $json;

    $base_de_datos = null;