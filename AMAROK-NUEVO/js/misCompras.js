const contenedorComprasVacio    = document.getElementById("compras-cliente-vacio")
const ContenedorComprasProducto = document.getElementById("compras-cliente-productos")          //EXTRACCIÓN DE DATOS DEL HTML
const templateMisCompras        = document.getElementById("template-compras-cliente").content
const fragmentMisCompras        = document.createDocumentFragment()

let misCompras = {};

function cargarCompras(){                                                                       //FUNCIÓN PARA CARGAR LAS COMPRAS CORRESPONDIENTES AL CLIENTE
    let clienteid = document.getElementById("id-usuario").value;
    var parametros = {
        'clientdoc': clienteid
    };
    $.ajax({
        data: parametros,
        url: '../src/traerComprasCliente.php',                                                  //OBTENCIÓN DE COMPRAS
        type: 'POST',  
        dataType:'json', 

        success: function(object){
            if(object==="ClienteSinVentas"){
                contenedorComprasVacio.classList.remove("disabled");
                ContenedorComprasProducto.classList.add("disabled");
            } else{
                contenedorComprasVacio.classList.add("disabled");
                ContenedorComprasProducto.classList.remove("disabled");
                misCompras = object;
                pintarMisCompras();
            }
        },
    });
}

cargarCompras()

const pintarMisCompras = () => {
    ContenedorComprasProducto.innerHTML = '';
    Object.values(misCompras).forEach(compras =>{
        if(compras.ventarec == false){
            templateMisCompras.querySelector('.numero-compras').textContent = "----"
            templateMisCompras.querySelector('.estado-compras').classList.add('estado-compras-no');         //PINTAR LAS COMPRAS EN EL CONTENEDOR CORRESPONDIENTE
            templateMisCompras.querySelector('.estado-compras').textContent = "SIN PAGO"
        } else {
            templateMisCompras.querySelector('.numero-compras').textContent = compras.ventanum
            templateMisCompras.querySelector('.estado-compras').classList.remove('estado-compras-no');
            templateMisCompras.querySelector('.estado-compras').textContent = "PAGADA"
        }
        templateMisCompras.querySelector('.fecha-compras').textContent = compras.fechacompra
        templateMisCompras.querySelector('.total-compras').textContent = compras.total
        templateMisCompras.querySelector('.carrito-producto-eliminar').setAttribute('href', `detalle-compra.php?ventanum=${compras.ventanum}`)
        const clone = templateMisCompras.cloneNode(true)
        fragmentMisCompras.appendChild(clone)
    })
    ContenedorComprasProducto.appendChild(fragmentMisCompras)
    
}