// DECLARAR LAS VARIABLES NECESARIAS PARA LLAMAR LOS DATOS DE LOS FORMULARIOS DE CLIENTES
const formulario = document.getElementById('formulario');                       // ID DEL FORMULARIO
const formEdi = document.getElementById('formularioEditar');                    // ID PARA VERIFICAR LA VALIDACION DE UN FORMULARIO EN ESPECIFICO
const inputs = document.querySelectorAll('#formulario input');                  // OBTENCION DE TODOS LOS INPUTS
const select = document.getElementById('iddepart');                             // ID DEL SELECT PARA VALIDAR
const inputciu = document.getElementById('ciudadid');
var botonValidarFormulario = document.getElementById('btnValidarForm');         // ID DEL BOTON PARA VALIDAR
// FIN DECLARAR VARIABLES

$(document).ready(function(){
    flechita.removeAttribute("href");
	flechita.setAttribute('href', `listarCiudades.php`);
}
);

// EXPRESIONES REGULARES PARA VALIDAR LOS CAMPOS DE LOS FORMULARIOS
const expresiones = {
    nombre: /^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ\s]+$/,
    preciodom: /^[0-9]{0,5}$/
}
// FIN EXPRESIONES REGULARES


// BLOQUE PARA VERIFICAR SI EL ESTADO DE LOS CAMPOS ES / FALSE = ERRONEO \ O / TRUE = CORRECTO \
if(formEdi===null){
    var campos = {
        ciudadnom: false,
        iddepart: false,
        preciodom: false
    }
    funcionvalidar();
} else {
    var campos = {
        ciudadnom: true,
        iddepart: true,
        preciodom: true
    }
    funcionvalidar();  
}
// FIN BLOQUE PARA VERIFICACION


// BLOQUE PARA IDENTIFICAR QUE CAMPO SE MODIFICA Y ENVIAR DATOS PARA VALIDARLOS
const validarFormulario = (e) => {
    switch (e.target.name) {
        case "ciudadnom":
            validarCampo(expresiones.nombre, e.target, e.target.name);      // SE ENVIA LA EXPRESION DEL BLOQUE "EXPRESIONES REGULARES", SE ENVIA LA ETIQUETA CON SU CONTENIDO COMPLETO Y
        break;                                                              // SE ENVIA EL ATRIBUTO 'name=""' DE LA ETIQUETA SELECIONADA
        case "iddepart":
            cambioopcion(e.target.name);
        break;
        case "preciodom":
            validarCampo(expresiones.preciodom, e.target, e.target.name);
        break;
    }
    funcionvalidar();
}
// FIN BLOQUE PARA IDENTIFICAR


// LA FUNCIONA VALIDA CADA QUE SE HACE UN CAMBIO Y AL INICIAR PARA QUE EL BOTON SE ACTIVE O DESACTIVE TOMANDO EN CUENTA EL FORMULARIO EN EL QUE ESTA
function funcionvalidar(){
    if(formEdi===null){
        if(campos.ciudadnom && campos.iddepart && campos.preciodom) {
            botonValidarFormulario.disabled = false;
        } else {
            botonValidarFormulario.disabled = true;
        }
    }else {
        if(campos.ciudadnom && campos.iddepart && campos.preciodom) {
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
		campos[campo] = true;                                                                                                          // ACTUALIZACIO DEL CAMPO DEL BLOQUE DE VERIFICACION
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
    if(select.value === 'Seleccionar un Departamento' || select === 'Seleccionar un Departamento'){
        document.getElementById(`grupo__${campo}`).classList.add('formulario__grupo-incorrecto');
		document.getElementById(`grupo__${campo}`).classList.remove('formulario__grupo-correcto');
		document.querySelector(`#grupo__${campo} i`).classList.add('bi-x-circle-fill');
		document.querySelector(`#grupo__${campo} i`).classList.remove('bi-check-circle-fill');
		document.querySelector(`#grupo__${campo} .formulario__input-error`).classList.add('formulario__input-error-activo');
		campos[campo] = false;                                                                                                           // ACTUALIZACIO DEL CAMPO DEL BLOQUE DE VERIFICACION
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

inputciu.addEventListener('keyup', recargarPagina); 


function recargarPagina(){
    alert('↩️ No intente borrar el dato traído, piense por favor !');
    location.reload();
}
// FIN BLOQUE DE "escucha"
