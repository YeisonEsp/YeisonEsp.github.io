const seccionProducto   = document.getElementById('seccionProducto');
const fragment          = document.createDocumentFragment();
const cantreq           = document.getElementById('cantreq');
const preuni            = document.getElementById('valpar');
const cuerpoTabla       = document.getElementById('cuerpo-tabla');
const footerTabla       = document.getElementById('pie-tabla');
const inputValorTotal   = document.getElementById('valor-total');
const inputValorpuntos  = document.getElementById('puntos-obtener');
const btnAgregarProd2   = document.getElementById('btnAgregarProd')
var btnvolverven2       = document.getElementById('btnvolverventa');            //EXTRACCIÓN DE DATOS DEL HTML
var btnfinalizar        = document.getElementById('finalizar');
const templateFooter    = document.getElementById('template-footer').content;
const templateCarrito   = document.getElementById('template-carrito').content;
var stockProducto       = document.getElementById('stock-producto');
var docum               = document.getElementById('clientdoc');
var tipopago            = document.getElementById('tipopago');
var depa                = document.getElementById('depa');
var ciud                = document.getElementById('ciud');
var usr                 = document.getElementById('usr');
var rol                 = document.getElementById('rol');
var codi                = document.getElementById('codigo-producto');

var archivoInput             = document.getElementById("archivo");
var btnEntrega          = document.getElementById('dom');

let carrito = {};
var verificarStock;
var sql = '';                   //VARIABLES GLOBALES
var p = 0;
var formData;

btnEntrega.addEventListener('click', () => {
    $('#exampleModal').modal('show');
});

btnfinalizar.addEventListener('click', (e) => {                     //EVENTO DE ESCUCHA DEL BOTÓN FINALIZAR
    e.preventDefault();
    if(tipopago.value === "Seleccione una opcion" || tipopago === "Seleccione una opción"){
        alert("❕ Seleccione un método de pago");
    }else{
        if(Object.keys(carrito).length <= 0){
            alert("❕ Debe agregar productos para comprar");                                //VALIDACIONES CORRESPONDIENTES PARA EJECUTAR LA OPERACIÓN
        }else{
            extraerArchivo();
            let metodoRetiro = document.getElementById("modoEntrega").value;
            if(metodoRetiro === "tienda"){
                extraerDatos();
            }else{
                if(!extraerDatosDomi()){
                    return;
                }
            }
            registrarVenta();
        }
    }
});

function extraerArchivo(){
    var archivo = archivoInput.files[0]; // Obtener el primer archivo seleccionado
    formData = new FormData(); // Crear un objeto FormData para enviar datos

    formData.append('tipopago', tipopago.value); // Agregar el tipo de pago al FormData
    formData.append('archivo', archivo); // Agregar el archivo al FormData
}

function registrarVenta(){
    $.ajax({
        data: formData,
        url: 'insertarVenta.php',
        type: 'POST',
        contentType: false, // Importante: no establecer contentType a false para FormData
        processData: false, // Importante: no procesar datos para FormData
        dataType:'text',

        success: function(mensaje){
            sql = '';
            p = 0;
            Swal.fire({
                position: "top-end",
                title: mensaje,
                showConfirmButton: false,
                timer: 3000,
            });
            if(mensaje==="✅ Venta guardada con éxito"){
                setTimeout(function () {
                    window.location = 'listarVentas.php';
                }, 3000);
            }
        }
    });
}

function extraerDatosDomi(){                                                //FORMACIÓN DE CONSULTA SQL PARA ENVIAR EN CASO DE DOMICILIO
    let domici = true;                                                  
    let ciudad = document.getElementById('idCiudad');
    let docu = document.getElementById('documento').value;
    let nombre = document.getElementById('nombre').value;
    let telefono = document.getElementById('telefono').value;
    let direccion = document.getElementById('direccion').value;
    if(ciudad.value.trim()===""||docu.trim()===""||nombre.trim()===""||direccion.trim()===""||telefono.trim()===""){
        alert('❕ Rellene los datos del domicilio por favor');
        return false;
    }else{
        sql = 'SELECT fun_insert_venta(';
        sql+= "'" + docum.value.trim() + "'," + "'" +  depa.value + "'," + "'" + ciud.value 
        + "'," + "'" +  tipopago.value + "'," + inputValorpuntos.value.trim();
        //FIN DE ENCABEZADO
        Object.values(carrito).forEach(producto =>{
            switch(p)
            {
                case 0:
                    sql += ", ARRAY[" + "'" + (producto.produccod).trim() + "'";
                    p++;
                break;
                case 1:
                    sql += "," + "'" + (producto.produccod).trim() + "'";
                break;
            } 
        });

        p=0;

        Object.values(carrito).forEach(producto =>{
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

        p=0;

        Object.values(carrito).forEach(producto =>{
            switch(p)
            {
                case 0:
                    sql += "], ARRAY[" + producto.preciouni;
                    p++;
                break;
                case 1:
                    sql += "," + producto.preciouni;
                break;
            } 
        });

        p=0;

        Object.values(carrito).forEach(producto =>{
            switch(p)
            {
                case 0:
                    sql += "], ARRAY[" + 0;
                    p++;
                break;
                case 1:
                    sql += "," + 0;
                break;
            } 
        });

        p=0;

        Object.values(carrito).forEach(producto =>{
            switch(p)
            {
                case 0:
                    sql += "], ARRAY[" + producto.precioneto;
                    p++;
                break;
                case 1:
                    sql += "," + producto.precioneto;
                break;
            } 
        });

        sql+= "]," + "'" + usr.value.trim() + "'," + "'" + rol.value.trim() + "', " + 
                domici + ", " + ciudad.value + ", '" + docu.trim() + "'" +  ", '" + nombre.trim() + "'" + ", '" + telefono.trim() + "'" + 
                ", '" + direccion.trim() + "'";

        sql+=");";

        formData.append('sql', sql); //Agregar el sql al FormData
        console.log(sql);
        return true;
    }
}

function extraerDatos(){                                                                //FORMACIÓN DE CONSULTA SQL SIN DOMICILIO
    let domici = false;
    //INICIO DE ENCABEZADO
    sql = 'SELECT fun_insert_venta(';
    sql+= "'" + docum.value.trim() + "'," + "'" +  depa.value + "'," + "'" + ciud.value 
    + "'," + "'" +  tipopago.value + "'," + inputValorpuntos.value.trim();
    //FIN DE ENCABEZADO
    Object.values(carrito).forEach(producto =>{
        switch(p)
        {
            case 0:
                sql += ", ARRAY[" + "'" + (producto.produccod).trim() + "'";
                p++;
            break;
            case 1:
                sql += "," + "'" + (producto.produccod).trim() + "'";
            break;
        } 
    });

    p=0;

    Object.values(carrito).forEach(producto =>{
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

    p=0;

    Object.values(carrito).forEach(producto =>{
        switch(p)
        {
            case 0:
                sql += "], ARRAY[" + producto.preciouni;
                p++;
            break;
            case 1:
                sql += "," + producto.preciouni;
            break;
        } 
    });

    p=0;

    Object.values(carrito).forEach(producto =>{
        switch(p)
        {
            case 0:
                sql += "], ARRAY[" + 0;
                p++;
            break;
            case 1:
                sql += "," + 0;
            break;
        } 
    });

    p=0;

    Object.values(carrito).forEach(producto =>{
        switch(p)
        {
            case 0:
                sql += "], ARRAY[" + producto.precioneto;
                p++;
            break;
            case 1:
                sql += "," + producto.precioneto;
            break;
        } 
    });
    sql+= "]," + "'" + usr.value + "'," + "'" + rol.value + "', " + domici + ", " + 0 + "," + "'" + "N_A" + "', '" + "N_A" + "'," + "'" + "N_A" + "'," + "'" + "N_A" + "')";

    formData.append('sql', sql); //Agregar el sql al FormData
    console.log(sql);
}


// aqui se escucha el boton con el "+" del formulario y se le envian los datos a "addCarrito"
seccionProducto.addEventListener('click', e =>{
    addCarrito(e)
})

function teclaEnter(e){
    if(e.keyCode===13){
        e.preventDefault();
        btnAgregarProd2.click();
    }
}

cantreq.addEventListener('keyup', teclaEnter);

// aqui se escucha el tbody de la tabla de los productos que se van a comprar y se le envia a "btnAccion" para que lo elimine
cuerpoTabla.addEventListener('click', e =>{
    btnAccion(e)
})

// aqui se escucha botón de volver de la sección de cliente y se vacía el carrito
btnvolverven2.addEventListener('click', () => {
    carrito = {}
    inputValorTotal.value = ""
    inputValorpuntos.value = ""
    pintarCarrito()
});

// aqui tomamos del documento html los datos del producto para mandárselos al "setCarrito"
const addCarrito = e => {
    verificarStock = stockProducto.value;
    if(e.target.classList.contains('btn-warning')){
        
        setCarrito(e.target.parentElement)
        
        const atributosEliminar = document.querySelectorAll('#seccionProducto input')
        for (var i = 0; i < 7; i++ ) {
            atributosEliminar[i].value = "";
            atributosEliminar[i].setAttribute("readonly", "");
        }
        atributosEliminar[0].removeAttribute("readonly")
        btnAgregarProd2.disabled = true;
        codi.focus();
    }
    
    e.stopPropagation(); //evita que se hereden algunos metodos que nos podrian molestar
}

// aqui se reciben los datos del "addCarrito" para luego enviarselo a "pintarCarrito"
const setCarrito = objeto => {
    auxProd = false;
    btnBuscarProducto.disabled = false;
    btnCancelarProd.disabled = true;
    const producto = {
        produccod:  objeto.querySelector('.idcod').value,
        producnom:  objeto.querySelector('.nom').value,
        producsto:  parseInt(objeto.querySelector('.cantdis').value),
        cantidad:   parseInt(objeto.querySelector('.cantreq').value),
        preciouni:  parseInt(objeto.querySelector('.valpar').value),
        precioneto: parseInt(objeto.querySelector('.valnet').value)
    }
    // esto se usa para aumentar la cantidad del producto
    if(carrito.hasOwnProperty(producto.produccod)){
        producto.cantidad = carrito[producto.produccod].cantidad + parseInt(cantreq.value)
    }
    // esto se usa para aumentar el valor neto del producto
    if(carrito.hasOwnProperty(producto.produccod)){
        producto.precioneto = carrito[producto.produccod].cantidad * parseInt(preuni.value)
    }
    carrito[producto.produccod] = { ...producto} // con esto se le envia el proceso anterior ↑
    pintarCarrito();
    
    
    // El carrito vendría siendo el datagridview, el objeto producto vendría siendo el registro y la propiedad sería la posición dentro de producto
}

// aqui vamos a tomar el objeto que creamos en "setCarrito" y lo vamos a colocar en la tabla de los productos para que se pueda visualizar
const pintarCarrito = () => {
    
    cuerpoTabla.innerHTML = '';
    Object.values(carrito).forEach(producto =>{
        if (producto.cantidad > producto.producsto){
            
            delete carrito[producto.produccod]
            
            return
        }
        templateCarrito.querySelector('.idpro').textContent = producto.produccod
        templateCarrito.querySelector('.nombrep').textContent = producto.producnom
        templateCarrito.querySelector('.cantidadp').textContent = producto.cantidad
        templateCarrito.querySelector('.preciounip').textContent = producto.preciouni
        templateCarrito.querySelector('.precionetop').textContent = producto.precioneto
        templateCarrito.querySelector('.btnpro').value = producto.produccod 
        const clone = templateCarrito.cloneNode(true)
        fragment.appendChild(clone)
    })
    cuerpoTabla.appendChild(fragment)
    pintarFooter()
    

    // este codigo se usa para que cuando la pagina se reinicie no se pierda todo el carrito, no creo que lo vayamos a usar por seguridad de los productos, PERO NO SE SI SE PUEDAN UTILIZAR PARA MANDARLO A LA BASE DE DATOS CON ALGUNO DE LOS PARAMETROS RAROS DE JS
    // localStorage.setItem('carrito', JSON.stringify(carrito))
    // console.log(localStorage)
}

// aqui vamos a pintar el pie de la tabla y modificarlo
const pintarFooter = () => {
    
    footerTabla.innerHTML = ''
    // si no hay productos pondra esto
    if(Object.keys(carrito).length === 0){
        
        footerTabla.innerHTML = `
        <th class="pie-tabla" scope="row" colspan="5">Carrito Vacio - compre algo carajo!</th>
        `
        return
    }
    
    // esto para que aumente la cantidad de prodcitos y el precio total de la compra en el pie de la pagina
    const nCantidad = Object.values(carrito).reduce((acc, {cantidad}) => acc + cantidad,0)
    const nPrecio = Object.values(carrito).reduce((acc, {cantidad, preciouni}) => acc + cantidad * preciouni,0 )
    
    templateFooter.querySelector('.cantiTotal').textContent = nCantidad
    templateFooter.querySelector('span').textContent = nPrecio

    const clone = templateFooter.cloneNode(true)
    fragment.appendChild(clone)
    footerTabla.appendChild(fragment)

    inputValorTotal.value = nPrecio
    inputValorpuntos.value = Math.trunc(parseInt(nPrecio)/1000)
}

// aqui le llega el dato de evento de escucha del cuerpo de la tabla, tomara el value del boton y lo eliminara de la lista de objetos para luego volver a pintarlo
const btnAccion = e => {
    
    if(e.target.classList.contains('btn-warning')){
        
        delete carrito[e.target.value] // seleccionamos el producto que borramos por medio del id
        inputValorTotal.value = ""
        inputValorpuntos.value = ""
        pintarCarrito();  // volvemos a mandarle para que lo pinte
    }
    e.stopPropagation(); //evita que se hereden algunos metodos que nos podrian molestar
}