<?php  

/**
* 
*/
class ControladorAlmacen
{
	
	public function stockFecha($post,$tipo,$condicion)
	{
		$objInsumos 	= new ModeloInsumos();	
		$data 			= new stdClass();	

		$data->codigo 			= '';
		$data->unidad_medida 	= '';
		$data->insumo 			= '';
		$data->movimiento 		= '';
		$data->desde 			= '';
		$data->hasta 			= '';

		if (isset($_POST['codigo']) && $_POST['codigo']!= '') {
			$data->codigo = $_POST['codigo'];
		}
		if (isset($_POST['unidad_medida']) && $_POST['unidad_medida']!= '') {
			$data->unidad_medida = $_POST['unidad_medida'];
		}
		if (isset($_POST['insumo']) && $_POST['insumo']!= '') {
			$data->insumo = $_POST['insumo'];
		}
		if (isset($_POST['movimiento']) && $_POST['movimiento']!= '') {
			$data->movimiento = $_POST['movimiento'];
		}
		if (isset($_POST['desde']) && $_POST['desde']!= '') {
			$data->desde =  formato_date('/',$_POST['desde']);
		}
		if (isset($_POST['hasta']) && $_POST['hasta']!= '') {
			$data->hasta = formato_date('/',$_POST['hasta']);
		}
		
		$lista 			= $objInsumos->listStockInsumos($data,$tipo,$condicion);

		return $lista;
	}

	public function stockAlmacen($post)
	{
		$data 	= new stdClass();
		$obj 	=  new ModeloInsumos();

		if (isset($post['desde']) && $post['desde']!= '') {
			$data->desde =  formato_date('/',$post['desde']);
		}
		if (isset($post['hasta']) && $post['hasta']!= '') {
			$data->hasta = formato_date('/',$post['hasta']);
		}
		return $obj->stockAlmacen($data);


	}
}

?>