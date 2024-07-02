<?php
    include_once "conexion.php";

    // Consulta SQL

    $sentencia = $base_de_datos->query("select pe.pedidoNum, pe.nitProvee, pr.proveeNom, pe.tipopago, to_char(pe.pedidoTotal, 'LFM9,999,999') AS pedidototal, pe.pedidopag, 
                                        to_char(pe.fec_insert, 'DD-MM-YYYY hh:MI:ss') AS fec_insert 
                                        FROM pedidoproveedor pe JOIN proveedor pr ON pe.nitProvee=pr.proveeNit 
                                        WHERE pe.pedidopag=true");
    $pedidos = $sentencia->fetchAll(PDO::FETCH_OBJ);

    foreach($pedidos as $ped)
    {
        if($ped->pedidopag){
            $ped->pedidopag='SI';
        }else{
            $ped->pedidopag='NO';
        }
    }

    // Convierte el array de objetos a JSON
    
    $json = json_encode($pedidos);

    // Envia el JSON al archivo PHP de la tabla
    echo $json;

    $base_de_datos = null;    