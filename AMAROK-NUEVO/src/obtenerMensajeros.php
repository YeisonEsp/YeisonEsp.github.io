<?php
// recargar_select.php

include_once "conexion.php"; 

$sentencia2 = $base_de_datos->query("SELECT usuarioDoc, usuarioNom FROM usuario WHERE usuarioRol = 'Mensajero' AND usuarioAct = true ORDER BY usuarioNom");
$mensajeros = $sentencia2->fetchAll(PDO::FETCH_OBJ);

$options = "";
foreach($mensajeros as $mensajero) {
    $options .= "<option value='{$mensajero->usuariodoc}'>{$mensajero->usuarionom}</option>";
}

echo $options;