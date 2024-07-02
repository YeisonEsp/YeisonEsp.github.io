/*var anteriorl;
var urll;*/

$(document).ready(function(){
    localStorage.clear();
    $.ajax({
        url: 'desactivarSesion.php',
    });
    let btnIniciar = document.getElementById("iniciar");
    let usuario = document.getElementById('use');
    let contrase = document.getElementById('con');
    btnIniciar.addEventListener('click', e =>{
        e.preventDefault();
        if(usuario.value.trim() !== "" && contrase.value.trim() !==""){
            // Genera un texto aleatorio de 10 caracteres
            let textoAleatorio1 = generarTextoAleatorio(100);
            let textoAleatorio2 = generarTextoAleatorio(50);
            let contraMd5 = CryptoJS.MD5(contrase.value);
            contraMd5 = textoAleatorio1 + contraMd5 + textoAleatorio2;
            let parametros = {
                'use': usuario.value,
                'con':  contraMd5 
            };
            $.ajax({
                data: parametros,
                url: 'loginProcess.php',
                type: 'POST',
                dataType:'text',
        
                success: function(mensaje){
                    switch(mensaje){
                        case "✔️ Todo bien admin":
                            window.location = 'listarVentas.php';
                            break;
                        case "✔️ Todo bien vendedor":
                            window.location = 'agregarVenta.php';
                            break;
                        case "✔️ Todo bien":
                            window.location = 'homeCliente.php';
                            break;
                        default:
                            usuario.focus();
                            contrase.value = null;
                            usuario.value = null;
                            Swal.fire({
                                position: "top",
                                title: mensaje,
                                showConfirmButton: false,
                                timer: 5000,
                            });
                            break;
                    }
                }
            });
        }else{
            Swal.fire({
                position: "top",
                title: "❕ Debe ingresar las credenciales",
                showConfirmButton: false,
                timer: 3000,
            });
        }
    });
    
}
);

function generarTextoAleatorio(longitud) {
    var caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var texto = '';

    for (var i = 0; i < longitud; i++) {
        var indice = Math.floor(Math.random() * caracteres.length);
        texto += caracteres.charAt(indice);
    }

    return texto;
}


/*anteriorl=document.referrer;
    if(anteriorl==""){
        console.log('Morimos');
        //localStorage.clear();

    }else{
        anteriorl = new URL(anteriorl);
        urll = anteriorl.pathname;
        console.log(urll);
    }*/