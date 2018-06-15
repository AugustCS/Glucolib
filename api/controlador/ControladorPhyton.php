<?php  
class Controladorphyton extends ControladorGeneral {


	public function index()
	{
		$data = new stdClass();
		$data->respuesta = 'OK';
		$data->mensaje = 'aqui recibiras los parametros';

		VistaJson($data);
		die();
	}
	public function respuesta()
	{
		require_once APP_DIR."modelo/ModeloDatos.php";  
		$data  	= new stdClass();
		$obj 	= new ModeloDatos();

		$data->valor = '';

		if (isset($_GET['parametro']) && !empty($_GET['parametro'])) {
			$data->valor = trim($_GET['parametro']);
		}
		if (empty($data->valor)) {
			$data->respuesta = 'ERROR';
			$data->mensaje = 'El parámetro valor esta vacío';

			VistaJson($data);
			return false;
		}else{
			$obj->actualizarParametro($data);
			$data->respuesta = 'OK';
			$data->mensaje = 'valor Guardado ';
			$data->valoractual = $obj->resultadoMuestra();

			VistaJson($data);
		}
	}

}

?>