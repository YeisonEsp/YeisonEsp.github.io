<?php

    if (!isset($_POST["clientdoc"]))
    {
    exit();
    }

    $cliente = $_POST["clientdoc"];

    include_once 'conexion.php';
    
    $sentencia = $base_de_datos->query("SELECT v.ventaNum, to_char(sum(dt.detventavalpar), 'LFM9,999,999') AS total, v.ventaRec, to_char(v.fec_insert, 'DD-MM-YYYY hh:MI:ss') AS fechacompra
                                        FROM venta v join detalleventa dt on v.ventaNum = dt.numVenta 
                                        WHERE docClient = '$cliente' GROUP BY v.ventaNum ORDER BY v.ventaRec");
    $num_rows = $sentencia->fetchAll(PDO::FETCH_OBJ);
    
    if($num_rows==false){
        $clienteinv = "ClienteSinVentas";
        $jsoninv = json_encode($clienteinv);
        echo $jsoninv;
    }else{
        $json = json_encode($num_rows);
        echo $json;
    }
    $base_de_datos = null;