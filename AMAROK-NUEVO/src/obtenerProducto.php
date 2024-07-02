<?php
    include_once "conexion.php";

    // Consulta SQL

    $sentencia = $base_de_datos->query("SELECT producCod, producNom, producMod, producSto, 
                                        to_char(producPre, 'LFM9,999,999') AS producPre, tip.tipoProNom, li.lineaNom, 
                                        ma.marcaNom FROM producto, tipoproducto tip, linea li, marca ma WHERE producAct = TRUE 
                                        AND idTipoPro = tip.tipoProId AND idLinea = li.lineaId AND idMarca = ma.marcaId;");
    $productos = $sentencia->fetchAll(PDO::FETCH_OBJ);
    
    $json = json_encode($productos);

    // Envia el JSON al archivo PHP de la tabla
    echo $json;

    $base_de_datos = null;    