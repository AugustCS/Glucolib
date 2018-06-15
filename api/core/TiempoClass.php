<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TiempoClass
 *
 * @author Segundo
 */
class TiempoClass {
    //put your code here
    static function defineTiempo(){
        
        /*
         * Definiremos el tiempo en base al pais de la sesion
         * en caso de no existir daremos por defecto el de venezuela
         * date_default_timezone_set('America/Caracas');
         *
        
        if( isset($_SESSION['codigo_pais']) && $_SESSION['codigo_pais'] != ''  ){
            switch ($codigoTiempo){
                case 1:{
                    date_default_timezone_set('America/Caracas'); //para Venezuela
                    break;
                }
                case 2:{
                    date_default_timezone_set('America/Lima'); //para Perú
                    break;
                }
            }
        }else{
            date_default_timezone_set('America/Caracas'); //tiempo por defecto el de Venezuela
        }
        */

        date_default_timezone_set('America/Lima'); //para Perú
        
        
    }
}

?>