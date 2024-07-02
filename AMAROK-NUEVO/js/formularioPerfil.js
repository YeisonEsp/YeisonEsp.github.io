var inputs = document.querySelectorAll('input');
var select = document.getElementById('idciudad');
var btnEdi = document.getElementById("btn-perfil");					//EXTRACCIÓN DE DATOS DE HTML
var btnAct = document.getElementById("btn-actualizar");
var inputs = document.querySelectorAll('input');
var punt = document.getElementById("clientpun");

const expresiones = {												//REGLAS PARA LOS CAPOS 
	documento: /^([0-9]{8}|[0-9]{10})$/,
	nombre: /^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ]+(?:\s+[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ]+){1,5}(?:\s+[-\sa-zA-ZáéíóúÁÉÍÓÚüÜñÑ]+)?$/,
	direccion: /^.{12,70}$/,
	telefono: /^[0-9]{10}$/,
	correo: /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/,
	password: /^.{8,20}$/
}

const campos = {
	clientdoc: false,
	idciudad: false,
	clientnom: false,												//INICIALIZACIÓN DE CAMPOS EN FALSE
	clientdir: false,
	clienttel: false,
	clientema: false,
	clientcon: false
}

const validarFormulario = (e) => {
	switch (e.target.name) {
		case "clientdoc":
			validarCampo(expresiones.documento, e.target, 'clientdoc');
		break;
		case "idciudad":
            cambioopcion(e.target.name);										//MÉTODO DE VALIDAR FORMULARIO
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
}

const validarCampo = (expresion, input, campo) => {													//MÉTODO PARA VALIDAR LOS CAMPOS
	if(expresion.test(input.valu.trim())){
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
    if(select.value === 'Seleccionar una Ciudad'){
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
	input.addEventListener('keyup', validarFormulario);
	input.addEventListener('blur', validarFormulario);
});

select.addEventListener('change', validarFormulario);       // AL CAMBIAR DE OPCION DENTRO DEL SELECT  
select.addEventListener('blur', validarFormulario);         // AL HACER CLICK FUERA DEL SELECT

btnEdi.addEventListener("click", () => {
    habilitar();
})

function habilitar(){
    btnEdi.hidden = true;
    btnEdi.disabled = true;
    btnAct.hidden = false;
    btnAct.disabled = false;
    inputs.forEach((input) => {
        input.readOnly = false;
    });
    select.disabled = false;
    punt.readOnly = true;
}