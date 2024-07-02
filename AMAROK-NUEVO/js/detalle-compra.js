const rutabase = '../images/Imagenes_Repuestos/';
let rutacompleta;
const ContenedorDetalleCompras      = document.getElementById("contendor-detalle-compra")
const contenedorDetComprasVacio     = document.getElementById("detalle-compra-vacio")                   //EXTRACCIÓN DE DATOS DE HTML
const templateDetCompras            = document.getElementById("template-detalle-compra").content
const fragmentDetCompras            = document.createDocumentFragment()

let detalleventa = {};

function cargarDetalleVenta(){
    let ventaid = document.getElementById("vent").value;
    var parametros = {
        'codventa': ventaid                                                    //CARGA DEL DETALLE DE LA COMPRA DEL CLIENTE
    };
    $.ajax({
        data: parametros,
        url: '../src/traerDetalleCompra.php',
        type: 'POST',  
        dataType:'json', 
        beforesend: function(){
            $('#mostrar-mensaje').html("Mensaje antes de enviar");
        },
        success: function(object){
            if(object==="CompraSinDetalle"){
                contenedorDetComprasVacio.classList.remove("disabled");
                ContenedorDetalleCompras.classList.add("disabled");
            } else{
                contenedorDetComprasVacio.classList.add("disabled");
                ContenedorDetalleCompras.classList.remove("disabled");
                detalleventa = object;
                pintarDetalleCompra();
            }
        },
    });
}

cargarDetalleVenta()

const pintarDetalleCompra = () => {
    ContenedorDetalleCompras.innerHTML = '';
    Object.values(detalleventa).forEach(detcompras =>{
        // Obtener la referencia al elemento de imagen
        let imagenRepuesto = templateDetCompras.querySelector('.carrito-producto-imagen');
        rutacompleta = rutabase + detcompras.produccod + '.jpg'
        // Asignar la ruta de la imagen a la propiedad src
        imagenRepuesto.src = rutacompleta;
        templateDetCompras.querySelector('.nombre-detcompras').textContent = detcompras.producnom
        templateDetCompras.querySelector('.canti-detcompras').textContent = detcompras.detventacan              //PINTAR LOS CAMPOS EN EL CONTENEDOR CORRESPONDIENTE
        templateDetCompras.querySelector('.preci-detcompras').textContent = detcompras.precioproduc
        templateDetCompras.querySelector('.descu-detcompras').textContent = detcompras.detventades
        templateDetCompras.querySelector('.valpar-detcompras').textContent = detcompras.detventavalpar
        const clone = templateDetCompras.cloneNode(true)
        fragmentDetCompras.appendChild(clone)
    })
    ContenedorDetalleCompras.appendChild(fragmentDetCompras)    
}