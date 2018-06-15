<?php  
/**
* 
*/
class ModeloMailing
{
	
	public function enviarClavePaciente($obj)
	{
		$mensaje =  '<p>Estimado Paciente: '.$obj->dato.', tu clave es: '.$obj->password.'</p>';
		$this->enviar($obj->correo, 'Recordatorio de Clave', $mensaje);
	}

	public function enviar($correo, $asunto, $mensaje)
	{
		@mail($correo, $asunto, $mensaje,"From: '".$correo."'");
	}
}

?>