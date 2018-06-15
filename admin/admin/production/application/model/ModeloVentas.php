<?php  

/**
* 
*/
class ModeloVentas
{

	public function eliminarPedido($pedido_id)
	{
		$sql = "DELETE FROM stock_almacen WHERE pedido_id = '".$pedido_id."'";
		$query =  new Consulta($sql);

		$sql =  "DELETE FROM pedidos_cabecera where id_pedido= '".$pedido_id."'";
		$query =  new Consulta($sql);

		$sql =  "DELETE FROM pedidos_detalle where pedido_cabecera_id= '".$pedido_id."'";
		$query =  new Consulta($sql);

	}

	public function verificarCierreCaja($obj)
	{

		$sql 	= "SELECT * FROM cierre_caja WHERE fecha = '$obj->fecha'";
		$query 	= new Consulta($sql);

		return $query->NumeroRegistros();
	}

	public function totalVentasDia($obj)
	{
		$sql = "SELECT SUM(total)AS total FROM pedidos_cabecera WHERE fecha_pedido = '$obj->fecha'";
		$query 	= new Consulta($sql);

		$row =  $query->VerRegistro();
		if ($row['total'] == 0) {
			return 0;
		}
		return $row['total'];
	}

	public function cambiarEstadoVenta($ventaID, $estado =2)
	{
		$sql = "UPDATE pedidos_cabecera set estado = $estado WHERE id_pedido = '$ventaID'";
		$query = new Consulta($sql);

	}


	public function obtenerTotalVentas($obj)
	{
		$sql = "SELECT count(*) as cantidad FROM pedidos_cabecera WHERE  fecha_pedido BETWEEN '$obj->inicio' AND '$obj->fin'";
		$query = new Consulta($sql);
		$row =  $query->VerRegistro();
		return $row['cantidad'];
	}

	public function obtenerJsonVentasAnuales($obj)
	{
		$sql = "SELECT 
					monto,
					fecha, 
					DATE_FORMAT(fecha,'%d') AS d, 
					DATE_FORMAT(fecha,'%m') AS m, 
					DATE_FORMAT(fecha,'%Y') AS y  
				FROM cierre_caja 
				WHERE  fecha BETWEEN '".$obj->inicio."' AND '".$obj->fin."' ORDER BY fecha ASC";

		$query = new Consulta($sql);
		$data = array();
		while ($row =  $query->VerRegistro()) {
			$mes = $row['m'];
			$dia = $row['d'];
			if ($mes < 10)  {
				$mes = substr($mes, 1);
			}

			$data[] =  array(
				'monto' => $row['monto'],
				'fecha' => $row['fecha'],
				'd' 	=> $dia,
				'm' 	=> $mes,
				'y' 	=> $row['y']
			);
		}
		return $data;
	}
	public function ventasPorProducto($obj)
	{
			$producto = '';
			if ($obj->producto != '') {
				$producto =  'AND pd.producto_id = "'.$obj->producto.'" ';
			}

		
		$sql 	= "SELECT nom_producto, SUM(cantidad) AS cantidad,SUM(total) AS total, precio AS precio_unitario,fecha
					FROM pedidos_detalle AS pd
					INNER JOIN producto AS p ON(p.id_producto = pd.producto_id)
					WHERE fecha BETWEEN '".$obj->inicio."' AND '".$obj->fin."'
					$producto
					GROUP BY nom_producto,cantidad, total, precio, fecha
					ORDER BY fecha DESC";

		$query 	= new Consulta($sql);
		$data 	= array();
		while ($row = $query->VerRegistro()) {
			$data[] = array(
				'nombre_producto' 	=> $row['nom_producto'],
				'cantidad' 			=> $row['cantidad'],
				'precio_unitario' 	=> $row['precio_unitario'],
				'total' 			=> $row['total'],
				'fecha' 			=> $row['fecha']
			);
		}

		return $data;
	

	}

	public function ventasDelDia()
	{
		$fecha = FECHA;
		
		$sql = "SELECT id_pedido,fecha_pedido,hora_pedido,cliente, total, estado FROM pedidos_cabecera where fecha_pedido = '".$fecha."' ORDER BY fecha_pedido DESC, hora_pedido DESC";
		$query = new Consulta($sql);

		$data = array();
		while ($row =  $query->VerRegistro()) {
			if ($row['estado'] == 1) {
				$condicion 		= 'Pendiente';
			}else if($row['estado'] == 2){
				$condicion = 'Pagado';
			}else{
				$condicion = 'Anulado';
			}


			$data[] =  array(
					'id_pedido' 	=> $row['id_pedido'],
					'cliente' 		=> $row['cliente'],
					'fecha_pedido' 	=> $row['fecha_pedido'],
					'hora_pedido' 	=> $row['hora_pedido'],
					'total' 		=> $row['total'],
					'estado' 		=> $row['estado'],
					'condicion' 	=> $condicion

				);

			
		}
		return $data;
	}

	public function generarCierreCaja($obj)
	{
		$sql 	= "INSERT INTO cierre_caja (fecha,monto,registro) VALUES ('$obj->fecha','$obj->total','$obj->registro')";
		$query 	= new Consulta($sql);

	}

	public function listadoVentas($obj)
	{
		$fecha = '';
		//pre($obj);


		if ($obj->fecha_inicio != '' && $obj->fecha_fin != '') {

			$fecha = " WHERE  fecha_pedido BETWEEN '".formato_date('/',$obj->fecha_inicio)."' AND '".formato_date('/',$obj->fecha_fin)."'";
		}
		

		$sql = "SELECT id_pedido,fecha_pedido,hora_pedido,cliente, total, estado FROM pedidos_cabecera $fecha ORDER BY fecha_pedido DESC, hora_pedido DESC";
		$query = new Consulta($sql);

		$data = array();

		while ($row =  $query->VerRegistro()) {
			if ($row['estado'] == 1) {
				$condicion 		= 'Pendiente';
			}else if($row['estado'] == 2){
				$condicion = 'Pagado';
			}else{
				$condicion = 'Anulado';
			}


			$data[] =  array(
					'id_pedido' 	=> $row['id_pedido'],
					'cliente' 		=> $row['cliente'],
					'fecha_pedido' 	=> $row['fecha_pedido'],
					'hora_pedido' 	=> $row['hora_pedido'],
					'total' 		=> $row['total'],
					'estado' 		=> $row['estado'],
					'condicion' 	=> $condicion

				);

			
		}
		return $data;
	}


	public function cabeceraVentaID($id)
	{
		$sql =  "SELECT id_pedido, cliente, total,estado, fecha_pedido FROM pedidos_cabecera where id_pedido = '$id'";
		$query = new Consulta($sql);

		$row = $query->VerRegistro();

		$data =  array(
					'cliente' 		=> $row['cliente'],
					'id_pedido' 	=> $row['id_pedido'],
					'total' 		=> $row['total'],
					'estado' 		=> $row['estado'],
					'fecha_pedido' 	=> $row['fecha_pedido']
					

				);

		return $data;



	}


	public function detalleVentaID($id)
	{
		$sql = "SELECT pd.pedido_cabecera_id,pd.pedidos_detalle_id, pd.producto_id,p.nom_producto, pd.precio, 
				pd.cantidad, pd.total, pd.fecha, pd.hora 
				FROM pedidos_detalle AS pd
				INNER JOIN producto AS p ON (p.id_producto =  pd.producto_id)
				WHERE pd.pedido_cabecera_id = '$id'";
		$query = new Consulta($sql);


		while ($row =  $query->VerRegistro()) {
			


			$data[] =  array(
					'pedido_cabecera_id' 	=> $row['pedido_cabecera_id'],
					'pedidos_detalle_id' 	=> $row['pedidos_detalle_id'],
					'producto_id' 			=> $row['producto_id'],
					'nom_producto' 			=> $row['nom_producto'],
					'precio' 				=> $row['precio'],
					'cantidad' 				=> $row['cantidad'],
					'total' 				=> $row['total'],
					'fecha' 				=> $row['fecha'],
					'hora' 					=> $row['hora'],
					

				);

			
		}
		return $data;
	}

	

	public function listCierreDiarioVentas()
	{
		$sql 	= "SELECT fecha,monto,DATE(registro) AS fecha_registro, TIME(registro) AS hora_registro FROM cierre_caja ORDER BY id DESC";
		$query 	= new Consulta($sql);

		while ($row =  $query->VerRegistro()) {
			$data[] = array(

				'fecha' 			=> $row['fecha'],
				'monto' 			=> $row['monto'],
				'fecha_registro' 	=> $row['fecha_registro'],
				'hora_registro' 	=> $row['hora_registro']

				);

		}
		return $data;
	}
}
?>