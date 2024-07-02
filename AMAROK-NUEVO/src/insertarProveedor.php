<?php
session_start();
if(!isset($_SESSION['id']) ||
    !isset($_SESSION['username']))
{
    echo "<script>
            localStorage.clear();
            alert('↩️ Debe iniciar sesión para hacer la operación solicitada');
            window.location = 'login.php';
        </script>";
}

if (!isset($_POST["proveenit"])  ||
    !isset($_POST["idciudad"])   ||
    !isset($_POST["proveenom"])  ||
    !isset($_POST["proveedir"])  ||
    !isset($_POST["proveetel"])  ||
    !isset($_POST["proveeema"]))
    {
        echo "<script>
                localStorage.clear();
                alert('❗ Los campos vienen nulos');
                window.history.go(-1);
            </script>";
    }


if (trim($_POST["proveenit"]) === "" ||
    trim($_POST["idciudad"]) === "" ||
    trim($_POST["proveenom"]) === "" ||
    trim($_POST["proveedir"]) === "" ||
    trim($_POST["proveetel"]) === "" ||
    trim($_POST["proveeema"]) === "") 
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
            $proveenit          = trim($_POST["proveenit"]);
            $idciudad           = trim($_POST["idciudad"]);
            $proveenom          = trim($_POST["proveenom"]);
            $proveedir          = trim($_POST["proveedir"]);
            $proveetel          = trim($_POST["proveetel"]);
            $proveeema          = trim($_POST["proveeema"]);
            try{
                $sentencia = $base_de_datos->prepare("SELECT fun_insert_proveedor( ?,?,?,?,?,?,?,? );");
                $sentencia->execute([$proveenit, $idciudad, $proveenom, $proveedir, $proveetel, $proveeema, $usua, $role]);
                $msg = $sentencia->fetchColumn();
                if($msg==='00000')
                {
                    $base_de_datos=null;
                    echo "<script>
                            localStorage.clear();
                            alert('✅ Registro guardado con exito');
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

