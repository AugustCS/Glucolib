<?php
/**
 * Description of ModeloIndex
 *
 * @author Segundo
 */
class ModeloEstadisticas{
    
    public function registrametrica( $obj ){
//DB_NAME_ESTADISTICAS
        $sql = "INSERT INTO estadisticas
        (estadisticas_tipos_id, category_id, promotion_id, idfacebook, iddispositivo, brand_id, customer_id, registro, estado, 
                            ip, browser, sistema, sistemaversion, apilatitud, apilongitud, userlatitud, userlongitud, seccion,
                            browserversion, pais_nombre , pais_codigo, region_codigo, region_nombre, ciudad,dispositivo,movil,devicewidth,deviceheight,tienda_id,sucursal_id)

        VALUES ('$obj->estadisticas_tipos_id', '$obj->category_id', '$obj->promotion_id', '$obj->idfacebook', '$obj->iddispositivo', 
                '$obj->marca_id', '$obj->customer_id', '$obj->registro', '0',
                '$obj->ip', '$obj->browser', '$obj->sistema', '$obj->sistema_version', '$obj->apilatitud', '$obj->apilongitud', 
                '$obj->userlatitud', '$obj->userlongitud', '$obj->seccion', '$obj->browser_version', '$obj->pais_nombre' , '$obj->pais_codigo' , 
                '$obj->region_codigo', '$obj->region_nombre', '$obj->ciudad', '$obj->dispositivo', '$obj->movil','$obj->devicewidth','$obj->deviceheight','$obj->tienda_id','$obj->sucursal_id') ";

        
        return  ModeloConexion::ejecutar( $sql , DB_NAME_ESTADISTICAS ,DB_INSERT);
         

    }
    public function registrametricaMultiple( $obj,$total ){
        $values ='';
        $insert = "INSERT INTO estadisticas
        (estadisticas_tipos_id, category_id, promotion_id, idfacebook, iddispositivo, brand_id, customer_id, registro, estado, 
                            ip, browser, sistema, sistemaversion, apilatitud, apilongitud, userlatitud, userlongitud, seccion,
                            browserversion, pais_nombre , pais_codigo, region_codigo, region_nombre, ciudad,dispositivo,movil ) VALUES ";
        
        for($i= 0; $i<$total; $i++){
           $values .= "('$obj->estadisticas_tipos_id', '$obj->category_id', '$obj->promotion_id', '$obj->idfacebook', '$obj->iddispositivo', 
                '$obj->brand_id', '$obj->customer_id', '$obj->registro', '0',
                '$obj->ip', '$obj->browser', '$obj->sistema', '$obj->sistema_version', '$obj->apilatitud', '$obj->apilongitud', 
                '$obj->userlatitud', '$obj->userlongitud', '$obj->seccion', '$obj->browser_version', '$obj->pais_nombre' , '$obj->pais_codigo' , 
                '$obj->region_codigo', '$obj->region_nombre', '$obj->ciudad', '$obj->dispositivo', '$obj->movil'), "; 
        }
        $sql = eliminaUltimocaracter($insert.$values);
        echo $sql;
        return ModeloConexion::ejecutar( $sql , DB_NAME ,DB_INSERT);

    }

    public function listadispositivos(){

        $sql = "SELECT * 
                FROM dispositivo_usuario";

        return ModeloConexion::ejecutar( $sql , DB_NAME , DB_SELECT );

    }

    
}

?>