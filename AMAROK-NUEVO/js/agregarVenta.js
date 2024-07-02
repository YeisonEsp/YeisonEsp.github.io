// Declaramos de las etiquetas a usar
const btnMatacho        = document.getElementById('matacho');
const btnAggProd        = document.getElementById('btnAgregarProd')
var cliente             = document.getElementById('clientdoc');
var ciudadInput         = document.getElementById('idciudad');
var btnConti            = document.getElementById('btncontinuar');
var mensa               = document.getElementById('mostrar-mensaje');
var btnvolverven        = document.getElementById('btnvolverventa');
var productoinpt        = document.getElementById('codigo-producto');
var cantidadReq         = document.getElementById('cantreq');
var cajasInputs         = document.querySelectorAll('.contenedor-de-todo input');
var mensajeProducto2    = document.getElementById('mostrar-mensaje-producto');
var mensajeCantidad2    = document.getElementById('mostrar-mensaje-cantidad');
var depa                = document.getElementById('depa');
var ciud                = document.getElementById('ciud');

// Declaramos de las etiquetas a usar

$(document).ready(function(){
        depa.hidden = true;
        ciud.hidden = true;
        depa.disabled = true;
        ciud.disabled = true;
        flechita.removeAttribute("href");
        flechita.setAttribute('href', `listarVentas.php`);
    }
);

// Escuchar los clics en el boton de "Continuar"
btnConti.addEventListener('click', () => {
    existeCliente();
});
// Escuchar el boton de continuar

// Escuchar los clics en el boton de "Volver"
btnvolverven.addEventListener('click', () => {
    btnvolverfuncion()
    
});
// Escuchar los clics en el boton de "Volver"

function btnvolverfuncion(){
    btnConti.hidden = false;
    cliente.disabled = false;
    btnvolverven.hidden = true;
    mensa.hidden = true;
    auxProd = false;
    limpiarTodasCajas();
}

// funcion para limpiar todos los inputs
function limpiarTodasCajas(){
    for (var i = 0; i < 11; i++ ) {

        cajasInputs[i].value = "";
        cajasInputs[i].setAttribute("readonly", "");
    }
    btnMatacho.disabled = true;
    btnAggProd .disabled = true;
    btnCancelarProd.disabled = true;
    productoinpt.setAttribute("readonly", "");
    cliente.removeAttribute("readonly");
    mensajeProducto2.innerHTML = "";
    mensajeCantidad2.innerHTML = "";
    //console.log(cantidadReq);
    cantidadReq.setAttribute("readonly", "");
    //console.log(cantidadReq);
}
// funcion para limpiar todos los inputs

// funcion para validar con el Enter el documento ingresado
function teclaEnter(event){
    if(event.keyCode===13){
        event.preventDefault();
        btnConti.click();
    }
}
cliente.addEventListener('keyup', teclaEnter);
// funcion para validar con el Enter el documento ingresado

// funcion para traer y validar el documento ingresado con la base de datos
function existeCliente(){
    let clientevalor = cliente.value;
    var parametros = {
        'clientdoc': clientevalor
    };
    $.ajax({
        data: parametros,
        url: 'existeCliente.php',
        type: 'POST',  
        dataType:'json', 
        beforesend: function(){
            $('#mostrar-mensaje').html("Mensaje antes de enviar");
        },
        success: function(object){
            if(object==="El cliente no existe ❕" || object==="Cliente inactivo ❕"){
                $('#mostrar-mensaje').html(object);
                mensa.hidden = false;
                cliente.focus();
            } else {
                cliente.setAttribute("readonly", "");
                btnvolverven.hidden = false;
                btnConti.hidden = true; 
                mensa.hidden = true;
                depa.value = object[0]["departnom"];
                ciud.value = object[0]["ciudadnom"];
                ciudadInput.value = object[0]["departnom"] + " - " + object[0]["ciudadnom"];
                productoinpt.removeAttribute("readonly");
                btnMatacho.disabled = false;
                productoinpt.focus();
            }
        },
        
    });
}
// funcion para traer y validar el documento ingresado con la base de datos