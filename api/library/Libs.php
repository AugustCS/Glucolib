<?php

function getBoundaries($lat, $lng, $distance = 1, $earthRadius = 6371)
{
    $return = array();
    // Los angulos para cada dirección
    $cardinalCoords = array('north' => '0',
                            'south' => '180',
                            'east' => '90',
                            'west' => '270');

    $rLat = deg2rad($lat);
    $rLng = deg2rad($lng);
    $rAngDist = $distance/$earthRadius;

    foreach ($cardinalCoords as $name => $angle)
    {
        $rAngle = deg2rad($angle);
        $rLatB = asin(sin($rLat) * cos($rAngDist) + cos($rLat) * sin($rAngDist) * cos($rAngle));
        $rLonB = $rLng + atan2(sin($rAngle) * sin($rAngDist) * cos($rLat), cos($rAngDist) - sin($rLat) * sin($rLatB));

         $return[$name] = array('lat' => (float) rad2deg($rLatB), 
                                'lng' => (float) rad2deg($rLonB));
    }

    return array('min_lat'  => $return['south']['lat'],
                 'max_lat' => $return['north']['lat'],
                 'min_lng' => $return['west']['lng'],
                 'max_lng' => $return['east']['lng']);
}
function pre($expression) {
    echo '<pre>';
    print_r($expression);
    echo '</pre>';
}
function formato_date($comodin,$fecha){
    $nfecha=explode($comodin,$fecha);
        $dia=$nfecha[0];
	$mes=$nfecha[1];
	$ano=$nfecha[2];
	$ufecha=$ano."-".$mes."-".$dia;
	return $ufecha;
}
function formato_mesdiaanio($comodin,$fecha){
    if($fecha!=""){
       $nfecha=explode($comodin,$fecha);
       
        $dia=$nfecha[1];
	$mes=$nfecha[0];
	$ano=$nfecha[2];

        
        $ufecha = $ano."-".$mes."-".$dia;
        return $ufecha;
    }else{
        return "";
    }
    
}
function eliminaUltimocaracter($myString){
    $myString = substr($myString, 0, -1);
    return $myString;
}
function formato_slash($comodin,$fecha){
	$nfecha=explode($comodin,$fecha);
	$dia=$nfecha[2];
	$mes=$nfecha[1];
	$ano=$nfecha[0];
	$ufecha=$dia."/".$mes."/".$ano;
	return $ufecha;
}
 function sql_htm($string){ 
  $xml_str = mb_convert_encoding($string, "UTF-8", "ISO-8859-1"); 
  return $xml_str; 
}
function htm_sql($string){ 
  $xml_str = mb_convert_encoding($string, "ISO-8859-1", "UTF-8"); 
  return $xml_str; 
}
function aumentaDiasFecha($fechaDefault,$dias){
        $fecha = new DateTime($fechaDefault);
        $fecha->modify('+'.$dias.' day');
        return $fecha->format('Y-m-d H:i:s');
}
function aumentaHoras($fechaDefault,$horas){
        $hora = new DateTime($fechaDefault);
        $hora->modify('+'.$horas.' hour');
        return $hora->format('H:i:s');
}

function VistaJson($respuesta){

    header("Content-Type: application/json");
    echo json_encode( ( $respuesta ) );


}