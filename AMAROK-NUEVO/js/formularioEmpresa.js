var inputs = document.querySelectorAll('input');

$(document).ready(function(){
    flechita.removeAttribute("href");                           //ESTABLECER EL HREF DE LA FLECHA DE VOLVER
	flechita.setAttribute('href', `listarEmpresas.php`);
}
);

const expresiones = {
    nit: /^[0-9]{10}$/,
    nombre: /^.{4,25}$/,                                        //ESTABLECER REGLAS CON REGEX PARA LOS CAMPOS A VALIDAR
    telefono: /^[0-9]{10}$/                                         
}

const campos = {
    empretranit: false,
    empretranom: false,                                         //INICIALIZAR LOS CAMPOS EN FALSE
    empretratel: false
}

const validarFormulario = (e) => {
    switch (e.target.name) {
        case "empretranit":
            validarCampo(expresiones.nit, e.target, 'empretranit');
        break;
        case "empretranom":                                                     //MÉTODO DE VALIDAR FORMULARIO
            validarCampo(expresiones.nombre, e.target, 'empretranom');
        break;
        case "empretratel":
            validarCampo(expresiones.telefono, e.target, 'empretratel');
        break;
    }
}

const validarCampo = (expresion, input, campo) => {
    if(expresion.test(input.value.trim())){
        document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-incorrecto');
        document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-correcto');
        document.querySelector(`#grupo__${campo} i`).classList.add('bi-check-circle-fill');                 //MÉTODO DE VALIDAR CAMPOS
        document.querySelector(`#grupo__${campo} i`).classList.remove('bi-x-circle-fill');
        document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.remove('formulario__input-error-activo');
        campos[campo] = true;
    } else {
        document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-incorrecto');
        document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-correcto');
        document.querySelector(`#grupo__${campo} i`).classList.add('bi-x-circle-fill');
        document.querySelector(`#grupo__${campo} i`).classList.remove('bi-check-circle-fill');
        document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.add('formulario__input-error-activo');
        campos[campo] = false;
    }
}

inputs.forEach((input) => {
    input.addEventListener('keyup', validarFormulario);                                     //EVENTOS DE ESCUCHA DE LOS INPUTS
    input.addEventListener('blur', validarFormulario);
});