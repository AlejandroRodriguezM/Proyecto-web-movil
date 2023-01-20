<?php

// Include the main TCPDF library (search for installation path).
require_once('../../tcpdf/tcpdf.php');

// Retrieve the form data from the POST request
$nombre = $_POST['nombre_cliente_test'];
$email = $_POST['email_cliente_test'];
$problema = $_POST['problema_cliente_test'];
$fecha_entrega = $_POST['fecha_cliente_test'];
$fecha_terminado = $_POST['fecha_terminado_test'];
$horas_trabajadas = $_POST['horas_reales_test'];
$tecnico = $_POST['tecnico_test'];
$numFactura = $_POST['numFactura_test'];
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($tecnico);
$pdf->SetTitle('Factura de telefono');
$pdf->SetSubject('Factura de telefono');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "Factura de reparacion" . "\nNumero de factura: $numFactura", "Por tienda de moviles. Tienda virtual", array(0, 64, 255), array(0, 64, 128));
$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

$html = '<h1>Factura de reparacion</h1>';
//make table with border and padding
$html .= '<table border="1" cellpadding="5">';
$html .= '<tr><th>Nombre:</th><td>' . $nombre . '</td></tr>';
$html .= '<tr><th>Email:</th><td>' . $email . '</td></tr>';
$html .= '<tr><th>Problema:</th><td>' . $problema . '</td></tr>';
$html .= '<tr><th>Fecha de entrega en tienda:</th><td>' . $fecha_entrega . '</td></tr>';
$html .= '<tr><th>Fecha de arreglo:</th><td>' . $fecha_terminado . '</td></tr>';
$html .= '<tr><th>Tecnico:</th><td>' . $tecnico . '</td></tr>';
$html .= '<tr style="border: none;"><th>Precio total:</th><td>' . $horas_trabajadas . '€</td></tr>';
$html .= '</table>';

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('factura.pdf', 'D');
