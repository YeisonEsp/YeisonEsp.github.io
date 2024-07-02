<?php

if(!isset($_POST["idciudad"]))          //VALIDAR QUE EL ID DE LA CIUDAD ESTÉ DEFINIDO Y NO SEA NULO
{
    echo "<script>
            localStorage.clear();
            alert('❕ Debe seleccionar una ciudad!');
            window.history.go(-1);
        </script>";
}

if (!isset($_POST["clientdoc"])  ||
    !isset($_POST["idciudad"])   ||
    !isset($_POST["clientnom"])  ||
    !isset($_POST["clientdir"])  ||
    !isset($_POST["clienttel"])  ||
    !isset($_POST["clientema"])  ||
    !isset($_POST["clientcon"]))        //VALIDAR QUE LOS CAMPOS ESTÉN DEFINIDOS Y NO SEAN NULOS
{
    echo "<script>
            localStorage.clear();
            window.history.go(-1);
        </script>";
}

session_start();

if (trim($_POST["clientdoc"]) === "" ||
    trim($_POST["idciudad"]) === "" ||
    trim($_POST["clientnom"]) === "" || 
    trim($_POST["clientdir"]) === "" ||
    trim($_POST["clienttel"]) === "" ||
    trim($_POST["clientema"]) === "" ||
    trim($_POST["clientcon"]) === "")         //VALIDAR QUE LOS CAMPOS NO VENGAN EN BLANCO
{
    echo "<script>
            localStorage.clear();
            alert('❕ Debe llenar todos los campos para poder guardar el registro');
            window.history.go(-1);
        </script>";
}else{
    if(isset($_SESSION['id']) ||
        isset($_SESSION['username']))
    {
        $usua = $_SESSION['id'];
        $role = $_SESSION['username'];
    }else
    {
        $usua = $_POST["clientdoc"];
        $role = 'Cliente';
    }
}

include_once "conexion.php";

switch(true)    
{
    case ($role=='Administrador') || ($role=='Vendedor'):   #En caso de que el rol de la sesión sean Administrador o Vendedor
    $clientdoc          = trim($_POST["clientdoc"]);
    $idciudad           = trim($_POST["idciudad"]);
    $clientnom          = trim($_POST["clientnom"]);
    $clientdir          = trim($_POST["clientdir"]);
    $clienttel          = trim($_POST["clienttel"]);
    $clientema          = trim($_POST["clientema"]);
    $clientcon          = trim($_POST["clientcon"]);    
        try{
            $sentencia = $base_de_datos->prepare("SELECT fun_insert_cliente(?, ?, ?, ?, ?, ?, ?, ?, ?);");    #Preparo la consulta
            $sentencia->execute([$clientdoc, $idciudad, $clientnom, $clientdir, $clienttel, $clientema, $clientcon, $usua, $role]); #Ejecuto la consulta
            $msg = $sentencia->fetchColumn();   #Obtengo el mensaje que viene de la función
            if($msg==='00000')                  #Si salió bien, hace esta parte del código
            {
                $base_de_datos=null;
                echo "<script>
                        localStorage.clear();
                        alert('✅ Registro guardado con exito');
                        window.location = 'listarClientes.php';
                    </script>";
            }else
            {    
                                            #En caso de error, mostrará cual fue el error en la función
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
                echo "¡No existe ninguna excepción con ese código!";    #Si no existe, queda en blanco la página
                exit();
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
        $clientcon          = $_POST["clientcon"];
        try{
            $sentencia = $base_de_datos->prepare("SELECT fun_insert_cliente(?, ?, ?, ?, ?, ?, ?, ?, ?);");
            $sentencia->execute([$clientdoc, $idciudad, $clientnom, $clientdir, $clienttel, $clientema, $clientcon, $usua, $role]);
            $msg = $sentencia->fetchColumn();
            if($msg==='00000')
            {
                $base_de_datos=null;
                echo "<script>
                            alert('✅ Registro guardado con exito');
                            window.location = 'loginCliente.php';
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
                echo "¡No existe ninguna excepción con ese código!";
                exit();
            }
        
            echo "<script>
                    alert('⚠️ Excepción: $excep_nombre');
                    window.history.go(-1);
                </script>";
        }
    break;

    default:                                      #Si no es ningún de los permitidos, ejecutará esta parte del código
        $base_de_datos=null;
        echo "<script>
				localstorage.clear();
				alert('↩️ No tiene permisos para realizar esta operación');
				window.history.go(-1);
			</script>";
    break;
}
