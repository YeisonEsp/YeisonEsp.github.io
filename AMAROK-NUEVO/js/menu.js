const openMenu = document.querySelector("#open-menu")
const closeMenu = document.querySelector("#close-menu");
const aside = document.querySelector("aside");
const carritophp = document.getElementById("carritophp");


if(carritophp === null){
    var productosEnCarrito;
    var productosEnCarritoLS    = localStorage.getItem("productos-en-carrito");

    function actualizarNumerito() {
        var nuevoNumerito = productosEnCarrito.reduce((acc, producto) => acc + producto.cantidad, 0);
        numerito.innerText = nuevoNumerito;
    }

    if (productosEnCarritoLS) {
        productosEnCarrito = JSON.parse(productosEnCarritoLS);
        actualizarNumerito();
    } else {
        productosEnCarrito = [];
    }
}



openMenu.addEventListener("click", () => {
    aside.classList.add("aside-visible");
})

closeMenu.addEventListener("click", () => {
    aside.classList.remove("aside-visible");
})

