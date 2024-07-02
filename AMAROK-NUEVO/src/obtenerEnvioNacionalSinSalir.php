<?php
    include_once "conexion.php";

    // Consulta SQL

    $sentencia = $base_de_datos->query("SELECT en.envioNum, en.numVenta, d.departNom, c.ciudadNom, en.envioDocDes, 
                                        en.envioNomDes, en.envioDirDes, en.envioTelDes, en.envioPre, 
                                        to_char(en.fec_insert, 'DD-MM-YYYY hh:MI:ss') AS fec_insert 
                                        FROM envio en JOIN ciudad c ON en.idCiudad=c.ciudadId 
                                        JOIN departamento d ON c.idDepart=d.departId 
                                        WHERE (d.departId <> 27 OR (c.ciudadNom <> 'Bucaramanga' AND c.ciudadNom <> 'Floridablanca' 
                                        AND c.ciudadNom <> 'Piedecuesta' AND c.ciudadNom <> 'Norte de Bucaramanga'
                                        AND c.ciudadNom <> 'Girón')) AND en.envioEnt=false AND en.envioSal=false;");
    $envios = $sentencia->fetchAll(PDO::FETCH_OBJ);

    // Convierte el array de objetos a JSON
    
    $json = json_encode($envios);

    // Envia el JSON al archivo PHP de la tabla
    echo $json;

    $base_de_datos = null;