<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ModeloGeneral
 *
 * @author Segundo
 */
class ControladorGeneral {

    //put your code here
    function __construct() {
        //Aqui inicializamos todo lo que necesitemos desde el inicio
        $this->MotorVista = new Vista();
        $this->MotorFecha = date("Y-m-d H:i:s");

        //PROCESO PARA DETECTAR EL DISPOSITIVO
        $this->Dispositivo = new stdClass();

        //Estos valores son seteados dependiendo de la petición
        $this->Dispositivo->estadisticas_tipos_id    = "";
        $this->Dispositivo->category_id              = "";
        $this->Dispositivo->promotion_id             = "";
        $this->Dispositivo->idfacebook               = "";
        $this->Dispositivo->iddispositivo            = "";
        $this->Dispositivo->devicewidth              = "";
        $this->Dispositivo->deviceheight             = "";
        $this->Dispositivo->seccion                  = "";
        $this->Dispositivo->registro                 = "";
        $this->Dispositivo->customer_id              = "";
        $this->Dispositivo->sucursal_id              = "";
        $this->Dispositivo->tienda_id                = "";
        $this->Dispositivo->marca_id                 = "";
        $this->Dispositivo->carpeta                  = "";
        $this->Dispositivo->carpeta_mediana          = "";
        $this->Dispositivo->carpeta_grande           = "";
        $this->Dispositivo->carpeta_pequena          = "";//
        //====================================================================================
        /*
        $ua = UA::parse();


        if (isset($ua->family)) {
            $this->Dispositivo->browser = $ua->family;
        } elseif (isset($ua->browser)) {
            $this->Dispositivo->browser = $ua->browser;
        } else {
            $this->Dispositivo->browser = $ua->browser;
        }

        if (isset($ua->os)) {
            $this->Dispositivo->sistema = $ua->os;
        } elseif (isset($ua->osFull)) {
            $this->Dispositivo->sistema = $ua->os;
        } else {
            $this->Dispositivo->sistema = $ua->os;
        }

        $this->Dispositivo->sistema_version = $ua->osVersion;
        $this->Dispositivo->browser_version = $ua->version;

        if (isset($ua->device)) {
            if ($ua->device == "Unknown") {
                $this->Dispositivo->dispositivo = $ua->device;
            } else {
                $this->Dispositivo->dispositivo = $ua->device;
            }
        } else {
            $this->Dispositivo->dispositivo = "Desktop";
        }
        if ($ua->isMobile || $this->Dispositivo->browser == "Android") {
            $this->Dispositivo->movil = "1";
        } else {
            $this->Dispositivo->movil = "0";
        }

        //PROCESO PARA LA GEOLOCALIZACION
        require_once(APP_LIBRARY . "geoip/geoipcity.inc");
        require_once(APP_LIBRARY . "geoip/geoipregionvars.php");
        $gi = geoip_open(APP_LIBRARY  . "geoip/GeoLiteCity.dat", GEOIP_STANDARD);

        //obtenemos el ip
        $iprequest = $_SERVER['REMOTE_ADDR'];
        //$iprequest = "54.20.15.100";
        
        switch ($iprequest) {
            case "127.0.0.1":
                $iprequest ="190.43.157.55";
                break;
            case "::1":
                $iprequest ="190.43.157.55";
                break;
        }
        
        
        $data = geoip_record_by_addr($gi, $iprequest);
            
        $this->Dispositivo->pais_nombre = strtolower($data->country_name);
        $this->Dispositivo->pais_codigo = strtolower($data->country_code);
        $this->Dispositivo->region_codigo = $data->region;
        $this->Dispositivo->region_nombre = @$GEOIP_REGION_NAME[$data->country_code][$data->region];
        $this->Dispositivo->ciudad = $data->city;
        $this->Dispositivo->apilongitud = $data->longitude;
        $this->Dispositivo->apilatitud = $data->latitude;
        $this->Dispositivo->ip = $iprequest;
        
        
        
        /*
        country_code: "PE",
        country_code3: "PER",
        country_name: "Peru",
        region: "15",
        city: "Lima",
        postal_code: null,
        latitude: -12.05,
        longitude: -77.05,
        area_code: null,
        dma_code: null,
        metro_code: null,
        continent_code: "SA"         
         */
        /*
        $ancho = 2000;
        geoip_close($gi);
        if( isset( $_REQUEST['devicewidth'] ) && $_REQUEST['devicewidth'] != '' ){
            $ancho =  $_REQUEST['devicewidth'];
        }

        //Evaluamos el ancho 
        //LG G3
        if( $ancho <= 1440 && $ancho > 1081  ){
            $this->Dispositivo->carpeta = '220x220/';
            $this->Dispositivo->carpeta_mediana = '400x400/';
            $this->Dispositivo->carpeta_grande = '1024x1024/';
            $this->Dispositivo->carpeta_pequena = '220x220/';
        }
        //HTC ONE
        if( $ancho <= 1080  && $ancho > 721 ){
            $this->Dispositivo->carpeta = '220x220/';
            $this->Dispositivo->carpeta_mediana = '320x320/';
            $this->Dispositivo->carpeta_grande = '1024x1024/';
            $this->Dispositivo->carpeta_pequena = '220x220/';
        }
        //MOTOROLA  MOTO G
        if( $ancho <= 720  && $ancho > 481 ){
            $this->Dispositivo->carpeta = '160x160/';
            $this->Dispositivo->carpeta_mediana = '220x220/';
            $this->Dispositivo->carpeta_grande = '400x400/';
            $this->Dispositivo->carpeta_pequena = '110x110/';
        }

        //LG G2
        if( $ancho <= 480 && $ancho > 241 ){
            $this->Dispositivo->carpeta = '83x83/';
            $this->Dispositivo->carpeta_mediana = '160x160/';
            $this->Dispositivo->carpeta_grande = '400x400/';
            $this->Dispositivo->carpeta_pequena = '83x83/';
        }
        //LG E4
        if( $ancho <= 240 ){
            $this->Dispositivo->carpeta = '60x60/';
            $this->Dispositivo->carpeta_mediana = '60x60/';
            $this->Dispositivo->carpeta_grande = '200x200/';
            $this->Dispositivo->carpeta_pequena = '50x50/';
        }


        */




        
    }

}

?>