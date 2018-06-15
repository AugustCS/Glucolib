<?php
// echo $_SERVER['SERVER_NAME'].'<br>';
// echo $_SERVER['DOCUMENT_ROOT'].'-';

switch ($_SERVER['SERVER_NAME']) {
        case 'api-glucolib.vh':
                define('APP_DIR', 'C:/xampp/htdocs/api-glucolib/');
                define('APP_INI', 'C:/xampp/htdocs/api-glucolib/'); 
                define('APP_ROOT', 'C:/xampp/htdocs/api-glucolib/'); 
                define('APP_LIBRARY', 'C:/xampp/htdocs/api-glucolib/library'); 
                define('WEB_DIR', 'http://api-glucolib.vh');
                define('CDN_WEB', 'http://api-glucolib.vh');
                define('DB_NAME', 'glucolib');
                define('DB_NAME_ESTADISTICAS', '');
                define('DB_NAME_GEO', '');
                define('WEB_OTHER', 'http://'.$_SERVER['SERVER_NAME']);
                define('DB_HOST', 'localhost');
                define('DB_USER', 'root');
                define('DB_PASS', '');
                define('CDN_DIR', 'cdn/app/');
        break;
        case 'api.glucolib.com':
                define('APP_DIR', '/home/samy061090/public_html/api/');
                define('APP_INI', '/home/samy061090/public_html/'); 
                define('APP_ROOT', '/home/samy061090/public_html/api/'); 
                define('APP_LIBRARY', '/home/samy061090/public_html/api/library'); 
                define('WEB_DIR', 'http://api.glucolib.com/');
                define('CDN_WEB', 'http://api.glucolib.com/');
                define('DB_NAME', 'glucolib');
                define('DB_NAME_ESTADISTICAS', '');
                define('DB_NAME_GEO', '');
                define('WEB_OTHER', 'http://'.$_SERVER['SERVER_NAME']);
                define('DB_HOST', 'localhost');
                define('DB_USER', 'concytec');
                define('DB_PASS', 'concytec');
                define('CDN_DIR', 'cdn/app/');
        break;


             
}

//define('IMAGENES_S3', 'http://d18wr2yp4p5cba.cloudfront.net/cdn/app/');

        define('library', APP_DIR.'library/');
        //define('web_service', 'https://dbfv50pped.execute-api.us-east-2.amazonaws.com/dev/');
        define('web_service', 'https://xoyoplognd.execute-api.us-east-2.amazonaws.com/dev/testGlucolib/');

//BD CONSTANTES
define('DB_SELECT', "1");
define('DB_INSERT', "2");
define('DB_UPDATE', "3");
define('DB_DELETE', "4");
define('DB_PROCESS',"5");

//PARA EL GCM

//ZONA HORARIA
define('DB_TIMEZONE', " SET time_zone = 'America/Lima' ");
define('DB_CHARSET', " SET NAMES 'utf8' ");

//VALIDACIONES
define('XMLHTTPREQUEST', "XMLHttpRequest");
define('CODVERSION', "?v=0.2.12.3");



//S3

define("_IMAGENES_S3_",'http://d18wr2yp4p5cba.cloudfront.net/cdn/app/');

define("_AWSACCESSKEY_S3_", "AKIAI6GNDI6Q5ETWDFRA");
define("_AWSSECRETKEY_S3_", "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");
define('BUCKET_S3', 'heyshop');


//CONSTANTE PARA ENTORNO DE PRODUCCION
ini_set('error_reporting', E_ALL | E_NOTICE );
ini_set('display_errors', true ); //Cambiamos a 0 para no mostrar errores
ini_set('track_errors', 'On');


require_once (library.'Libs.php');
?>