<?php

require 'vendor/autoload.php';
include_once '../php/funciones/funciones.php';
include_once '../php/funciones/funciones_csv.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$file_datos_usuario = "../csv/datos_usuarios.csv";
$csv = estadisticas_trabajadores($file_datos_usuario);
// Create a new Excel file
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
// Add the headers of the sheet
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Nombre');
$sheet->setCellValue('C1', 'Horas trabajadas');
$sheet->setCellValue('D1', 'Moviles arreglados');
$sheet->setCellValue('E1', 'Porcentaje de horas trabajadas');
$sheet->setCellValue('F1', 'Porcentaje de telefonos arreglados');
// Add the relevant data to the Excel file
$i = 2; // Start on row 2
foreach ($csv as $row) {
    $id = $row[0];
    $porcentaje_telefonos = porcentaje_moviles($id, $file_datos_usuario);
    $porcentaje_horas = porcentaje_horas($id, $file_datos_usuario);
    $sheet->setCellValue('A' . $i, $row[0]);
    $sheet->setCellValue('B' . $i, $row[1]);
    $sheet->setCellValue('C' . $i, $row[2]);
    $sheet->setCellValue('D' . $i, $row[3]);
    $sheet->setCellValue('E' . $i, $porcentaje_horas . "%");
    $sheet->setCellValue('F' . $i, $porcentaje_telefonos . "%");
    $i++;
}
// Save the file
$fileName = 'estadisticas_trabajadores' . '.xlsx';
$writer = new Xlsx($spreadsheet);
$writer->save($fileName);

// Set the appropriate headers to trigger a download in the browser
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $fileName . '";');

// Read the file and output its contents
readfile($fileName);
unlink($fileName); // delete the created file after download
