// DECLARAR LAS VARIABLES NECESARIAS PARA LLAMAR LOS DATOS DE LOS FORMULARIOS DE CLIENTES
const formulario = document.getElementById('formulario');                       // ID DEL FORMULARIO
const inputs = document.querySelectorAll('#formulario input');                  // OBTENCION DE TODOS LOS INPUTS
var botonValidarFormulario = document.getElementById('btnValidarForm');         // ID DEL BOTON PARA VALIDAR
// FIN DECLARAR VARIABLES

$(document).ready(function(){
    flechita.removeAttribute("href");
	flechita.setAttribute('href', `listarParametros.php`);
}
);

// EXPRESIONES REGULARES PARA VALIDAR LOS CAMPOS DE LOS FORMULARIOS
const expresiones = {
    nombre: /^.{3,50}$/,
    direccion: /^.{12,70}$/,
    telefono: /^[0-9]{10}$/,
    correo: /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/,
    factura: /^[0-9]{2,9}$/,
    descuento: /^\d{1,4}$/,
    domicilio: /^\d{1,4}$/,
    // password: /^.{6,20}$/
    tiempo: /^[0-9]{1,2}$/
}
// FIN EXPRESIONES REGULARES


// BLOQUE PARA VERIFICAR SI EL ESTADO DE LOS CAMPOS ES / FALSE = ERRONEO \ O / TRUE = CORRECTO \
var campos = {
    emprenom:  true,
    empredir: true,
    empretel: true,
    emprecel: true,
    empreema: true,
    numfacini: true,
    redpundes: true,
    redpundom: true,
    // admincon:  true
    tiemposalir: true
}
// FIN BLOQUE PARA VERIFICACION


// BLOQUE PARA IDENTIFICAR QUE CAMPO SE MODIFICA Y ENVIAR DATOS PARA VALIDARLOS
const validarFormulario = (e) => {
    switch (e.target.name) {                                                    
        case "emprenom":
            validarCampo(expresiones.nombre, e.target, e.target.name);      // SE ENVIA LA EXPRESION DEL BLOQUE "EXPRESIONES REGULARES", SE ENVIA LA ETIQUETA CON SU CONTENIDO COMPLETO Y
        break;                                                              // SE ENVIA EL ATRIBUTO 'name=""' DE LA ETIQUETA SELECIONADA
        case "empredir":
            validarCampo(expresiones.direccion, e.target, e.target.name);   
        break;
        case "empretel":
            validarCampo(expresiones.telefono, e.target, e.target.name);   
        break;
        case "emprecel":
            validarCampo(expresiones.telefono, e.target, e.target.name);   
        break;
        case "empreema":
            validarCampo(expresiones.correo, e.target, e.target.name);   
        break;                                              
        case "numfacini":
            validarCampo(expresiones.factura, e.target, e.target.name);
        break;
        case "redpundes":
            validarCampo(expresiones.descuento, e.target, e.target.name);
        break;
        case "redpundom":
            validarCampo(expresiones.domicilio, e.target, e.target.name);
        break;
        //case "admincon":
          //  validarCampo(expresiones.password, e.target, e.target.name);
        //break;
        case "tiemposalir":
            validarCampo(expresiones.tiempo, e.target, e.target.name);
        break;
    }
    funcionvalidar();
}
// FIN BLOQUE PARA IDENTIFICAR


// LA FUNCIONA VALIDA CADA QUE SE HACE UN CAMBIO Y AL INICIAR PARA QUE EL BOTON SE ACTIVE O DESACTIVE TOMANDO EN CUENTA EL FORMULARIO EN EL QUE ESTA
function funcionvalidar(){
    if(campos.emprenom && campos.empredir && campos.empretel && campos.emprecel && campos.empreema && campos.numfacini && campos.redpundes && campos.redpundom && campos.tiemposalir /*&& campos.admincon*/) {
        botonValidarFormulario.disabled = false;
    } else {
        botonValidarFormulario.disabled = true;
    }
}
// FIN FUNCIONA VALIDAR


// BLOQUE DE VALIDACION CON EL CUAL SE TOMAN LOS DATOS DEL BLOQUE ANTERIOR PARA VALIDAR
const validarCampo = (expresion, input, campo) => {
    if(expresion.test(input.value.trim())){
        document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-incorrecto');
		document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-correcto');
		document.querySelector(`#grupo__${campo} i`).classList.add('bi-check-circle-fill');
		document.querySelector(`#grupo__${campo} i`).classList.remove('bi-x-circle-fill');
		document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.remove('formulario__input-error-activo');
		campos[campo] = true;                                                                                                           // ACTUALIZACIO DEL CAMPO DEL BLOQUE DE VERIFICACION
    } else {
        document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-incorrecto');
		document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-correcto');
		document.querySelector(`#grupo__${campo} i`).classList.add('bi-x-circle-fill');
		document.querySelector(`#grupo__${campo} i`).classList.remove('bi-check-circle-fill');
		document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.add('formulario__input-error-activo');
		campos[campo] = false;                                                                                                         // ACTUALIZACIO DEL CAMPO DEL BLOQUE DE VERIFICACION
    }
}
// FIN BLOQUE DE VALIDACION


// BLOQUE DE "escucha" DE LOS MOVIMIENTOS DEL USUARIO EN LA PAGINA
inputs.forEach((input) => {
    input.addEventListener('keyup', validarFormulario);     // AL LEVANTAR LA TECLA
    input.addEventListener('blur', validarFormulario);      // AL HACER CLICK FUERA DE LOS INPUTS
});
// FIN BLOQUE DE "escucha"