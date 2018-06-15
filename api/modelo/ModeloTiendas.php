<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ModeloTiendas
 *
 * @author Habitalo
 */
class ModeloTiendas {
    //put your code here
    public function listado() {
        $sql =  "SELECT * FROM tiendas ORDER BY nombre ASC";
        $data =  ModeloConexion::ejecutar( $sql , DB_NAME ,DB_SELECT);
        $respuesta = array();
                for ( $i = 0; $i < $data['TOTAL']; $i++) {
                    $rp = new stdClass();
                    $rp->tienda_nombre  = $data['LISTA'][$i]->nombre;
                    $rp->latitud        = $data['LISTA'][$i]->latitud;
                    $rp->longitud       = $data['LISTA'][$i]->longitud;
                    $rp->tienda_id      = $data['LISTA'][$i]->id;
                    $respuesta[] = $rp;
                }
    	return $respuesta;
    }
    
    public function listarTiendas($obj) {
        $sql =  "SELECT * FROM tiendas WHERE sucursales_id = '$obj->sucursal_id' ORDER BY nombre ASC";

        $data =  ModeloConexion::ejecutar( $sql , DB_NAME , DB_SELECT);
        $respuesta = array();
                for ( $i = 0; $i < $data['TOTAL']; $i++) {
                    $rp = new stdClass();
                    $rp->tienda_nombre  = $data['LISTA'][$i]->nombre;
                    $rp->tienda_id      = $data['LISTA'][$i]->id;
                    $respuesta[] = $rp;
                }
        return $respuesta;
    }

    
    public function listarMarcasxTiendas($obj) {
        $sql =  "SELECT * FROM  marcas WHERE sucursales_id = '$obj->sucursal_id' AND tiendas_id = '$obj->tienda_id' ORDER BY nombre ASC";
        $data =  ModeloConexion::ejecutar( $sql , DB_NAME ,DB_SELECT);
        $respuesta = array();
                for ( $i = 0; $i < $data['TOTAL']; $i++) {
                    $rp = new stdClass();
                    $rp->marca_nombre   = $data['LISTA'][$i]->nombre;
                    $rp->marca_id       = $data['LISTA'][$i]->id;
                    $respuesta[] = $rp;
                }
        return $respuesta;
    }
    
    public function listarCategoriasxCliente($obj) {
        $sql = "SELECT id,nombre 
                FROM categorias
                ORDER BY nombre ASC";
        $data =  ModeloConexion::ejecutar( $sql , DB_NAME ,DB_SELECT);
        $respuesta = array();
                for ( $i = 0; $i < $data['TOTAL']; $i++) {
                    $rp = new stdClass();
                    $rp->categoria_id           = $data['LISTA'][$i]->id;
                    $rp->categoria_nombre       = $data['LISTA'][$i]->nombre;
                    $respuesta[] = $rp;
                }
        return $respuesta;
    }
    
    public function crearTiendas($obj) {

        require APP_DIR."modelo/ModeloImagenes.php";
        require APP_DIR."modelo/S3.php";

        
        $s3                         = new S3(_AWSACCESSKEY_S3_, _AWSSECRETKEY_S3_);
        $objImagenes                = new ModeloImagenes();
        $respuesta                  = new stdClass();
        
        $CDN_DIR                    = _IMAGENES_S3_;
        $bucketTienda               = 'tienda/original/';
        $bucketMarca                = 'marca/original/';
        $carpeta_tienda_origen      = $CDN_DIR.$bucketTienda;
        $carpeta_tienda_destino     = CDN_DIR.$bucketTienda;
        
        $carpeta_marca_origen       = $CDN_DIR.$bucketMarca;
        $carpeta_marca_destino      = CDN_DIR.$bucketMarca;
        
        //IMAGEN DE ORIGEN TIENDA
        $fileorigin         = $carpeta_tienda_origen.$obj->tienda_foto;
        $nombre             = md5($obj->tienda_foto).'.jpg';
        $obj->tienda_foto   = $nombre;
        //INICIAMOS EL PROCESO DE GENERACION DE LA NUEVA IMAGEN  TIENDA
        $newfile            = $carpeta_tienda_destino.$nombre;
        $img                = imagecreatefromjpeg($fileorigin);
        $width              = imagesx( $img );
        $height             = imagesy( $img );
        // create a new temporary image
        $tmp_img            = imagecreatetruecolor( $width, $height );
        imagecopyresampled($tmp_img, $img, 0, 0, 0, 0, $width, $height, $width, $height);

        $filename           = tempnam(sys_get_temp_dir(), "foo");
        imagejpeg($tmp_img, $filename);
        
        
        
        //IMAGEN DE ORIGEN MARCA
        $fileoriginMarca    = $carpeta_marca_origen.$obj->marca_foto;
        $nombreMarca        = md5($obj->marca_foto).'.jpg';
        $obj->marca_foto    = $nombreMarca;
        //INICIAMOS EL PROCESO DE GENERACION DE LA NUEVA IMAGEN  MARCA
        $newfileMarca       = $carpeta_marca_destino.$nombreMarca;
        $imgMarca           = imagecreatefromjpeg($fileoriginMarca);
        $widthMarca         = imagesx( $imgMarca );
        $heightMarca        = imagesy( $imgMarca );
        // create a new temporary image
        $tmp_imgMarca       = imagecreatetruecolor( $widthMarca, $heightMarca );
        imagecopyresampled($tmp_imgMarca, $imgMarca, 0, 0, 0, 0, $widthMarca, $heightMarca, $widthMarca, $heightMarca);

        $filenameMarca      = tempnam(sys_get_temp_dir(), "foo");
        imagejpeg($tmp_imgMarca, $filenameMarca);
        
                   
                   if ($s3->putObjectFile($filename, BUCKET_S3,$newfile, S3::ACL_PUBLIC_READ)) {
                       
                       //VERIFICAMOS SI LA TIENDA YA FUE CREADA
                       $verificaTienda = $this->verificaExistenciaTienda($obj);
                       
                       if($verificaTienda == 0){
                           $respuesta->proceso = "OK TIENDA";
                        //INSERTAMOS REGISTRO DE TIENDA
                        $obj->tienda_foto = $nombre;
                        $sql =  " INSERT INTO tiendas (empresas_id,sucursales_id,nombre,direccion,latitud,
                            longitud,tienda_cobertura,registro,original_foto) 
                            VALUES('$obj->cliente_id ','$obj->sucursal_id','$obj->tienda_nombre','$obj->tienda_direccion','$obj->latitud',
                                '$obj->longitud','100','$obj->registro','$obj->tienda_foto')";
                        
                        $data =  ModeloConexion::ejecutar( $sql , DB_NAME ,DB_INSERT);
                        $obj->tienda_id = $data['INSERT_ID'];
                        
                        $objImagenes->insertCollectionImageTiendas($obj);
                        
                        if ($s3->putObjectFile($filenameMarca, BUCKET_S3,$newfileMarca, S3::ACL_PUBLIC_READ)) {
                        $respuesta->proceso = "OK MARCA";
                       
                       //INSERTAMOS REGISTRO DE MARCA
                        $obj->tienda_foto = $nombre;
                        $sql =  " INSERT INTO marcas (`empresas_id`, `tiendas_id`, `sucursales_id`, `nombre`, `registro`, `original_foto`) 
                            VALUES('$obj->cliente_id ','$obj->tienda_id','$obj->sucursal_id','$obj->tienda_nombre','$obj->registro','$obj->marca_foto')";
                        $dato =  ModeloConexion::ejecutar( $sql , DB_NAME ,DB_INSERT);
                        $obj->marca_id = $dato['INSERT_ID'];
                        
                        $objImagenes->insertCollectionImageMarcas($obj);
                           
                       }else{
                           $respuesta->proceso = "Algo salió mal al subir el logo de Marca ... lo siento";
                       }
                        
                        
                        
                        
                       }
                    }else{
                        $respuesta->proceso = "Algo salió mal al subir el logo de Tienda ... lo siento";
                    }
        
    }
    public function verificaExistenciaTienda($obj) {
        $sql = "SELECT COUNT(*) AS CANTIDAD FROM tiendas WHERE empresas_id = '$obj->cliente_id' AND sucursales_id = '$obj->sucursal_id'AND nombre = '$obj->tienda_nombre'";
        $data =  ModeloConexion::ejecutar( $sql , DB_NAME ,DB_SELECT);
        $lista = $data['LISTA'];
        return   $lista[0]->CANTIDAD;
        
    }
    
}
