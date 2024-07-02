var cont;
let param = document.getElementById('parametro');
var id = document.getElementById('id-usuario').value;
var ro = document.getElementById('rol-usuario').value;
let parammessage = param.value * 60000;
let identificadorIntervaloDeTiempo;
let identificadorIntervaloDeTiempo2;
let paramms = parammessage + 15000;

$(document).ready(function(){
    avisar();
    cont = setInterval( function () {
        indicadorSesion();
    }, 5000 )
}
);

function indicadorSesion(){
    var id = document.getElementById('id-usuario').value;
    var ro = document.getElementById('rol-usuario').value;
    var parametros = {
        'rol': ro,
        'id':  id 
    };

    $.ajax({
        data: parametros,
        url: 'sesionActiva.php',
        type: 'POST',
        dataType:'text',

        success: function(mensaje){
            if(mensaje!==""){
                clearInterval(cont);
                Swal.fire(mensaje);
                setTimeout( function () {
                    window.location = 'desactivarSesion.php';
                }, 3000 );
            }
        }
    });
}

function avisar() {
    identificadorIntervaloDeTiempo = setTimeout(mandarMensaje, parammessage);
    sacar();
    document.addEventListener('click', function(event){
        clearTimeout(identificadorIntervaloDeTiempo);
        clearTimeout(identificadorIntervaloDeTiempo2);
        identificadorIntervaloDeTiempo = setTimeout(mandarMensaje, parammessage);
        sacar();
    });
    document.addEventListener('mousemove', function(event){
        clearTimeout(identificadorIntervaloDeTiempo);
        clearTimeout(identificadorIntervaloDeTiempo2);
        identificadorIntervaloDeTiempo = setTimeout(mandarMensaje, parammessage);
        sacar();
    });
}

function mandarMensaje() {
    Swal.fire(param.value + " minutos de inactividad. Su sesión se cerrará si no navega por el sistema en los próximos 15 segundos!.");
}

function sacar() {
    identificadorIntervaloDeTiempo2 = setTimeout(redirigir, paramms);
}

function redirigir(){
    window.location = './desactivarSesion.php';
}

