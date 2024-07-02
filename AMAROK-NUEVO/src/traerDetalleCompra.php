<?php
    if(session_start()===false)
    {
        session_start();
    }
    
    if(!isset($_SESSION['id']) ||
        !isset($_SESSION['username']))
    {
        echo "<script>
                alert('↩️ Debe logearse como cliente para entrar a esta página');
                window.location = 'login.php';
            </script>";
    }
    if($_SESSION['username']!='Cliente'){
        echo "<script>
                alert('↩️ No tiene permisos para entrar a esta página');
                window.location = 'login.php';
            </script>";
    }

    if (!isset($_POST["codventa"]))
    {
    exit();
    }

    $codventa = $_POST["codventa"];
    $docclient = $_SESSION['id'];

    include_once 'conexion.php';
    
    $sentencia = $base_de_datos->query("SELECT p.producCod, p.producNom, dt.detVentaCan, to_char(dt.precioProduc, 'LFM9,999,999') AS precioProduc, to_char(dt.detVentaDes, 'LFM9,999,999') AS detVentaDes, to_char(dt.detVentaValPar, 'LFM9,999,999') AS detVentaValPar 
                                        FROM detalleventa dt, producto p, venta v 
                                        WHERE dt.numVenta = $codventa AND p.producCod =  dt.codProduc AND v.ventanum = $codventa AND v.docclient= '$docclient';");
    $num_rows = $sentencia->fetchAll(PDO::FETCH_OBJ);
    if($num_rows==false){
        $detcomprainv = "CompraSinDetalle";
        $jsoninv = json_encode($detcomprainv);
        echo $jsoninv;
    }else{
        $json = json_encode($num_rows);
        echo $json;
    }
    $base_de_datos = null;