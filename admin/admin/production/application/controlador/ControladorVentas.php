<?php  
/**
* 
*/
class ControladorVentas
{
	
	public function totalVentasMensuales()
	{
		$data 		= new stdClass();
		$obj 		= new ModeloVentas();
		$data->inicio 		= obtenerPrimerDiaMes();
		$data->fin 			= obtenerUltimoDiaMes();;

		$retorno = $obj->obtenerTotalVentas($data);

		return $retorno;

	}

	public function ventasPorProducto($post)
	{
		
		$obj 			= new ModeloVentas();
		$data 			= new stdClass();
		$data->inicio 	= '';
		$data->fin 		= '';

		if ($post->fecha_inicio != '') {
			$data->inicio = formato_date('/',$post->fecha_inicio);
		}

		if ($post->fecha_fin != '') {
			$data->fin = formato_date('/',$post->fecha_fin);
		}
		$data->producto = $post->producto;
		$retorno 		= $obj->ventasPorProducto($data);

		return $retorno;
	}

	public function totalVentasSemanales()
	{
		$data 		= new stdClass();
		$obj 		= new ModeloVentas();

		$fecha 				= inicio_fin_semana(FECHA);
		$data->inicio 		= $fecha['fechaInicio'];
		$data->fin 			= $fecha['fechaFin'];

		$retorno = $obj->obtenerTotalVentas($data);

		return $retorno;

	}

	public function totalVentasDiarias()
	{
		$data 		= new stdClass();
		$obj 		= new ModeloVentas();

		$data->inicio 		= FECHA;
		$data->fin 			= FECHA;

		$retorno = $obj->obtenerTotalVentas($data);

		return $retorno;

	}

	public function jsonVentasAnuales($inicio)
	{
		$data 		= new stdClass();
		$obj 		= new ModeloVentas();

		$data->inicio 		= $inicio;
		$data->fin 			= FECHA;

		$retorno = $obj->obtenerJsonVentasAnuales($data);
		return $retorno;
		
		
	}
}

?>