<?php  

class ModeloPacientes{

	public function __construct(){

	}

	


	public function listPacientes()
	{
		
		$sql = "SELECT * FROM pacientes ORDER BY  registro, id_usuario DESC";
		$query = new Consulta($sql);

		?> 
		<a href="pacientes-excel.php" class="btn btn-info" id="descargar-excel">DESCARGAR EXCEL</a>
		<div class="table-responsive">
			<table class="table table-striped jambo_table bulk_action">
				<thead>
				  <tr class="headings">
				    <th class="column-title">Nombre Completo</th>
				    <th class="column-title">Email</th>
				    <th class="column-title">Registro</th>
				    <th class="column-title no-link last"><span class="nobr">Opciones</span>
				    </th>
				  </tr>
				</thead>
				<tbody>
				<?php  

				while($row = $query->VerRegistro()){
					?>
					<tr class="even pointer">
			            <td class=" "><i class="glyphicon glyphicon-file"></i>&nbsp; <?php echo $row['nombre']. ' '.$row['apellido'] ?></td>
				        <td class=" "><?php echo $row['correo'] ?></td>
				        <td class=" "><?php echo $row['registro'] ?></td>
				        <td class=" last">
				        	<a href="?action=perfil&id=<?php echo $row['id_usuario']; ?>" class="btn btn-info">Datos del Paciente</a>
				        	<a href="?action=tomas&id=<?php echo $row['id_usuario']; ?>" class="btn btn-warning"><i class="glyphicon glyphicon-new-window"></i> Ver Detalle</a>

				        	<a href="?action=eliminar&id=<?php echo $row['id_usuario']; ?>" class="btn btn-danger"><i class="glyphicon glyphicon-close"></i> Eliminar</a>
				        </td>
				    </tr>
				<?php
				}

				?>
				</tbody>
			</table>
		</div>
		<?php					
	}

	public function eliminarPacientes()
	{
		$sql = "DELETE from pacientes WHERE id_usuario='".$_GET['id']."'";
		$query = new Consulta($sql);

		//$this->_msgbox->setMsgbox('Paciente eliminado correctamente',2);
		location("index.php");
	}

	public function newPacientes()
	{
		$obj_idiomas = new ModeloIdiomas();
		$idiomas	 = $obj_idiomas->getIdiomas();
		?>
        	<legend>Nueva noticia</legend>
        	<form action="?action=add" method="post" name="noticias" enctype="multipart/form-data" class="form-horizontal form-label-left">
                <input type="hidden" name="tipo_cambio" id="tipo_cambio" value="<?php //echo TIPO_CAMBIO ?>" />
            	<?php
				for($i = 0; $i < count($idiomas); $i++){
                    if($i==0){
                        $bandera="images/en.png";
                    }
                    if($i==1){
                        $bandera="images/es.png";
                    }
                    ?> 
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12"><img src="<?php echo $bandera;?>">&nbsp;Titulo: </label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" name="titulo[]" value="" class="form-control col-md-7 col-xs-12" size="59" maxlength="50">
						</div>

					</div>

				<?php  
				}

				for($i = 0; $i < count($idiomas); $i++){
                    if($i==0){
                        $bandera="images/en.png";
                    }
                    if($i==1){
                        $bandera="images/es.png";
                    }
                    ?> 
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12"><img src="<?php echo $bandera;?>">&nbsp;Descripción: </label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<textarea id="" cols="20" rows="10" name="descripcion[]" class="form-control col-md-7 col-xs-12"></textarea>
						</div>

					</div>
					
				<?php  
				}
				?>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Imagen: </label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="file" class="foto" name="foto" id="foto">
					</div>

				</div>

				<div class="ln_solid"></div>
	  				<div class="form-group">
	  					<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
	  						<input type="reset" name="cancelar" value="CANCELAR" class="btn btn-danger" onclick="history.back()">  
							<input type="button" name="" value="GUARDAR" onclick="return valida_noticias('add','')" class="btn btn-success"><br clear="all">
	  					</div>
	  				</div>
        	</form>
		<?php
	}
	public function pacienteId($id)
	{
		$sql =  "SELECT * FROM pacientes WHERE id_usuario = '".$id."'";
		$query =  new Consulta($sql);
		$data =  $query->VerRegistro();
		return $data;
	}

	public function perfilPacientes() 
	{

		$obj = $this->pacienteId($_GET['id']);
		//pre($obj);

		?>
        	<legend>Perfil del Paciente</legend>
        	<form action="?action=add" method="post" name="noticias" enctype="multipart/form-data" class="form-horizontal form-label-left">
                <input type="hidden" name="tipo_cambio" id="tipo_cambio" value="<?php //echo TIPO_CAMBIO ?>" />
            	 
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12"><img src="<?php echo $bandera;?>">&nbsp;Nombre: </label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" name="nombre" readonly="" value="<?php echo $obj['nombre']; ?>" class="form-control col-md-7 col-xs-12" size="59" maxlength="50">
						</div>

					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12"><img src="<?php echo $bandera;?>">&nbsp;Apellido: </label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" name="nombre" readonly="" value="<?php echo $obj['apellido']; ?>" class="form-control col-md-7 col-xs-12" size="59" maxlength="50">
						</div>

					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12"><img src="<?php echo $bandera;?>">&nbsp;Correo: </label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" name="nombre" readonly="" value="<?php echo $obj['correo']; ?>" class="form-control col-md-7 col-xs-12" size="59" maxlength="50">
						</div>

					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12"><img src="<?php echo $bandera;?>">&nbsp;Fecha Nacimiento: </label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" name="nombre" readonly="" value="<?php echo $obj['fecha_nacimiento']; ?>" class="form-control col-md-7 col-xs-12" size="59" maxlength="50">
						</div>

					</div>

					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12"><img src="<?php echo $bandera;?>">&nbsp;Sexo: </label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" name="nombre" readonly="" value="<?php echo $obj['sexo']; ?>" class="form-control col-md-7 col-xs-12" size="59" maxlength="50">
						</div>

					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12"><img src="<?php echo $bandera;?>">&nbsp;Tipo  de Diabetes: </label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" name="nombre" readonly="" value="<?php echo $obj['tipo_diabetes']; ?>" class="form-control col-md-7 col-xs-12" size="59" maxlength="50">
						</div>

					</div>
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12"><img src="<?php echo $bandera;?>">&nbsp;Tipo Fototipo: </label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<input type="text" name="nombre" readonly="" value="<?php echo $obj['tipo_fototipo']; ?>" class="form-control col-md-7 col-xs-12" size="59" maxlength="50">
						</div>

					</div>
					<div class="form-group">
						<div class="col-md-3 col-sm-3 col-xs-12"></div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<a href="pacientes.php" class="btn btn-success">REGRESAR</a>
						</div>
					</div>
				
				
        	</form>
		<?php
	}

	public function addPacientes()
	{
		$data =  new stdClass();

		if (isset($_POST['titulo']) && count($_POST['titulo']) > 0 ) {
			
			$nombre 	= '';
			$destino 	= _ruta_imagenes_saweto_;
        	$update 	= ", '" . $nombre . "' ";
		

	        if (isset($_FILES['foto']['name']) && $_FILES['foto']['name'] != "") {
	        	$nombre_archivo = $_FILES['foto']['name'];

				$nombre_file = time().trim($nombre_archivo);
				$nombre = $nombre_file;	
				
	            $temp = $_FILES['foto']['tmp_name'];
	            move_uploaded_file($temp, $destino.'noticias/'.$nombre); 
	        }
			$query = new Consulta("INSERT INTO  noticias (fecha, orden) VALUES('".TIEMPO."'
			,'".$this->orderPacientes()."'
			)");


			$id = $query->NuevoId();
			$obj_idiomas = new ModeloIdiomas();
			$idiomas	 = $obj_idiomas->getIdiomas();
			for($i = 0; $i < count($idiomas); $i++)
			{
				$query = new Consulta("INSERT INTO  noticias_idiomas (id_usuario, id_idioma, titulo, url, descripcion,imagen)
											VALUES (
												'".$id."',
												'".$idiomas[$i]['id']."',
												'".addslashes($_POST['titulo'][$i])."',
												'".url_amigable($_POST['titulo'][1], 1)."',
												'".addslashes($_POST['descripcion'][$i])."',
												'".$nombre."'
												)");
			}
			$this->_msgbox->setMsgbox('Noticia grabada correctamente',2);
			location("noticias.php");

		}
	}
	
	public function orderPacientes()
	{
		$query = new Consulta("SELECT MAX(orden) max_orden
									FROM noticias");

		$row   = $query->VerRegistro();
		return (int)($row['max_orden']+1);
	}

	public function deletePacientes()
	{
		$sql =  "DELETE FROM noticias where id_usuario = '".$_GET['id']."'";
		$uqery =  new Consulta($sql);
		$this->_msgbox->setMsgbox('Se elimino correctamente.',2);
		location("noticias.php");

	}
	public function updatePacientes()
	{
		$nombre 	= '';
		$destino 	= _ruta_imagenes_saweto_;
		$update 	= '';
	
        if (isset($_FILES['foto']['name']) && $_FILES['foto']['name'] != "") {
        	$nombre_archivo = $_FILES['foto']['name'];

			$nombre_file = time().trim($nombre_archivo);
			$nombre = $nombre_file;	
			
            $temp = $_FILES['foto']['tmp_name'];
            move_uploaded_file($temp, $destino.'noticias/'.$nombre); 
        	$update 	= ",imagen='" . $nombre . "' ";
        }

        $obj_idiomas = new ModeloIdiomas();
		$idiomas	 = $obj_idiomas->getIdiomas();
		for($i = 0; $i < count($idiomas); $i++)
		{
			$query = new Consulta("UPDATE  noticias_idiomas
										SET titulo	    =  '".addslashes($_POST['titulo'][$i])."',
											url        =  '".url_amigable($_POST['titulo'][1], 1)."',
											descripcion  =  '".addslashes($_POST['descripcion'][$i])."'
											$update
										WHERE id_idioma = '".$idiomas[$i]['id']."'
										AND id_usuario = '".$_GET['id']."'");
		}


		$this->_msgbox->setMsgbox('Se actualizo correctamente.',2);
		location("noticias.php");
	}

	public function estadisticasPacientes()
	{
// ini_set('display_errors', true );
// ini_set('track_errors', 'on');
		//$data 		=  $this->getPaciente($_GET['id']);
		$desde 	= '';
		$hasta 	= '';
		if (isset($_GET['desde']) && !empty($_GET['desde'])) {
			$desde =  $_GET['desde'];
			//pre($desde);
			$dato = explode('-', $desde);
			//pre($dato);
			$desde 	= revertir_mesdiaanio($dato[0]);
			$hasta 	= revertir_mesdiaanio($dato[1]);

		}
		$data 		=  $this->camposGlucemia($_GET['id'],$desde, $hasta);
		//$columns 	=  $this->camposGlucemiaFecha($_GET['id'],$desde, $hasta);
		$columns 	=  $this->camposGlucemiaFechaEstadisticas($_GET['id'],$desde, $hasta);
		$retorno 	= $this->agruparxFecha($columns);

		$obj        = new HTMLAJAX();
				?>
		<legend>Paciente Tomas 
        		<span class="pull-right">
        			<a href="?action=tomas&id=<?= $_GET['id'];?>" class="btn btn-bordered btn-sm btn-info">Listar</a>
        			<a href="?action=estadisticas&id=<?= $_GET['id'];?>" class="btn btn-bordered btn-sm btn-warning">Ver Estadísticas</a>
        			<a class="btn btn-bordered btn-sm btn-success" href="pacientes-excel.php?id=<?= $_GET['id'];?>">Descargar Excel</a>
        		</span>
        	</legend>

			<div class="table-responsive">

			<?php $obj->estadisticas($retorno, $data, $_GET['id'], $_GET['desde']); ?>
		</div>
		<?php
	}

	public function agruparxFecha($data)
	{
		$nuevoArreglo = array();
		for ($i=0; $i < count($data); $i++) { 
			$registro = $data[$i];
			$nuevoArreglo[$registro['fecha']][$data[$i]['hora']] = $data[$i]['glucosa'];
		}
		return $nuevoArreglo;
	}

	public function datosPaciente($id)
	{
		$sql =  "SELECT nombre, correo, apellido FROM pacientes where id_usuario = '".$id."'";
		$query =  new Consulta($sql);
		$data = $query->VerRegistro();
		return $data;
	}


	public function tomasPacientes()
	{
		$data 		=  $this->getPaciente($_GET['id']);
		$columns 	=  $this->campos($_GET['id']);
		$datoP 		= $this->datosPaciente($_GET['id']);
		$obj        = new HTMLAJAX();

		$paciente 	= $datoP['nombre']. ' '. $datoP['apellido'];
		//pre($datoP);	
		?>
        	<legend>Paciente:  <?= $paciente; ?>
        		<span class="pull-right">
        			<a href="?action=tomas&id=<?= $_GET['id'];?>" class="btn btn-bordered btn-sm btn-info">Listar</a>
        			<a href="?action=estadisticas&id=<?= $_GET['id'];?>" class="btn btn-bordered btn-sm btn-warning">Ver Estadísticas</a>
        			<a class="btn btn-bordered btn-sm btn-success" href="pacientes-excel.php?id=<?= $_GET['id'];?>">Descargar Excel</a>
        		</span>
        	</legend>

			<div class="table-responsive">
			<button class="btn btn-info" id="mostrar-tabla">Mostrar todo</button><br>
			<?php $obj->tabla($columns, $data); ?>
		</div>
		<?php
	}

	

	public function campos($id)
	{
		//$sql =  "SELECT * FROM toma_decimal where id_usuario = $id ORDER BY registro DESC";
		$sql =  "SELECT concat(nombre,' ',apellido) as paciente,TM.*
				FROM toma_decimal AS TM
				INNER JOIN pacientes as P ON (P.id_usuario = TM.id_usuario)
				where TM.id_usuario = '".$id."'  ORDER BY TM.registro DESC";
		
		$query =  new Consulta($sql);
		$data = array();
		$i = 1;
		while($row = $query->nombrecampo($i)){
			$data[] = $row;		
			$i++;
		}	

			return $data;
	}	

	public function camposGlucemia($id,$desde, $hasta)
	{	
		$and = '';
		if (!empty($desde) && !empty($hasta)) {
			$and = " AND date(registro) between '".$desde."' and '".$hasta."'";
		}
		$sql =  "SELECT glucosa FROM toma_decimal where id_usuario = '".$id."' $and ORDER BY registro DESC";
		
		$query =  new Consulta($sql);
		$data = array();
		$i = 1;
		while($row = $query->VerRegistro($i)){

			$data[] = array(
				'glucosa' => $row['glucosa']
				);		
			$i++;
		}	

			return $data;
	}

	public function camposGlucemiaFecha($id, $desde, $hasta)
	{
		$and = '';
		if (!empty($desde) && !empty($hasta)) {
			$and = " AND date(registro) between '".$desde."' and '".$hasta."'";
		}
		$sql =  "SELECT registro FROM toma_decimal where id_usuario = '".$id."' $and ORDER BY registro DESC";
		
		$query =  new Consulta($sql);
		$data = array();
		$i = 1;
		while($row = $query->VerRegistro($i)){

			$data[] = array(
				'registro' => $row['registro']
				);		
			$i++;
		}	

			return $data;
	}
	public function camposGlucemiaFechaEstadisticas($id, $desde, $hasta)
	{
		$and = '';
		if (!empty($desde) && !empty($hasta)) {
			//$and = " AND date(registro) between '".$desde."' and '".$hasta."'";
			$and = " AND date(registro) between  CAST('".$desde."' AS DATE) AND CAST('".$hasta."' AS DATE) ";
		}
		// //$sql =  "SELECT registro FROM toma_decimal where id_usuario = '".$id."' $and ORDER BY registro DESC";
		$sql =  "SELECT date(registro)as fecha, DATE_FORMAT(registro, '%H:%I' ) as hora, glucosa FROM toma_decimal where id_usuario = '".$id."' $and ORDER BY registro ASC";
		$query =  new Consulta($sql);
		$data = array();
		$i = 1;
		while($row = $query->VerRegistro($i)){

			$data[] = array(
				'fecha' 	=> formato_slash('-',$row['fecha']),
				'hora' 		=> $row['hora'],
				'glucosa' 	=> $row['glucosa']
				);		
			$i++;
		}	
		return $data;
	}
	public function getPaciente($id= null)
	{	
		$where = '';
		if (!empty($id)) {
			$where = " where TM.id_usuario = '".$id."'";
		}
		$sql =  "SELECT concat(nombre,' ',apellido) as paciente,TM.*
				FROM toma_decimal AS TM
				INNER JOIN pacientes as P ON (P.id_usuario = TM.id_usuario)
				$where  ORDER BY TM.registro DESC";
		
		$query =  new Consulta($sql);
		$data = array();
		while($row = $query->VerRegistro()){
			$data[] = $row;		
		}	

			return $data;			
	}
}
?>		