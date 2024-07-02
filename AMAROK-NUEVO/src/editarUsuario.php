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
    !isset($_POST["usuarionom"]) ||
    !isset($_POST["usuariodir"]) ||
    !isset($_POST["usuariotel"]) ||
    !isset($_POST["usuarioema"]) ||
    !isset($_POST["usuariodoc"]) ||
    !isset($_POST["usuariorol"])            //VALIDAR QUE LOS DATOS ESTÉN DEFINIDOS Y NO SEAN NULOS
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
    case ($role=='Administrador'):                              //VALIDAR QUE SE EJECUTE LO SIGUIENTE SOLO SI ES ADMINISTRADOR
        $usuariodoc     = trim($_POST["usuariodoc"]);
        $usuariorol     = trim($_POST["usuariorol"]);
        $usuarionom     = trim($_POST["usuarionom"]);
        $usuariodir     = trim($_POST["usuariodir"]);
        $usuariotel     = trim($_POST["usuariotel"]);
        $usuarioema     = trim($_POST["usuarioema"]);
        try{
            $sentencia = $base_de_datos->prepare("SELECT fun_update_usuario(?,?,?,?,?,?,?,?);");        //QUERY BY EXAMPLE
            $sentencia->execute([$usuariodoc, $usuariorol, $usuarionom, $usuariodir, $usuariotel, $usuarioema, $usua, $role]);
            $msg = $sentencia->fetchColumn();
            if($msg==='00000')                                      //EVALUACIÓN DE RESULTADO DE LA OPERACIÓN
            {
                $base_de_datos=null;
                echo "<script>
                        localStorage.clear();
                        alert('✅ Registro actualizado con exito');
                        window.location = 'listarUsuarios.php';
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
            $excep_nombre = $excepciones->excepnom;             //EN CASO DE EXCEPCIÓN, SE MUESTRA LA CAUSA
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