<?php
session_start();                    //INICIALIZAR SESIÓN
if(!isset($_SESSION['id']) ||
    !isset($_SESSION['username']))
{
    echo "<script>
            localStorage.clear();
            alert('↩️ Debe iniciar sesión para hacer la operación solicitada');
            window.location = 'login.php';
        </script>";
}

if (!isset($_POST["empretranit"])  ||
    !isset($_POST["empretranom"])  ||
    !isset($_POST["empretratel"]))
    {
        echo "<script>
                localStorage.clear();
                alert('❗ Los campos vienen nulos');
                window.history.go(-1);
            </script>";
    }


if (trim($_POST["empretranit"]) === "" ||
    trim($_POST["empretranom"]) === "" ||
    trim($_POST["empretratel"]) === "") 
{
    echo "<script>
            localStorage.clear();
            alert('❗ Debe llenar todos los campos');
            window.history.go(-1);
        </script>";
}else{
    $usua = $_SESSION['id'];
    $role = $_SESSION['username'];
    include_once "conexion.php";

    switch(true)
    {
        case ($role=='Administrador') || ($role=='Vendedor'):
            $empretranit      = trim($_POST["empretranit"]);
            $empretranom      = trim($_POST["empretranom"]);
            $empretratel      = trim($_POST["empretratel"]);
            try{
                $sentencia = $base_de_datos->prepare("SELECT fun_insert_empresa( ?,?,?,?,? );");
                $sentencia->execute([$empretranit, $empretranom, $empretratel, $usua, $role]);
                $msg = $sentencia->fetchColumn();
                if($msg==='00000')
                {
                    $base_de_datos=null;
                    echo "<script>
                            localStorage.clear();
                            alert('✅ Registro guardado con exito');
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
                $excepciones = $sentencia->fetchObject();
                $excep_nombre = $excepciones->excepnom;
                $base_de_datos=null;
                if (!$excepciones)
                {
                    #No existe
                    echo "¡No existe ninguna excepción con ese código!";
                    exit();
                }
            
                echo "<script>
                    localStorage.clear();
                    alert('⚠️ Excepción: $excep_nombre');
                    window.history.go(-1);
                </script>";
            }
        break;

        default:
            $base_de_datos=null;
            echo "<script>
                    alert('↩️ No tiene permisos para realizar esta operación');
                    window.location = 'login.php';
                </script>";
        break;
    }
}

