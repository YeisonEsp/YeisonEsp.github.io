const formulario = document.getElementById('formulario');                       // ID DEL FORMULARIO
var inputs = document.querySelectorAll('input');
const select = document.getElementById('idciudad');
const formEdi = document.getElementById('formularioEditar');                    // ID PARA VERIFICAR LA VALIDACION DE UN FORMULARIO EN ESPECIFICO
var btnEnviarCliente = document.getElementById('btnEnviarCliente');         // ID DEL BOTON PARA VALIDAR
const formularioreg = document.getElementById('formularioregistrarse');

$(document).ready(function(){
	if (formularioreg === null) {
		flechita.removeAttribute("href");
		flechita.setAttribute('href', `listarClientes.php`);
	}
});

const expresiones = {
	documento: /^([0-9]{8}|[0-9]{10})$/,
	nombre: /^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ]+(?:\s+[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ]+){1,5}(?:\s+[-\sa-zA-ZáéíóúÁÉÍÓÚüÜñÑ]+)?$/,
	direccion: /^.{12,70}$/,
	telefono: /^[0-9]{10}$/,
	correo: /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/,
	password: /^.{8,20}$/
}

// BLOQUE PARA VERIFICAR SI EL ESTADO DE LOS CAMPOS ES / ERRONEO = FALSE \ O / CORRECTO = TRUE \
if(formEdi===null){
    var campos = {
        clientdoc: false,
		idciudad: false,
		clientnom: false,
		clientdir: false,
		clienttel: false,
		clientema: false,
		clientcon: false
    }
    funcionvalidar();
} else {
    var campos = {
        clientdoc: true,
		idciudad: true,
		clientnom: true,
		clientdir: true,
		clienttel: true,
		clientema: true,
		clientcon: true
    }
    funcionvalidar();  
}
// FIN BLOQUE PARA VERIFICACION

const validarFormulario = (e) => {
	switch (e.target.name) {
		case "clientdoc":
			validarCampo(expresiones.documento, e.target, 'clientdoc');
		break;
		case "idciudad":
            cambioopcion(e.target.name);
        break;
		case "clientnom":
			validarCampo(expresiones.nombre, e.target, 'clientnom');
		break;
		case "clientdir":
			validarCampo(expresiones.direccion, e.target, 'clientdir');
		break;
		case "clienttel":
			validarCampo(expresiones.telefono, e.target, 'clienttel');
		break;
		case "clientema":
			validarCampo(expresiones.correo, e.target, 'clientema');
		break;
		case "clientcon":
			validarCampo(expresiones.password, e.target, 'clientcon');
		break;
		case "password2":
			validarPassword2();
		break;
	}
	funcionvalidar();
}

// LA FUNCIONA VALIDA CADA QUE SE HACE UN CAMBIO Y AL INICIAR PARA QUE EL BOTON SE ACTIVE O DESACTIVE TOMANDO EN CUENTA EL FORMULARIO EN EL QUE ESTA
function funcionvalidar(){
    if(formEdi===null){
        if(campos.clientdoc && campos.idciudad && campos.clientnom && campos.clientdir && campos.clienttel && campos.clientema && campos.clientcon) {
            btnEnviarCliente.disabled = false;
        } else {
            btnEnviarCliente.disabled = true;
        }
    }else {
        if(campos.idciudad && campos.clientnom && campos.clientdir && campos.clienttel && campos.clientema) {
            btnEnviarCliente.disabled = false;
        } else {
            btnEnviarCliente.disabled = true;
        }
    }
}
// FIN FUNCIONA VALIDAR

const validarCampo = (expresion, input, campo) => {
	if(expresion.test(input.value.trim())){
		document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-incorrecto');
		document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-correcto');
		document.querySelector(`#grupo__${campo} i`).classList.add('bi-check-circle-fill');
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

const validarPassword2 = () => {
	const inputPassword1 = document.getElementById('clientcon');
	const inputPassword2 = document.getElementById('password2');

	if(inputPassword1.value !== inputPassword2.value){
		document.getElementById(`grupo__password2`).classList.add('formulario__grupo-incorrecto');
		document.getElementById(`grupo__password2`).classList.remove('formulario__grupo-correcto');
		document.querySelector(`#grupo__password2 i`).classList.add('bi-x-circle-fill');
		document.querySelector(`#grupo__password2 i`).classList.remove('bi-check-circle-fill');
		document.querySelector(`#grupo__password2 .formulario__input-error`).classList.add('formulario__input-error-activo');
		campos['clientcon'] = false;
	} else {
		document.getElementById(`grupo__password2`).classList.remove('formulario__grupo-incorrecto');
		document.getElementById(`grupo__password2`).classList.add('formulario__grupo-correcto');
		document.querySelector(`#grupo__password2 i`).classList.remove('bi-x-circle-fill');
		document.querySelector(`#grupo__password2 i`).classList.add('bi-check-circle-fill');
		document.querySelector(`#grupo__password2 .formulario__input-error`).classList.remove('formulario__input-error-activo');
		campos['clientcon'] = true;
	}
}

// BLOQUE DE VALIDACION DEL SELECT
function cambioopcion(campo){
    if(select.value === 'Seleccionar una Ciudad' || select === 'Seleccionar una Ciudad'){
        document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-incorrecto');
		document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-correcto');
		document.querySelector(`#grupo__${campo} i`).classList.add('bi-x-circle-fill');
		document.querySelector(`#grupo__${campo} i`).classList.remove('bi-check-circle-fill');
		document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.add('formulario__input-error-activo');
		campos[campo] = false;                                                                                                         // ACTUALIZACIÓN DEL CAMPO DEL BLOQUE DE VERIFICACION
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

inputs.forEach((input) => {
	input.addEventListener('click', funcionvalidar);
	input.addEventListener('keyup', validarFormulario);
	input.addEventListener('blur', validarFormulario);
});

select.addEventListener('change', validarFormulario);       // AL CAMBIAR DE OPCION DENTRO DEL SELECT  
select.addEventListener('blur', validarFormulario);         // AL HACER CLICK FUERA DEL SELECT