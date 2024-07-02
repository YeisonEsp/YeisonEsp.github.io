<?php
    include_once 'conexion.php';

    $sentencia = $base_de_datos->query("select tiemposalir from parametros");
    $paramet = $sentencia->fetchAll(PDO::FETCH_OBJ);
    $base_de_datos=null;
?>