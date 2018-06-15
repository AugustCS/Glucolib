<?php  
/**
* 
*/
class ControladorAlertas
{
	
	public function panelAlertas()
	{
		
		$data 		= new stdClass();
		$objAlertas = new ModeloAlertas();



		return $objAlertas->alertasActivas($data);

	}
}

?>