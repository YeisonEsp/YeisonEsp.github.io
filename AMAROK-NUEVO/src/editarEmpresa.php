<?php
session_start();                        //INICIALIZAR SESIÓN
if(!isset($_SESSION['id']) ||
    !isset($_SESSION['username']))      //VALIDAR QUE LOS DATOS DE LA SESIÓN ESTÉN DEFINIDOS Y NO ESTÉN NULOS
{
    echo "<script>
            localStorage.clear();
            window.history.go(-1);
        </script>";
}

if (
    !isset($_POST["empretranom"]) ||
    !isset($_POST["empretratel"])           //VALIDAR QUE EL NOMBRE Y TELÉFONO DE LA EMPRESA ESTÉN DEFINIDOS Y NO SEAN NULOS
) {
    echo "<script>
            localStorage.clear();
            window.history.go(-1);
        </script>";
}

$usua = $_SESSION['id'];
$role = $_SESSION['username'];

include_once "conexion.php";

switch(true)
{
    case ($role=='Administrador') || ($role=='Vendedor'):               //VALIDAR QUE SE EJECUTE LO SIGUIENTE SOLO SI ES ADMINISTRADOR O VENDEDOR
        $empretranit      = trim($_POST["empretranit"]);
        $empretranom      = trim($_POST["empretranom"]);
        $empretratel      = trim($_POST["empretratel"]);
        try{
            $sentencia = $base_de_datos->prepare("SELECT fun_update_empresa(?,?,?,?,?);");      //QUERY BY EXAMPLE
            $sentencia->execute([$empretranit, $empretranom, $empretratel, $usua, $role]);
            $msg = $sentencia->fetchColumn();               //EVALUACIÓN DE RESULTADO DE LA OPERACIÓN
            if($msg==='00000')
            {
                $base_de_datos=null;
                echo "<script>
                            localStorage.clear();
                            alert('✅ Registro actualizado con exito');
                            window.location = 'listarEmpresas.php';
                        </script>";
            }else
            {
                echo "<script>
                        localStorage.clear();
                        alert('❌ Error: $msg');
                        window.history.go(-1);
                </script>";
            }
        }catch(PDOException $e){
            
            $excepcod = $e->getCode();
            $sentencia = $base_de_datos->prepare("SELECT excepNom from excepciones WHERE excepCod = ?;");
            $sentencia->execute([$excepcod]);   
            $excepciones = $sentencia->fetchObject();           //EN CASO DE EXCEPCIÓN, SE MUESTRA LA CAUSA
            $excep_nombre = $excepciones->excepnom;
            $base_de_datos=null;
            if (!$excepciones)
            {
                #No existe
                echo "<script>
                        localStorage.clear();
                        alert('❗ No existe ninguna excepción con ese código');
                        window.history.go(-1);
                    </script>";
            }
        
            echo "<script>
                    localStorage.clear();
                    alert('⚠️ Excepción: $excep_nombre');
                    window.history.go(-1);
                </script>";
        }
    break;

    default:                                            //SI NO ES NINGÚN ROL PERMITIDO, SE LE CIERRA LA SESIÓN POR CHISTOSITO
        $base_de_datos=null;
        echo "<script>
                alert('↩️ No tiene permisos para realizar esta operación');
                window.location = 'desactivarSesion.php';
            </script>";
    break;
}