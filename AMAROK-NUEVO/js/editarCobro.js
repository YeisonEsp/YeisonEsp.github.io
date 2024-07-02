const btnGuardarPago = document.getElementById("guardarPago");

btnGuardarPago.addEventListener('click', () => {
    const modopago = document.getElementById("modoPago").value.trim();
    const archivoInput = document.getElementById("archivo");
    const archivo = archivoInput.files[0]; // Obtener el primer archivo seleccionado
    let formData = new FormData(); // Crear un objeto FormData para enviar datos

    formData.append('modopago', modopago); // Agregar el modo de pago al FormData
    formData.append('archivo', archivo); // Agregar el archivo al FormData

    // Agregar otros parámetros si es necesario
    formData.append('ventanum', ventaedit.value);
    $.ajax({
        data: formData,
        url: 'actualizarCobro.php',
        type: 'POST',
        contentType: false, // Importante: no establecer contentType a false para FormData
        processData: false, // Importante: no procesar datos para FormData
        dataType: 'text',
        success: function(mensaje){
            $('#exampleModal').modal('hide');
            Swal.fire({
                position: "top-end",
                title: mensaje,
                showConfirmButton: false,
                timer: 3000,
            });
        }
    });
})

var botonDescargar = document.getElementById('descargarImagen');
botonDescargar.addEventListener('click', () => {
    var comprobantever = document.getElementById("comprobantever");
    var imagen = document.getElementById('imagenAMostrar');
    // Construye la ruta de la imagen usando el número de venta
    var rutaImagen = '../images/Comprobantes_Cobros/' + comprobantever.value + '.jpg';
    // Establece la ruta de la imagen en el atributo src
    imagen.src = rutaImagen;
    // Crea un enlace temporal
    var enlaceTemporal = document.createElement('a');
    enlaceTemporal.href = rutaImagen;
    enlaceTemporal.download = comprobantever.value + '.jpg';
    document.body.appendChild(enlaceTemporal);
    enlaceTemporal.click();
    document.body.removeChild(enlaceTemporal);
    $('#imagenModal').modal('hide');
})