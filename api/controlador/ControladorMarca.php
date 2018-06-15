<?php

/**
 * Description of ControladorIndex
 *
 * @author Segundo
 */
class ControladorMarca extends ControladorGeneral {


    public function registro() {

        $dato = new stdClass();
        $dato->respuesta = "OK";
        $dato->get = $_GET;


        $this->MotorVista->show($dato);
    }

    public function listado(){


        $objMarcam = new ModeloMarca();
        
        require_once APP_DIR."modelo/ModeloUsuario.php";  
    	$objUsuario = new ModeloUsuario();
    	
        $operacion = new stdClass();
        $operacion->idusuario = "1";
        $operacion->nombre = "Pepito Sanchez";
        $operacion->apellido = "1";
        $operacion->edad = "20";
        $operacion->cumpleanios = "1";

    	$data = new stdClass();
        $data->respuesta = "respuesta";
        $data->error = "error";
    	$data->lista = $objUsuario->getUsers();




        $objUsuario->updateUser( $operacion );


        
    	//print_r($data);

    	
        /*
    	for ( $i = 0; $i < $data->lista['TOTAL']; $i++) {
            echo ''.$data->lista['LISTA'][$i]->PERNOMBRE.'<br>';
        } 
        */

        //$this->MotorVista->show($data);



    }

}

?>