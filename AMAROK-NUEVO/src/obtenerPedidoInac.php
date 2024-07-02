<?php
    include_once "conexion.php";

    // Consulta SQL

    $sentencia = $base_de_datos->query("select pe.pedidoNum, pe.nitProvee, pr.proveeNom, to_char(pe.pedidoTotal, 'LFM9,999,999') AS pedidototal, pe.pedidopag, 
                                        to_char(pe.fec_insert, 'DD-MM-YYYY hh:MI:ss') AS fec_insert
                                        FROM pedidoproveedor pe JOIN proveedor pr ON pe.nitProvee=pr.proveeNit 
                                        WHERE pe.pedidopag=false");
    $pedidosinac = $sentencia->fetchAll(PDO::FETCH_OBJ);

    foreach($pedidosinac as $pedi)
    {
        if($pedi->pedidopag){
            $pedi->pedidopag='SI';
        }else{
            $pedi->pedidopag='NO';
        }
    }

    // Convierte el array de objetos a JSON
    
    $json = json_encode($pedidosinac);

    // Envia el JSON al archivo PHP de la tabla
    echo $json;

    $base_de_datos = null;    