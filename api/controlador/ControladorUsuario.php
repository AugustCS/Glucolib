<?php  

/**
* 
*/
class ControladorUsuario extends ControladorGeneral
{
	
	public function loginFacebook()
	{
		$retorno = new stdClass();
		$data 	 = new stdClass();
		$obj 	 = new ModeloUsuario();
		$retorno->respuesta 	= 'OK';
		$retorno->mensaje 		= 'Registro facebook correcto';
		//token=SEVZU0hPUDAwMVBFUlU=, gender=male, locationName=Chaclacayo, Lima, Peru, latitud=-12.0272751, devicewidth=, birthday=04/03/1988, firstName=Clarence, longitud=-76.9083194, fullName=Clarence Martínez, iddispositivo=, id=10213368959840009, deviceheight=, lastName=Martínez, profileURL=https://scontent.xx.fbcdn.net/v/t1.0-1/p200x200/14915421_10211278760746338_1697133925888817184_n.jpg?oh=0937565a0cdb8647970faf467a952baa&oe=59B9AE58}


		if (isset($_POST['iddispositivo']) && $_POST['iddispositivo']!= '') {
			$data->iddispositivo = $_POST['iddispositivo'];
		}

		if (isset($_POST['token']) && $_POST['token']!= '') {
			$data->token = $_POST['token'];
		}

		if (isset($_POST['gender']) && $_POST['gender']!= '') {
			$data->gender = $_POST['gender'];
		}

		if (isset($_POST['locationName']) && $_POST['locationName']!= '') {
			$data->locationName = $_POST['locationName'];
		}

		if (isset($_POST['latitud']) && $_POST['latitud']!= '') {
			$data->latitud = $_POST['latitud'];
		}

		if (isset($_POST['devicewidth']) && $_POST['devicewidth']!= '') {
			$data->devicewidth = $_POST['devicewidth'];
		}

		if (isset($_POST['birthday']) && $_POST['birthday']!= '') {
			$data->birthday = $_POST['birthday'];
		}
		
		if (isset($_POST['firstName']) && $_POST['firstName']!= '') {
			$data->firstName = $_POST['firstName'];
		}
		
		if (isset($_POST['longitud']) && $_POST['longitud']!= '') {
			$data->longitud = $_POST['longitud'];
		}
		
		if (isset($_POST['fullName']) && $_POST['fullName']!= '') {
			$data->fullName = $_POST['fullName'];
		}
		
		if (isset($_POST['deviceheight']) && $_POST['deviceheight']!= '') {
			$data->deviceheight = $_POST['deviceheight'];
		}
		
		if (isset($_POST['lastName']) && $_POST['lastName']!= '') {
			$data->lastName = $_POST['lastName'];
		}



		if (isset($_POST['id']) && $_POST['id']!= '') {
			$data->id = $_POST['id'];
		}

		if (isset($_POST['profileURL']) && $_POST['profileURL']!= '') {
			$data->profileURL = $_POST['profileURL'];
		}

		$retorno = $obj->verificaUsuarioFacebook($data);


		VistaJson($retorno);
	}

	public function login()
	{
		$data 		= new stdClass();
		$retorno 	= new stdClass();
		$obj 		= new ModeloUsuario();
		//longitud=-76.9082277, iddispositivo=, token=SEVZU0hPUDAwMVBFUlU=, deviceheight=, usuario=, latitud=-12.0272244, devicewidth=, tipo=, clave=
		$retorno->respuesta 	= 'ERROR';
		$retorno->mensaje 		= 'El usuario no existe en el sistema';
		$data->width 			= '';
		$data->height 			= '';
		$data->usuario 			= '';
		$data->clave 			= '';
		$data->latitud 			= '';
		$data->longitud 		= '';
		$data->token 			= '';
		$data->devicewidth 		= '';
		$data->deviceheight 	= '';
		$data->registro 		= TIEMPO;

		if (isset($_POST['usuario']) && $_POST['usuario']!= '') {
			$data->usuario = $_POST['usuario'];
		}

		if (isset($_POST['clave']) && $_POST['clave']!= '') {
			$data->clave = $_POST['clave'];
		}

		// if (isset($_POST['longitud']) && $_POST['longitud']!= '') {
		// 	$data->longitud = $_POST['longitud'];
		// }


		// if (isset($_POST['latitud']) && $_POST['latitud']!= '') {
		// 	$data->latitud = $_POST['latitud'];
		// }

		if (isset($_POST['iddispositivo']) && $_POST['iddispositivo']!= '') {
			$data->iddispositivo = $_POST['iddispositivo'];
		}	
		
		// if (isset($_POST['token']) && $_POST['token']!= '') {
		// 	$data->token = $_POST['token'];
		// }


		// if (isset($_POST['devicewidth']) && $_POST['devicewidth']!= '') {
		// 	$data->devicewidth = $_POST['devicewidth'];
		// }	

		// if (isset($_POST['deviceheight']) && $_POST['deviceheight']!= '') {
		// 	$data->deviceheight = $_POST['deviceheight'];
		// }	

		//VERIFICAMOS SI USUARIO EXISTE CASO CONTRARIO LO CREAMOS
		if ($data->usuario == "" ) {
			$retorno->respuesta = 'ERROR';
			$retorno->mensaje 	= 'Ingrese su email';
			VistaJson($retorno);
			die();

		}
		if ($data->clave == "" ) {
			$retorno->respuesta = 'ERROR';
			$retorno->mensaje 	= 'Ingrese su contraseña';
			VistaJson($retorno);
			die();
		}
		if ($data->usuario != '' && $data->clave != '') {
			$mensaje = $obj->verificaUsuario($data);
			$retorno = $mensaje;
			//$retorno->respuesta = 'OK';
			//$retorno->mensaje 	= 'Registros Correctos';
			$retorno->listado  = $obj->listadoDatos($data);
			VistaJson($retorno);
		}else{
			$retorno->respuesta = 'ERROR';
			$retorno->mensaje 	= 'Faltan datos';
			VistaJson($retorno);
			die();
		}
	}

	public function getdatos()
	{
		$data 		= new stdClass();
		$retorno 	= new stdClass();
		$obj  		= new ModeloUsuario();

		$retorno->respuesta 	= 'ERROR';
		$retorno->mensaje 		= 'El usuario no existe en el sistema';

		$data->id_usuario = '';
		if (isset($_POST['id_usuario']) && !empty($_POST['id_usuario'])) {
			$data->id_usuario =  $_POST['id_usuario'];
		}

		if (!empty($data->id_usuario)) {
		$respuesta  = $obj->datos($data);
			
		$retorno->respuesta 	= 'OK';
		$retorno->mensaje 		= 'Datos del usuario';
		$retorno->tiempo 		= TIEMPO;
		$retorno->listado 		= $respuesta;
		}

		

		VistaJson($retorno);
		die();
	}

	public function setdatos()
	{
		$data 		= new stdClass();
		$retorno 	= new stdClass();
		$obj  		= new ModeloUsuario();

		$retorno->respuesta 	= 'ERROR';
		$retorno->mensaje 		= 'El usuario no existe en el sistema';

		$data->id_usuario 		= '';
		$data->nombre 			= '';
		$data->apellido 		= '';
		$data->fecha_nacimiento = '';
		$data->sexo 			= '';
		$data->tipo_diabetes 	= '';
		$data->fototipo 		= '';
		$data->color_piel 		= '';
		$data->grupo_color_piel = '';
		$data->codigo_paciente 	= '';
		$data->edad 			= '';
		$data->glucemia 		= '';
		$data->saturacion_ox 	= '';
		$data->ritmo_cardiaco 	= '';

		if (isset($_POST['id_usuario']) && !empty($_POST['id_usuario'])) {
			$data->id_usuario =  $_POST['id_usuario'];
		}

		if (isset($_POST['nombre']) && !empty($_POST['nombre'])) {
			$data->nombre =  $_POST['nombre'];
		}

		if (isset($_POST['apellido']) && !empty($_POST['apellido'])) {
			$data->apellido =  $_POST['apellido'];
		}

		if (isset($_POST['fecha_nacimiento']) && !empty($_POST['fecha_nacimiento'])) {
			$data->fecha_nacimiento =  $_POST['fecha_nacimiento'];
		}

		if (isset($_POST['sexo']) && !empty($_POST['sexo'])) {
			$data->sexo =  $_POST['sexo'];
		}

		if (isset($_POST['tipo_diabetes']) && !empty($_POST['tipo_diabetes'])) {
			$data->tipo_diabetes =  $_POST['tipo_diabetes'];
		}

		if (isset($_POST['fototipo']) && !empty($_POST['fototipo'])) {
			$data->fototipo =  $_POST['fototipo'];
		}

		if (isset($_POST['color_piel']) && !empty($_POST['color_piel'])) {
			$data->color_piel =  $_POST['color_piel'];
		}

		if (isset($_POST['grupo_color_piel']) && !empty($_POST['grupo_color_piel'])) {
			$data->grupo_color_piel =  $_POST['grupo_color_piel'];
		}

		if (isset($_POST['glucemia']) && !empty($_POST['glucemia'])) {
			$data->glucemia =  $_POST['glucemia'];
		}

		if (isset($_POST['edad']) && !empty($_POST['edad'])) {
			$data->edad =  $_POST['edad'];
		}

		if (isset($_POST['saturacion_ox']) && !empty($_POST['saturacion_ox'])) {
			$data->saturacion_ox =  $_POST['saturacion_ox'];
		}

		if (isset($_POST['ritmo_cardiaco']) && !empty($_POST['ritmo_cardiaco'])) {
			$data->ritmo_cardiaco =  $_POST['ritmo_cardiaco'];
		}

		if (isset($_POST['codigo_paciente']) && !empty($_POST['codigo_paciente'])) {
			$data->codigo_paciente =  $_POST['codigo_paciente'];
		}

		if (!empty($data->id_usuario)) {
		$respuesta  = $obj->setdatos($data);
			
		$retorno->respuesta 	= 'OK';
		$retorno->mensaje 		= 'Actualización de datos exitoso';
		$retorno->tiempo 		= TIEMPO;
		$retorno->listado 		= $respuesta;
		}

		VistaJson($retorno);
		die();
	}

	public function contrasena()
	{
		$data 		= new stdClass();
		$retorno 	= new stdClass();
		$obj 		= new ModeloUsuario();

		$retorno->respuesta		= 'ERROR'; 
		$retorno->mensaje		= 'Faltan datos'; 


		$data->iddispositivo  	= '';
		$data->correo  			= '';

		if (isset($_POST['iddispositivo']) && !empty($_POST['iddispositivo'])) {
			$data->iddispositivo = trim($_POST['iddispositivo']);
		}
		if (isset($_POST['correo']) && !empty($_POST['correo'])) {
			$data->correo = trim($_POST['correo']);
		}

		if (!empty($data->correo)) {
			$retorno->respuesta		= 'ERROR'; 
			$retorno->mensaje		= 'El correo ingresado no existe'; 
			$total = $obj->verificaCorreo($data);

			if ($total > 0) {
				$retorno->respuesta		= 'OK'; 
				$retorno->mensaje		= 'La contraseña se envío correctamente al correo indicado';
				$total = $obj->enviarClavePaciente($data); 
			}
		}

		VistaJson($retorno);
		die();
	}

	public function registrar()
	{
		$data 		= new stdClass();
		$retorno 	= new stdClass();
		$obj 		= new ModeloUsuario();

		$retorno->respuesta		= 'ERROR'; 
		$retorno->mensaje		= 'Faltan datos'; 		

		$data->correo 	= '';
		$data->clave 	= '';

		if (isset($_POST['correo']) && !empty($_POST['correo'])) {
			$data->correo = trim($_POST['correo']);
		}

		if (isset($_POST['clave']) && !empty($_POST['clave'])) {
			$data->clave = trim($_POST['clave']);
		}

		if (!empty($data->correo) && !empty($data->clave)) {
			$retorno->respuesta		= 'ERROR'; 
			$retorno->mensaje		= 'El correo ingresado ya existe'; 
			$total = $obj->verificaCorreo($data);

			if ($total == 0) {
				$retorno->respuesta		= 'OK'; 
				$retorno->mensaje		= 'Correo registrado correctamente';
				$total = $obj->registrarPaciente($data); 
			}
		}

		VistaJson($retorno);
		die();
	}
}

?>