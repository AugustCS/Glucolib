<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ModeloImagenes
 *
 * @author Habitalo
 */
class ModeloImagenes {
    //put your code here
    
    public function getFormatosImagenes() {
        $sql  =  "SELECT id,carpeta,ancho,alto,extension,tipo,registro,estado from imagenes_formatos where estado=1";
        $data =  ModeloConexion::ejecutar( $sql , DB_NAME ,DB_SELECT);
        $respuesta = array();
                for ( $i = 0; $i < $data['TOTAL']; $i++) {
                    $rp = new stdClass();
                    $rp->id         = $data['LISTA'][$i]->id;
                    $rp->carpeta    = $data['LISTA'][$i]->carpeta;
                    $rp->ancho      = $data['LISTA'][$i]->ancho;
                    $rp->alto       = $data['LISTA'][$i]->alto;
                    $rp->extension  = $data['LISTA'][$i]->extension;
                    $rp->tipo       = $data['LISTA'][$i]->tipo;
                    $rp->registro   = $data['LISTA'][$i]->registro;
                    $rp->estado     = $data['LISTA'][$i]->estado;
                    $respuesta[] = $rp;
                }
    	return $respuesta;

    }
    public function insertCollectionImageTiendas($obj){
        $getFormatosImagenes = $this->getFormatosImagenes();
        $values = "";
        $insert = "INSERT into imagenes (imagenes_formatos_id,imagenes_tipos_id,origen, registro, tipo,empresas_id,tiendas_id) VALUES ";
        for($m=0; $m<count($getFormatosImagenes);$m++){
            $values .= "('".$getFormatosImagenes[$m]->id."','4','$obj->tienda_foto','$obj->registro','1','$obj->cliente_id','$obj->tienda_id'),";
        }
        $sql = eliminaUltimocaracter($insert.$values);
        //pre($sql);
          ModeloConexion::ejecutar( $sql , DB_NAME ,DB_INSERT);
    }
    
    public function insertCollectionImageDeals($obj){
        $getFormatosImagenes = $this->getFormatosImagenes();
        $values = "";
        $insert = "INSERT into imagenes (imagenes_formatos_id,imagenes_tipos_id,origen, registro, tipo,empresas_id,tiendas_id,marcas_id,deals_id) values ";
        for($m=0; $m<count($getFormatosImagenes);$m++){
            $values .= "('".$getFormatosImagenes[$m]->id."','2','$obj->deal_foto','$obj->registro','1','$obj->cliente_id','$obj->tienda_id','$obj->marca_id','$obj->deal_id'),";
        }
        $sql = eliminaUltimocaracter($insert.$values);
          ModeloConexion::ejecutar( $sql , DB_NAME ,DB_INSERT);
        return 1;
    }
    
    
    public function insertCollectionImageMarcas($obj){
        $getFormatosImagenes = $this->getFormatosImagenes();
        $values = "";
        $insert = "INSERT into imagenes (imagenes_formatos_id,imagenes_tipos_id,origen, registro, tipo,empresas_id,tiendas_id,marcas_id) values ";
        for($m=0; $m<count($getFormatosImagenes);$m++){
            $values .= "('".$getFormatosImagenes[$m]->id."','3','$obj->marca_foto','$obj->registro','1','$obj->cliente_id','$obj->tienda_id','$obj->marca_id'),";
        }
        $sql = eliminaUltimocaracter($insert.$values);
        //pre($sql);
          ModeloConexion::ejecutar( $sql , DB_NAME ,DB_INSERT);
    }
    
    
}
