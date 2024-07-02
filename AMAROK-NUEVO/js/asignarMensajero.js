const btnAsignar = document.getElementById("asignarMen");           //EXTRAER DATOS DE HTML
const btnGuardarObs = document.getElementById("guardarObs");
const formulario = document.getElementById("titulo").textContent;
if(formulario!=='ENVÍOS LOCALES ENTREGADOS'){
    const btnFinalizar = document.getElementById("finalizarEnv");
    btnFinalizar.addEventListener('click', () => {                        //EVENTO DE ESCUCHA EN EL BOTÓN DE GUARDAR FINALIZAR
        var empresa = document.getElementById("empretranit").value;
        const archivoInput = document.getElementById("archivo");
        const archivo = archivoInput.files[0]; // Obtener el primer archivo seleccionado
        if(empresa.trim()===''||archivo===null){
            Swal.fire({
                position: "top-end",
                title: "❕Debe enviar los datos correspondientes",
                showConfirmButton: false,
                timer: 3000,
            });
        }else{
            let formData = new FormData(); // Crear un objeto FormData para enviar datos
    
            formData.append('empretranit', empresa); // Agregar la empresa de transporte al FormData
            formData.append('archivo', archivo); // Agregar el archivo al FormData
    
            // Agregar otros parámetros si es necesario
            formData.append('envionum', enviofinalizar.value);
            $.ajax({
                data: formData,
                url: 'finalizarEnvio.php',
                type: 'POST',
                contentType: false, // Importante: no establecer contentType a false para FormData
                processData: false, // Importante: no procesar datos para FormData
                dataType: 'text',
                success: function(mensaje){
                    $('#finalizarModal').modal('hide');
                    Swal.fire({
                        position: "top-end",
                        title: mensaje,
                        showConfirmButton: false,
                        timer: 3000,
                    });
                }
            });
        }
    })

    var botonDescargar = document.getElementById('descargarImagen');
    botonDescargar.addEventListener('click', () => {
        var comprobantever = document.getElementById("comprobantever");
        var imagen = document.getElementById('imagenAMostrar');
        // Construye la ruta de la imagen usando el número de venta
        var rutaImagen = '../images/Guias_Envios/' + comprobantever.value + '.jpg';
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
}

btnAsignar.addEventListener('click', () => {                        //EVENTO DE ESCUCHA EN EL BOTÓN DE ASIGNAR MENSAJERO
    var mensajero = document.getElementById("docusuario");
    var parametros = {
    'envionum': envioedit.value,                                    //ASIGNACIÓN DE LOS DATOS A ENVIAR EN LA VARIABLE PARÁMETROS
    'docusuario': mensajero.value
    };
    $.ajax({
        data: parametros,
        url: 'asignarMensajero.php',                                //ENVÍO DE DATOS POR MÉTODO POST HACIA EL PHP
        type: 'POST',
        dataType: 'text',
        success: function(mensaje){
            $('#exampleModal').modal('hide');
            Swal.fire({
                position: "top-end",
                title: mensaje,                                     //MOSTRAR RESULTADO DE LA OPERACIÓN
                showConfirmButton: false,
                timer: 3000,
            });
        }
    });
})

btnGuardarObs.addEventListener('click', () => {                        //EVENTO DE ESCUCHA EN EL BOTÓN DE GUARDAR OBSERVACIÓN
    var observacion = document.getElementById("envioobs");
    if(observacion.value.trim()==='' || aggobs.value.trim() ===''){
        Swal.fire({
            position: "top-end",
            title: "❕ Datos vacíos",                                     //MOSTRAR RESULTADO DE LA OPERACIÓN
            showConfirmButton: false,
            timer: 3000,
        });
    }else{
        var parametros = {
            'envionum': aggobs.value,                                    //ASIGNACIÓN DE LOS DATOS A ENVIAR EN LA VARIABLE PARÁMETROS
            'envioobs': observacion.value
        };
        $.ajax({
            data: parametros,
            url: 'insertarObservacion.php',                                //ENVÍO DE DATOS POR MÉTODO POST HACIA EL PHP
            type: 'POST',
            dataType: 'text',
            success: function(mensaje){
                $('#observModal').modal('hide');
                Swal.fire({
                    position: "top-end",
                    title: mensaje,                                     //MOSTRAR RESULTADO DE LA OPERACIÓN
                    showConfirmButton: false,
                    timer: 3000,
                });
            }
        });
    }
})