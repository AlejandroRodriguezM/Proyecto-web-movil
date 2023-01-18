<?php
// Include the TCPDF library
require_once('./tcpdf/tcpdf.php');

// Initialize the validation array
$validate = array('success' => false, 'message' => '');

// Retrieve the form data from the POST request
$nombre = $_POST['nombre_cliente'];
$email = $_POST['email_cliente'];
$problema = $_POST['problema_cliente'];
$fecha = $_POST['fecha_entrega_cliente'];
$horas_trabajadas = $_POST['horas_trabajadas'];
$tecnico = $_POST['trabajador'];

try {
    // Create a new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Invoice');

    // Set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Invoice', PDF_HEADER_STRING);

    // Set header and footer fonts
    $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

    // Set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

    // Set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // Set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // Set font
    $pdf->SetFont('helvetica', '', 12);

    // Add a page
    $pdf->AddPage();

    // Create the HTML content for the invoice
    $html = '<h1>Invoice</h1>';
    $html .= '<table>';
    $html .= '<tr><th>Name:</th><td>' . $nombre . '</td></tr>';
    $html .= '<tr><th>Email:</th><td>' . $email . '</td></tr>';
    $html .= '<tr><th>Problem:</th><td>' . $problema . '</td></tr>';
    $html .= '<tr><th>Date:</th><td>' . $fecha . '</td></tr>';
    $html .= '<tr><th>Hours Worked:</th><td>' . $horas_trabajadas . '</td></tr>';
    $html .= '<tr><th>Technician:</th><td>' . $tecnico . '</td></tr>';
    $html .= '</table>';
    chmod('./facturas', 0777);

    // Output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

    // reset pointer to the last page
    $pdf->lastPage();

    // Close and output PDF document
    $pdf->Output('./facturas/test.pdf', 'E');
    // Set the validation array to success
    $validate['success'] = true;
    $validate['message'] = 'Invoice created successfully';
} catch (Exception $e) {
    // Set the validation array to failure
    $validate['success'] = false;
    $validate['message'] = 'Invoice creation failed';
}

echo json_encode($validate);
