<?php  

/**
* 
*/
class ModeloPedidos
{
	
	public function updatePedidosAction()
	{

		$objProductos  =  new ModeloProductos();
		$objInsumos    =  new ModeloInsumos();

		$productos 	= array_filter($_POST['producto']);
		$precio 	= array_filter($_POST['precio']);
		$cantidad 	= array_filter($_POST['cantidad']);
		$total 		= array_filter($_POST['total']);

		$pop 	= array_keys($productos);
		$inicio = key($productos);
		$final 	= array_pop($pop);

		for ($i = 0; $i < $final; $i++) { 

			if ($i< $inicio || $total[$i] == '0.00') {
				unset($total[$i]);
			}
			
		}
		$productos 	= array_values($productos);
		$precio 	= array_values($precio);
		$cantidad 	= array_values($cantidad);
		$total 		= array_values($total);

		
		
		$sql =  "UPDATE pedidos_cabecera set 
					cliente = '".$_POST['cliente']."', 
					total= '".$_POST['totalpedido']."' 
				where id_pedido = '".$_POST['venta']."'";

		$query = new Consulta($sql);

		//ELiminamos el detalle de la venta y lo volvemos a crear
		$this->eliminarDdetalleVenta($_POST['venta']);
		$objInsumos->eliminarSalidaAlmacen($_POST['venta']);

		//creamos los item de la venta

		$sqlDetalle 	= "INSERT INTO pedidos_detalle(pedido_cabecera_id, producto_id, precio, cantidad, total, fecha, hora) VALUES ";
		$sql_detalle 	= '';
		for ($i=0; $i < count($precio); $i++) { 


			
			$producto_id 	= $objProductos->busquedaxNombre($productos[$i]);
			$insumos 		= $objInsumos->listInsumosxProducto($producto_id);
			$objInsumos->salidaInsumos($insumos,$cantidad[$i],$_POST['venta']);

			$sql_detalle .= "(
							'".$_POST['venta']."',
							'".$producto_id."',
							'".$precio[$i]."',
							'".$cantidad[$i]."',
							'".$total[$i]."',
							'".FECHA."',
							'".HORA."'
							),";
		}

		 $sql 	= eliminaUltimoCaracrter($sqlDetalle.$sql_detalle);

		 $query = new Consulta($sql);
		 location("pedidos-dia.php");
		
	}

	public function eliminarDdetalleVenta($venta)
	{
		$sql =  "DELETE FROM pedidos_detalle WHERE pedido_cabecera_id = '$venta'";

		$query = new Consulta($sql);

	}





	public function listarPedidos($obj)
	{
		$fecha = FECHA;

		$sql = "SELECT PD.pedidos_detalle_id, P.nom_producto, PD.precio,PD.cantidad,PD.total, PD.fecha, PD.hora 
				FROM pedidos_detalle AS PD
				INNER JOIN producto AS P ON (P.id_producto = PD.producto_id)
				WHERE PD.fecha BETWEEN '$obj->fecha_inicio' AND '$obj->fecha_fin'";

		$query = new Consulta($sql);

		
		$numeroRegistros 	= $query->NumeroRegistros();
		//echo $sql;
				while ($row = $query->VerRegistro()) {

					$data[] = array(
						'pedidos_detalle_id' 	=> $row['pedidos_detalle_id'],
						'nom_producto' 			=> $row['nom_producto'],
						'precio' 				=> $row['precio'],
						'cantidad' 				=> $row['cantidad'],
						'total' 				=> $row['total'],
						'fecha' 				=> $row['fecha'],
						'hora' 					=> $row['hora']

						);
				}

				return $data;
		

	}


	public function addPedidosAction()
	{
		$objProductos  	= new ModeloProductos();
		$objInsumos 	= new ModeloInsumos();

		$productos 	= array_filter($_POST['producto']);
		$precio 	= array_filter($_POST['precio']);
		$cantidad 	= array_filter($_POST['cantidad']);
		$total 		= array_filter($_POST['total']);

		$pop 	= array_keys($productos);
		$inicio = key($productos);
		$final 	= array_pop($pop);

		for ($i = 0; $i < $final; $i++) { 

			if ($i< $inicio) {
				unset($total[$i]);
			}
			
		}

		$sqlcabecera =  "INSERT INTO pedidos_cabecera (fecha_pedido, hora_pedido, cliente, total) VALUES(
				'".FECHA."',
				'".HORA."',
				'".$_POST['cliente']."',
				'".$_POST['totalpedido']."')";

		$query = new Consulta($sqlcabecera);
		$pedido_cabecera_id = $query->nuevoId();		

		$sqlDetalle 	= "INSERT INTO pedidos_detalle(pedido_cabecera_id, producto_id, precio, cantidad, total, fecha, hora) VALUES ";
		$sql_detalle 	= '';
		for ($i = $inicio; $i < ($final +1); $i++) { 
			$producto_id =  $objProductos->busquedaxNombre($productos[$i]);
			//ingresamos la salida de insumos por producto

			$insumos = $objInsumos->listInsumosxProducto($producto_id);

			$objInsumos->salidaInsumos($insumos,$cantidad[$i],$pedido_cabecera_id);

			$sql_detalle .= "(
							'".$pedido_cabecera_id."',
							'".$producto_id."',
							'".$precio[$i]."',
							'".$cantidad[$i]."',
							'".$total[$i]."',
							'".FECHA."',
							'".HORA."'
							),";
		}

		$sql =  eliminaUltimoCaracrter($sqlDetalle.$sql_detalle);

		$query = new Consulta($sql);

		location("pedidos-dia.php"); 
	}
}

?>