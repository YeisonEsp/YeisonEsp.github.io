
<?php
session_start();                        #Activo la sesión
if(!isset($_SESSION['id']) ||
    !isset($_SESSION['username']))      #Si hay sesión activa deja pasar, si no lo manda al login
{
    echo "<script>
            localStorage.clear();
            window.history.go(-1);
        </script>";
}

if (
    !isset($_POST["clientnom"]) ||
    !isset($_POST["idciudad"]) ||
    !isset($_POST["clientdir"]) ||      #Valido que las variables estén definidas y no nulas
    !isset($_POST["clienttel"]) ||
    !isset($_POST["clientema"]) ||
    !isset($_POST["clientdoc"]) 
) {
    echo "<script>
            localStorage.clear();
            window.history.go(-1);
        </script>";
}

if (trim($_POST["clientdoc"]) === "" ||
    trim($_POST["idciudad"]) === "" ||
    trim($_POST["clientnom"]) === "" || 
    trim($_POST["clientdir"]) === "" ||
    trim($_POST["clienttel"]) === "" ||
    trim($_POST["clientema"]) === ""
){
        echo "<script>
            localStorage.clear();
            alert('❕ Debe llenar todos los campos para actualizar sus datos');
            window.history.go(-1);
        </script>";
}else{
    $usua = $_SESSION['id'];
    $role = $_SESSION['username'];          #Asigno a variables el id y username de la sesión

    include_once "conexion.php";            #Incluyo la conexión a la base de datos

    switch(true)    
    {
        case ($role=='Administrador') || ($role=='Vendedor'):   #En caso de que el rol de la sesión sean Administrador o Vendedor
            $clientdoc     = trim($_POST["clientdoc"]);               #hace esta parte del código
            $idciudad      =  trim($_POST["idciudad"]);
            $clientnom     = trim($_POST["clientnom"]);
            $clientdir     = trim($_POST["clientdir"]);               #Asigno a variables los campos que vienen del formulario anterior
            $clienttel     = trim($_POST["clienttel"]);
            $clientema     = trim($_POST["clientema"]);
            try{
                $sentencia = $base_de_datos->prepare("SELECT fun_update_cliente(?,?,?,?,?,?,?,?);");    #Preparo la consulta
                $sentencia->execute([$clientdoc, $idciudad, $clientnom, $clientdir, $clienttel, $clientema, $usua, $role]); #Ejecuto la consulta
                $msg = $sentencia->fetchColumn();   #Obtengo el mensaje que viene de la función
                if($msg==='00000')                  #Si salió bien, hace esta parte del código
                {
                    $base_de_datos=null;
                    echo "<script>
                                localStorage.clear();
                                alert('✅ Registro actualizado con exito');
                                window.location = 'listarClientes.php';
                            </script>";
                }else
                {                                   #En caso de error, mostrará cual fue el error en la función
                    echo "<script>
                            localStorage.clear();
                            alert('❌ Error: $msg');
                            window.history.go(-1);
                        </script>";
                }
            }catch(PDOException $e){
                                                    #En caso de excepción, mostrará cual fue la excepción en la función
                $excepcod = $e->getCode();
                $sentencia = $base_de_datos->prepare("SELECT excepNom from excepciones WHERE excepCod = ?;");
                $sentencia->execute([$excepcod]);
                $excepciones = $sentencia->fetchObject();   #Consulto la bd en la tabla de excepciones, y traigo el código que
                $excep_nombre = $excepciones->excepnom;     #corresponda con el obtenido de la función
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
                                                                            #Si coincide el código, lo mostrará en una alerta
                echo "<script>
                        localStorage.clear();
                        alert('⚠️ Excepción: $excep_nombre');
                        window.history.go(-1);
                    </script>";
            }
        break;

        case ($role=='Cliente'):
            $clientdoc     = $_POST["clientdoc"];
            $idciudad      =  $_POST["idciudad"];
            $clientnom     = $_POST["clientnom"];         #En caso de que el rol sea cliente, hará lo mismo del anterior caso,
            $clientdir     = $_POST["clientdir"];         #solo que enviará al perfil del cliente
            $clienttel     = $_POST["clienttel"];
            $clientema     = $_POST["clientema"];
            try{
                $sentencia = $base_de_datos->prepare("SELECT fun_update_cliente(?,?,?,?,?,?,?,?);");
                $sentencia->execute([$clientdoc, $idciudad, $clientnom, $clientdir, $clienttel, $clientema, $usua, $role]);
                $msg = $sentencia->fetchColumn();
                if($msg==='00000')
                {
                    $base_de_datos=null;
                    echo "<script>
                                alert('✅ Registro actualizado con exito');
                                window.location = 'cliente-perfil.php?clientdoc=$clientdoc';
                            </script>";
                }else
                {
                    echo "<script>
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
                    echo "<script>
                            alert('❗ No existe ninguna excepción con ese código');
                            window.history.go(-1);
                        </script>";
                }
            
                echo "<script>
                        alert('⚠️ Excepción: $excep_nombre');
                        window.history.go(-1);
                    </script>";
            }
        break;

        default:                                        #Si no es ningún de los permitidos, ejecutará esta parte del código
            $base_de_datos=null;
            echo "<script>
                    alert('↩️ No tiene permisos para realizar esta operación');
                    window.location = 'desactivarSesion.php';
                </script>";
        break;
    }
}