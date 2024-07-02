var productosEnCarrito = localStorage.getItem("productos-en-carrito");
productosEnCarrito = JSON.parse(productosEnCarrito);

const contenedorCarritoVacio = document.querySelector("#carrito-vacio");
const contenedorCarritoProductos = document.querySelector("#carrito-productos");
const contenedorCarritoAcciones = document.querySelector("#carrito-acciones");
const contenedorCarritoComprado = document.querySelector("#carrito-comprado");              //EXTRACCIÓN DE DATOS DE HTML
let botonesEliminar = document.querySelectorAll(".carrito-producto-eliminar");
const botonVaciar = document.querySelector("#carrito-acciones-vaciar");
const contenedorTotal = document.querySelector("#total");
const botonComprar = document.querySelector("#carrito-acciones-comprar");

var sql = '';
var p = 0;

function cargarProductosCarrito() {
    if (productosEnCarrito && productosEnCarrito.length > 0) {

        contenedorCarritoVacio.classList.add("disabled");
        contenedorCarritoProductos.classList.remove("disabled");
        contenedorCarritoAcciones.classList.remove("disabled");                             //CARGA DE PRODUCTOS SELECCIONADOS EN EL CARRITO
        contenedorCarritoComprado.classList.add("disabled");
    
        contenedorCarritoProductos.innerHTML = "";
    
        productosEnCarrito.forEach(producto => {
            var producp = producto.producpre.slice(1);
            producp = producp.replace(",","");
            const div = document.createElement("div");
            div.classList.add("carrito-producto");
            div.innerHTML = `
                <img class="carrito-producto-imagen" src="../images/Imagenes_Repuestos/${producto.produccod}.jpg" alt="${producto.producnom}">
                <div class="carrito-producto-titulo">
                    <small>Nombre</small>
                    <h3>${producto.producnom}</h3>
                </div>
                <div class="carrito-producto-cantidad">
                    <small>Cantidad</small>
                    <p>${producto.cantidad}</p>
                </div>
                <div class="carrito-producto-precio">
                    <small>Precio_Unitario</small>
                    <p>$${new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'COP', minimumFractionDigits: 0}).format(
                        producp,
                    )}</p>
                </div>
                <div class="carrito-producto-subtotal">
                    <small>Subtotal</small>
                    <p>$${new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'COP', minimumFractionDigits: 0}).format(
                        parseInt(producp) * producto.cantidad,
                    )}</p>
                </div>
                <button class="carrito-producto-eliminar" id="${producto.produccod}"><i class="bi bi-trash-fill"></i></button>
            `;
    
            contenedorCarritoProductos.append(div);
        })
    
    actualizarBotonesEliminar();
    actualizarTotal();
	
    } else {
        contenedorCarritoVacio.classList.remove("disabled");
        contenedorCarritoProductos.classList.add("disabled");
        contenedorCarritoAcciones.classList.add("disabled");
        contenedorCarritoComprado.classList.add("disabled");
    }
}

cargarProductosCarrito();

function actualizarBotonesEliminar() {
    botonesEliminar = document.querySelectorAll(".carrito-producto-eliminar");

    botonesEliminar.forEach(boton => {
        boton.addEventListener("click", eliminarDelCarrito);
    });
}

function eliminarDelCarrito(e) {
    Toastify({
        text: "Producto eliminado",
        duration: 3000,
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
        style: {
            background: "linear-gradient(to right, #860000, #ab0000)",
            borderRadius: "2rem",
            textTransform: "uppercase",
            fontSize: ".75rem"
        },
        offset: {
            x: '1.5rem', // horizontal axis - can be a number or a string indicating unity. eg: '2em'
            y: '1.5rem' // vertical axis - can be a number or a string indicating unity. eg: '2em'
        },
        onClick: function(){} // Callback after click
    }).showToast();

    const idBoton = e.currentTarget.id;
    const index = productosEnCarrito.findIndex(producto => producto.produccod === idBoton);
    
    productosEnCarrito.splice(index, 1);
    cargarProductosCarrito();

    localStorage.setItem("productos-en-carrito", JSON.stringify(productosEnCarrito));

}

botonVaciar.addEventListener("click", vaciarCarrito);
function vaciarCarrito() {

    Swal.fire({
        title: '¿Estás seguro?',
        icon: 'question',
        html: `Se van a borrar ${productosEnCarrito.reduce((acc, producto) => acc + producto.cantidad, 0)} productos.`,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: 'Sí',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            productosEnCarrito.length = 0;
            localStorage.setItem("productos-en-carrito", JSON.stringify(productosEnCarrito));
            cargarProductosCarrito();
        }
    })
}


function actualizarTotal() {
    const totalCalculado = productosEnCarrito.reduce((acc, producto) => acc + (parseInt(producto.producpre.slice(1).replace(",","")) * producto.cantidad), 0);
    total.innerText = `$${new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'COP', minimumFractionDigits: 0}).format(
        totalCalculado,
    )}`;
}

botonComprar.addEventListener("click", comprarCarrito);
function comprarCarrito() {                                             //EVENTO DE ESCUCHA DEL BOTÓN COMPRAR

    window.location = 'metodoEnvio.php';                                //SE REDIRECCIONA AL USUARIO HACIA EL PHP CORRESPONDIENTE
}

function extraerDatos(){
    sql = 'SELECT fun_insert_venta_cliente(';
    sql+= "'" + id + "'";

    Object.values(productosEnCarrito).forEach(producto =>{
        switch(p)
        {
            case 0:                                                     //EXTRACCIÓN DE DATOS PARA FORMAR CONSULTA SQL
                sql += ", ARRAY[" + "'" + producto.produccod + "'";
                p++;
            break;
            case 1:
                sql += "," + "'" + producto.produccod + "'";
            break;
        } 
    });

    p=0;

    Object.values(productosEnCarrito).forEach(producto =>{
        switch(p)
        {
            case 0:
                sql += "], ARRAY[" + producto.cantidad;
                p++;
            break;
            case 1:
                sql += "," + producto.cantidad;
            break;
        } 
    });
    sql+= "]);";

    //console.log(sql);
}