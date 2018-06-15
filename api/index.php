<?php

ini_set('default_charset', 'utf-8');

//echo $_SERVER["DOCUMENT_ROOT"];

require_once 'config.php'; //Llamamos el archivo de configuracion
require_once APP_DIR . 'core/patron.php'; //Llamamos el archivo de configuracion

header('P3P: CP="IDC DSP COR CURa DMa OUR IND PHY ONL COM STA"');
session_name("heyshopmadafaca");
session_start();



require_once APP_DIR . 'core/TiempoClass.php'; //Llamamos el archivo de configuracion del tiempo
TiempoClass::defineTiempo();
define('TIEMPO', date("Y-m-d H:i:s") );
define('HORA', date("H:i:s") );


//DATA DEL UAPARSER

//require_once APP_LIBRARY . 'uaparser/UAParser.php';



require_once APP_DIR . 'core/UtilitarioClass.php';

require APP_DIR . 'core/Vista.php'; //Mini motor de plantillas
require APP_DIR . 'core/ControladorGeneral.php'; //Mini motor de plantillas


require_once APP_DIR . 'core/controlador.php'; //Llamamos el archivo de configuracion de los modulos
Controlador::inicia();



?>