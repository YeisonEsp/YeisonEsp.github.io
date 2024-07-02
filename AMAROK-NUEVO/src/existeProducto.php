<?php
    if (!isset($_POST["produccod"]))            //VALIDAR QUE EL CÓDIGO DEL PRODUCTO ESTÉ DEFINIDO Y NO SEA NULO
    {
    exit();
    }

    $producto = $_POST["produccod"];

    include_once 'conexion.php';

    $sentencia = $base_de_datos->query("SELECT produccod FROM producto WHERE produccod= '$producto';");     //QUERY A LA BD
    $num_rows = $sentencia -> fetchColumn();
    if($num_rows==0){                                   //EVALUACIÓN DE RESULTADO DE LA OPERACIÓN
        $productoinv = "El producto no existe";
        $jsoninv = json_encode($productoinv);
        echo $jsoninv;                                  //RETORNO DEL JSON EN CASO DE QUE NO EXISTA EL PRODUCTO
    }else{
        $sentencia2 = $base_de_datos->query("SELECT producCod, producSto, producNom, producPre, producMod FROM producto WHERE producCod = '$producto';");
        $jproducto = $sentencia2->fetchAll(PDO::FETCH_OBJ);
        $json = json_encode($jproducto);
        echo $json;                                     //RETORNO DEL JSON EN CASO DE QUE EXISTA EL PRODUCTO
        $base_de_datos = null;
    }
?>