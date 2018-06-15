<?php  
error_reporting(E_ALL ^ E_NOTICE);
require_once 'config.php';

function my_autoloader($class) {
	if(file_exists( _model_.$class.'.php'  )){
		include _model_.$class.'.php';
	}
}

spl_autoload_register('my_autoloader');


function my_autoloader2($class) {
	if(file_exists( _controlador_.$class.'.php'  )){
		include _controlador_.$class.'.php';
	}
}

spl_autoload_register('my_autoloader2');


require_once _view_.'Secciones.php';
require_once _util_.'Libs.php';
require_once _util_.'ThumbnailBlob.php';

$link = new Conexion($_config['bd']['server'],$_config['bd']['user'],$_config['bd']['password'],$_config['bd']['name']);
	session_start();	

//idioma
if(isset($_SESSION['idioma'])){
	$idioma = $_SESSION['idioma'];
}else{
	$idioma = new ModeloIdioma();
}
//cuando hay que cambiar idioma
if(isset($_GET['switch'])){$idioma->switchs($_GET['switch']);}
//incluimos el archivo de variables del idioma
define("ID_IDIOMA",$idioma->__get('_id'));

$sesion = new ModeloSesion($idioma);


if(isset($_POST['login']) && isset($_POST['password']) && !empty($_POST['login']) &&!empty($_POST['password'])){
	$sesion->validaAcceso($_POST['login'], $_POST['password']);
}

//msgbox
if(!(isset($_SESSION['msg']))){
	$msgbox = new Msgbox();
}else{
	$msgbox = $_SESSION['msg'];
}
	
//configuracion del sitio
$user = new ModeloUsuario($sesion->getUsuario()->getId());

$config_site = new ModeloConfiguration($msgbox,$user);
$configs = $config_site->getData();

foreach($configs as $clave=>$valor){
	define($clave,$valor);
}

define('USUARIO_LOGEADO_NOMBRE', $sesion->getUsuario()->getNombre().' '.$sesion->getUsuario()->getApellidos());
define('USUARIO_LOGEADO_ID', $sesion->getUsuario()->getId());
define('USUARIO_LOGEADO_ROL', $sesion->getUsuario()->getRol());

if(strstr($_SERVER['PHP_SELF'],"login.php")){$flag=0;} else {$flag=1;}
if(!is_object($sesion->getUsuario()->getRol()))	if ($flag) header("location:"._web_."index.php");
if($sesion->getUsuario()->getLogeado()==FALSE)  if ($flag) header("location:"._web_."index.php");

?>