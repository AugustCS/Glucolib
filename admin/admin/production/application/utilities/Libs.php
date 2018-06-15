<?php
function stats_standard_deviation(array $a, $sample = false) {
        $n = count($a);
        if ($n === 0) {
            trigger_error("The array has zero elements", E_USER_WARNING);
            return false;
        }
        if ($sample && $n === 1) {
            trigger_error("The array has only 1 element", E_USER_WARNING);
            return false;
        }
        $mean = array_sum($a) / $n;
        $carry = 0.0;
        foreach ($a as $val) {
            $d = ((double) $val) - $mean;
            $carry += $d * $d;
        };
        if ($sample) {
           --$n;
        }
        return sqrt($carry / $n);
    }
function paginar($actual, $total, $por_pagina, $enlace){
	$total_paginas = ceil($total/$por_pagina);
	$anterior = $actual - 1;
	$posterior = $actual + 1;
	if ($actual>1)
		$texto = "<a href=\"$enlace$anterior\">&laquo;</a>";
	else
		$texto = "<a href='#'>&laquo;</a>";
	for ($i=1; $i<$actual; $i++)
		$texto .= "<a href=\"$enlace$i\">$i</a> ";
		$texto   .= "<b>$actual</b>";
	for ($i=$actual+1; $i<=$total_paginas; $i++)
		$texto .= "<a href=\"$enlace$i\">$i</a> ";
	if ($actual<$total_paginas)
		$texto .= "<a href=\"$enlace$posterior\">&raquo;</a>";
	else
		$texto .= "<a href='#'>&raquo;</a>";
	return $texto;
}
function completarNumeros( $limite, $posiciones ) {
			$no_encontradas = array();
            for ($i=0; $i < $limite; $i++) { 
            	if ($i != $posiciones) {
            		array_unshift($no_encontradas, $i);
            	}
            }
            
            return $no_encontradas;
        }

function horas()
{
	$horas = array('00:00', '00:30','01:00','01:30','02:00', '02:30', '03:00','03:30', 
					'04:00', '04:30', '05:00', '05:30', '06:00', '06:30', '07:00', '07:30', 
					'08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', 
					'11:30', '12:00','12:30','13:00','13:30','14:00', '14:30', 
					'15:00','15:30', '16:00', '16:30', '17:00', '17:30', '18:00', 
					'18:30', '19:00', '19:30', '20:00', '20:30', '21:00', '21:30', 
					'22:00', '22:30', '23:00', '23:30');

	 return $horas;
}

 function url_amigable($url, $tipo) {
    if ($tipo == 1) {
        $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        $url = utf8_decode($url);
        $url = strtr($url, utf8_decode($originales), $modificadas);
        $url = strtolower($url);
        $url = preg_replace('[^ A-Za-z0-9_-]', '', $url);
        return str_replace(" ", "-", strtolower($url));
    } else if ($tipo == 2) {
        $url = preg_replace('[^ A-Za-z0-9_-]', '', $url);
        return str_replace("-", " ", strtolower($url));
    }
}


function dd($array){
	echo "<pre>";
	print_r($array);
	echo "</pre>";
	die();
}
function pre($array){
	echo "<pre>";
	print_r($array);
	echo "</pre>";
}

function archivoActual()
{
	return  basename($_SERVER['PHP_SELF']);

}

function quitarExtension($string)
{
	$extension 		= pathinfo($string, PATHINFO_EXTENSION);
	$nombre_base 	= basename($string, '.'.$extension);

	return $nombre_base;

}
function get_extension($str) {
	$data = explode(".", $str);
        return end($data);
}



function mostrarMensaje($obj)
{
	
	$_SESSION['ERROR']['RESPUESTA'] = $obj->respuesta;
	$_SESSION['ERROR']['MENSAJE'] = $obj->mensaje;
}

function paginar_catalogo($actual, $total, $por_pagina, $enlace) {
  $total_paginas = ceil($total/$por_pagina);
  $anterior = $actual - 1;
  $posterior = $actual + 1;
  	$texto = " " ;
	
	if ($actual>1)  
   $texto .= '<a  class="scroll_left" href="'.$enlace.$anterior.'"><img src="aplication/webroot/imgs/arrow_previous.png"  alt="" /></a>';
  else
   $texto .= '<a class="scroll_left" href="#"><img src="aplication/webroot/imgs/arrow_previous.png"  alt="" /></a>';
		$texto .= " ";
  for ($i=1; $i<$actual; $i++)
    $texto .= " <a href=\"$enlace$i\">$i</a>  ";
  	$texto .= "<a id='active_paginado'>$actual</a> ";
 for ($i=$actual+1; $i<=$total_paginas; $i++)
    $texto .= " <a href=\"$enlace$i\">$i</a> ";
	$texto .= " ";
  if ($actual<$total_paginas)
    $texto .= '<a class="scroll_righ" href="'.$enlace.$posterior.'"><img src="aplication/webroot/imgs/arrow_next.png" alt="" /></a>';
  else
    $texto .= '<a class="scroll_righ" href="#"><img src="aplication/webroot/imgs/arrow_next.png" alt="" /></a>';
	
  return $texto;
}

function comillas_inteligentes($valor){
    // Retirar las barras
    if (get_magic_quotes_gpc()) {
        $valor = stripslashes($valor);
    }

    // Colocar comillas si no es entero
    if (!is_numeric($valor)) {
        $valor = "'" . mysql_real_escape_string($valor) . "'";
    }
	
	//utilizar con sprintf($consulta)
    return $valor;
}


function formato_date($comodin,$fecha){
	$nfecha=explode($comodin,$fecha);
	$dia=$nfecha[0];
	$mes=$nfecha[1];
	$ano=$nfecha[2];
	$ufecha=$ano."-".$mes."-".$dia;
	return $ufecha;
}
function formato_slash($comodin,$fecha){
	$nfecha=explode($comodin,$fecha);
	$dia=$nfecha[2];
	$mes=$nfecha[1];
	$ano=$nfecha[0];
	$ufecha=$dia."/".$mes."/".$ano;
	return $ufecha;
}
function formato_slash_ingles($comodin,$fecha)
{
	$nfecha=explode($comodin,$fecha);
	$dia=$nfecha[2];
	$mes=$nfecha[1];
	$ano=$nfecha[0];
	$ufecha=$mes."/".$dia."/".$ano;
	return $ufecha;
}

function formato_fecha_hora($string)
{
	$cadena 	= explode(" ",$string);
	$fecha 		= formato_24_horas_spanol($string);
	$hora 		= formato_24_horas($cadena[1]).":00";
	$fechaHora 	= $fecha.' '.$hora;
	//pre($fecha);
	
	return $fecha;
}

function formato_12_horas($string)
{
	return date("g:i A",strtotime($string));
}

function formato_24_horas($string)
{
	return date("G:i",strtotime($string));
}


function formato_24_horas_spanol($string)
{	

	$arreglo 	= explode(' ', $string);
	$fecha 		= explode('/',$arreglo[0]);
	$hora 		=  formato_24_horas($arreglo[1].' '.$arreglo[2]);

	$anio 	= $fecha[2];
	$mes 	= $fecha[0];
	$dia 	= $fecha[1];
$nuevaFecha = $anio.'-'.$mes.'-'.$dia;


$formato 	= $nuevaFecha.' '.$hora;

	return $formato;
}

function send($text) {
    header("Content-type: text/html; charset=utf-8");
    echo utf8_encode($text);
}

function passcont($psw){
	$txt=strlen($psw);
	$txt1=substr($psw,0,3);
	$txt2=substr($psw,3,3);

}

function impSelect($tabla,$extra,$idd){
	
	if($tabla == "provincias"){		
		$cat = "departamento";
	}else if($tabla == "distritos"){		
		$cat = "provincia";
	}	
	
	$where=" WHERE id_$cat = '".$idd."' ";
		
	$sql="SELECT * FROM ".$tabla." ".$where ;	
	$query = mysql_query($sql); 
	
	$retur = "";
	$retur.= '<select name = "'.$tabla.'" '.$extra.'   >
		<option value="">Seleccionar... </option>';
		while($row = mysql_fetch_array($query)){
			$retur .= " <option value='".$row[0]."' > ".$row[2]." ";
		} 
		//$retur.= $nuevo_valor; 
	$retur .= "</select>";
	// echo  $retur;
	echo $retur ;
}

function passencode($password){	
	$newpass = ( md5($password) . '&' . strrev(strlen($password))  );
	return $newpass;	 
}

function passdecode($password ){
	$newpass = strrev($password);
	$newpass = explode('&', $newpass);
	$newpass = $newpass[0];	
	return $newpass;
}

function encriptar($valor){
	$cad=strlen($valor);
	$subcad=ceil($cad/2);
	$prev_valor=substr(strrev($valor),0,$subcad);
	$next_valor=substr(strrev($valor),$subcad,$cad);
	$pcad=$cad*647667904564;	
	$pass=$pcad.'|'.$prev_valor.'$'.$subcad.'|'.$next_valor.'$w3809245n0t9';	
	return str_replace("'","?",$pass);		
}

function desencriptar($valor){
	$cad=strlen($valor);
	$subcad=ceil($cad/2);
	$new_valor=explode("|",$valor);
	
	$pvalor=explode("$",$new_valor[1]);
	$prev_valor=$pvalor[0];
	
	$nvalor=explode("$",$new_valor[2]);
	$next_valor=$nvalor[0];
	
	$pass=strrev($prev_valor.$next_valor);
	return str_replace('?',"'",$pass);		
}
function in_multi_array($needle, $haystack)
{
    $in_multi_array = false;
    if(in_array($needle, $haystack))
    {
        $in_multi_array = true;
    }
    else
    {   
        for($i = 0; $i < sizeof($haystack); $i++)
        {
            if(is_array($haystack[$i]))
            {
                if(in_multi_array($needle, $haystack[$i]))
                {
                    $in_multi_array = true;
                    break;
                }
            }
        }
    }
    return $in_multi_array;
} 

  function VistaJson($respuesta){
		header("Content-Type: application/json", true);
        echo json_encode($respuesta);
	}


function encode_json($array){
	$array_claves = array_keys($array);
	$filas = count($array, COUNT_RECURSIVE);
	$filas_array = count($array);
	if($filas == 0 or $filas == "")
		return false;
	else{
		if($filas>$filas_array){
			$coma = "";
			for($j=0; $j<$filas_array; $j++){
				$array_claves = array_keys($array[$j]);
				$filas = count($array[$j]);
				$array_array = $array[$j];
				$vector = $vector . $coma .recuperar_array($array_claves,$filas,$array_array);
				$coma=", ";
			}
			$vector = '['.$vector.']';
			return $vector;
		}
		else
		{
		$vector = recuperar_array($array_claves,$filas,$array);
		}			
	}
}

function limpiar_text($variables){
		$variables = trim( str_replace( "'","",str_replace("#","",$variables) ) );
		$variables = mysql_real_escape_string(strip_tags($variables));
}

function recuperar_array($array_claves,$filas,$array){
	for($i=0; $i<$filas; $i++){
		$coma=", ";
		if(($i+1)==$filas)
		$coma="";
		$vector= $vector . '"' . $array_claves[$i] . '":"' . eregi_replace("[\n|\r|\n\r]", ' ', utf8_encode($array[$array_claves[$i]])). '"' . $coma;
	}
	$vector="{".$vector."}";
	return $vector;
}
function Month($fecha){
	$nfecha = explode("-",$fecha);
	$dia = $nfecha[2];
	$mes = $nfecha[1];
	$ano = $nfecha[0];
	$meses = array('01' => 'Enero','02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre');
	return  $meses[$mes]." ".$ano; 
}
function fecha_long($fecha){
	$nfecha = explode("-",$fecha);
	$dia = $nfecha[2];
	$mes = $nfecha[1];
	$ano = $nfecha[0];
	$meses = array('01' => 'Enero','02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre');
	return  $dia." de ".$meses[$mes]." del ".$ano; 
}
function ext($archivo) {
	$trozos = explode("." , $archivo);
	$ext = $trozos[ count($trozos) - 1];
	return (string) $ext;
}

function formatVideo($video, $w, $h){
	$nvideo = str_replace('width="640" height="385"','width="'.$w.'" height="'.$h.'"',$video);
	$nvideo = str_replace('width="560" height="340"','width="'.$w.'" height="'.$h.'"',$nvideo);
	$nvideo = str_replace('width="480" height="385"','width="'.$w.'" height="'.$h.'"',$nvideo);
	$nvideo = str_replace('allowfullscreen="true"','allowfullscreen="true" wmode="transparent"',$nvideo);
	return $nvideo;
}
function validateUser($id){
	$objca  = new ClienteAdmin($id);
	$plan = $objca->__get("_planes");
	
	if($plan[0]['estado'] == 0){
		return FALSE;
	}else{
		return TRUE;
	}
}

function aumentarMonth($desde, $cant){
	$fecha = $desde;
	return date("Y-m-d", strtotime("$fecha +".$cant." month"));  
}

function updateEstatus(){
	$query = new Consulta("SELECT * FROM clientes_planes WHERE fecha_finaliza < '".date("Y-m-d")."'");
	while($row = $query->VerRegistro()){
		$queryU = new Consulta("UPDATE clientes_planes SET estado = '0' 
										WHERE id_cliente_plan = '".$row['id_cliente_plan']."'");
	}
}

function inCategories($id_cat=0){

	$sql = "SELECT * FROM categorias c, categorias_idiomas ci 
					WHERE c.id_categoria = ci.id_categoria
					AND  ci.id_idioma = '".ID_IDIOMA."' ORDER BY c.id_categoria";
					
	$query = new Consulta($sql);

	while($row = $query->VerRegistro()){
		$data[$row['id_categoria']] = array("parent_id" => $row['id_parent'], "name" => $row['nombre_categoria']);	
	}
	$array   = $data;
	
	return createTree($array,$id_cat); 
}

function eliminaUltimoCaracrter($cadena)
{
	$cadena = substr ($cadena, 0, -1);
	return $cadena;
}

function obtenerUltimoDiaMes() { 
      $month = date('m');
      $year = date('Y');
      $day = date("d", mktime(0,0,0, $month+1, 0, $year));
 
      return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
  };
 
  /** Actual month first day **/
 function obtenerPrimerDiaMes() {
      $month = date('m');
      $year = date('Y');
      return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
 }

function inicio_fin_semana($fecha){

    $diaInicio="Monday";
    $diaFin="Sunday";

    $strFecha = strtotime($fecha);

    $fechaInicio = date('Y-m-d',strtotime('last '.$diaInicio,$strFecha));
    $fechaFin = date('Y-m-d',strtotime('next '.$diaFin,$strFecha));

    if(date("l",$strFecha)==$diaInicio){
        $fechaInicio= date("Y-m-d",$strFecha);
    }
    if(date("l",$strFecha)==$diaFin){
        $fechaFin= date("Y-m-d",$strFecha);
    }
    return Array("fechaInicio"=>$fechaInicio,"fechaFin"=>$fechaFin);
}  

function obtenerNombreArchivo()
{
	$nombre_archivo 	= parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
	//verificamos si en la ruta nos han indicado el directorio en el que se encuentra
	if ( strpos($nombre_archivo, '/') !== FALSE )
	//de ser asi, lo eliminamos, y solamente nos quedamos con el nombre sin su extension
		$nombre_archivo 	= explode('/', $nombre_archivo);
		$nombre_archivo 	= array_pop($nombre_archivo);
		$nombre_archivo 	= preg_replace('/\.php$/', '' ,$nombre_archivo);

	return $nombre_archivo;
}
function obtenerUrlActual()
	{
	$host= $_SERVER["HTTP_HOST"];
	$url= $_SERVER["REQUEST_URI"];
	return "http://" . $host . $url;
}

function createTree($array, $currentParent, $currLevel = 0, $prevLevel = -1) {
	foreach ($array as $categoryId => $category) {
		if ($currentParent == $category['parent_id']) {
			
			return $categoryId.",";	
							
			if ($currLevel > $prevLevel) { $prevLevel = $currLevel; }
			$currLevel++; 
			createTree ($array, $categoryId, $currLevel, $prevLevel);
			$currLevel--;	 		 	
		}	
	}
}


function getUrlActual(){
	$numero  = count($_GET);
	$tags 	 = array_keys($_GET);
	$valores = array_values($_GET);
	
	for($i=0;$i<$numero;$i++){
			$cad .=$tags[$i]."=".$valores[$i]."&";
	}
	$url = ($cad == '') ? basename($_SERVER['PHP_SELF']) : basename($_SERVER['PHP_SELF']).'?'.substr($cad,0,strlen($cad)-1);
	return $url;
}

function mostrarMensajePopup($tipoMensaje, $mensaje, $url, $tiempo)
{
	echo '<script type="text/javascript">
			alert("'.$mensaje.'");
			setTimeout(function(){ location.href="'.$url.'";}, 100);
			

	</script>';
}
function revertir_mesdiaanio($fecha)
{
	$valor = explode('/', $fecha);
	$dia = $valor[1];
	$mes = $valor[0];
	$anio = $valor[2];

	$fecha = trim($anio).'-'.trim($mes).'-'.trim($dia);
	return $fecha;
}

function location($url)
{
	echo '<script type="text/javascript">location.href="'.$url.'";</script>';
}

function get_uid_producto($prid, $params){
	$uprid = $prid;
	if ( (is_array($params)) && (!strstr($prid, '{')) ) {			
		while (list($option, $value) = each($params)){				
			$uprid = $uprid . '{' .$option . '}' . $value;
		}
	}
	return $uprid;
}
	
function get_id_producto($uprid) {
    $pieces = explode('{', $uprid);

    return $pieces[0];
}


?>