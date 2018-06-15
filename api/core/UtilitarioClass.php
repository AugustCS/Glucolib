<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UtilitarioClass
 *
 * @author Segundo
 */
class UtilitarioClass {

    static function decodeutf8($cadena){
        //return utf8_decode( $cadena );
        return $cadena;
    }


    
    static function fecha_completo($cadena) {

        $mes = array('01' => "Enero",
                     '02' => "Febrero",
                     '03' => "Marzo",
                     '04' => "Abril",
                     '05' => "Mayo",
                     '06' => "Junio",
                     '07' => "Julio",
                     '08' => "Agosto",
                     '09' => "Setiembre",
                     '10' => "Octubre",
                     '11' => "Noviembre",
                     '12' => "Diciembre");
        
        if( $cadena !== '0000-00-00 00:00:00' ){

            $dia = substr($cadena, 8, 2);
            $pos = substr($cadena, 5, 2);
            
            return $dia.' de '.$mes[$pos].' de '.substr($cadena, 0, 4);

        }else{

            return "";
            
        }
    }


    static function fecha_dia_mes($cadena) {


        $mes = array('01' => "Enero",
                     '02' => "Febrero",
                     '03' => "Marzo",
                     '04' => "Abril",
                     '05' => "Mayo",
                     '06' => "Junio",
                     '07' => "Julio",
                     '08' => "Agosto",
                     '09' => "Setiembre",
                     '10' => "Octubre",
                     '11' => "Noviembre",
                     '12' => "Diciembre");
        
        if( $cadena !== '0000-00-00 00:00:00' ){

            $dia = substr($cadena, 8, 2);
            $pos = substr($cadena, 5, 2);

            return $dia.' de '.$mes[$pos];
        }else{
            return "";
        }
        
    }

    static function pre($array) {
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }

    static function extract_mes_literal($cadena) {


        $mes = array('01' => "Enero",
                     '02' => "Febrero",
                     '03' => "Marzo",
                     '04' => "Abril",
                     '05' => "Mayo",
                     '06' => "Junio",
                     '07' => "Julio",
                     '08' => "Agosto",
                     '09' => "Setiembre",
                     '10' => "Octubre",
                     '11' => "Noviembre",
                     '12' => "Diciembre");
        
            $pos = substr($cadena, 5, 2);

            return $mes[$pos];
       
        
    }

    static function fecha_anio($cadena) {        
        
        if( $cadena !== '0000-00-00 00:00:00' ){
            return substr($cadena, 0, 4);
        }else{
            return "";
        }
                
    }


    static function extract_dia($cadena){
        
        return substr($cadena, 8, 2);
        
    }

    static function extract_mes($cadena){
        
        return substr($cadena, 5, 2);
        
    }

    static function extract_anio($cadena){
        
        return substr($cadena, 0, 4);
        
    }




    static function fecha_espaniol($cadena) {
        
        return substr($cadena, 8, 2) . '/' . substr($cadena, 5, 2) . '/' . substr($cadena, 0, 4);
        
    }

    static function fecha_data($cadena) {
        
        return substr($cadena, 8, 2) . '-' . substr($cadena, 5, 2) . '-' . substr($cadena, 0, 4);
        
    }

    static function paginacion($actual, $total, $por_pagina, $enlace, $pag_visibles) {

        $total_paginas = ceil($total / $por_pagina);
        $anterior = $actual - 1;
        $posterior = $actual + 1;
        $contador = 0;
        $err = '';
        $texto = '';

        if ($actual >= $pag_visibles) {
            $iactual = $actual - round($pag_visibles / 2);

            if ($iactual > round(($total / $por_pagina) - $pag_visibles) + 1) {
                $iactual = round(($total / $por_pagina) - $pag_visibles) + 1;
            }
        }
        else
            $iactual = 1;

        if ($total_paginas > 1) {

            if ($actual > 1) {
                $texto .= '<a class="primero" href="' . $enlace . '1"></a>';
            }


            if ($actual > 1) {
                $texto .= "<a class=\"anterior\" href=\"$enlace$anterior\"> </a>";
            } else {
                $texto .= "<a class=\"anterior\" ></a>";
            }

            //empezamos el for
            //echo $iactual.' -- '.$actual.' -- '.$pag_visibles;
            $timp = round($total / $por_pagina) + 1;
            //echo $total.' -- '. round($total / $por_pagina). ' -- '.$actual;		

            if ($timp >= $actual) {
                for ($i = $iactual; $i < $actual; $i++) {
                    $texto .= "<a class=\"normal\" href=\"$enlace$i\">$i</a>";
                    $contador++;
                }
            } else {
                $auxpag = explode('?', $enlace);
                echo ' No existen resultados para esta p&aacute;gina. <a href="$auxpag[0]">Regresar</a>  ';
                $err = 1;
                //echo $auxpag[0];
                //header('Location: $auxpag');					
            }

            $texto .= "<a class=\"seleccion\">$actual</a>";
            $contador++;

            for ($i = $actual + 1; $i <= $total_paginas; $i++) {
                $texto .= "<a class=\"normal\" href=\"$enlace$i\">$i</a>";
                $contador++;
                if ($contador == $pag_visibles) {
                    $i = $total_paginas;
                }
            }//fin del for

            if ($actual < $total_paginas) {
                $texto .= "<a class=\"siguiente\" href=\"$enlace$posterior\"></a>";
            } else {
                $texto .= "";
            }

            if ($actual < $total_paginas) {
                $texto .= '<a class="ultimo" href="' . $enlace . $total_paginas . '"></a>';
            }


            if ($err == 1) {
                $texto = '';
            }




            return $texto;
        }
    }

}

?>