<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario con Gráficas</title>
    <!-- Incluir estilos CSS -->
    <link rel="stylesheet" href="../css/graficas.css">
    <!-- Incluir librerías externas para gráficas (ej. Chart.js) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <h1>Dashboard con Gráficas</h1>
        <!-- Formulario para seleccionar el tipo de información -->
        <form id="dataForm">
            <label for="optionSelect">Selecciona el tipo de información:</label>
            <select id="optionSelect" name="option">
                <option value="obtenerCliente">Clientes</option>
                <option value="obtenerProducto">Productos</option>
                <option value="obtenerVenta">Ventas</option>
                <!-- Agrega más opciones según sea necesario -->
            </select>
            <button type="submit">Mostrar Gráfica</button>
        </form>

        <!-- Contenedor para la gráfica -->
        <div class="chart-container">
            <canvas id="myChart"></canvas>
        </div>
    </div>

    <!-- Incluir script JS para manejar la lógica del formulario y de las gráficas -->
    <script src="../js/graficas.js"></script>
</body>
</html>
