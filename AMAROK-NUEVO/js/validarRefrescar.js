var cont;
var ubicacion;
let param = document.getElementById('parametro');
var id = document.getElementById('id-usuario').value;
var ro = document.getElementById('rol-usuario').value;
let parammessage = param.value * 60000;
let identificadorIntervaloDeTiempo;
let identificadorIntervaloDeTiempo2;
let paramms = parammessage + 15000;

$(document).ready(function(){
    ubicacion=window.location.pathname;
    avisar();
    validarRefreshF();
    cont = setInterval( function () {
        validarNullF();
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
                }, 2000 );
            }
        }
    });
}

function validarRefreshF(){
    if(localStorage.getItem(ubicacion)==null){
        localStorage.clear();
        localStorage.setItem(ubicacion,'adentro');
    }else{
        clearInterval(cont);
        Swal.fire('↩️ Acción no permitida. Se cerrará la sesión');
        setTimeout( function () {
            window.location = 'desactivarSesion.php';
        }, 2000 );
    }
}

function validarNullF(){
    if(localStorage.getItem(ubicacion)==null){
        clearInterval(cont);
        Swal.fire('↩️ Acción no permitida. Se cerrará la sesión');
        setTimeout( function () {
            window.location = 'desactivarSesion.php';
        }, 2000 );
    }
}

function avisar() {
    ocultarOpciones();
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

function ocultarOpciones(){
    const op_para = document.getElementById('grupo__listarParametros');
    const menu_usua = document.getElementById('menu-usua');
    const menu_pedid = document.getElementById('menu-pe');
    const menu_cont = document.getElementById('menu-cont');
    switch(ro){
        case 'Vendedor':
            menu_usua.hidden = true;
            menu_pedid.hidden = true;
            menu_cont.hidden = true;
            op_para.hidden = true;
            break;
        default:
            break;
    }
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

