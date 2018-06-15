<?php  
include("inc.aplication_top.php");

switch ($_GET['opcion']) {
	case 'prod':
		$id = $_GET['id'];
		$query = new consulta("SELECT * FROM productos_imagenes WHERE id = '$id' ");
	    $datos = $query->VerRegistro();
	        
	     if(isset($datos['big_producto_imagen'])){
				if(file_exists(_ruta_imagenes_saweto_ . $datos['big_producto_imagen'])){
					unlink (_ruta_imagenes_saweto_ . $datos['big_producto_imagen']);
					unlink (_ruta_imagenes_saweto_ . $datos['thumb_producto_imagen']);
				}							
			}

		// ELIMINA REGISTRO
		$sql = " DELETE FROM productos_imagenes WHERE id = '".$id."' ";
		$queryDelete = new Consulta($sql);	
	break;

	case 'banner':
		$id = $_GET['id'];
		$sql =  "SELECT * FROM banners WHERE imagen_banner_imagen = '$id' ";
		$query = new consulta($sql);
	    $datos = $query->VerRegistro();
	        
	     if(isset($datos['imagen_banner_imagen'])){
				if(file_exists(_ruta_imagenes_saweto_ . 'banners/'.$datos['imagen_banner_imagen'])){
					unlink (_ruta_imagenes_saweto_ . 'banners/'. $datos['imagen_banner_imagen']);
					unlink (_ruta_imagenes_saweto_ . 'banners/'. $datos['thumb_banner_imagen']);
				}							
			}

		// ELIMINA REGISTRO
		$sql = " DELETE FROM banners WHERE imagen_banner_imagen = '".$id."' ";
		$queryDelete = new Consulta($sql);	
	break;
}

?>