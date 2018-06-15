<?php  

/**
* 
*/
class ControladorDatos extends ControladorGeneral
{
	
	
	public function entrada()
	{
		require_once APP_DIR."modelo/ModeloConfiguracion.php";  
		$data 					= new stdClass();
		$retorno 				= new stdClass();
		$obj 					= new ModeloDatos();
		$obConfiguracion 		= new ModeloConfiguracion();
		//longitud=-76.9082277, iddispositivo=, token=SEVZU0hPUDAwMVBFUlU=, deviceheight=, usuario=, latitud=-12.0272244, devicewidth=, tipo=, clave=
		$retorno->respuesta 	= 'ERROR';
		$retorno->mensaje 		= 'El usuario no existe en el sistema';
		$data->width 			= '';
		$data->height 			= '';
		$data->usuario 			= 'clarence@gmail.com';
		$data->clave 			= '123456';
		$data->id_usuario 		= '';
		$data->latitud 			= '';
		$data->longitud 		= '';
		$data->token 			= '';
		$data->devicewidth 		= '';
		$data->deviceheight 	= '';
		$data->iddispositivo 	= '';
		$data->bluetooth 		= '';
		$data->parametro 		= '';
		$data->calibracion 		= '';
		$data->registro 		= TIEMPO;


		$data->web_service		= $obConfiguracion->obtenerWebService();
		
		if (isset($_POST['iddispositivo']) && $_POST['iddispositivo']!= '') {
			$data->iddispositivo = $_POST['iddispositivo'];
		}

		if (isset($_POST['id_usuario']) && $_POST['id_usuario']!= '') {
			$data->id_usuario = $_POST['id_usuario'];
		}	
		
		if (isset($_POST['serie_bluetooth']) && $_POST['serie_bluetooth']!= '') {
			$data->serie_bluetooth = $_POST['serie_bluetooth'];
		}

		if (isset($_POST['calibracion']) && $_POST['calibracion']!= '') {
			$data->calibracion = $_POST['calibracion'];
		}

		if (isset($_POST['parametro']) && $_POST['parametro']!= '') {
			$data->parametro = explode(',', $_POST['parametro']);
		}	

		if ($data->iddispositivo != '' && isset($_POST['parametro']) && isset($_POST['id_usuario'])) {
			$mensaje 				= $obj->registrarDatos($data);
			$mensajeDecimal 		= $obj->registrarDatosDecimal($data);

			$retorno->respuesta 	= 'OK';
			$retorno->mensaje 		= 'Registros Correctos';
			$retorno->resultado 	=  $mensajeDecimal; //$obj->resultadoMuestra().'mg/dL';
			//$retorno->sql 			= $mensajeDecimal;
			VistaJson($retorno);
			die();
		}else{
			$retorno->respuesta 	= 'ERROR';
			$retorno->mensaje 		= 'Faltan datos';
			$retorno->iddispositivo = 'no puede ser vacío';
			$retorno->id_usuario 	= 'no puede ser vacío';
			$retorno->parametro 	= 'Es una cadena separado por comas';
			VistaJson($retorno);
			die();
		}
	}

	public function algoritmo()
	{	
		$data = new stdClass();
		$obj 	= new ModeloDatos();

		$data->id_usuario 		= 52;
		$data->id_dispositivo 	= '794c11d448d8f2d3';
		$respuesta 				= $obj->extraerRegistrosPaciente($data);

		$primer_registro = '';
		$ultimo_registro = '';

		$data->dato1 = 560;
		$data->dato2 = 530;
		$data->id_toma = '';
		$total = count($respuesta);
		if ($total == 2) {
			foreach ($respuesta as $indice => $parametros) :
				 switch ($indice) {
				 	case 0:
				 	$data->id_toma = $parametros->id_toma;
				 		//$primer_registro = '{"dato1":'.$data->dato1.'"}';
				 		// $json = json_encode($parametros);
				 		// $primer_registro = base64_encode($json);
				 		$primer_registro = $parametros;
				 	break;
					
				 	case 1:
				 		$ultimo_registro = $parametros;
					break;					
					
				}
				
			endforeach;
		}

		

		// pre($primer_registro);

		// $primer_registro = $this->encrypt($primer_registro);
		// $ultimo_registro = $this->encrypt($ultimo_registro);

		//$primer_registro = urlencode($primer_registro);
		// $primer_registro = '';
		// $ultimo_registro = urlencode($ultimo_registro);
		// $ultimo_registro = '';

		//$url  		= web_service.'?primer_registro='.$primer_registro.'&ultimo_registro='.$ultimo_registro;

		// echo $url;
		//
		//pre($url);

//		$url  		= web_service.'method=metodMerListarVenta&json='.$parametros;
		//$output 	= file_get_contents($url);

		//pre($output);

		// $params= ['primer_registro'=>$primer_registro, 'ultimo_registro'=>$ultimo_registro];

		// //pre($params);
		// $defaults = array(
		// CURLOPT_URL => web_service, 
		// CURLOPT_POST => true,
		// CURLOPT_POSTFIELDS => $params,
		// );
		// $ch = curl_init();
		// //curl_setopt_array($ch, ($params + $defaults)); 

		// pre($ch);  


		// $cc = new curl_initx(); 
		// $cc->post(web_service,'primer_registro='.$primer_registro); 
		// pre($cc);

		$data = new stdClass();
		$data->primer_registro =  $primer_registro;
		$data->ultimo_registro =  $ultimo_registro;
		$post = [
		// 'pe_reg' => 50,
		// 'ul_reg' => 100,
		 'pe_reg' => $primer_registro,
		 'ul_reg' => $ultimo_registro,
		];

$json =  json_encode($post);
//$json =  $post;

// 		pre($json);
// die();
		$ch = curl_init(web_service);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

		// execute!
		$response = curl_exec($ch);

		// close the connection, release resources used
		curl_close($ch);

		// do anything you want with your response
		$respuesta_ws = json_decode($response);
		$respuesta_ws = json_decode($respuesta_ws,2);
		
		$valor = $respuesta_ws['glucosa'];

		echo $valor;



	}

public function objectToArray($d) {
	if(is_object($d)){
		$d = get_object_vars($d);
	}
	if(is_array($d)){
		return array_map(__FUNCTION__, $d);
	}else{
		return $d;
	}
}

public function encrypt( $q ) {
    $cryptKey  = 'glucolib';
    $qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
    return( $qEncoded );
}

public function decrypt( $q ) {
    $cryptKey  = 'glucolib';
    $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
    return( $qDecoded );
}



}

?>