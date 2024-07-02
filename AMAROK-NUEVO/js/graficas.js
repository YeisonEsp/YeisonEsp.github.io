document.addEventListener('DOMContentLoaded', function() {
    let myChart = null; // Variable para mantener la referencia del gráfico actual
    // Manejar envío del formulario
    document.getElementById('dataForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Evitar que el formulario se envíe

        // Obtener el valor seleccionado del select
        var selectedOption = document.getElementById('optionSelect').value;

        if (myChart) {
            myChart.destroy();
        }

        // Realizar solicitud Fetch para obtener los datos correspondientes
        fetch(`${selectedOption}.php`) // Ejemplo: productos.php, ventas.php, clientes.php
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Error en la solicitud Fetch: ${response.status} ${response.statusText}`);
                }
                return response.json();
            })
            .then(data => {
                // Validar y asignar las etiquetas adecuadas según la opción seleccionada
                var labels;
                var data;
                var label;
                switch(selectedOption){
                    case 'obtenerProducto':
                        labels=data.map(item => item.producnom);
                        data=data.map(item => item.producsto);
                        label='Stock';
                        break;
                    case 'obtenerCliente':
                        labels=data.map(item => item.clientnom);
                        data=data.map(item => item.clientpun);
                        label='Puntos';
                        break;
                    case 'obtenerVenta':
                        labels=data.map(item => `${item.ventanum} - ${item.docclient}`);
                        data=data.map(item => parseFloat(item.total.replace(/[^\d.-]/g, '')));
                        label='Totales';
                        break;
                }
                // Preparar datos y opciones para la gráfica
                var ctx = document.getElementById('myChart').getContext('2d');
                myChart = new Chart(ctx, {
                    type: 'bar', // Tipo de gráfica (puedes cambiar según tu necesidad)
                    data: {
                        labels: labels, // Etiquetas dinámicas según los datos obtenidos
                        datasets: [{
                            label: label, // Etiqueta de la gráfica
                            data: data, // Datos reales que se mostrarán (stock o puntos)
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error al obtener datos:', error);
            });
    });
});
