<?php  
/**
* 
*/
class ModeloUsuario
{
	public function verificaCorreo($obj)
	{
		$sql = "SELECT correo FROM pacientes 
					where correo= '".$obj->correo."'";
		$data = ModeloConexion::ejecutar( $sql , DB_NAME ,DB_SELECT);
		$total = $data['TOTAL'];

		return $total;
	}

	public function enviarClavePaciente($obj)
	{
		require_once APP_DIR."modelo/ModeloMailing.php";  
		$objMailing = new ModeloMailing();
		$sql = "SELECT concat(nombre, apellido) as dato, correo, password FROM pacientes 
					where correo= '".$obj->correo."'";
		$data = ModeloConexion::ejecutar( $sql , DB_NAME ,DB_SELECT);
		$total = $data['TOTAL'];
		$lista = $data['LISTA'][0];

		$objMailing->enviarClavePaciente($lista); //enviando mailing al paciente
	}

	public function verificaUsuario($obj)
	{
		$retorno = new stdClass();

		$retorno->respuesta = '';
		$retorno->mensaje 	= '';

		$sql = "SELECT correo, password FROM pacientes 
					where correo= '".$obj->usuario."'";
		$data = ModeloConexion::ejecutar( $sql , DB_NAME ,DB_SELECT);
		$total = $data['TOTAL'];
		if ($total > 0) {
			$sql = "SELECT id_usuario, correo, password FROM pacientes 
					where correo= '".$obj->usuario."' AND password= '".$obj->clave."'";
			$data = ModeloConexion::ejecutar( $sql , DB_NAME ,DB_SELECT);

			$total = $data['TOTAL'];
			if ($total == 0) {
				$retorno->respuesta = 'ERROR';
				$retorno->mensaje 	= 'La password ingresada es incorrecta';
			}else{
				$retorno->respuesta 		= 'OK';
				$retorno->mensaje 			= 'Datos ingresados correctamente';
				$retorno->id_usuario 		= $data['LISTA'][0]->id_usuario;
				$retorno->registros 		= $this->registrosTomaPacientes($data['LISTA'][0]->id_usuario);
			}
		} else{

			$sql = "INSERT INTO pacientes (correo, password, registro) VALUES(
					'".$obj->usuario."',
					'".$obj->clave."',
					'".$obj->registro."')";
			$data = ModeloConexion::ejecutar( $sql , DB_NAME ,DB_INSERT);

			$retorno->respuesta 		= 'OK';
				$retorno->mensaje 		= 'Cuenta registrada correctamente';
				$retorno->id_usuario 	= $data['INSERT_ID'];
				$retorno->registros 	= $this->registrosTomaPacientes($data['INSERT_ID']);
		}

		return $retorno;			
	}

	public function verificaUsuarioFacebook($obj)
	{
		$sql = "SELECT correo, password FROM usuario where facebook_id = '".$obj->id."'";
		$data = ModeloConexion::ejecutar( $sql , DB_NAME ,DB_SELECT);
		$total = $data['TOTAL'];
		if ($total > 0) {
				$retorno->respuesta = 'OK';
				$retorno->mensaje 	= 'Datos ingresados correctamente';
			
		} else{

			$sql = "INSERT INTO login_padres (facebook_id, nombres, paterno) VALUES(
					'".$obj->id."',
					'".$obj->firstName."',
					'".$obj->lastName."'
					)";
			$data = ModeloConexion::ejecutar( $sql , DB_NAME ,DB_INSERT);

			$retorno->respuesta = 'OK';
				$retorno->mensaje 	= 'Cuenta registrada correctamente';

		}

		return $retorno;
	}

	public function registrosTomaPacientes($idUsuario)
	{
		//$sql =  "SELECT * FROM resultado_toma";
		$sql =  "SELECT * FROM toma_decimal where id_usuario='".$idUsuario."' ORDER BY id_toma DESC";

		$data = ModeloConexion::ejecutar( $sql , DB_NAME ,DB_SELECT);
        $respuesta = array();
                for ( $i = 0; $i < $data['TOTAL']; $i++) {
                		$glucosa = $data['LISTA'][$i]->glucosa;
                	if ($data['LISTA'][$i]->glucosa == '') {
                		$glucosa = $data['LISTA'][$i]->calibracion;
                	}
                
                    $rp = new stdClass();
                    $rp->id_resultado    = $data['LISTA'][$i]->id_toma;
                    $rp->id_usuario         = $data['LISTA'][$i]->id_usuario;
                    $rp->resultado          = $glucosa.' mg/dL'; //$data['LISTA'][$i]->resultado.' mg/dL';
                    $rp->mensaje          	= '';//$data['LISTA'][$i]->mensaje;
                    $rp->fecha_toma         = $data['LISTA'][$i]->registro;
                    $rp->dispositivo_id     = $data['LISTA'][$i]->id_dispositivo;
                    $rp->serie_bluetooth     = $data['LISTA'][$i]->serie_bluetooth;
                    $respuesta[]            = $rp;
                }
    	return $respuesta;
	}

	public function listadoDatos($obj)
	{
		// $data =  array(
		// 		'fecha' =>array(
		// 				'parametro1' => '1',
		// 				'parametro2' => '1',
		// 				'parametro3' => '1',
		// 				'parametro4' => '1',
		// 				'parametro5' => '1',
		// 				'parametro6' => '1',
		// 			)
		// 	);
		// return $data;
	}

	public function datos($obj)
	{
		$sql = "SELECT * FROM pacientes WHERE id_usuario = '".$obj->id_usuario."'";

		$data = ModeloConexion::ejecutar( $sql , DB_NAME ,DB_SELECT);
		$total = $data['TOTAL'];

		$respuesta = array();
                for ( $i = 0; $i < $data['TOTAL']; $i++) {
                
                    $rp = new stdClass();
                    $rp->nombre    			= $data['LISTA'][$i]->nombre;
                    $rp->apellido    		= $data['LISTA'][$i]->apellido;
                    $rp->correo    			= $data['LISTA'][$i]->correo;
                    $rp->tipo_diabetes    	= $data['LISTA'][$i]->tipo_diabetes;
                    $rp->tipo_fototipo    	= $data['LISTA'][$i]->tipo_fototipo;
                    $rp->codigo_paciente    = $data['LISTA'][$i]->codigo_paciente;
                    $rp->fecha_nacimiento   = formato_slash('-',$data['LISTA'][$i]->fecha_nacimiento);
                    $rp->sexo   			= $data['LISTA'][$i]->sexo;
                    $rp->edad   			= $data['LISTA'][$i]->edad;
                    $rp->color_piel   		= $data['LISTA'][$i]->color_piel;
                    $rp->grupo_color_piel   = $data['LISTA'][$i]->grupo_color_piel;
                    $rp->glucemia   		= $data['LISTA'][$i]->glucemia;
                    $rp->saturacion_ox   	= $data['LISTA'][$i]->saturacion_ox;
                    $rp->ritmo_cardiaco   	= $data['LISTA'][$i]->ritmo_cardiaco;
                    $respuesta[]            = $rp;
                }
    	return $respuesta;

	}

	public function setdatos($obj)
	{
		$sql = "UPDATE pacientes SET 
			nombre = '".$obj->nombre."', 
			apellido = '".$obj->apellido."', 
			tipo_diabetes = '".$obj->tipo_diabetes."', 
			tipo_fototipo = '".$obj->fototipo."', 
			sexo = '".$obj->sexo."', 
			edad = '".$obj->edad."', 
			color_piel = '".$obj->color_piel."', 
			grupo_color_piel = '".$obj->grupo_color_piel."', 
			glucemia = '".$obj->glucemia."', 
			saturacion_ox = '".$obj->saturacion_ox."', 
			codigo_paciente = '".$obj->codigo_paciente."', 
			ritmo_cardiaco = '".$obj->ritmo_cardiaco."', 
			fecha_nacimiento = '".formato_date('/',$obj->fecha_nacimiento)."' 

		WHERE id_usuario = '".$obj->id_usuario."'";
		$data = ModeloConexion::ejecutar( $sql , DB_NAME ,DB_UPDATE);
		return $data;
	}

	public function registrarPaciente($obj)
	{
		$sql = "INSERT INTO pacientes (correo, password) VALUES('$obj->correo','$obj->clave')";
		$data = ModeloConexion::ejecutar( $sql , DB_NAME ,DB_INSERT);


		return $data;
	}
}

?>