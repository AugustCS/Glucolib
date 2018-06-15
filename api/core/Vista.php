<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Vista
 *
 * @author Segundo
 */
class Vista {

    public function show( $vars = "" ) {
        //$name es el nombre de nuestra plantilla, por ej, listado.php
        //$vars es el contenedor de nuestras variables, es un arreglo del tipo llave => valor, opcional.     

        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        //header('Content-type: application/json; charset=utf-8');
        //header('Content-Type: application/json;');
        //header('Content-Type: charset=utf-8');
        header('Content-type: text/html; charset=utf-8');
        header('Access-Control-Allow-Origin: *');

        
        $vars->tiempo = date("Y-m-d H:i:s") ;

        echo json_encode($vars);

        //Guardamos los datos
        $file = fopen(APP_DIR."archivo.txt", "a");

        fwrite($file, print_r($_REQUEST, TRUE));
        fwrite($file, print_r($vars, TRUE));
        fclose($file);


        /*
Content-Type    text/html; charset=UTF-8

        //Armamos la ruta a la plantilla
        $path = VISTA. $name.'.php';

        //Si no existe el fichero en cuestion, tiramos un 404
        if (file_exists($path) == false) {
            //trigger_error('Template `' . $path . '` does not exist.', E_USER_NOTICE);
            echo 'No existe la vista: '.$path;
            return false;
        }

        //print_r($vars);

        if (is_array($vars)) {
            foreach ($vars as $key => $value) {
                $$key = $value;
                //print_r($$key);
            }
        }
        

        //Finalmente, incluimos la plantilla.
        include($path);
        */
    }

}

/*
  El uso es bastante sencillo:
  $vista = new View();
  $vista->show('listado.php', array("nombre" => "Juan"));
 */
?>