<?php if ( ! defined(‘BASEPATH’)) exit(‘No direct script access allowed’);
class Eksportexcel extends CI_Controller {
public function index(){
$this->load->library(‘phpexcel’);
$this->load->library(‘PHPExcel/IOFactory’);

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setTitle("title")
->setDescription("description");

// Assign cell values
$objPHPExcel->setActiveSheetIndex(0)
->setCellValue(‘B3′, ‘Nama Lengkap’)
->setCellValue(‘B5′, ‘Alamat’)
->setCellValue(‘B7′, ‘No. Telp’)
->setCellValue(‘F7′, ‘No. HP’)
->setCellValue(‘B9′, ‘Email’)
->setCellValue(‘B11′, ‘Jenis Kelamin’)
->setCellValue(‘B13′, ‘Status’)
->setCellValue(‘B15′, ‘Tempat/Tanggal Lahir’)
->setCellValue(‘B17′, ‘Pendidikan Terakhir’)
->setCellValue(‘B21′, ‘Gaji yang Diminta’);
// Save it as an excel 2003 file
$objWriter = IOFactory::createWriter($objPHPExcel, ‘Excel5′);
$objWriter->save("./fileExcel/".date(‘dmYHis’).".xls");
$this->load->view();

?>