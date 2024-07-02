<?php
// Verificar si se ha enviado un formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $json_data = file_get_contents('php://input');
    
    // Decodificar el JSON en un array asociativo de PHP
    $data = json_decode($json_data, true);
    // Obtener credenciales del usuario desde la solicitud POST
    $user = $data["UsuarioDoc"];
    $passw = md5($data["UsuarioCon"]);

    // Realizar la verificación de las credenciales en la base de datos
    include_once 'conexion.php';
    $rol = 'Mensajero';
    // (Consulta a la base de datos para verificar si el usuario y la contraseña son válidos)
    $sentencia = $base_de_datos->query("select u.usuarioAct, u.sesionActiva, p.empreTel from usuario u, parametros p WHERE u.usuarioDoc='$user' AND u.usuarioRol='Mensajero' AND u.usuarioCon='$passw'");
                $rows = $sentencia -> fetchObject();
    if(!$rows){
        
        echo json_encode(["success" => false, "message" => "Usuario y/o Password incorrectos"]);
    }else{
        if($rows->usuarioact===false){
            
            echo json_encode(["success" => false, "message" => "Usuario Inactivo, Contáctese con el administrador al número de teléfono: $rows->empretel"]);
        }else{
            if($rows->sesionactiva===false){
                include_once "conexion.php";
                try{
                    $sentencia = $base_de_datos->prepare("SELECT fun_active_sesion_otros(?, ?);");
                    $sentencia->execute([$user, $rol]);
                    $msg = $sentencia->fetchColumn();
                    if($msg==='00000')
                    {
                        echo json_encode(["success" => true, "message" => "Credenciales Correctas"]);
                    }else
                    {
                        
                        echo json_encode(["success" => false, "message" => "Error: $msg"]);
                    }
                }catch(PDOException $e){
                    
                    $excepcod = $e->getCode();
                    $sentencia = $base_de_datos->prepare("SELECT excepNom from excepciones WHERE excepCod = ?;");
                    $sentencia->execute([$excepcod]);
                    $excepciones = $sentencia->fetchObject();
                    $excep_nombre = $excepciones->excepnom;
                    if (!$excepciones)
                    {
                        
                        #No existe
                        echo json_encode(["success" => false, "message" => "No existe ninguna excepción con ese código"]);
                    }
                    
                    echo json_encode(["success" => false, "message" => "Excepción: $excep_nombre"]);
                }
            }else{
                $sentencia = $base_de_datos->prepare("SELECT fun_disable_sesion_otros(?, ?);");
                $sentencia->execute([$user, $rol]);
                echo json_encode(["success" => false, "message" => "SESIÓN YA ACTIVA"]);
            }
        }
    }
} else {
    // Devolver un error si no se ha enviado un formulario de inicio de sesión
    http_response_code(405); // Método no permitido
    echo json_encode(["success" => false, "message" => "Método no permitido"]);
}
$base_de_datos=null;
exit();