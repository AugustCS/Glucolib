<?php 

ini_set('error_reporting', E_ALL | E_NOTICE );
ini_set('display_errors', true ); //Cambiamos a 0 para no mostrar errores
ini_set('track_errors', 'On');

$nombre="Reporte-Pacientes-".date('Ymd').".xls";
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=$nombre");
require_once 'inc.aplication_top.php';
$obj    = new ModeloPacientes();
$html   = new HTMLAJAX();


$id   = isset($_GET['id']) ? $_GET['id'] : '';
$data     =  $obj->getPaciente($id);
$columns  =  $obj->campos($id);
$tabla =  $html->tabla($columns, $data);