<?php  
/**
* 
*/
class ModeloAlertas
{
	public function alertasActivas($obj)
	{
		$sql = "SELECT * FROM alertas where alerta_visto = 1 ORDER BY alerta_id DESC";
		$query =  new Consulta($sql);
		$data = array();
		while ($row = $query->VerRegistro()) {
			$data[] = array(
				'alerta_id' 			=> $row['alerta_id'],
				'alerta_titulo' 		=> $row['alerta_titulo'],
				'alerta_descripcion' 	=> $row['alerta_descripcion'],
				'alerta_imagen' 		=> $row['alerta_imagen'],
				'alerta_url' 			=> $row['alerta_url']
				);
		}


		return $data;



	}
}
?>

