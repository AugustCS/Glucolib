<?php  
/**
* 
*/
class ModeloUnidadMedida
{
	
	public function lista()
	{
		$sql =  "SELECT  id,nombre FROM unidad_medida order by nombre asc";
		$query =  new Consulta($sql);

		while ($row =  $query->VerRegistro()) {
			$data[] =  array(
				'id' 		=> $row['id'],
				'nombre' 	=> $row['nombre'],

			);

		}
		return $data;
	}
	public function lista2()
	{
		$sql =  "SELECT  id,nombre FROM unidad_medida where nombre<>'Kg' order by nombre asc";
		$query =  new Consulta($sql);

		while ($row =  $query->VerRegistro()) {
			$data[] =  array(
				'id' 		=> $row['id'],
				'nombre' 	=> $row['nombre'],

			);

		}
		return $data;
	}
}

?>