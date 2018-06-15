<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControladorImagenes
 *
 * @author Habitalo
 */
class ControladorImagenes extends ControladorGeneral {
    //put your code here
    public function listado() {
        $obj        =  new ModeloImagenes();
        $data       =  new stdClass();
        $respuesta  =  new stdClass();
        
        
        $listado = $obj->getFormatosImagenes($data);
        $respuesta->listado = $listado;
        $this->MotorVista->show($respuesta);

    }
    
    
}
