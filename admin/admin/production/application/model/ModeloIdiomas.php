<?php 
class ModeloIdiomas
{
	
	public function getIdiomas(){
		$query = new Consulta("SELECT * FROM idiomas ORDER BY id_idioma ASC");
		while($row = $query->VerRegistro())
		{
			$idiomas[] = array(
				'id' 	  => $row['id_idioma'],
				'nombre'  => $row['nombre_idioma'],
				'imagen'  => $row['imagen_idioma'],
				'archivo' => $row['archivo_idioma']
			);
		}
		return $idiomas;
	}
}
?>