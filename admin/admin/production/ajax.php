<?php include("inc.aplication_top.php");

$obj = new ControladorAjax();
if($_REQUEST['action']){
	$accion = $_REQUEST['action']."Ajax";	
	$obj->$accion();
}?>	