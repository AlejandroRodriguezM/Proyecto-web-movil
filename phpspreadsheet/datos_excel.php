<?php

require 'vendor/autoload.php';
include_once '../php/funciones/funciones.php';
include_once '../php/funciones/funciones_csv.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if ($_GET) {
    $id = $_GET['id'];
    $file_datos_usuario = "../csv/datos_usuarios.csv";
    $data = estadisticas_trabajador($id,$file_datos_usuario);
    if (is_string($data)) {
        return $data;
    }

    $porcentaje_telefonos = porcentaje_moviles($id,$file_datos_usuario);
    $porcentaje_horas = porcentaje_horas($id,$file_datos_usuario);

    // Create a new Excel file
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Add the relevant data to the Excel file
    $sheet->setCellValue('A1', 'ID');
    $sheet->setCellValue('B1', 'Nombre');
    $sheet->setCellValue('C1', 'Horas trabajadas');
    $sheet->setCellValue('D1', 'Moviles arreglados');
    $sheet->setCellValue('E1', 'Porcentaje de horas trabajadas');
    $sheet->setCellValue('F1', 'Porcentaje de telefonos arreglados');

    $sheet->setCellValue('A2', $data[0]);
    $sheet->setCellValue('B2', $data[1]);
    $sheet->setCellValue('C2', $data[2]);
    $sheet->setCellValue('D2', $data[3]);
    $sheet->setCellValue('E2', $porcentaje_horas . "%");
    $sheet->setCellValue('F2', $porcentaje_telefonos . "%");

    // Save the file
    $fileName = $data[0] . '_' . $data[1] . '.xlsx';
    $writer = new Xlsx($spreadsheet);
    $writer->save($fileName);

    // Set the appropriate headers to trigger a download in the browser
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $fileName . '";');

    // Read the file and output its contents
    readfile($fileName);
    unlink($fileName); // delete the created file after download
}
