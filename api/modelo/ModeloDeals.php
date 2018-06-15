<?php


class ModeloDeals{
    
    


    
    
    
    public function obtenerInfoSucursal($obj) {
        $sql = "SELECT branch_nam,cli_id,address FROM `tb_branch` where branch_id ='$obj->local_id'";
        $data = ModeloConexion::ejecutar( $sql , DB_NAME ,DB_SELECT);
        $respuesta = array();
                for ( $i = 0; $i < $data['TOTAL']; $i++) {
                
                    $rp = new stdClass();
                    $rp->nombre_sucursal    = $data['LISTA'][$i]->branch_nam;
                    $rp->id_cliente         = $data['LISTA'][$i]->cli_id;
                    $rp->direccion          = $data['LISTA'][$i]->address;
                    $respuesta[]            = $rp;
                }
//            

    	return $respuesta;
    }
    
    public function obtenerInfoMarca($obj) {
        $sql =  "SELECT * FROM tb_customer_brand WHERE tienda_id= '$obj->tienda_id' AND id_customer_brand = '$obj->marca_id'";
        $data = ModeloConexion::ejecutar($sql,DB_NAME ,DB_SELECT);
        $respuesta = array();
                for ( $i = 0; $i < $data['TOTAL']; $i++) {
                    $rp = new stdClass();
                    $rp->marca_nombre   = $data['LISTA'][$i]->brand_name;
                    $rp->marca_logo     = $data['LISTA'][$i]->original_foto;
                    $respuesta[]        = $rp;
                }
//            
    	return $respuesta;
        
    }
    
    public function obtenerInfoTienda($obj) {
        $sql = "SELECT tienda_nombre,tienda_id,cliente_id,tienda_direccion FROM tiendas where tienda_id ='$obj->tienda_id'";
        $data = ModeloConexion::ejecutar( $sql , DB_NAME ,DB_SELECT);
        $respuesta = array();
                for ( $i = 0; $i < $data['TOTAL']; $i++) {
                
                    $rp = new stdClass();
                    $rp->tienda_nombre  = $data['LISTA'][$i]->tienda_nombre;
                    $rp->id_cliente     = $data['LISTA'][$i]->cliente_id;
                    $rp->direccion      = $data['LISTA'][$i]->tienda_direccion;
                    $respuesta[]        = $rp;
                }
//            

    	return $respuesta;
    }
 

    
    public function crearDeal($obj) {
        require APP_DIR."modelo/ModeloImagenes.php";
        require APP_DIR."modelo/S3.php";
        
        $s3                         = new S3(_AWSACCESSKEY_S3_, _AWSSECRETKEY_S3_);
        $objImagenes                = new ModeloImagenes();
        $respuesta                  = new stdClass();
        
        $CDN_DIR                    = _IMAGENES_S3_;
        $bucketDeal                 = 'deals/original/';
        $carpeta_deal_origen        = $CDN_DIR.$bucketDeal;
        $carpeta_deal_destino       = CDN_DIR.$bucketDeal;
        
        //IMAGEN DE ORIGEN DEAL
        $fileorigin         = $carpeta_deal_origen.$obj->deal_foto;
        $nombre             = md5(TIEMPO.$obj->deal_foto).'.jpg';
        $obj->deal_foto   = $nombre;
        //INICIAMOS EL PROCESO DE GENERACION DE LA NUEVA IMAGEN DEL DEAL
        
        
        $newfile            = $carpeta_deal_destino.$nombre;
        $img                = imagecreatefromjpeg($fileorigin);
        $width              = imagesx( $img );
        $height             = imagesy( $img );
        // create a new temporary image
        $tmp_img            = imagecreatetruecolor( $width, $height );
        imagecopyresampled($tmp_img, $img, 0, 0, 0, 0, $width, $height, $width, $height);
        $filename           = tempnam(sys_get_temp_dir(), "foo");
        imagejpeg($tmp_img, $filename);

        
        
            $dia_inicio     = $obj->registro." ".$obj->hora;
            $dia_fin        = $obj->fin." ".$obj->hora_fin;
        
                   if ($s3->putObjectFile($filename, BUCKET_S3,$newfile, S3::ACL_PUBLIC_READ)) {
                       $respuesta->proceso = "OK DEAL";
                       //INSERTAMOS REGISTRO DEL DEAL
                        $sql = "INSERT INTO deals (empresas_id, sucursales_id, tiendas_id, marcas_id, nombre, 
                            descripcion, dia_inicio, dia_fin, estado, consideraciones, 
                            imagen_original, registro)
                            VALUES ('$obj->cliente_id','$obj->sucursal_id','$obj->tienda_id', '$obj->marca_id', '$obj->titulo', '$obj->descripcion', 
                                '$dia_inicio','$dia_fin', 1, '$obj->consideraciones', '$obj->deal_foto','$obj->registro')";
                       
                        $data =  ModeloConexion::ejecutar( $sql , DB_NAME ,DB_INSERT);
                        $obj->deal_id = $data['INSERT_ID'];

                        if($obj->deal_id >0){

                            $sql_categorias =  "INSERT INTO categorias_deals(categorias_id,deals_id,registro)
                                            VALUES(
                                            '$obj->categoria_id',
                                            '$obj->deal_id',
                                            '$obj->registro'    
                                            )"; 
                             $data =  ModeloConexion::ejecutar( $sql_categorias , DB_NAME ,DB_INSERT);

                        }
                        
                        $procesarImagenes = $objImagenes->insertCollectionImageDeals($obj);
                        if($procesarImagenes == 1){
                            $respuesta->proceso = 'Ok Imagenes procesadas';
                        }

                    }else{
                        $respuesta->proceso = "Algo salió mal al subir el logo del DEAL ... lo siento";
                    }

                    return $respuesta->proceso;
    }
}

?>