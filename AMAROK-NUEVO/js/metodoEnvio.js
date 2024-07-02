var sql = '';        //DECLARACIÓN DE VARIABLES GLOBALES
var p = 0;

$(document).ready(function(){                                       //INICIALIZACIÓN DEL DOCUMENTO
    var btnFinalizar = document.getElementById('btnFinalizar');
    const id = document.getElementById('id-usuario').value;                         //EXTRACCIÓN DE DATOS DEL HTML
    const ro = document.getElementById('rol-usuario').value;
    let productosEnCarrito = localStorage.getItem("productos-en-carrito");
    productosEnCarrito = JSON.parse(productosEnCarrito);

    btnFinalizar.addEventListener('click', (e) => {                 //EVENTO DE ESCUCHA DEL BOTÓN FINALIZAR
        e.preventDefault();
        if(metodoRetiro.value === "tienda"){
            registrarPedido();                                      //VALIDACIÓN DEL MÉTODO DE RETIRO
        }else{
            registrarPedidoDomi();
        }
    });

    function registrarPedidoDomi(){                                 //FUNCIÓN PARA REGISTRAR PEDIDO EN CASO DE DOMICILIO
        if(!extraerDatosDomi()){
            return;
        }
        var parametros = {
            'sql': sql
        };
        $.ajax({
            data: parametros,
            url: 'insertarVenta.php',                               //ENVÍO DE DATOS AL PHP CORRESPONDIENTE
            type: 'POST',  
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
                    productosEnCarrito.length = 0;              //VALIDACIÓN DE RESULTADOS
                    localStorage.clear();
                    setTimeout( function () {
                        window.location = 'compras-cliente.php';
                    }, 3000 );
                }
            }
        });
    }

    function registrarPedido(){
        extraerDatos();                                         //FUNCIÓN PARA REGISTRAR PEDIDO SIN DOMICILIO
        var parametros = {
            'sql': sql
        };
        $.ajax({
            data: parametros,
            url: 'insertarVenta.php',
            type: 'POST',  
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
                    productosEnCarrito.length = 0;
                    localStorage.clear();
                    setTimeout( function () {
                        window.location = 'compras-cliente.php';
                    }, 3000 );
                }
            }
        });
    }


    function extraerDatosDomi(){
        var ciudad = document.getElementById('idCiudad');
        var docu = document.getElementById('documento').value;
        var nombre = document.getElementById('nombre').value;
        var telefono = document.getElementById('telefono').value;           //FORMACIÓN DE CONSULTA SQL PARA ENVIAR
        var direccion = document.getElementById('direccion').value;
        if(ciudad.value.trim()===""||docu.trim()===""||nombre.trim()===""||direccion.trim()===""||telefono.trim()===""){
            alert('❕ Rellene los datos del domicilio por favor');
            return false;
        }else{
            sql = 'SELECT fun_insert_venta_domi(';
            sql+= "'" + id + "'";
        
            Object.values(productosEnCarrito).forEach(producto =>{
                switch(p)
                {
                    case 0:
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
            sql+= "], " + ciudad.value + ", '" + documento + "'" + ", '" + nombre + "'" + ", '" + telefono + "'" + ", '" + direccion + "'";

            sql+=");";
            return true;
        }
    }

    function extraerDatos(){                                    //FORMACIÓN DE CONSULTA SQL PARA ENVIAR
        sql = 'SELECT fun_insert_venta_cliente(';
        sql+= "'" + id + "'";
    
        Object.values(productosEnCarrito).forEach(producto =>{
            switch(p)
            {
                case 0:
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
    }
}
);