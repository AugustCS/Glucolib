<?php

//Dispatch url from QueryString




 // echo $_SERVER['REQUEST_URI'].'-';
 // echo '<br>';
// limpiamos la url




//$_SERVER['REQUEST_URI'] = str_replace("/desarrollo/api-cliente/", "", $_SERVER['REQUEST_URI']);
$_SERVER['REQUEST_URI'] = str_replace("/colegio/", "", $_SERVER['REQUEST_URI']);
//$_SERVER['REQUEST_URI'] = str_replace("/v2/", "", $_SERVER['REQUEST_URI']);


if( substr($_SERVER['REQUEST_URI'], 0,1) == '/' ){
	$_SERVER['REQUEST_URI'] = substr($_SERVER['REQUEST_URI'], 1);
}



$url = explode("/", $_SERVER['REQUEST_URI']);
/*
print_r($_REQUEST);
print_r($_POST);
print_r($_GET);
*/
    
if( isset($url[0]) ){
    $_REQUEST['modulo'] = $url[0];
    $_REQUEST['modulo']     = $_REQUEST['modulo'];
    $_POST['modulo']        = $_GET['modulo'] = $_REQUEST['modulo'];
}
if( isset($url[1]) ){
    $_REQUEST['metodo'] = $url[1];
    $_REQUEST['metodo']     = $_REQUEST['metodo'];
    $_POST['metodo']        = $_GET['metodo'] = $_REQUEST['metodo'];
}
if( isset($url[2]) ){
    $_REQUEST['parametro'] = $url[2];
    $_REQUEST['parametro']  = $_REQUEST['parametro'];
    $_POST['parametro']     = $_GET['parametro'] = $_REQUEST['parametro'];
}

//En data_params quedan los valores de parametros por URL 
unset($url[0], $url[1], $url[2]);
$_REQUEST['total']      = array_values($url);

?>