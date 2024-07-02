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

if (!isset($_POST["proveenit"]) ||
    !isset($_POST["proveenom"]) ||
    !isset($_POST["idciudad"]) ||
    !isset($_POST["proveedir"]) ||
    !isset($_POST["proveetel"]) ||
    !isset($_POST["proveeema"])         //VALIDAR QUE LOS CAMPOS ESTÉN DEFINIDOS Y NO SEAN NULOS
) {
    echo "<script>
            localStorage.clear();
            alert('❗ Los campos vienen nulos');
            window.history.go(-1);
        </script>";
}

$usua = $_SESSION['id'];
$role = $_SESSION['username'];

include_once "conexion.php";

switch(true)
{
    case ($role=='Administrador') || ($role=='Vendedor'):       //VALIDAR QUE SE EJECUTE LO SIGUIENTE SOLO SI ES ADMINISTRADOR O VENDEDOR          
        $proveenit     = trim($_POST["proveenit"]);
        $idciudad     = trim($_POST["idciudad"]);
        $proveenom     = trim($_POST["proveenom"]);
        $proveedir     = trim($_POST["proveedir"]);
        $proveetel     = trim($_POST["proveetel"]);
        $proveeema     = trim($_POST["proveeema"]);
        try{
            $sentencia = $base_de_datos->prepare("SELECT fun_update_proveedor(?,?,?,?,?,?,?,?);");      //QUERY BY EXAMPLE
            $sentencia->execute([$proveenit, $idciudad, $proveenom, $proveedir, $proveetel, $proveeema, $usua, $role]);
            $msg = $sentencia->fetchColumn();
            if($msg==='00000')                          //EVALUACIÓN DE RESULTADO DE LA OPERACIÓN
            {
                $base_de_datos=null;
                echo "<script>
                            localStorage.clear();
                            alert('✅ Registro actualizado con exito');
                            window.location = 'listarProveedores.php';
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
            $excepciones = $sentencia->fetchObject();
            $excep_nombre = $excepciones->excepnom;                 //EN CASO DE EXCEPCIÓN, SE MUESTRA LA CAUSA
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

    default:                                        //SI NO ES NINGÚN ROL PERMITIDO, SE LE CIERRA LA SESIÓN POR CHISTOSITO
        $base_de_datos=null;
        echo "<script>
                alert('↩️ No tiene permisos para realizar esta operación');
                window.location = 'desactivarSesion.php';
            </script>";
    break;
}