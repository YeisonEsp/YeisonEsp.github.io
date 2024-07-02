<?php
// Verificar si se ha enviado un formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $json_data = file_get_contents('php://input');
    
    // Decodificar el JSON en un array asociativo de PHP
    $data = json_decode($json_data, true);
    // Obtener credenciales del usuario desde la solicitud POST
    $user = $data["UsuarioDoc"];

    include_once "conexion.php";

    // Consulta SQL

    $sentencia = $base_de_datos->query("SELECT e.envioNum, d.departNom, c.ciudadNom, e.envioDocDes, 
                                        e.envioNomDes, e.envioDirDes, e.envioTelDes, 
                                        to_char(e.envioPre, 'LFM9,999,999') AS envioPre, 
                                        to_char(e.fec_salida, 'DD-MM-YYYY hh:MI:ss') AS fec_salida 
                                        FROM usuario u JOIN envio e ON u.usuarioDoc=e.docUsuario   
                                        AND u.usuarioRol='Mensajero' JOIN ciudad c ON e.idCiudad=c.ciudadId 
                                        JOIN departamento d ON c.idDepart=d.departId 
                                        WHERE e.docUsuario='$user' AND c.idDepart=27 AND (c.ciudadNom = 'Bucaramanga' OR c.ciudadNom = 'Floridablanca' 
                                        OR c.ciudadNom = 'Piedecuesta' OR c.ciudadNom = 'Norte de Bucaramanga' 
                                        OR c.ciudadNom = 'Girón') AND e.envioSal=true AND e.envioEnt=false  
                                        ORDER BY e.envioNum;");
    $envios = $sentencia->fetchAll(PDO::FETCH_OBJ);

    // Convierte el array de objetos a JSON
    
    $json = json_encode($envios);

    // Envia el JSON al archivo PHP de la tabla
    echo $json;
}else{
    http_response_code(405); // Método no permitido
    echo json_encode(["success" => false, "message" => "Método no permitido"]);
}
$base_de_datos=null;
exit();