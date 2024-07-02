<?php
    include_once "conexion.php";

    // Consulta SQL

    $sentencia = $base_de_datos->query("SELECT el.envioNum, el.numVenta, el.docUsuario, u.usuarioNom, c.ciudadNom, el.envioDocDes, 
                                        el.envioNomDes, el.envioDirDes, el.envioTelDes, el.envioPre, 
                                        to_char(el.fec_insert, 'DD-MM-YYYY hh:MI:ss') AS fec_insert, 
                                        to_char(el.fec_salida, 'DD-MM-YYYY hh:MI:ss') AS fec_salida 
                                        FROM usuario u JOIN envio el ON u.usuarioDoc=el.docUsuario  
                                        AND u.usuarioRol='Mensajero' JOIN ciudad c ON el.idCiudad=c.ciudadId 
                                        WHERE c.idDepart=27 AND (c.ciudadNom = 'Bucaramanga' OR c.ciudadNom = 'Floridablanca' 
                                        OR c.ciudadNom = 'Piedecuesta' OR c.ciudadNom = 'Norte de Bucaramanga' 
                                        OR c.ciudadNom = 'Girón') AND el.envioSal=true AND el.envioEnt=false;");
    $envios = $sentencia->fetchAll(PDO::FETCH_OBJ);

    // Convierte el array de objetos a JSON
    
    $json = json_encode($envios);

    // Envia el JSON al archivo PHP de la tabla
    echo $json;

    $base_de_datos = null;