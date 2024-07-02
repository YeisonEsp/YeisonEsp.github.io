// DECLARAR LAS VARIABLES NECESARIAS PARA LLAMAR LOS DATOS DE LOS FORMULARIOS DE CLIENTES
const inputtel              = document.getElementById('grupo__telefono');
const inputs                = document.querySelectorAll('#request input');  // OBTENCION DE TODOS LOS INPUTS
var botonEnviarFormulario   = document.getElementById('request');           // ID DEL BOTON PARA VALIDAR
var asuntodes               = document.getElementById('grupo__descripcion');
// FIN DECLARAR VARIABLES

// EXPRESIONES REGULARES PARA VALIDAR LOS CAMPOS DE LOS FORMULARIOS
const expresiones = {
    nombre: /^(?:[A-Za-záéíóúñ0-9\s])*[A-Za-záéíóúñ0-9\s]{4,25}$/,    ///^(?:[\p{L}\p{N}]\s*){4,25}$/,
    telefono: /^[0-9]{10}$/,
    correo: /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/
}
// FIN EXPRESIONES REGULARES

// BLOQUE PARA VERIFICAR SI EL ESTADO DE LOS CAMPOS ES / FALSE = ERRONEO \ O / TRUE = CORRECTO \
var campos = {
    nombre: false,
    telefono:  false,
    email: false,
    descripcion: false
}
// FIN BLOQUE PARA VERIFICACION

// BLOQUE PARA IDENTIFICAR QUE CAMPO SE MODIFICA Y ENVIAR DATOS PARA VALIDARLOS
const validarFormulario = (e) => {
    switch (e.target.name) {
        case "nombre":
            validarCampo(expresiones.nombre, e.target, e.target.name);         // SE ENVIA LA EXPRESION DEL BLOQUE "EXPRESIONES REGULARES", SE ENVIA LA ETIQUETA CON SU CONTENIDO COMPLETO Y
        break;                                                              // SE ENVIA EL ATRIBUTO 'name=""' DE LA ETIQUETA SELECIONADA
        case "telefono":
            validarCampo(expresiones.telefono, e.target, e.target.name);
        break;
        case "email":
            validarCampo(expresiones.correo, e.target, e.target.name);
        break;
        case "descripcion":
            validarl(e.target.name);
        break;
    }
}
// FIN BLOQUE PARA IDENTIFICAR

// LA FUNCIONA VALIDA CADA QUE SE HACE UN CAMBIO Y AL INICIAR PARA QUE EL BOTON SE ACTIVE O DESACTIVE TOMANDO EN CUENTA EL FORMULARIO EN EL QUE ESTA
botonEnviarFormulario.addEventListener('submit', (e) =>{
    if(campos.nombre && campos.telefono && campos.email && campos.descripcion) {
        botonValidarFormulario.disabled = false;
    } else {
        e.preventDefault();
        Swal.fire({
            position: "top-start",
            title: "❕ Debe rellenar los campos correctamente",
            showConfirmButton: false,
            timer: 3000,
        });
    }
});
// FIN FUNCIONA VALIDAR

// BLOQUE DE VALIDACION CON EL CUAL SE TOMAN LOS DATOS DEL BLOQUE ANTERIOR PARA VALIDAR
const validarCampo = (expresion, input, campo) => {
    if(expresion.test(input.value.trim())){
        document.getElementById(`grupo__${campo}`).classList.remove('contactuserror');
		document.getElementById(`grupo__${campo}`).classList.add('contactus');
        console.log(document.getElementById(`grupo__${campo}_error`))
        document.getElementById(`grupo__${campo}_error`).classList.remove('mensajerrorin');
        document.getElementById(`grupo__${campo}_error`).classList.add('mensajecorrecin');
		campos[campo] = true;                                                                                                           // ACTUALIZACIO DEL CAMPO DEL BLOQUE DE VERIFICACION
    } else {
        document.getElementById(`grupo__${campo}`).classList.add('contactuserror');
		document.getElementById(`grupo__${campo}`).classList.remove('contactus');
        document.getElementById(`grupo__${campo}_error`).classList.add('mensajerrorin');
        document.getElementById(`grupo__${campo}_error`).classList.remove('mensajecorrecin');
		campos[campo] = false;                                                                                                         // ACTUALIZACIO DEL CAMPO DEL BLOQUE DE VERIFICACION
    }
}
// FIN BLOQUE DE VALIDACION

// BLOQUE DE VALIDACION DE LONGITUD DEL INPUT DEL ASUNTO
function validarl(campo){
    if(asuntodes.value.length >= 4){
        document.getElementById('grupo__descripcion').classList.remove('contactusmesserror');
		document.getElementById('grupo__descripcion').classList.add('contactusmess');
        document.getElementById(`grupo__${campo}_error`).classList.remove('mensajerrorin');
        document.getElementById(`grupo__${campo}_error`).classList.add('mensajecorrecin');
        campos[campo] = true;
    }else{
        document.getElementById('grupo__descripcion').classList.add('contactusmesserror');
		document.getElementById('grupo__descripcion').classList.remove('contactusmess');
        document.getElementById(`grupo__${campo}_error`).classList.add('mensajerrorin');
        document.getElementById(`grupo__${campo}_error`).classList.remove('mensajecorrecin');
        campos[campo] = false;
    }
}
// FIN BLOQUE VALIDACION LONGITUD


//
function validarmaximo(event){
    const input = document.getElementById('grupo__telefono');
    if (input.value.length > 10) {
        input.event.preventDefault();
        // input.value = input.value.substring(0, 10); // Limita el valor a maxLength caracteres
        
    }
}
//

// BLOQUE DE "escucha" DE LOS MOVIMIENTOS DEL USUARIO EN LA PAGINA
inputs.forEach((input) => {
    input.addEventListener('keyup', validarFormulario);     // AL LEVANTAR LA TECLA
    input.addEventListener('blur', validarFormulario);      // AL HACER CLICK FUERA DE LOS INPUTS
});

inputtel.addEventListener('keypress', function() {
  if (this.value.length > 9) {
    this.value = this.value.substring(0, 9); // Limita el valor a maxLength caracteres
  }
});
// FIN BLOQUE DE "escucha"