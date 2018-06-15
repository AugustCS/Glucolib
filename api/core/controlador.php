<?php

class Controlador{

    static function inicia() {       
        
        /*
         * Ahora validaremos existencia de modulos,metodos y parametros recibidos 
         * Dependiendo del controlador se llamará a su modelo donde contiene todos los datos
         */
        
        //Seteamos el modulo
        $_GET['modulo'] = str_replace(".php", "", $_GET['modulo']);
        $_GET['modulo'] = str_replace("index", "Index", $_GET['modulo']);
        if (!empty($_GET['modulo'])) {
            //reemplazamos los guiones dle medio		
            $moduloName = 'Controlador'.ucfirst($_GET['modulo']);
            $moduloName = str_replace('-', '_', $moduloName);
            $modelname = 'Modelo'.ucfirst($_GET['modulo']);
        } else {
            $moduloName = "ControladorIndex";
            $modelname = 'ModeloIndex';
        }
        
        //Seteamos el metodo
        //Lo mismo sucede con las acciones, si no hay accion, tomamos index como accion
        
        if (!empty($_GET['metodo'])) {
            $metodoName = ucfirst($_GET['metodo']);
        } else {
            $metodoName = "index";
        }

        //echo APP_DIR."controlador/".$moduloName.".php";


        /*
        echo 'Controlador: '.$moduloName.'<br>';
        echo 'Modelo: '.$modelname.'<br>';
        echo 'Metodo: '.$metodoName.'<br>';
        */
        
        //Validamos que exista el modulo
        if (is_file(APP_DIR."controlador/".$moduloName.".php")) {
            require APP_DIR."controlador/".$moduloName.".php";
        } else {
            //Aqui podemos ver
            die('El modulo: '.$moduloName.' no existe - 404 not found');
            //require APP_DIR.'vista/error/error404.php';
            //exit();
        }

        

        //Si todo fue bien ahora validamos el metodo del modulo        
        $metodoName = str_replace('-', '_', $metodoName);
        if (is_callable(array($moduloName, $metodoName)) == false) {
            //trigger_error($moduloName . '->' . $metodoName . ' no existe', E_USER_NOTICE);
            require APP_DIR.'vista/error/error404metodo.php'; 
            exit();
            
        } else {
            /*
             * Si todo va bien llamo al modelo padre y al modelo del modulo 
             * y genero una instancia del modelo llamando a la accion u.u
             */
            //require APP_DIR."modelo/ModeloConexion.php";
            require APP_DIR."modelo/ModeloConexion.php";
            require APP_DIR."modelo/ModeloEstadisticas.php";
            require APP_DIR."modelo/".$modelname.".php";
            
            //Generamos la instancia

            $modulo = new $moduloName();
            $modulo->$metodoName();
            
        }
        
    }
}
?>