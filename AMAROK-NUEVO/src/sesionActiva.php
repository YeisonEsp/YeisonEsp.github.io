<?php
    if (!isset($_POST["rol"]) ||
        !isset($_POST["id"]))
    {
    exit();
    }
    $ro = $_POST["rol"];
    $id = $_POST["id"];
    include_once 'conexion.php';

    switch(true){
        case ($ro=='Administrador'):
            $sentencia = $base_de_datos->query("SELECT sesionActiva FROM parametros WHERE sesionActiva=true");
            $num_rows = $sentencia -> fetchColumn();
            if($num_rows==0){
                $base_de_datos=null;
                echo "⚠️ Se ha cerrado la sesión en todos los dispositivos ⚠️";
            }else{
                $base_de_datos=null;
                echo "";
            }
            break;
        case ($ro=='Cliente'):
            $sentencia = $base_de_datos->query("SELECT sesionActiva FROM cliente WHERE clientDoc= '$id' AND sesionActiva=true");
            $num_rows = $sentencia -> fetchColumn();
            if($num_rows==0){
                $base_de_datos=null;
                echo "⚠️ Sesión cerrada en todos los dispositivos. Vuelva a ingresar ⚠️";
            }else{
                $base_de_datos=null;
                echo "";
            }
            break;
        case ($ro=='Vendedor') || ($ro=='Bodeguero') || ($ro=='Mensajero'):
            $sentencia = $base_de_datos->query("SELECT sesionActiva FROM usuario WHERE usuarioDoc= '$id' AND usuarioRol= '$ro' AND sesionActiva=true");
            $num_rows = $sentencia -> fetchColumn();
            if($num_rows==0){
                $base_de_datos=null;
                echo "⚠️ Sesión cerrada en todos los dispositivos. Vuelva a ingresar ⚠️";
            }else{
                $base_de_datos=null;
                echo "";
            }
            break;
    }