const botonesCategorias     = document.querySelectorAll(".boton-categoria");
let botonesAgregar          = document.querySelectorAll(".producto-agregar");
const cuerpoDocumento       = document.getElementById('contenedor-productos')
const templateProductos     = document.getElementById('template-productos').content         //EXTRACCIÓN DE DATOS DE HTML
// Obtén referencia al selector de categorías y contenedor de productos
const filtroCategoria = document.getElementById('filtro-categoria');
const contenedorProductos   = document.querySelector("#contenedor-productos");
const tituloPrincipal       = document.querySelector("#titulo-principal");
const numerito              = document.querySelector("#numerito");
const rutabase = '../images/Imagenes_Repuestos/';
let rutacompleta;
const fragmentProductpos    = document.createDocumentFragment()

let productosC = {};

function cargarProductos(){
    $.ajax({
        url: 'traerProductos.php',
        type: 'POST',  
        dataType:'json',                                                                    //CARGA DE PRODUCTOS EN EL CONTENEDOR CORRESPONDIENTE
        beforesend: function(){
            $('#mostrar-mensaje').html("Mensaje antes de enviar");
        },
        success: function(object){
            productosC = object;
            pintarProductos()
        },
        
    });
}

cargarProductos()

const pintarProductos = () => {
    cuerpoDocumento.innerHTML = '';
    const categoriaSeleccionada = filtroCategoria.value;
    console.log(categoriaSeleccionada);
    const productosFiltrados = categoriaSeleccionada === 'todos' ?
        productosC : // Mostrar todos los productos si se selecciona 'todos'
        productosC.filter(producto => producto.tipoproid === categoriaSeleccionada);
    productosFiltrados.forEach(producto => {
        // Clonar el template de productos
        const clone = templateProductos.cloneNode(true);
        
        // Configurar los elementos del template con los datos del producto actual
        const imagenRepuesto = clone.querySelector('.producto-imagen');
        rutacompleta = rutabase + producto.produccod + '.jpg';
        imagenRepuesto.src = rutacompleta;
        clone.querySelector('.producto-titulo').textContent = producto.producnom;
        clone.querySelector('.producto-precio').textContent = producto.producpre + " COP";
        clone.querySelector('.producto-stock').textContent = producto.producsto;
        clone.querySelector('.producto-agregar').id = producto.produccod;

        // Agregar el clon al fragmento de productos
        fragmentProductpos.appendChild(clone);
    });

    // Agregar todos los productos al cuerpo del documento
    cuerpoDocumento.appendChild(fragmentProductpos);

    // Actualizar los botones de agregar al carrito después de cargar los productos
    actualizarBotonesAgregar();
}

filtroCategoria.addEventListener('change', pintarProductos);


botonesCategorias.forEach(boton => boton.addEventListener("click", () => {
    aside.classList.remove("aside-visible");
}))


botonesCategorias.forEach(boton => {
    boton.addEventListener("click", (e) => {

        botonesCategorias.forEach(boton => boton.classList.remove("active"));
        e.currentTarget.classList.add("active");

        // para alguien del futuro
        // para validar las categorias se puede tomar la categoria por base de datos y comprarlo con el futuro select de categorias
        // esto "producto => producto.categoria.id" quedaria sin el id y el "e.currentTarget.id"

        if (e.currentTarget.id != "todos") {
            const productoCategoria = productos.find(producto => producto.categoria.id === e.currentTarget.id);
            tituloPrincipal.innerText = productoCategoria.categoria.nombre;
            const productosBoton = productos.filter(producto => producto.categoria.id === e.currentTarget.id);
            cargarProductos(productosBoton);
        } else {
            tituloPrincipal.innerText = "REPUESTOS";
            cargarProductos(productos);
        }

    })
});


function actualizarBotonesAgregar() {
    botonesAgregar = document.querySelectorAll(".producto-agregar");

    botonesAgregar.forEach(boton => {
        boton.addEventListener("click", agregarAlCarrito);
    });
}


if (productosEnCarritoLS) {
    productosEnCarrito = JSON.parse(productosEnCarritoLS);
    actualizarNumerito();
} else {
    productosEnCarrito = [];
}


function agregarAlCarrito(e) {

    Toastify({
        text: "Producto agregado",
        duration: 3000,
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
        style: {
            background: "linear-gradient(to right, #c6c6fc, #ffffff)",
            color: "#333",
            fontWeight: "bold",
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
    const productoAgregado = productosC.find(producto => producto.produccod === idBoton);

    
    if(productosEnCarrito.some(producto => producto.produccod === idBoton)) {
        const index = productosEnCarrito.findIndex(producto => producto.produccod === idBoton);
        productosEnCarrito[index].cantidad++;
    } else {
        productoAgregado.cantidad = 1;
        productosEnCarrito.push(productoAgregado);
    }
    actualizarNumerito();
    localStorage.setItem("productos-en-carrito", JSON.stringify(productosEnCarrito));
}

function actualizarNumerito() {
    let nuevoNumerito = productosEnCarrito.reduce((acc, producto) => acc + producto.cantidad, 0);
    numerito.innerText = nuevoNumerito;
}