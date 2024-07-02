// traerParametros.php
const imagenuno = document.getElementById("imagenuno")
const imagendos = document.getElementById("imagendos")
const imagentres = document.getElementById("imagentres")
const imagencuatro = document.getElementById("imagencuatro")
const preciouno = document.getElementById("preciouno")
const preciodos = document.getElementById("preciodos")
const preciotres = document.getElementById("preciotres")
const preciocuatro = document.getElementById("preciocuatro")
const nombreuno = document.getElementById("nombreuno")
const nombredos = document.getElementById("nombredos")
const nombretres = document.getElementById("nombretres")
const nombrecuatro = document.getElementById("nombrecuatro")
const carruseluno = document.getElementById("carruseluno")
const carruseldos = document.getElementById("carruseldos")
const carruseltres = document.getElementById("carruseltres")
const rutabase = './images/Imagenes_Repuestos/';
let rutacompleta;

function mostrarproductos(){
    $.ajax({
        url: 'src/traerProductos.php',
        type: 'POST',  
        dataType:'json', 
        beforesend: function(){
            $('#mostrar-mensaje').html("Mensaje antes de enviar");
        },
        success: function(object){
            rutacompleta = rutabase + object[0]["produccod"] + '.jpg'            
            imagenuno.src = rutacompleta;
            rutacompleta = rutabase + object[1]["produccod"] + '.jpg'            
            imagendos.src = rutacompleta;
            rutacompleta = rutabase + object[2]["produccod"] + '.jpg'            
            imagentres.src = rutacompleta;
            rutacompleta = rutabase + object[3]["produccod"] + '.jpg'            
            imagencuatro.src = rutacompleta;
            preciouno.textContent = object[0]["producpre"] + " COP"
            preciodos.textContent = object[1]["producpre"] + " COP"
            preciotres.textContent = object[2]["producpre"] + " COP"
            preciocuatro.textContent = object[3]["producpre"] + " COP"
            nombreuno.textContent = object[0]["producnom"]
            nombredos.textContent = object[1]["producnom"]
            nombretres.textContent = object[2]["producnom"]
            nombrecuatro.textContent = object[3]["producnom"]
            rutacompleta = rutabase + object[4]["produccod"] + '.jpg'            
            carruseluno.src = rutacompleta;
            rutacompleta = rutabase + object[5]["produccod"] + '.jpg'            
            carruseldos.src = rutacompleta;
            rutacompleta = rutabase + object[6]["produccod"] + '.jpg'            
            carruseltres.src = rutacompleta;
        },
        
    });
}
mostrarproductos()