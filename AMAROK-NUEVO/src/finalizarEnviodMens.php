<?php                                                                   //API PARA CONSUMO DE LA APP MÓVIL
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $json_data = file_get_contents('php://input');
    
    // Decodificar el JSON en un array asociativo de PHP
    $data = json_decode($json_data, true);
    // Obtener credenciales del usuario desde la solicitud POST
    $envio = $data["envionum"];
    $empresa = '';

    // Realizar la verificación de las credenciales en la base de datos
    include_once 'conexion.php';
    
    try{
        $sentencia = $base_de_datos->prepare("SELECT fun_finish_shipping(?,?);");
        $sentencia->execute([$envio, $empresa]);
        $msg = $sentencia->fetchColumn();
        if(ctype_digit($msg))
        {
            echo json_encode(["success" => true, "message" => "Envío finalizado"]);
        }else
        {
            echo json_encode(["success" => false, "message" => "$msg"]);
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
} else {
    // Devolver un error si no se ha enviado un formulario de inicio de sesión
    http_response_code(405); // Método no permitido
    echo json_encode(["success" => false, "message" => "Método no permitido"]);
}
$base_de_datos=null;
exit();