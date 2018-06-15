<?php 
class ModeloBanner 
{
	private $_imagenes;
	public function __construct()
	{		
			$sql_imgs = " SELECT * FROM banners where id_idioma = 1";
			$query_imgs = new Consulta($sql_imgs);			
			if($query_imgs->NumeroRegistros() > 0)
			{
				while($row_imgs = $query_imgs->VerRegistro())
				{
					$this->_imagenes[] = array(
							'id' 		=> $row_imgs['id'],
							'thumbnail' => $row_imgs['thumb_banner_imagen'],
							'imagen' 	=> $row_imgs['imagen_banner_imagen']);
				}
			}
	}
	public function __get($atributo){
		return $this->$atributo;
	}
}
?>