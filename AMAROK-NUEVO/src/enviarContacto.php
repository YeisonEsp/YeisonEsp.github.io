<?php

if (!isset($_POST["nombre"]) ||
    !isset($_POST["telefono"]) ||
    !isset($_POST["email"]) ||
    !isset($_POST["descripcion"]))          //VALIDAR QUE LOS CAMPOS ESTÉN DEFINIDOS Y NO SEAN NULOS
{
    echo "<script>
            alert('❕Los campos no están definidos');
            window.history.go(-1);
        </script>";
}

if ($_POST["nombre"] === "" ||
    $_POST["telefono"] === "" ||
    $_POST["email"] === "" || 
    $_POST["descripcion"] === "")           //VALIDAR QUE LOS CAMPOS NO ESTÉN EN BLANCO
{
    echo "<script>
            alert('❕Debe llenar todos los campos para enviar el mensaje');
            window.history.go(-1);
        </script>";
}else
{
    include_once "conexion.php";

    $nombre     = $_POST["nombre"];
    $telefono     = $_POST["telefono"];
    $email     = $_POST["email"];
    $descrip     = $_POST["descripcion"];


    try{
        $sentencia = $base_de_datos->prepare("SELECT fun_insert_contactenos(?,?,?,?);");        //QUERY BY EXAMPLE
        $sentencia->execute([$nombre, $telefono, $email, $descrip]);
        $msg = $sentencia->fetchColumn();                               //EVALUACIÓN DE RESULTADO DE LA OPERACIÓN
        if($msg==='00000')
        {
            echo "<script>
                        alert('✅ Enviado con exito');
                        window.location = '../';
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
        $excep_nombre = $excepciones->excepnom;             //EN CASO DE EXCEPCIÓN, SE MUESTRA LA CAUSA
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
}

