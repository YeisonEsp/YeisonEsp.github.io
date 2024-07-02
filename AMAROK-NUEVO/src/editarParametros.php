
<?php
session_start();                            //INICIALIZAR SESIÓN
if(!isset($_SESSION['id']) ||
    !isset($_SESSION['username']))          //VALIDAR QUE LOS DATOS DE LA SESIÓN ESTÉN DEFINIDOS Y NO ESTÉN NULOS
{
    echo "<script>
            localStorage.clear();
            window.history.go(-1);
        </script>";
}

if (
    !isset($_POST["emprenom"]) ||
    !isset($_POST["empredir"]) ||
    !isset($_POST["empretel"]) ||
    !isset($_POST["emprecel"]) ||
    !isset($_POST["empreema"]) ||
    !isset($_POST["numfacini"]) ||
    !isset($_POST["redpundes"]) ||
    !isset($_POST["redpundom"]) ||
    !isset($_POST["tiemposalir"]) ||
    !isset($_POST["emprenit"])              //VALIDAR QUE LOS CAMPOS ESTÉN DEFINIDOS Y NO SEAN NULOS
) {
    echo "<script>
            localStorage.clear();
            window.history.go(-1);
        </script>";
}

if (trim($_POST["emprenit"]) === "" ||
    trim($_POST["emprenom"])=== "" ||
    trim($_POST["empredir"]) === "" ||
    trim($_POST["empretel"]) === "" ||
    trim($_POST["emprecel"]) === "" ||
    trim($_POST["empreema"]) === "" ||
    trim($_POST["numfacini"]) === "" ||
    trim($_POST["redpundes"]) === "" ||
    trim($_POST["redpundom"]) === "" ||
    trim($_POST["tiemposalir"]) === "" )         //VALIDAR QUE LOS CAMPOS NO ESTÉN EN BLANCO
{
    echo "<script>
            localStorage.clear();
            alert('❕ Debe llenar todos los campos, exceptuando la contraseña');
            window.history.go(-1);
        </script>";
}else{
    $usua = $_SESSION['id'];
    $role = $_SESSION['username'];

    include_once "conexion.php";

    switch(true)
    {
        case ($role=='Administrador'):                  //VALIDAR QUE SE EJECUTE LO SIGUIENTE SOLO SI ES ADMINISTRADOR O VENDEDOR
            $emprenit     = trim($_POST["emprenit"]);
            $emprenom     = trim($_POST["emprenom"]);
            $empredir     = trim($_POST["empredir"]);
            $empretel     = trim($_POST["empretel"]);
            $emprecel     = trim($_POST["emprecel"]);
            $empreema     = trim($_POST["empreema"]);
            $numfacini     = trim($_POST["numfacini"]);
            $redpundes     = trim($_POST["redpundes"]);
            $redpundom     = trim($_POST["redpundom"]);
            $tiemposalir     = trim($_POST["tiemposalir"]);
            if(trim($_POST["admincon"])!==""){
                $admincon     = md5($_POST["admincon"]);
            }else{
                $admincon     = $_POST["admincon"];
            }
            try{
                $sentencia = $base_de_datos->prepare("SELECT fun_update_parametros(?,?,?,?,?,?,?,?,?,?,?,?,?);");       //QUERY BY EXAMPLE
                $sentencia->execute([$emprenit, $emprenom, $empredir, $empretel, $emprecel, $empreema,$numfacini, $redpundes, $redpundom, $tiemposalir, $admincon, $usua, $role]);
                $msg = $sentencia->fetchColumn();
                if($msg==='00000')                              //EVALUACIÓN DE RESULTADO DE LA OPERACIÓN
                {
                    $base_de_datos=null;
                    echo "<script>
                                localStorage.clear();
                                alert('✅ Registro actualizado con exito');
                                window.location = 'listarParametros.php';
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
                $excep_nombre = $excepciones->excepnom;         //EN CASO DE EXCEPCIÓN, SE MUESTRA LA CAUSA
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
}