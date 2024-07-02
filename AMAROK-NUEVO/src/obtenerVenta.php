<?php
    include_once "conexion.php";

    // Consulta SQL

    $sentencia = $base_de_datos->query("SELECT v.ventaNum, v.docClient, cl.clientNom, v.departamento, v.ciudad, v.tipopago, v.ventaDom, v.ventaCan, to_char(sum(dt.detventavalpar), 'LFM9,999,999') AS total, to_char(v.fec_insert, 'DD-MM-YYYY hh:MI:ss') AS fechaventa 
                                        FROM venta v JOIN cliente cl ON v.docClient=cl.clientDoc 
                                        JOIN detalleventa dt ON v.ventaNum=dt.numVenta WHERE v.ventaRec = TRUE GROUP BY v.ventaNum, cl.clientDoc;");
    $ventas = $sentencia->fetchAll(PDO::FETCH_OBJ);

    foreach($ventas as $ven)
    {
        if($ven->ventadom){
            $ven->ventadom='SI';
        }else{
            $ven->ventadom='NO';
        }
        if($ven->ventacan){
            $ven->ventacan='SI';
        }else{
            $ven->ventacan='NO';
        }
    }

    // Convierte el array de objetos a JSON
    
    $json = json_encode($ventas);

    // Envia el JSON al archivo PHP de la tabla
    echo $json;

    $base_de_datos = null;