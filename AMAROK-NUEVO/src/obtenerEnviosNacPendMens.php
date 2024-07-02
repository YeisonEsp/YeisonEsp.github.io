<?php
// Verificar si se ha enviado un formulario con post
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $json_data = file_get_contents('php://input');
    
    // Decodificar el JSON en un array asociativo de PHP
    $data = json_decode($json_data, true);
    $user = $data["UsuarioDoc"];

    include_once "conexion.php";

    // Consulta SQL

    $sentencia = $base_de_datos->query("SELECT e.envioNum, d.departNom, c.ciudadNom, e.envioDocDes, 
                                        e.envioNomDes, e.envioDirDes, e.envioTelDes, 
                                        to_char(e.fec_salida, 'DD-MM-YYYY hh:MI:ss') AS fec_salida
                                        FROM usuario u JOIN envio e ON u.usuarioDoc=e.docUsuario   
                                        AND u.usuarioRol='Mensajero' JOIN ciudad c ON e.idCiudad=c.ciudadId 
                                        JOIN departamento d ON c.idDepart=d.departId 
                                        WHERE e.docUsuario='$user' AND (d.departId <> 27 OR (c.ciudadNom <> 'Bucaramanga' AND c.ciudadNom <> 'Floridablanca' 
                                        AND c.ciudadNom <> 'Piedecuesta' AND c.ciudadNom <> 'Norte de Bucaramanga'
                                        AND c.ciudadNom <> 'Girón')) AND e.envioSal=true AND e.envioEnt=false  
                                        ORDER BY e.envioNum;");
    $envios = $sentencia->fetchAll(PDO::FETCH_OBJ);

    // Convierte el array de objetos a JSON
    
    $json = json_encode($envios);

    // Envia el JSON como respuesta
    echo $json;
}else{
    http_response_code(405); // Método no permitido
    echo json_encode(["success" => false, "message" => "Método no permitido"]);
}
$base_de_datos=null;
exit();