<?php  

/**
* 
*/
class ModeloInsumos
{
	
	public function obtenerUltimoID()
	{
		$sql 	= "SELECT MAX(id_insumo) as ID FROM insumo";
		$query 	= new Consulta($sql);
		$data 	= $query->VerRegistro();

		return $data['ID'] + 1;
	}

	public function precioInsumoEntregar($idInsumo)
	{
		$sql = " SELECT i.id, i.insumo_id, i.cantidad, i.unidad_medida_id, u.nombre, i.precio_compra
				FROM stock_almacen AS i
				INNER JOIN unidad_medida AS u ON
				(u.id = i.unidad_medida_id)
				WHERE insumo_id = '$idInsumo' and movimiento_almacen_id = 1 ORDER BY id DESC LIMIT 1";
		$query =  new Consulta($sql);
		$data =  array();
		while ($row =  $query->VerRegistro()) {
			$data[] = array(
				'id' 				=> $row['id'],
				'insumo_id' 				=> $row['insumo_id'],
				'cantidad' 			=> $row['cantidad'],
				'unidad_medida_id' 	=> $row['unidad_medida_id'],
				'nombre' 			=> $row['nombre'],
				'precio_compra' 	=> $row['precio_compra']
			);
		}

		return $data;

	}

	public function addInsumosAction()
	{
		$codigo = "I-0000".$this->obtenerUltimoID();

		$sql = "INSERT INTO insumo (cod_insumo, nom_insumo, des_insumo, fec_registro)VALUES(
			'".$codigo."',
			'".$_POST['nombre']."',
			'".$_POST['descripcion']."',
			'".TIEMPO."'
			)";

		$query =  new Consulta($sql);
		location("insumos.php");
	}

	public function eliminarSalidaAlmacen($pedido_id)
	{
		$sql =  "DELETE FROM stock_almacen where pedido_id = $pedido_id";
		$query = new Consulta($sql);

	}

	public function salidaInsumos($obj,$cantidad,$pedido_id)
	{
				
		if ($obj->total > 0) {
			$lista  =  $obj->listado;

			for ($i=0; $i < count($lista); $i++) { 

				$totalPrecioVendido = $cantidad * $lista[$i]['cantidad'];
				
				$sql = "INSERT INTO stock_almacen (insumo_id, cantidad, unidad_medida_id, fecha_registro,movimiento_almacen_id,pedido_id)VALUES(
					'".$lista[$i]['id_insumo']."',
					'".$cantidad."',
					'".$lista[$i]['unidad_medida']."',
					'".TIEMPO."',
					'2',
					'".$pedido_id."'
					)";

					$query = new Consulta($sql);


			}
			
		}
	}


	public function addCantidadInsumosAction()
	{
		
		$cantidad 		= $_POST['cantidad'];
		$unidadMedida 	= $_POST['unidad_medida'];

		switch ($_POST['unidad_medida']) {
				case '1':
					$cantidad 		= 1000 * $_POST['cantidad'];
					$unidadMedida 	= 4;
					break;
				
				case '2':
					$cantidad 		= 1000 * $_POST['cantidad'];
					$unidadMedida 	= 5;
					break;
			}	
		
		$sql = "INSERT INTO stock_almacen (insumo_id, cantidad, unidad_medida_id, precio_compra, precio_venta, fecha_registro, movimiento_almacen_id)VALUES(
			'".$_POST['insumo_id']."',
			'".$cantidad."',
			'".$unidadMedida."',
			'".$_POST['precio_compra']."',
			'".$_POST['precio_venta']."',
			'".TIEMPO."',
			'1'
			)";


		$query =  new Consulta($sql);
		location("ingreso-almacen.php");
	}


	public function updateCantidadInsumosAction()
	{

		$cantidad 		= $_POST['cantidad'];
		$unidadMedida 	= $_POST['unidad_medida'];

		switch ($_POST['unidad_medida']) {
				case '1':
					$cantidad 		= 1000 * $_POST['cantidad'];
					$unidadMedida 	= 4;
					break;
				
				case '2':
					$cantidad 		= 1000 * $_POST['cantidad'];
					$unidadMedida 	= 5;
					break;
			}	



		$sql = "UPDATE stock_almacen set 
				insumo_id 		= '".$_POST['insumo_id']."',
				cantidad 		= '".$cantidad."',
				unidad_medida_id= '".$unidadMedida."',
				precio_compra 	= '".$_POST['precio_compra']."',
				precio_venta 	= '".$_POST['precio_venta']."'
				WHERE id = '".$_POST['id']."'";
		$query =  new Consulta($sql);
		location("ingreso-almacen.php");
	}

	public function deleteCantidadInsumosAction()
	{
		$sql ="DELETE FROM stock_almacen WHERE id = '".$_GET['id']."'";
		$query =  new Consulta($sql);
		location("ingreso-almacen.php");
		
	}


	public function deleteInsumosAction()
	{
		$sql ="DELETE FROM insumo WHERE id_insumo = '".$_GET['id']."'";
		$query =  new Consulta($sql);
		location("insumos.php");
	}

		public function updateInsumosAction()
	{
		$sql =  "UPDATE insumo set 
				nom_insumo 		= '".$_POST['nombre']."',
				des_insumo 		= '".$_POST['descripcion']."'
				WHERE id_insumo = '".$_POST['id']."'
				";

			$query =  new Consulta($sql);
		location("insumos.php");	
	}

	public function listInsumos()
	{
		$sql = "SELECT id_insumo, nom_insumo, des_insumo,cod_insumo, fec_registro FROM insumo";
		$query =  new Consulta($sql);
		$data =  array();
		while ($row =  $query->VerRegistro()) {
			$data[] = array(
				'id' 				=> $row['id_insumo'],
				'nombre' 			=> $row['nom_insumo'],
				'descripcion' 		=> $row['des_insumo'],
				'nom_producto' 		=> $row['nom_insumo'],
				'des_producto' 		=> $row['des_insumo'],
				'cod_insumo' 		=> $row['cod_insumo'],
				'fec_registro' 		=> $row['fec_registro'],
			);
		}

		return $data;
	}

	public function listInsumosxProducto($producto_id)
	{
		$sql =  "SELECT id_producto,id_insumo, unidad_medida, cantidad 
				FROM producto_insumo 
				WHERE id_producto = '$producto_id'";
		$query 				= new Consulta($sql);
		$respuesta 			= new stdClass();
		$respuesta->total 	= $query->NumeroRegistros();

		$data = array();
		while ($row =  $query->VerRegistro()) {
			$data[] = array(
				'id_producto' 		=> $row['id_producto'],
				'id_insumo' 		=> $row['id_insumo'],
				'unidad_medida' 	=> $row['unidad_medida'],
				'cantidad' 			=> $row['cantidad']
			);
		}
		
		$respuesta->listado = $data;

		return $respuesta;

	}


	public function listSalidaStockInsumos()
	{
		$sql = "SELECT ii.id, ii.insumo_id,cantidad,ii.unidad_medida_id, precio_compra, 
				precio_venta, fecha_registro,i.nom_insumo AS insumo ,i.cod_insumo, 
				u.nombre AS unidad_medida FROM stock_almacen AS ii
				INNER JOIN insumo AS i ON(i.id_insumo = ii.insumo_id)
				INNER JOIN unidad_medida AS u ON (u.id = ii.unidad_medida_id)
				where movimiento_almacen_id = 2
				ORDER BY fecha_registro DESC";
		$query =  new Consulta($sql);
		$data  = array();
		while ($row =  $query->VerRegistro()) {
			$data[] = array(
				'id' 				=> $row['id'],
				'id_insumo' 		=> $row['insumo_id'],
				'cantidad' 			=> $row['cantidad'],
				'unidad_medida_id' 	=> $row['unidad_medida_id'],
				'precio_compra' 	=> $row['precio_compra'],
				'precio_venta' 		=> $row['precio_venta'],
				'fecha_registro' 	=> $row['fecha_registro'],
				'insumo' 			=> $row['insumo'],
				'cod_insumo' 		=> $row['cod_insumo'],
				'unidad_medida' 	=> $row['unidad_medida']
			);
		}

		return $data;
	}

	public function listStockInsumos($obj, $tipo,$condicion=null)
	{
		$where 	= "";
        $codigo 		= $obj->codigo;
        $desde 			= $obj->desde;
        $hasta 			= $obj->hasta;
        $unidad_medida 	= $obj->unidad_medida;
        $insumo 		= $obj->insumo;
        $movimiento 	= $obj->movimiento;

        if($desde!=""){
            $where ="DATE(fecha_registro)>='".$desde."'";
        }
        if($hasta!=""){
            if($where!=""){$where=$where." AND ";}
            $where = $where ."DATE(fecha_registro)<='".$hasta."'";
        }
        if($codigo!=""){
            if($where!=""){$where=$where." AND ";}
            $where = $where ."i.cod_insumo='".$codigo."'";
        }
        if($unidad_medida!=""){
            if($where!=""){$where=$where." AND ";}
            $where = $where ."ii.unidad_medida_id='".$unidad_medida."'";
        }

        if ($insumo != "") {
        	if($where!=""){$where=$where." AND ";}
            $where = $where ."i.nom_insumo LIKE '%".$insumo."%'";
        }

        if ($movimiento != "") {
        	if($where!=""){$where=$where." AND ";}
            $where = $where ."movimiento_almacen_id='".$movimiento."'";
        }

        if ($tipo!= "") {
        	if($where!=""){$where=$where." AND ";}
            $where = $where ."movimiento_almacen_id='".$tipo."'";
        }

        if($where!=""){$where=" where ".$where;}


        if ($condicion != "") {
        	$sql = "SELECT ii.id, ii.insumo_id,cantidad,ii.unidad_medida_id, precio_compra, 
				precio_venta, fecha_registro,i.nom_insumo AS insumo ,i.cod_insumo, 
				u.nombre AS unidad_medida,movimiento_almacen_id FROM stock_almacen AS ii
				INNER JOIN insumo AS i ON(i.id_insumo = ii.insumo_id)
				INNER JOIN unidad_medida AS u ON (u.id = ii.unidad_medida_id)
				$where 
				ORDER BY fecha_registro DESC";

			$query =  new Consulta($sql);
			$data = array();
			while ($row =  $query->VerRegistro()) {
				$movimientoAlmacen = "Entradas";
				if ($row['movimiento_almacen_id'] == 2) {
					# code...
					$movimientoAlmacen = "Salidas";
				}

				
						$data[] = array(
							'id' 				=> $row['id'],
							'id_insumo' 		=> $row['insumo_id'],
							'cantidad' 			=> $row['cantidad'],
							'unidad_medida_id' 	=> $row['unidad_medida_id'],
							'precio_compra' 	=> $row['precio_compra'],
							'precio_venta' 		=> $row['precio_venta'],
							'fecha_registro' 	=> $row['fecha_registro'],
							'insumo' 			=> $row['insumo'],
							'cod_insumo' 		=> $row['cod_insumo'],
							'unidad_medida' 	=> $row['unidad_medida'],
							'movimientoAlmacen' => $movimientoAlmacen
						);	
				

				
			}
        }else{


        	$sql = "SELECT ii.id, ii.insumo_id,sum(cantidad) as cantidad,ii.unidad_medida_id, precio_compra, 
				precio_venta, fecha_registro,i.nom_insumo AS insumo ,i.cod_insumo, 
				u.nombre AS unidad_medida,movimiento_almacen_id FROM stock_almacen AS ii
				INNER JOIN insumo AS i ON(i.id_insumo = ii.insumo_id)
				INNER JOIN unidad_medida AS u ON (u.id = ii.unidad_medida_id)
				
				$where 
				group by ii.insumo_id
				ORDER BY fecha_registro DESC";


				//pre($sql);
		$query =  new Consulta($sql);
		$data = array();
		while ($row =  $query->VerRegistro()) {
			$movimientoAlmacen = "Entradas";
			$cantidad  = $row['cantidad'];
			if ($row['movimiento_almacen_id'] == 2) {
				# code...
				$movimientoAlmacen 	= "Salidas";
				$cantidad  			= '-'.$row['cantidad'];
			}

			
					$data[] = array(
						'id' 				=> $row['id'],
						'id_insumo' 		=> $row['insumo_id'],
						'cantidad' 			=> $cantidad,
						'unidad_medida_id' 	=> $row['unidad_medida_id'],
						'precio_compra' 	=> $row['precio_compra'],
						'precio_venta' 		=> $row['precio_venta'],
						'fecha_registro' 	=> $row['fecha_registro'],
						'insumo' 			=> $row['insumo'],
						'cod_insumo' 		=> $row['cod_insumo'],
						'unidad_medida' 	=> $row['unidad_medida'],
						'movimientoAlmacen' => $movimientoAlmacen
					);	
			

			
		}

        }


		return $data;
	}

public function stockAlmacen($obj)
	{
		
		if (isset($obj->desde) && isset($obj->hasta)) {
			$desde 			= $obj->desde;
			$hasta 			= $obj->hasta;		
		}else{
			$desde 			= FECHA;
			$hasta 			= FECHA;	
		}


		$where 	= "";
        

		if($desde!=""){
            $where ="DATE(fecha_registro)>='".$desde."'";
        }
        if($hasta!=""){
            if($where!=""){$where=$where." AND ";}
            $where = $where ."DATE(fecha_registro)<='".$hasta."'";
        }
        

        if($where!=""){$where=" and ".$where;}

		$sql =  "SELECT 
				cod_insumo,insumo_id,insumo,unidad_medida_id, unidad_medida,SUM(calculo) AS total, 
				fecha_registro,SUM(precio_compra) AS precio_compra,SUM(precio_venta) AS precio_venta
					FROM (
					SELECT i.cod_insumo,ii.insumo_id, i.nom_insumo AS insumo,ii.unidad_medida_id, u.nombre AS unidad_medida,SUM(cantidad) AS total, 
							movimiento_almacen_id ,fecha_registro,
							CASE movimiento_almacen_id WHEN '1' THEN precio_compra ELSE '0.00' END precio_compra,
							CASE movimiento_almacen_id WHEN '1' THEN precio_venta ELSE '0.00' END precio_venta,
							CASE movimiento_almacen_id WHEN '1' THEN 'entradas' ELSE 'salidas' END movimiento,
							CASE movimiento_almacen_id WHEN '1' THEN SUM(cantidad)  ELSE CONCAT('-',SUM(cantidad)) END calculo
							FROM stock_almacen AS ii
							INNER JOIN insumo AS i ON(i.id_insumo = ii.insumo_id)
							INNER JOIN unidad_medida AS u ON (u.id = ii.unidad_medida_id)
							WHERE movimiento_almacen_id = ii.movimiento_almacen_id
							$where
							GROUP BY insumo_id, ii.movimiento_almacen_id				
							ORDER BY ii.insumo_id,fecha_registro DESC) AS DD
							
				GROUP BY insumo_id";
			$query =  new Consulta($sql);
			$data = array();
			while ($row =  $query->VerRegistro()) {
					$data[] = array(
						
						'insumo_id' 		=> $row['insumo_id'],
						'cod_insumo' 		=> $row['cod_insumo'],
						'insumo' 			=> $row['insumo'],
						'unidad_medida' 	=> $row['unidad_medida'],
						'unidad_medida_id' 	=> $row['unidad_medida_id'],
						'total' 			=> $row['total'],
						'fecha_registro' 	=> $row['fecha_registro'],
						'precio_compra' 	=> $row['precio_compra'],
						'precio_venta' 		=> $row['precio_venta'],
					);									
			}

			return $data;

	}	

public function reingresoAlmacenInsumosSobrantes($insumos,$fecha_registro)
	{
		$fecha = $fecha_registro;
		//sumar 1 dia
		$nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha_registro ) ) ;
		$nuevafecha = date ( 'Y-m-d' , $nuevafecha );


		$sql_cabecera =  "INSERT INTO stock_almacen(insumo_id,unidad_medida_id,movimiento_almacen_id, cantidad, precio_compra,precio_venta,flag_auxiliar,fecha_registro) VALUES ";
		$sql_detalle = '';
		for ($m=0; $m < count($insumos); $m++) { 
			$sql_detalle .= "(
						".$insumos[$m]['insumo_id'].",
						".$insumos[$m]['unidad_medida_id'].",
						1,
						".$insumos[$m]['total'].",
						".$insumos[$m]['precio_compra'].",
						".$insumos[$m]['precio_venta'].",
						3,
						'".$nuevafecha."'

			),";

		}


		$sql 	= eliminaUltimoCaracrter($sql_cabecera.$sql_detalle);
		$query 	= new Consulta($sql);
	}	


public function ingresoInsumoID($id)
	{
		$sql = "SELECT ii.id, ii.insumo_id,cantidad,ii.unidad_medida_id, precio_compra, 
		precio_venta, fecha_registro,i.nom_insumo AS insumo ,i.cod_insumo, 
		u.nombre AS unidad_medida FROM stock_almacen AS ii
		INNER JOIN insumo AS i ON(i.id_insumo = ii.insumo_id)
		INNER JOIN unidad_medida AS u ON (u.id = ii.unidad_medida_id)
		WHERE ii.id = '".$id."'";
		$query =  new Consulta($sql);
		$data = '';
		//pre($sql);
		while ($row =  $query->VerRegistro()) {
			$data = array(
				'id' 				=> $row['id'],
				'id_insumo' 		=> $row['insumo_id'],
				'cantidad' 			=> $row['cantidad'],
				'unidad_medida_id' 	=> $row['unidad_medida_id'],
				'precio_compra' 	=> $row['precio_compra'],
				'precio_venta' 		=> $row['precio_venta'],
				'fecha_registro' 	=> $row['fecha_registro'],
				'insumo' 			=> $row['insumo'],
				'cod_insumo' 		=> $row['cod_insumo'],
				'unidad_medida' 	=> $row['unidad_medida']
			);
		}

		return $data;
	}
	


	public function insumoID($id)
	{
		$sql = "SELECT id_insumo, nom_insumo, des_insumo,cod_insumo, fec_registro FROM insumo
			WHERE id_insumo = '".$id."'
			";
		$query =  new Consulta($sql);
		$data = '';
		while ($row =  $query->VerRegistro()) {
			$data = array(
				'id' 				=> $row['id_insumo'],
				'nombre' 			=> $row['nom_insumo'],
				'descripcion' 		=> $row['des_insumo'],
				'des_producto' 		=> $row['des_insumo'],
				'cod_insumo' 		=> $row['cod_insumo'],
				'fec_registro' 		=> $row['fec_registro'],
			);
		}

		return $data;
	}


}

?>