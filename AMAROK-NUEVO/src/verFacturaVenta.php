<?php
require_once '../FPDF/fpdf.php'; // Asegúrate de incluir el archivo de la biblioteca FPDF

if (!isset($_POST["ventanum"])) {
    exit();
}

$ventanum = $_POST["ventanum"];

session_start();
$usua = $_SESSION['id'];
$role = $_SESSION['username'];

if ($role !== "Administrador" && $role !== "Vendedor") {
    echo "NO ESTÁ AUTORIZADO PARA VER LAS FACTURAS DE VENTAS ❌";
    exit();
}

$path = '../images/logo.png';
$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

include_once "conexion.php";

$sentencia = $base_de_datos->prepare("SELECT v.ventaNum, to_char(v.fec_insert, 'DD-MM-YYYY') AS fechaventa, 
                                    v.tipopago, v.ventaDom, to_char(v.fec_insert, 'hh:MI:ss') AS horaventa,
                                    v.docClient, to_char(sum(dt.detventavalpar), 'LFM9,999,999') AS total
                                    FROM venta v JOIN detalleventa dt ON v.ventaNum=dt.numVenta
                                    WHERE v.ventaNum = $ventanum GROUP BY v.ventaNum;");
$sentencia->execute();
$venta = $sentencia->fetch(PDO::FETCH_OBJ);

if (!$venta) {
    echo "<script>
            alert('No existe ninguna venta con ese número❕');
            window.history.go(-1);
        </script>";
}

if ($venta->ventadom) {
    $venta->ventadom = 'Si';
} else {
    $venta->ventadom = 'No';
}

$cliente = $venta->docclient;

$sentencia = $base_de_datos->prepare("SELECT dt.codProduc, p.producNom, dt.detVentaCan, to_char(dt.precioProduc, 'LFM9,999,999') AS precioProduc, 
                                        to_char(dt.detVentaValPar, 'LFM9,999,999') AS detVentaValPar 
                                        FROM detalleventa dt JOIN producto p ON dt.codProduc = p.producCod 
                                        WHERE dt.numVenta = $ventanum;");
$sentencia->execute();
$dets = $sentencia->fetchAll(PDO::FETCH_OBJ);

if (!$dets) {
    echo "¡No existe algún Cliente con ese documento!";
    exit();
}

$sentencia = $base_de_datos->prepare("SELECT empreNit, empreNom, empreDir, empreTel, empreEma FROM parametros;");
$sentencia->execute();
$parametros = $sentencia->fetch(PDO::FETCH_OBJ);

if (!$parametros) {
    echo "¡No existe algún registro de parámetros con ese Nit!";
    exit();
}

$sentencia = $base_de_datos->prepare("SELECT clientdoc, clientnom, c.ciudadnom, d.departnom, clientdir, clienttel, clientema FROM cliente JOIN ciudad c ON idCiudad = c.ciudadId JOIN departamento d ON idDepart = d.departId WHERE clientdoc = '$cliente';");
$sentencia->execute();
$clientes = $sentencia->fetch(PDO::FETCH_OBJ);

if (!$clientes) {
    echo "¡No existe algún Cliente con ese documento!";
    exit();
}

$base_de_datos = null;

// Crear un nuevo objeto FPDF con codificación UTF-8
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial','',12);
$pdf->AliasNbPages();

// Función para centrar texto
function CenterText($text, $pdf) {
    $pdf->Cell(0, 10, utf8_decode($text), 0, 1, 'C');
}

// Agregar info de la empresa
$pdf->SetFont('Arial', 'B', 16);
CenterText('Información de la empresa', $pdf);

// Agregar los detalles de la factura
$pdf->SetFont('Arial', '', 12);
CenterText('Nit: ' . $parametros->emprenit, $pdf);
CenterText('Nombre: ' . $parametros->emprenom, $pdf);
CenterText('Dirección: ' . $parametros->empredir, $pdf);

$pdf->Ln(3); 

$pdf->SetLineWidth(0.5);
$pdf->Line(65, $pdf->GetY(), 145, $pdf->GetY());

$pdf->Ln(3); // Añadir espacio después de la línea divisoria

// Agregar el título
$pdf->SetFont('Arial', 'B', 16);
CenterText('Información de la factura', $pdf);

// Agregar los detalles de la factura
$pdf->SetFont('Arial', '', 12);
CenterText('Número de factura: ' . $venta->ventanum, $pdf);
CenterText('Fecha de expedición: ' . $venta->fechaventa, $pdf);
CenterText('Método de pago: ' . $venta->tipopago, $pdf);

$pdf->Ln(3); 

$pdf->SetLineWidth(0.5);
$pdf->Line(65, $pdf->GetY(), 145, $pdf->GetY());

$pdf->Ln(3); // Añadir espacio después de la línea divisoria

$pdf->SetFont('Arial', 'B', 16);
CenterText('Datos del cliente', $pdf);

$pdf->SetFont('Arial', '', 12);
CenterText('Documento: ' . $clientes->clientdoc, $pdf);
CenterText('Nombre: ' . $clientes->clientnom, $pdf);
CenterText('Dirección: ' . $clientes->clientdir, $pdf);
CenterText('Teléfono: ' . $clientes->clienttel, $pdf);
CenterText('Ciudad: ' . $clientes->ciudadnom, $pdf);
CenterText('Departamento: ' . $clientes->departnom, $pdf);

$pdf->Ln(3); 

$pdf->SetLineWidth(0.5);
$pdf->Line(65, $pdf->GetY(), 145, $pdf->GetY());

$pdf->Ln(3); // Añadir espacio después de la línea divisoria

// Agregar los detalles de los productos
$pdf->SetFont('Arial', 'B', 16);
CenterText('Detalles de los productos', $pdf);

// Crear una tabla para los detalles de los productos
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(30, 10, utf8_decode('Código'), 1, 0, 'C');
$pdf->Cell(60, 10, utf8_decode('Nombre'), 1, 0, 'C');
$pdf->Cell(30, 10, utf8_decode('Cantidad'), 1, 0, 'C');
$pdf->Cell(30, 10, utf8_decode('Precio Unitario'), 1, 0, 'C');
$pdf->Cell(30, 10, utf8_decode('Subtotal'), 1, 1, 'C');

foreach ($dets as $de) {
    $pdf->Cell(30, 10, utf8_decode($de->codproduc), 1, 0, 'C');
    $pdf->Cell(60, 10, utf8_decode($de->producnom), 1, 0, 'C');
    $pdf->Cell(30, 10, utf8_decode($de->detventacan), 1, 0, 'C');
    $pdf->Cell(30, 10, utf8_decode($de->precioproduc), 1, 0, 'C');
    $pdf->Cell(30, 10, utf8_decode($de->detventavalpar), 1, 1, 'C');
}

$pdf->SetFont('Arial', 'B', 16);
CenterText('Total: ' . $venta->total, $pdf);

// Guardar el PDF en el servidor
$pdf->Output("../images/Facturas_Ventas/Factura_$ventanum.pdf", "F");

