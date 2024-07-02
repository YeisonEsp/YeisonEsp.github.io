<?php

if (!isset($_POST["usuariodoc"])  ||
    !isset($_POST["usuariorol"])  ||
    !isset($_POST["usuarionom"])  ||
    !isset($_POST["usuariodir"])  ||
    !isset($_POST["usuariotel"])  ||
    !isset($_POST["usuarioema"])  ||
    !isset($_POST["usuariocon"]))
{
    echo "<script>
            localStorage.clear();
            alert('❗ Los campos vienen nulos');
            window.history.go(-1);
        </script>";
}

if (trim($_POST["usuariodoc"]) === "" ||
    trim($_POST["usuariorol"]) === "" ||
    trim($_POST["usuarionom"]) === "" ||
    trim($_POST["usuariodir"]) === "" ||
    trim($_POST["usuariotel"]) === "" ||
    trim($_POST["usuarioema"]) === "" ||
    trim($_POST["usuariocon"]) === "") 
{
    echo "<script>
            localStorage.clear();
            alert('❗ Debe llenar todos los campos');
            window.history.go(-1);
        </script>";
}else{
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

    $usua = $_SESSION['id'];
    $role = $_SESSION['username'];
    include_once "conexion.php";

    switch(true)
    {
        case ($role=='Administrador'):
            $usuariodoc          = trim($_POST["usuariodoc"]);
            $usuariorol          = trim($_POST["usuariorol"]);
            $usuarionom          = trim($_POST["usuarionom"]);
            $usuariodir          = trim($_POST["usuariodir"]);
            $usuariotel          = trim($_POST["usuariotel"]);
            $usuarioema          = trim($_POST["usuarioema"]);
            $usuariocon          = trim($_POST["usuariocon"]);
            try{
                $sentencia = $base_de_datos->prepare("SELECT fun_insert_usuario(?, ?, ?, ?, ?, ?, ?, ?, ?);");
                $sentencia->execute([$usuariodoc, $usuariorol, $usuarionom, $usuariodir, $usuariotel, $usuarioema, $usuariocon, $usua, $role]);
                $msg = $sentencia->fetchColumn();
                if($msg==='00000')
                {
                    echo "<script>
                            localStorage.clear();
                            alert('✅ Registro guardado con exito');
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
                    alert('⚠️ Excepción: $excep_nombre');
                    window.history.go(-1);
                </script>";
            }
        break;

        default:
            echo "<script>
                    alert('↩️ No tiene permisos para realizar esta operación');
                    window.location = 'login.php';
                </script>";
        break;
    }
}
