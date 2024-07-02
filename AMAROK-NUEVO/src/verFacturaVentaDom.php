<?php
if (!isset($_POST["ventanum"]))
{
exit();
}
$ventanum = $_POST["ventanum"];

session_start();
$usua = $_SESSION['id'];
$role = $_SESSION['username'];
if($role !=="Administrador" && $role !=="Vendedor"){
    echo "NO ESTÁ AUTORIZADO PARA VER LAS FACTURAS DE VENTAS ❌";
    exit();
}

require_once '../dompdf/vendor/autoload.php'; 

use Dompdf\Dompdf;
use Dompdf\Options;

// Directorio temporal donde dompdf almacenará archivos temporales
$tempDir = '../images/Comprobantes_Pagos/';

// Opciones de configuración para dompdf
$options = [
    'tempDir' => $tempDir,
];

// Crear una instancia de Dompdf con las opciones de configuración
$dompdf = new Dompdf($options);

ob_start();
// Opciones para Dompdf (puedes ajustar según sea necesario)
$options = new Options();
$options->set('isHtml5ParserEnabled', true); // Habilita el análisis de HTML5
$options->set('isRemoteEnabled', true); // Permite cargar imágenes remotas

// Puedes configurar otras opciones aquí si es necesario, como el tamaño del papel y la orientación

// Establece las opciones en Dompdf
$dompdf->setOptions($options);
$path = '../images/logo.png';
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="../images/amarok.ico">
    <style>
        /* Reducir el tamaño de la fuente */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 9pt;
        }
        .container {
            margin: 10px auto;
            padding: 10px;
            border-radius: 10px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .section{
            border-bottom: 1.5px inset black;
        }
        /* Estilo para los títulos */
        h2 {
            margin-bottom: 5px;
        }
        /* Estilo para las tablas */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            margin: 5px 0;
            text-align: center;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
        }

        .deta{
            background-color: #2a2a2c;
            color: whitesmoke;
        }

        #tab_deta{
            margin-top: 13px;
        }
        /* Estilo para el contenedor de la empresa */
        .company-info {
            display: flex;
            align-items: center; /* Centrar verticalmente */
            margin-bottom: 20px; /* Espacio entre secciones */
        }
        /* Estilo para el logo */
        .company-logo {
            max-width: 100px;
            max-height: 100px;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }
        /* Estilo para la información de la empresa */
        .company-details {
            flex-grow: 1; /* Ocupa el espacio restante */
        }
    </style>
</head>
<body>
    <!-- Del formulario de la venta, tendrá que venir el documento del cliente y el número de la factura -->
    <!-- Con los 2 datos, podemos traer todo lo que le compete a la venta actual -->
    <?php
        include_once "conexion.php";
        $sentencia = $base_de_datos->prepare("SELECT v.ventaNum, to_char(v.fec_insert, 'DD-MM-YYYY') AS fechaventa, 
                                            v.tipopago, v.ventaDom, to_char(v.fec_insert, 'hh:MI:ss') AS horaventa,
                                            v.docClient, to_char(sum(dt.detventavalpar), 'LFM9,999,999') AS total
                                            FROM venta v JOIN detalleventa dt ON v.ventaNum=dt.numVenta
                                            WHERE v.ventaNum = $ventanum GROUP BY v.ventaNum;");
        $sentencia->execute();
        $venta = $sentencia->fetchObject();
        if (!$venta)
        {
            #No existe
            echo "<script>
                    alert('No existe ninguna venta con ese número❕');
                    window.history.go(-1);
                </script>";
        }
        if($venta->ventadom){
            $venta->ventadom = 'Si';
        }else{
            $venta->ventadom = 'No';
        }
        $cliente = $venta->docclient;

        $sentencia = $base_de_datos->prepare("SELECT dt.codProduc, p.producNom, dt.detVentaCan, to_char(dt.precioProduc, 'LFM9,999,999') AS precioProduc, 
                                                to_char(dt.detVentaValPar, 'LFM9,999,999') AS detVentaValPar 
                                                FROM detalleventa dt JOIN producto p ON dt.codProduc = p.producCod 
                                                WHERE dt.numVenta = $ventanum;");
        $sentencia->execute();
        $dets = $sentencia->fetchAll(PDO::FETCH_OBJ);
        if (!$dets)
        {
            #No existe
            echo "¡No existe algún Cliente con ese documento!";
            exit();
        }

        $sentencia = $base_de_datos->prepare("SELECT empreNit, empreNom, empreDir, empreTel, empreEma FROM parametros;");
        $sentencia->execute();
        $parametros = $sentencia->fetchObject();
        
        if (!$parametros)
        {
            echo "¡No existe algún registro de parámetros con ese Nit!";
            exit();
        }

        $sentencia = $base_de_datos->prepare("SELECT clientdoc, clientnom, c.ciudadnom, d.departnom, clientdir, clienttel, clientema FROM cliente JOIN ciudad c ON idCiudad = c.ciudadId JOIN departamento d ON idDepart = d.departId WHERE clientdoc = '$cliente';");
        $sentencia->execute();
        $clientes = $sentencia->fetchObject();
        if (!$clientes)
        {
            #No existe
            echo "¡No existe algún Cliente con ese documento!";
            exit();
        }

        $base_de_datos = null;
    ?>
    <div class="container">
        <!-- Logo de la empresa y su información -->
        <div class="section">
            <img src="<?php echo $base64?>" height="150px" width="150px" alt="Imagen">
            <h2>Información de la empresa</h2>
            <table>
                <thead>
                    <tr>
                        <th class="deta">Nit</th>
                        <th class="deta">Nombre</th>
                        <th class="deta">Dirección</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $parametros->emprenit ?></td>
                        <td><?php echo $parametros->emprenom ?></td>
                        <td><?php echo $parametros->empredir ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Información del cliente -->
        <div class="section">
            <h2>Información del cliente</h2>
            <table>
                <thead>
                    <tr>
                        <th class="deta">Documento</th>
                        <th class="deta">Nombre completo</th>
                        <th class="deta">Reside en</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $clientes->clientdoc ?></td>
                        <td><?php echo $clientes->clientnom ?></td>
                        <td><?php echo $clientes->departnom ?>, <?php echo $clientes->ciudadnom ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Detalles de la factura -->
        <h2>Información de la factura</h2>
        <table>
            <thead>
                <tr>
                    <th class="deta">Número de factura</th>
                    <th class="deta">Fecha de expedición</th>
                    <th class="deta">Método de pago</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $venta->ventanum ?></td>
                    <td><?php echo $venta->fechaventa ?></td>
                    <td><?php echo $venta->tipopago ?></td>
                </tr>
            </tbody>
        </table>
        <!-- Tabla de productos -->
        <table id="tab_deta">
            <thead>
                <tr>
                    <th class="deta">Código_Producto</th>
                    <th class="deta">Nombre</th>
                    <th class="deta">Cantidad</th>
                    <th class="deta">Precio_Unitario(COP)</th>
                    <th class="deta">Subtotal(COP)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($dets as $de)
					{
						?>
						<tr>
							<td><?php echo $de->codproduc ?></td>
							<td><?php echo $de->producnom ?></td>
							<td><?php echo $de->detventacan ?></td>
							<td><?php echo $de->precioproduc ?></td>
                            <td><?php echo $de->detventavalpar ?></td>
						</tr>
					<?php
					} ?>
            </tbody>
        </table>
        <!-- Total -->
        <p style="font-size: 12pt;"><strong>Total(COP):</strong> <?php echo $venta->total ?></p>
    </div>
</body>
</html>

<?php
// Guarda todo el HTML generado en una variable
$html_factura = ob_get_clean();
// Carga el HTML en Dompdf
$dompdf->loadHtml($html_factura);

$dompdf->setPaper('A4', 'portrait');

// Renderiza el PDF
$dompdf->render();
//$dompdf->stream("Factura.pdf", array("Attachment" => false));
$output = $dompdf->output();
$namepdf = "Factura_$venta->ventanum".".pdf";
$path = '../images/Facturas_Ventas/'.$namepdf;

if (file_exists($path)) {
    //echo "El fichero $path existe";
    unlink($path);
    file_put_contents($path, $output);
} else {
    //echo "El fichero $namepdf no existe";
    file_put_contents($path, $output);
}
?>