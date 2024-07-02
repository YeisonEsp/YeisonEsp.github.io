const btnBuscarProducto     = document.getElementById('matacho');
const btnAgregarProd        = document.getElementById('btnAgregarProd');
const btnCancelarProd       = document.getElementById('cancelarProd');
var cliente2                = document.getElementById('clientdoc');
var productoinpt            = document.getElementById('codigo-producto');
var stockProducto           = document.getElementById('stock-producto');
var nombreProducto          = document.getElementById('nombre-producto');
var cantidadReqProducto     = document.getElementById('cantreq');
var modelo                  = document.getElementById('modelo');                //EXTRACCIÓN DE DATOS DE HTML
var precioUniProducto       = document.getElementById('valpar');
var modelo                  = document.getElementById('modelo');
var precioNetoProducto      = document.getElementById('precio-neto-producto');
var mensajeProducto         = document.getElementById('mostrar-mensaje-producto');
var mensajeCantidad         = document.getElementById('mostrar-mensaje-cantidad');
var cajasInputs2            = document.querySelectorAll('#seccionProducto input')
var auxProd = false;
const variablesValidar = [productoinpt, stockProducto, nombreProducto, modelo, precioUniProducto, precioNetoProducto, inputValorTotal, inputValorpuntos, ciudadInput];
//

btnBuscarProducto.addEventListener('click', () => {
    buscarProducto();
});
// Escuchar los clics en el boton de "buscar producto"

cantidadReqProducto.addEventListener('keyup', () => {
    if (cantidadReqProducto.hasAttribute("readonly")){
        //console.log(cantidadReqProducto)
    }else{
        btnAgregarProd.disabled = true;
        validarStock();
    }
    
})
// Escuchar al levantar la tecla y valida cantidad

productoinpt.addEventListener('keyup', teclaEnter);
// Escuchar al levantar la tecla y el codigo

variablesValidar.forEach(variable => {
    variable.addEventListener('keyup', recargarPaginaVenta)
})
//

btnCancelarProd.addEventListener('click', () => {
    auxProd = false;
    limpiarCajasProd();
    cantidadReqProducto.setAttribute("readonly", "");
    productoinpt.removeAttribute("readonly");
    btnMatacho.disabled = false;
    btnAgregarProd.disabled = true;
    mensajeCantidad.innerHTML = "";
});
// Escuchar al levantar la tecla y enviar accion al btnbuscarprod

// recargar la pagina por culpa de un webon
function recargarPaginaVenta(){
    if(auxProd === true){
        alert('↩️ No intente borrar el dato traído, piense por favor !');
        limpiarCajasProd();
        btnvolverfuncion()
    }
    
}

// limpiar las cajas de la sesión del producto
function limpiarCajasProd(){
    for (var i = 0; i < 7; i++ ) {
        cajasInputs2[i].value = "";
    }
}
// limpiar las cajas de la sesión del producto

// validar el stock actual y realizar calculos
function validarStock(){
    mensajeCantidad.innerHTML = '';
    var stockActual = parseInt(stockProducto.value);
    var cantidadPedida = parseInt(cantidadReqProducto.value);
    if(stockActual <= 0){
        limpiarCajasProd();
    } else if (cantidadPedida <= 0) {
        cantidadReqProducto.value = "";
        precioNetoProducto.value = "";
    } else if (cantidadPedida <= stockActual) {
        precioNetoProducto.value = cantidadPedida * precioUniProducto.value
        btnAgregarProd.disabled = false;
    } else {
        cantidadReqProducto.value = "";
        precioNetoProducto.value = "";
        mensajeCantidad.innerHTML = 'Insuficiente Stock Mano';
    }
}
// validar el stock actual y realizar calculos

// funcion para validar con el Enter el codigo del producto ingresado
function teclaEnter(event){
    if(event.keyCode===13){
        event.preventDefault();
        btnBuscarProducto.click();
    }
}
// funcion para validar con el Enter el codigo del producto ingresado


// funcion para traer y validar el codigo del producto ingresado con la base de datos
function buscarProducto(){
    let productoCodigo = productoinpt.value;
    var parametros = {
        'produccod': productoCodigo
    };
    $.ajax({
        data: parametros,
        url: '../src/existeProducto.php',
        type: 'POST',
        dataType:'json',
        beforesend: function(){
            $('#mostrar-mensaje-producto').html("Mensaje antes de enviar");
        },
        success: function(object){
            if(object==="El producto no existe"){
                $('#mostrar-mensaje-producto').html(object);
                mensajeProducto.hidden = false;
                productoinpt.focus();
                cantidadReqProducto.setAttribute("readonly", "");
            } else {
                limpiarCajasProd();
                mensajeProducto.hidden = true;
                productoinpt.value = object[0]["produccod"];
                stockProducto.value = object[0]["producsto"];
                nombreProducto.value = object[0]["producnom"];
                precioUniProducto.value = object[0]["producpre"];
                modelo.value = object[0]["producmod"];
                cantidadReqProducto.removeAttribute("readonly");
                productoinpt.setAttribute("readonly", "");
                btnMatacho.disabled = true;
                btnCancelarProd.disabled = false;
                auxProd = true;
                cantidadReqProducto.focus();
            }
        },
    });
}
// funcion para traer y validar el codigo del producto ingresado con la base de datos


