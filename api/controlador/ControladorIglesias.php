<?php  
/**
* 
*/
class ControladorIglesias extends ControladorGeneral
{
	
	public function listado()
	{
		$retorno 	=  new stdClass();
		$data 		=  new stdClass();

		$retorno->respuesta = 'OK';
		$retorno->mensaje 	= 'EntrarListado';
		// $data->EntrarListado = 'EntrarListado';
		// $data->titulo = 'EntrarListado';


		vistaJson($retorno);
	}
	public function busqueda()
	{
		$retorno		=  new stdClass();
		$data 			=  new stdClass();
		$objIglesias 	= new ModeloIglesias();
		//longitud=-76.9082591, latitud=-12.0272815, devicewidth=720, tipo=1, iddispositivo=103c364df26b646f, token=SEVZU0hPUDAwMVBFUlU=, deviceheight=1184
		$retorno->respuesta 	= 'ERROR';
		$retorno->mensaje 		= 'faltan datos';

		$data->latitud 			= '';
		$data->longitud 		= '';
		$data->devicewidth 		= '';
		$data->deviceheight 	= '';
		$data->iddispositivo 	= '';
		$data->token 			= '';
		$data->nivel 			= '';
		$data->curso 			= '';

		if (isset($_POST['latitud']) && $_POST['latitud']!== '') {
			$data->latitud = $_POST['latitud'];
		}

		if (isset($_POST['longitud']) && $_POST['longitud']!== '') {
			$data->longitud = $_POST['longitud'];
		}

		if (isset($_POST['devicewidth']) && $_POST['devicewidth']!== '') {
			$data->devicewidth = $_POST['devicewidth'];
		}

		if (isset($_POST['deviceheight']) && $_POST['deviceheight']!== '') {
			$data->deviceheight = $_POST['deviceheight'];
		}

		if (isset($_POST['iddispositivo']) && $_POST['iddispositivo']!== '') {
			$data->iddispositivo = $_POST['iddispositivo'];
		}

		if (isset($_POST['token']) && $_POST['token']!== '') {
			$data->token = $_POST['token'];
		}

		if (isset($_POST['curso']) && $_POST['curso']!== '') {
			$data->curso = $_POST['curso'];
		}

		if (isset($_POST['nivel']) && $_POST['nivel']!== '') {
			$data->nivel = $_POST['nivel'];
		}

		if (isset($data->latitud) && $data->latitud!= '' && isset($data->longitud) && $data->longitud!= '') {
			$retorno->respuesta 	= 'OK';
			$retorno->mensaje 		= 'Se encontraron datos';
			$retorno->listado 		= $objIglesias->listado($data);


			vistaJson($retorno);
		}

		
	}
	public function detalle()
	{
		$data 			=  new stdClass();
		$retorno		=  new stdClass();
		$objIglesias 	= new ModeloIglesias();

		//longitud=-76.9082238, latitud=-12.0272347, devicewidth=720, iddispositivo=103c364df26b646f, token=SEVZU0hPUDAwMVBFUlU=, id=4, deviceheight=1184
		
		$retorno->respuesta 			= 'ERROR';
		$retorno->mensaje 				= 'No Se encontraron datos';
		$data->latitud 					= '';
		$data->longitud 				= '';
		$data->devicewidth 				= '';
		$data->deviceheight 			= '';
		$data->iddispositivo 			= '';
		$data->token 					= '';
		$data->id 						= '';
		$data->idnivel					= '';
		$data->idcurso					= '';

		if (isset($_POST['longitud']) && $_POST['longitud']!== '') {
			$data->longitud = $_POST['longitud'];
		}

		if (isset($_POST['latitud']) && $_POST['latitud']!== '') {
			$data->latitud = $_POST['latitud'];
		}

		if (isset($_POST['devicewidth']) && $_POST['devicewidth']!== '') {
			$data->devicewidth = $_POST['devicewidth'];
		}

		if (isset($_POST['deviceheight']) && $_POST['deviceheight']!== '') {
			$data->deviceheight = $_POST['deviceheight'];
		}

		if (isset($_POST['iddispositivo']) && $_POST['iddispositivo']!== '') {
			$data->iddispositivo = $_POST['iddispositivo'];
		}

		if (isset($_POST['token']) && $_POST['token']!== '') {
			$data->token = $_POST['token'];
		}

		if (isset($_POST['id']) && $_POST['id']!== '') {
			$data->id = $_POST['id'];
		}

		if (isset($_POST['idnivel']) && $_POST['idnivel']!== '') {
			$data->idnivel = $_POST['idnivel'];
		}

		if (isset($_POST['idcurso']) && $_POST['idcurso']!== '') {
			$data->idcurso = $_POST['idcurso'];
		}


		$retorno->respuesta 			= 'OK';
		$retorno->mensaje 				= 'Se encontraron datos';


		$retorno->listado 				= $objIglesias->detalle($data);
		$retorno->telefonos->lista		= $objIglesias->telefonos($data);
		$retorno->telefonos->total		= count($objIglesias->telefonos($data));
		$retorno->misa->lista			= $objIglesias->misasxCapilla($data);
		$retorno->misa->total			= 3;
		$retorno->adoracion->lista		= $objIglesias->misasxCapilla($data);
		$retorno->adoracion->total		= 3;
		$retorno->confesion->lista		= $objIglesias->misasxCapilla($data);
		$retorno->confesion->total		= 3;

		$retorno->cursos->lista		= $objIglesias->cursos($data);
		$retorno->cursos->total		= 6;


		vistaJson($retorno);
	}
}

?>