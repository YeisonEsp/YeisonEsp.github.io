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

if (!isset($_GET["produccod"]))         //VALIDAR QUE EL CÓDIGO DEL PRODUCTO ESTÉ DEFINIDO Y NO SEA NULO
{
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
    case ($role=='Administrador') || ($role=='Vendedor'):           //VALIDAR QUE SE EJECUTE LO SIGUIENTE SOLO SI ES ADMINISTRADOR O VENDEDOR
        $produccod = $_GET["produccod"];
        try{
            $sentencia = $base_de_datos->prepare("SELECT fun_active_producto( ?,?,? );");
            $sentencia->execute([$produccod, $usua, $role]);                                //QUERY BY EXAMPLE
            $msg = $sentencia->fetchColumn();
            if($msg==='00000')                                      //EVALUACIÓN DE RESULTADO DE LA OPERACIÓN
            {
                echo "<script>
                            localStorage.clear();
                            alert('✅ Registro activado con exito');
                            window.location = 'listarProductos.php';
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
            $excepciones = $sentencia->fetchObject();                   //EN CASO DE EXCEPCIÓN, SE MUESTRA LA CAUSA
            $excep_nombre = $excepciones->excepnom;
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
                    alert('⚠️ Excepcón: $excep_nombre');
                    window.history.go(-1);
                </script>";
        }
    break;

    default:                                                            //SI NO ES NINGÚN ROL PERMITIDO, SE LE CIERRA LA SESIÓN POR CHISTOSITO
        echo "<script>
                localStorage.clear();
                alert('↩️ No tiene permisos para realizar esta operación');
                window.location = 'desactivarSesion.php';
            </script>";
    break;
}