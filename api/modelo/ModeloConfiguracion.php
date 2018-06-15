<?php  
/**
* 
*/
class ModeloConfiguracion
{
	
	public function obtenerWebService()
	{
		$sql =  "SELECT * FROM configuracion WHERE id_configuracion = '2'";
		$data = ModeloConexion::ejecutar( $sql , DB_NAME ,DB_SELECT);

		return $data['LISTA'][0]->valor_configuracion;
	}
}
?>