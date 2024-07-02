<?php
    include_once "conexion.php";

    // Consulta SQL

    $sentencia = $base_de_datos->query("SELECT el.envioNum, el.numVenta, c.ciudadNom, el.envioDocDes, 
                                        el.envioNomDes, el.envioDirDes, el.envioTelDes, el.envioPre, 
                                        to_char(el.fec_insert, 'DD-MM-YYYY hh:MI:ss') AS fec_insert 
                                        FROM envio el JOIN ciudad c ON el.idCiudad=c.ciudadId   
                                        WHERE c.idDepart=27 AND (c.ciudadNom = 'Bucaramanga' OR c.ciudadNom = 'Floridablanca' 
                                        OR c.ciudadNom = 'Piedecuesta' OR c.ciudadNom = 'Norte de Bucaramanga' 
                                        OR c.ciudadNom = 'Girón') AND el.envioEnt=false AND el.envioSal=false;");
    $envios = $sentencia->fetchAll(PDO::FETCH_OBJ);

    // Convierte el array de objetos a JSON
    
    $json = json_encode($envios);

    // Envia el JSON al archivo PHP de la tabla
    echo $json;

    $base_de_datos = null;