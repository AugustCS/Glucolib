<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControladorTiendas
 *
 * @author Habitalo
 */
class ControladorTiendas extends ControladorGeneral {    

        public function listado(){


        
    	$obj                   = new ModeloTiendas();
        $respuesta             = new stdClass();
        $data                  = new stdClass();
        
        $data->respuesta       = "respuesta";
        $data->error           = "error";
    	
        //$respuesta->listado     = $obj->listado($data);
        $respuesta->respuesta  = "OK";
        $respuesta->mensaje    = "Listado de gustos completo";
        $this->MotorVista->show($respuesta);


    }
    
        public function registrar(){
            
            $obj        = new ModeloTiendas();
            $respuesta  = new stdClass();
            $data       = new stdClass();

            //Seteamos las variables de respuesta
            $respuesta->respuesta   = "ERROR";
            $respuesta->mensaje     = "No se recibieron parámetros";

            $data->tienda_nombre    = "";
            $data->tienda_direccion = "";
            $data->latitud          = "";
            $data->longitud         = "";
            $data->cliente_id       = "1";
            $data->sucursal_id      = "13"; //sucursal appvenrure
            $data->registro         = TIEMPO;
            $data->tienda_foto      = "logo_tienda.jpg";
            $data->marca_foto       = "logo_marca.jpg";
            $data->tienda_id        = "";
            $data->marca_id         = "";
            
            if( isset( $_POST['tienda_nombre'] ) && $_POST['tienda_nombre'] != '' ){
                $data->tienda_nombre = $_POST['tienda_nombre'];
            }

            if( isset( $_POST['tienda_direccion'] ) && $_POST['tienda_direccion'] != '' ){
                $data->tienda_direccion =  $_POST['tienda_direccion'];
            }

            if( isset( $_POST['latitud'] ) && $_POST['latitud'] != '' ){
                $data->latitud =  $_POST['latitud'];
            }

            if( isset( $_POST['longitud'] ) && $_POST['longitud'] != '' ){
                $data->longitud =  $_POST['longitud'];
            }

            if($data->tienda_nombre!="" && $data->tienda_direccion!="" && $data->latitud!="" && $data->longitud!=""){
                $respuesta = $obj->crearTiendas($data);    
            }
            
            $this->MotorVista->show($respuesta);
            
            
        }
        
        
        public function listarTiendas(){
            
            $obj        = new ModeloTiendas();
            $respuesta  = new stdClass();
            $data       = new stdClass();

            $data->sucursal_id      = "13";
            $respuesta->listado     = $obj->listarTiendas($data);
            $respuesta->respuesta   = "OK";
            $respuesta->mensaje     = "Listado de tiendas completo";
            $this->MotorVista->show($respuesta);  
            
        }
        
        public function listarMarcas(){
            
            $obj        = new ModeloTiendas();
            $respuesta  = new stdClass();
            $data       = new stdClass();

            $respuesta->respuesta        = "ERROR";
            $respuesta->error            = "NO SE RECIBIERON PARÁMETROS";
            $data->sucursal_id      = "13";
            $data->tienda_id        = "";
            
            if( isset( $_POST['tienda_id'] ) && $_POST['tienda_id'] != '' ){
                $data->tienda_id        =  $_POST['tienda_id'];
                $respuesta->listado     = $obj->listarMarcasxTiendas($data);
                $respuesta->respuesta   = "OK";
                $respuesta->mensaje     = "Listado de marcas";
            }
            $this->MotorVista->show($respuesta);  
            
            
            
        }
        
        public function listarCategorias(){
            
            $obj        = new ModeloTiendas();
            $respuesta  = new stdClass();
            $data       = new stdClass();

            $data->cliente_id       = "1";
            $respuesta->listado     = $obj->listarCategoriasxCliente($data);
            $respuesta->respuesta   = "OK";
            $respuesta->mensaje     = "Listado de Categorias";
            $this->MotorVista->show($respuesta);  
            
            
            
        }
     
}
