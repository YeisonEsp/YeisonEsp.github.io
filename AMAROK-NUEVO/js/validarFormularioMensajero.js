// DECLARAR LAS VARIABLES NECESARIAS PARA LLAMAR LOS DATOS DE LOS FORMULARIOS DE CLIENTES
const formulario = document.getElementById('formulario');                       // ID DEL FORMULARIO
const formEdi = document.getElementById('formEditMensa');                    // ID PARA VERIFICAR LA VALIDACION DE UN FORMULARIO EN ESPECIFICO
const inputs = document.querySelectorAll('#formulario input');                  // OBTENCION DE TODOS LOS INPUTS
var botonValidarFormulario = document.getElementById('btnValidarForm');         // ID DEL BOTON PARA VALIDAR
// FIN DECLARAR VARIABLES


// EXPRESIONES REGULARES PARA VALIDAR LOS CAMPOS DE LOS FORMULARIOS
const expresiones = {
    documento: /^([0-9]{8}|[0-9]{10})$/,
    nombre: /^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ]+(?:\s+[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ]+){1,5}(?:\s+[-\sa-zA-ZáéíóúÁÉÍÓÚüÜñÑ]+)?$/,
    direccion: /^.{12,68}$/,
    telefono: /^[0-9]{10}$/,
    correo: /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/,
    password: /^.{6,20}$/
}
// FIN EXPRESIONES REGULARES


// BLOQUE PARA VERIFICAR SI EL ESTADO DE LOS CAMPOS ES / FALSE = ERRONEO \ O / TRUE = CORRECTO \
if(formEdi===null){
    var campos = {
        mensajdoc: false,
        mensajnom: false,
        mensajdir: false,
        mensajtel: false,
        mensajema: false,
        mensajcon: false
    }
    funcionvalidar();
} else {
    var campos = {
        mensajdoc: true,
        mensajnom: true,
        mensajdir: true,
        mensajtel: true,
        mensajema: true,
        mensajcon: true
    }
    funcionvalidar();  
}
// FIN BLOQUE PARA VERIFICACION


// BLOQUE PARA IDENTIFICAR QUE CAMPO SE MODIFICA Y ENVIAR DATOS PARA VALIDARLOS
const validarFormulario = (e) => {
    switch (e.target.name) {
        case "mensajdoc":
            validarCampo(expresiones.documento, e.target, e.target.name);   // SE ENVIA LA EXPRESION DEL BLOQUE "EXPRESIONES REGULARES", SE ENVIA LA ETIQUETA CON SU CONTENIDO COMPLETO Y
        break;                                                              // SE ENVIA EL ATRIBUTO 'name=""' DE LA ETIQUETA SELECIONADA
        case "mensajnom":
            validarCampo(expresiones.nombre, e.target, e.target.name);
        break;
        case "mensajdir":
            validarCampo(expresiones.direccion, e.target, e.target.name);
        break;
        case "mensajtel":
            validarCampo(expresiones.telefono, e.target, e.target.name);
        break;
        case "mensajema":
            validarCampo(expresiones.correo, e.target, e.target.name);
        break;
        case "mensajcon":
            validarCampo(expresiones.password, e.target, e.target.name);
        break;
    }
    funcionvalidar();
}
// FIN BLOQUE PARA IDENTIFICAR


// LA FUNCIONA VALIDA CADA QUE SE HACE UN CAMBIO Y AL INICIAR PARA QUE EL BOTON SE ACTIVE O DESACTIVE TOMANDO EN CUENTA EL FORMULARIO EN EL QUE ESTA
function funcionvalidar(){
    if(formEdi===null){
        if(campos.mensajdoc && campos.mensajnom && campos.mensajdir && campos.mensajtel && campos.mensajema && campos.mensajcon) {
            botonValidarFormulario.disabled = false;
        } else {
            botonValidarFormulario.disabled = true;
        }
    }else {
        if(campos.mensajnom && campos.mensajdir && campos.mensajtel && campos.mensajema && campos.mensajcon) {
            botonValidarFormulario.disabled = false;
        } else {
            botonValidarFormulario.disabled = true;
        }
    }
}
// FIN FUNCIONA VALIDAR


// BLOQUE DE VALIDACION CON EL CUAL SE TOMAN LOS DATOS DEL BLOQUE ANTERIOR PARA VALIDAR
const validarCampo = (expresion, input, campo) => {
    if(expresion.test(input.value.trim())){
        document.querySelector(`#grupo-${campo}-mensajero .formulario-texto-error`).classList.remove('formulario-texto-error-active');    // CLASE PARA QUE SE QUITE EL MENSAJE DE ERROR
        campos[campo] = true;                                                                                                           // ACTUALIZACIO DEL CAMPO DEL BLOQUE DE VERIFICACION
    } else {
        document.querySelector(`#grupo-${campo}-mensajero .formulario-texto-error`).classList.add('formulario-texto-error-active');       // CLASE PARA QUE SE AÑADA EL MENSAJE DE ERROR
        campos[campo] = false;                                                                                                          // ACTUALIZACIO DEL CAMPO DEL BLOQUE DE VERIFICACION
    }
}
// FIN BLOQUE DE VALIDACION


// BLOQUE DE "escucha" DE LOS MOVIMIENTOS DEL USUARIO EN LA PAGINA
inputs.forEach((input) => {
    input.addEventListener('click', funcionvalidar);
    input.addEventListener('keyup', validarFormulario);     // AL LEVANTAR LA TECLA
    input.addEventListener('blur', validarFormulario);      // AL HACER CLICK FUERA DE LOS INPUTS
});

select.addEventListener('change', validarFormulario);       // AL CAMBIAR DE OPCION DENTRO DEL SELECT  
select.addEventListener('blur', validarFormulario);         // AL HACER CLICK FUERA DEL SELECT
// FIN BLOQUE DE "escucha"
