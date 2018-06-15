<?php 
class ModeloBanner 
{
	private $_imagenes;
	public function __construct()
	{		
			$sql_imgs = " SELECT * FROM banners";
			$query_imgs = new Consulta($sql_imgs);			
			if($query_imgs->NumeroRegistros() > 0)
			{
				while($row_imgs = $query_imgs->VerRegistro())
				{
					$this->_imagenes[] = array(
							'id' 		 => $row_imgs['id'],
							'thumbnail'  => $row_imgs['thumb_banner_imagen'],
							'imagen' 	 => $row_imgs['imagen_banner_imagen'],
							'nombre' 	 => $row_imgs['nombre_banner'],
							'url' 		 => $row_imgs['url_banner']
							);
				}
			}
	}
	public function __get($atributo){
		return $this->$atributo;
	}
}
?>