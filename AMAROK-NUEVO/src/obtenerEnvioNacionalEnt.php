<?php
    include_once "conexion.php";

    // Consulta SQL

    $sentencia = $base_de_datos->query("SELECT en.envioNum, en.numVenta, en.docUsuario, u.usuarioNom, e.empreTraNom, d.departNom, c.ciudadNom, 
                                        en.envioDocDes, en.envioNomDes, en.envioDirDes, en.envioTelDes, en.envioPre, 
                                        en.envioObs, to_char(en.fec_salida, 'DD-MM-YYYY hh:MI:ss') AS fec_salida, 
                                        to_char(en.fec_entrega, 'DD-MM-YYYY hh:MI:ss') AS fec_entrega 
                                        FROM usuario u JOIN envio en ON u.usuarioDoc=en.docUsuario 
                                        AND u.usuarioRol='Mensajero' JOIN empresatransporte e ON en.nitEmpreTra=e.empreTraNit 
                                        JOIN ciudad c ON en.idCiudad=c.ciudadId 
                                        JOIN departamento d ON c.idDepart=d.departId 
                                        WHERE (d.departId <> 27 OR (c.ciudadNom <> 'Bucaramanga' AND c.ciudadNom <> 'Floridablanca' 
                                        AND c.ciudadNom <> 'Piedecuesta' AND c.ciudadNom <> 'Norte de Bucaramanga'
                                        AND c.ciudadNom <> 'Girón')) AND en.envioEnt=true;");
    $envios = $sentencia->fetchAll(PDO::FETCH_OBJ);

    // Convierte el array de objetos a JSON
    
    $json = json_encode($envios);

    // Envia el JSON al archivo PHP de la tabla
    echo $json;

    $base_de_datos = null;