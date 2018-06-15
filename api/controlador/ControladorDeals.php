<?php

/**
 * Description of ControladorIndex
 *
 * @author Segundo
 */
class ControladorDeals extends ControladorGeneral {
    
    public function listado(){

        $objEstadistica = new ModeloEstadisticas();
        $objDeals = new ModeloDeals();
        $respuesta  = new stdClass();
        $data       = new stdClass();


        //Seteamos las variables de respuesta
        $respuesta->respuesta = "ERROR";
        $respuesta->mensaje = "Hubo problemas con su información, intentelo más tarde";


        //Seteamos las variables de los procesos
        $data->idfacebook       = "";
        $data->iddispositivo    = "";
        $data->userlatitud      = "";
        $data->userlongitud     = "";
        $data->registro         =  TIEMPO;

        $data->devicewidth      = "";
        $data->deviceheight     = "";
        $data->carpeta          = $this->Dispositivo->carpeta;
        
        
        //Validamos los parametros recibidos

        
        if( isset( $_POST['idfacebook'] ) && $_POST['idfacebook'] != '' ){
            $data->idfacebook =  $_POST['idfacebook'];
        }

        if( isset( $_POST['iddispositivo'] ) && $_POST['iddispositivo'] != '' ){
            $data->iddispositivo =  $_POST['iddispositivo'];
        }

        if( isset( $_POST['userlatitud'] ) && $_POST['userlatitud'] != ''   ){
            $data->userlatitud =  $_POST['userlatitud'];
        }else{
            $data->userlatitud =  $this->Dispositivo->apilatitud;
        }

        if( isset( $_POST['userlongitud'] ) && $_POST['userlongitud'] != '' ){
            $data->userlongitud =  $_POST['userlongitud'];
        }else{
            $data->userlongitud =  $this->Dispositivo->apilongitud;
        }
        
        
        
        
        if( isset( $_POST['devicewidth'] ) && $_POST['devicewidth'] != '' ){
            $data->devicewidth =  $_POST['devicewidth'];
        }

        if( isset( $_POST['deviceheight'] ) && $_POST['deviceheight'] != '' ){
            $data->deviceheight =  $_POST['deviceheight'];
        }

        
        
        $this->Dispositivo->userlatitud     = $data->userlatitud;
        $this->Dispositivo->userlongitud    = $data->userlongitud;
        $this->Dispositivo->iddispositivo   = $data->iddispositivo;
        $this->Dispositivo->devicewidth     = $data->devicewidth;
        $this->Dispositivo->deviceheight    = $data->deviceheight;
        //$this->Dispositivo->tienda_id        = "";
        
        
        if(  $data->idfacebook != '' && $data->iddispositivo != '' ){
            
            //Seteamos datos de la estadistica
            $this->Dispositivo->estadisticas_tipos_id    = "11";//Verificación de cuenta de usuario 
            $this->Dispositivo->idfacebook               = $data->idfacebook;
            $this->Dispositivo->seccion                  = "deals-listado";
            
            
            $this->Dispositivo->registro                 = date("Y-m-d H:i:s");
            //$objEstadistica->registrametrica($this->Dispositivo);

            $listado = $objDeals->listadoDeals($data);
            //$listado = $objDeals->listadoDeals('10206095309363293','-12.107116', '-76.971586', '0.250');
            $respuesta->listado    = $listado;
            $respuesta->respuesta = "OK";
            $respuesta->mensaje = "Listado deals";
            
        }  else {
                $respuesta->respuesta = "ERROR";
                $respuesta->mensaje = "No se recibieron parámetros";
        }
        
        $this->MotorVista->show($respuesta);
        
        if(isset($respuesta->listado)){
            for($p= 0; $p<count($respuesta->listado); $p++){
            
                $dataDeal                                   = $objDeals->obtenerInfoDeal($data,$respuesta->listado[$p]->promotion_id);
                $this->Dispositivo->estadisticas_tipos_id   = "21";//cantidad de deals enviados
                $this->Dispositivo->seccion                 = "deals-enviados";
                $this->Dispositivo->promotion_id            = $respuesta->listado[$p]->promotion_id;
                $this->Dispositivo->category_id             = $dataDeal[0]->category_id;
                $this->Dispositivo->customer_id             = $dataDeal[0]->cli_id;
                $this->Dispositivo->marca_id                = $dataDeal[0]->marca_id; 
                $this->Dispositivo->tienda_id               = $respuesta->listado[$p]->tienda_id; 
                $this->Dispositivo->sucursal_id             = $respuesta->listado[$p]->sucursal_id; 
                
                //$objEstadistica->registrametrica($this->Dispositivo);
            
            }
        }
        
    }
        
    public function crearDeal(){
    
            $obj        = new ModeloDeals();
            $respuesta  = new stdClass();
            $data       = new stdClass();

            $respuesta->respuesta   = "ERROR";
            $respuesta->mensaje     = "No se recibieron parámetros";
            $data->cliente_id       = "1";
            $data->sucursal_id      = "13";
            $data->tienda_id        = "";
            $data->marca_id         = "";
            $data->titulo           = "";
            $data->categoria_id     = "";
            $data->registro         =  TIEMPO;
            $data->hora             =  HORA;
            $data->hora_fin         =  aumentaHoras(TIEMPO,2);
            $data->fin              =  aumentaDiasFecha(TIEMPO, 5);
            $data->descripcion      = "descripción";
            $data->consideraciones  = "consideraciones";
            $data->deal_foto        = "flyer_deal.jpg";
            
            if( isset( $_POST['tienda_id'] ) && $_POST['tienda_id'] != '' ){
                $data->tienda_id =  $_POST['tienda_id'];
            }
            
            if( isset( $_POST['marca_id'] ) && $_POST['marca_id'] != '' ){
                $data->marca_id =  $_POST['marca_id'];
            }
            
            if( isset( $_POST['titulo'] ) && $_POST['titulo'] != '' ){
                $data->titulo =  $_POST['titulo'];
            }
            
            if( isset( $_POST['categoria_id'] ) && $_POST['categoria_id'] != '' ){
                $data->categoria_id =  $_POST['categoria_id'];
            }
            if($data->tienda_id != "" && $data->marca_id!="" && $data->titulo!="" && $data->categoria_id!=""){
                $respuesta->listado     = $obj->crearDeal($data);
                $respuesta->respuesta   = "OK";
                $respuesta->mensaje     = "Deal creado con éxito";
                $this->MotorVista->show($respuesta); 

            }else { 
                $this->MotorVista->show($respuesta); 
            }
            
    }
    

}

?>