// DECLARAR LAS VARIABLES NECESARIAS PARA LLAMAR LOS DATOS DE LOS FORMULARIOS DE CLIENTES
const formulario = document.getElementById('formulario');                       // ID DEL FORMULARIO
const formEdi = document.getElementById('formularioEditar');                    // ID PARA VERIFICAR LA VALIDACION DE UN FORMULARIO EN ESPECIFICO
const inputs = document.querySelectorAll('#formulario input');                  // OBTENCION DE TODOS LOS INPUTS
const select = document.getElementById('idciudad');                             // ID DEL SELECT PARA VALIDAR
var botonValidarFormulario = document.getElementById('btnValidarForm');         // ID DEL BOTON PARA VALIDAR
// FIN DECLARAR VARIABLES

$(document).ready(function(){
    flechita.removeAttribute("href");
	flechita.setAttribute('href', `listarProveedores.php`);
}
);

// EXPRESIONES REGULARES PARA VALIDAR LOS CAMPOS DE LOS FORMULARIOS
const expresiones = {
    nit: /^[0-9]{10}$/,
    nombre: /^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ]+(?:\s+[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ]+){1,5}(?:\s+[-\sa-zA-ZáéíóúÁÉÍÓÚüÜñÑ]+)?$/,
    direccion: /^.{12,68}$/,
    telefono: /^[0-9]{10}$/,
    correo: /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/
}
// FIN EXPRESIONES REGULARES


// BLOQUE PARA VERIFICAR SI EL ESTADO DE LOS CAMPOS ES / FALSE = ERRONEO \ O / TRUE = CORRECTO \
if(formEdi===null){
    var campos = {
        proveenit: false,
        idciudad:  false,
        proveenom: false,
        proveedir: false,
        proveetel: false,
        proveeema: false
    }
    funcionvalidar();
} else {
    var campos = {
        proveenit: true,
        idciudad:  true,
        proveenom: true,
        proveedir: true,
        proveetel: true,
        proveeema: true
    }
    funcionvalidar();  
}
// FIN BLOQUE PARA VERIFICACION


// BLOQUE PARA IDENTIFICAR QUE CAMPO SE MODIFICA Y ENVIAR DATOS PARA VALIDARLOS
const validarFormulario = (e) => {
    switch (e.target.name) {
        case "proveenit":
            validarCampo(expresiones.nit, e.target, e.target.name);   // SE ENVIA LA EXPRESION DEL BLOQUE "EXPRESIONES REGULARES", SE ENVIA LA ETIQUETA CON SU CONTENIDO COMPLETO Y
        break;                                                              // SE ENVIA EL ATRIBUTO 'name=""' DE LA ETIQUETA SELECIONADA
        case "idciudad":
            cambioopcion(e.target.name);
        break;
        case "proveenom":
            validarCampo(expresiones.nombre, e.target, e.target.name);
        break;
        case "proveedir":
            validarCampo(expresiones.direccion, e.target, e.target.name);
        break;
        case "proveetel":
            validarCampo(expresiones.telefono, e.target, e.target.name);
        break;
        case "proveeema":
            validarCampo(expresiones.correo, e.target, e.target.name);
        break;
    }
    funcionvalidar();
}
// FIN BLOQUE PARA IDENTIFICAR


// LA FUNCIONA VALIDA CADA QUE SE HACE UN CAMBIO Y AL INICIAR PARA QUE EL BOTON SE ACTIVE O DESACTIVE TOMANDO EN CUENTA EL FORMULARIO EN EL QUE ESTA
function funcionvalidar(){
    if(formEdi===null){
        if(campos.proveenit && campos.idciudad && campos.proveenom && campos.proveedir && campos.proveetel && campos.proveeema) {
            botonValidarFormulario.disabled = false;
        } else {
            botonValidarFormulario.disabled = true;
        }
    }else {
        if(campos.idciudad && campos.proveenom && campos.proveedir && campos.proveetel && campos.proveeema) {
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


// BLOQUE DE VALIDACION DEL SELECT
function cambioopcion(campo){
    if(select.value === 'Seleccionar una Ciudad' || select === 'Seleccionar una Ciudad'){
        document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-incorrecto');
		document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-correcto');
		document.querySelector(`#grupo__${campo} i`).classList.add('bi-x-circle-fill');
		document.querySelector(`#grupo__${campo} i`).classList.remove('bi-check-circle-fill');
		document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.add('formulario__input-error-activo');
		campos[campo] = false;                                                                                                        // ACTUALIZACIÓN DEL CAMPO DEL BLOQUE DE VERIFICACION
    }else{
        document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-incorrecto');
		document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-correcto');
		document.querySelector(`#grupo__${campo} i`).classList.add('bi-check-circle-fill');
		document.querySelector(`#grupo__${campo} i`).classList.remove('bi-x-circle-fill');
		document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.remove('formulario__input-error-activo');
		campos[campo] = true;
    }
}
// FIN BLOQUE DE VALIDACION DEL SELECT


// BLOQUE DE "escucha" DE LOS MOVIMIENTOS DEL USUARIO EN LA PAGINA
inputs.forEach((input) => {
    input.addEventListener('click', funcionvalidar);
    input.addEventListener('keyup', validarFormulario);     // AL LEVANTAR LA TECLA
    input.addEventListener('blur', validarFormulario);      // AL HACER CLICK FUERA DE LOS INPUTS
});

select.addEventListener('change', validarFormulario);       // AL CAMBIAR DE OPCION DENTRO DEL SELECT  
select.addEventListener('blur', validarFormulario);         // AL HACER CLICK FUERA DEL SELECT
// FIN BLOQUE DE "escucha"
