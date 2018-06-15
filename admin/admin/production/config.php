<?php

 // echo $_SERVER['SERVER_NAME'].'<br>';
 // echo $_SERVER['DOCUMENT_ROOT'].'-<br>';
 // die();


switch ($_SERVER['SERVER_NAME']) {

	case 'admin.glucolib.com':
		$_config['server']['url'] 			= "http://admin.glucolib.com/";				
		$_config['server']['host'] 			= "/home/samy061090/public_html/admin/admin/production/";	
		$_config['bd']['server']  			= "localhost";										
		$_config['bd']['name']	  			= "glucolib";								
		$_config['bd']['user']	  			= "concytec";									
		$_config['bd']['password']			= "concytec";	
		$_config['server']['url_imagenes']  = "/home/samy061090/public_html/imagenes/";
		$_config['server']['web_imagenes']  = "http://imagenes.mdesawetoperu.org/";
	break;
}
	
	define("_web_",$_config['server']['url']);
	define("_ruta_",$_config["server"]["host"]);
	define("_includes_",$_config["server"]["host"]."application/includes/");
	
	define("_imgs_",$_config["server"]["url"]."application/webroot/imgs/");
	define("_vouchers_",$_config["server"]["url"]."application/webroot/voucher/");
	define("_catalogo_",$_config["server"]["url"]."application/webroot/imgs/catalogo/");
	define("_icons_",_imgs_."icons/");
	define("_admin_",_imgs_."admin/");
	define('_imagenes_',$_config['server']['url_imagenes']);
	define("_flash_",$_config["server"]["url"]."application/webroot/flash/");
	
		
	define("_model_",$_config["server"]["host"]."application/model/");
	define("_controlador_",$_config["server"]["host"]."application/controlador/");
	define("_view_",$_config["server"]["host"]."application/view/");
	define("_partials_",$_config["server"]["host"]."application/view/partials/");
	define("_util_",$_config["server"]["host"]."application/utilities/");
	
	
	define("_img_file_","application/utilities/img.php");
	define("_imagen_","application/utilities/imagen.php");
	define("_imgs_prod_","application/webroot/imgs/catalogo/");
	define("_language_",$_config["server"]["host"]."application/language/");
	define("_ruta_imagenes_saweto_",$_config["server"]["url_imagenes"]);
	define("_imagenes_saweto_",$_config["server"]["web_imagenes"]);


	date_default_timezone_set('America/Lima');
	define('TIEMPO', date("Y-m-d H:i:s") );
	define('HORA', date("H:i") );
	define('FECHA', date("Y-m-d") );
	//define('FECHA', '2017-03-03');
	define('TIEMPO_SESSION', 900);

//CONSTANTE PARA ENTORNO DE PRODUCCION
ini_set('error_reporting', E_ALL | E_NOTICE );
ini_set('display_errors', false );
ini_set('track_errors', 'off');
		
?>