<?php
require './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', 'Hello World !');
$sheet->setCellValue('B2', '壺生氣了!')->setCellValue('C3', '海龍王彼得~');

$writer = new Xlsx($spreadsheet);
$writer->save('反正我很閒.xlsx');
