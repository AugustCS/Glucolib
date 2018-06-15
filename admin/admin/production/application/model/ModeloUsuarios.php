<?php 

require_once _model_.'ModeloUsuario.php';

class ModeloUsuarios{
	
	private $_msgbox;
	
	public function __construct($msg=''){//	CONSTRUCTOR DE LA CLASE USUARIOS
		$this->_msgbox = $msg;
	}
		
	public function newUsuarios($idioma){//	FORMULARIO DE INGRESO DE NUEVO USUARIO AL SISTEMA
	    $roles =  new ModeloRoles();
		$rols = $roles->getRoles();
	?>	
			<legend> Nuevo Registro</legend>			
				<form name='usuarios' method='post' action='' enctype="multipart/form-data"  class="form-horizontal form-label-left"> 
 				
	  				<div class="form-group">
	  					<label class="control-label col-md-3 col-sm-3 col-xs-12" > Rol: </label>
	  					<div class="col-md-6 col-sm-6 col-xs-12">
	  					<select name='id_rol' id='id_rol' class='form-control col-md-7 col-xs-12'> 
								<option value=' '> Seleccione rol</option> 
								<?php foreach($rols as $key):?>
				                <option value='<?php echo $key['id'] ?>'><?php echo $key['nombre'] ?></option> 
				                <?php endforeach ?>
							</select>
	  					</div>

	  				</div>

	  				<div class="form-group">
	  					<label class="control-label col-md-3 col-sm-3 col-xs-12" > Nombre Usuario: </label>
	  					<div class="col-md-6 col-sm-6 col-xs-12">
	  						<input type='text' name='nombre_usuario' value='' class='form-control col-md-7 col-xs-12' size='59'  maxlength=50 >
	  					</div>

	  				</div>
	  				<div class="form-group">
	  					<label class="control-label col-md-3 col-sm-3 col-xs-12" > Apellidos Usuario: </label>
	  					<div class="col-md-6 col-sm-6 col-xs-12">
	  						<input type='text' name='apellidos_usuario' value='' class='form-control col-md-7 col-xs-12' size='59'  maxlength=50 >
	  					</div>

	  				</div>
	  				<div class="form-group">
	  					<label class="control-label col-md-3 col-sm-3 col-xs-12" > Email Usuario: </label>
	  					<div class="col-md-6 col-sm-6 col-xs-12">
	  						<input type='text' name='email_usuario' value='' class='form-control col-md-7 col-xs-12' size='59'  maxlength=50 >
	  					</div>
	  				</div>
	  				<div class="form-group">
	  					<label class="control-label col-md-3 col-sm-3 col-xs-12" > Login Usuario: </label>
	  					<div class="col-md-6 col-sm-6 col-xs-12">
	  						<input type='text' name='login_usuario' value='' class='form-control col-md-7 col-xs-12' size='59'  maxlength=20 >
	  					</div>
	  				</div>
	  				<div class="form-group">
	  					<label class="control-label col-md-3 col-sm-3 col-xs-12" > Password Usuario: </label>
	  					<div class="col-md-6 col-sm-6 col-xs-12">
	  						<input type='text' name='password_usuario' value='' class='form-control col-md-7 col-xs-12' size='59'  maxlength=20 >
	  					</div>
	  				</div>
	  				<<!-- div class="form-group">
	  					<label class="control-label col-md-3 col-sm-3 col-xs-12" > Foto Usuario: </label>
	  					<div class="col-md-6 col-sm-6 col-xs-12">
	  						<input type='file' name='foto_usuario' value=''  class='form-control col-md-7 col-xs-12'>
	  					</div>
	  				</div> -->
	  				<div class="ln_solid"></div>
	  				<div class="form-group">
	  					<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
	  					<input type="hidden" name="foto_usuario" value="">
	  						<input type='reset' name='cancelar' value='CANCELAR' class='btn btn-danger' >  
							<input type='button' name='actualizar' value='GUARDAR' onclick='return valida_usuarios("add","")' class='btn btn-success'><br clear='all' />
	  					</div>
	  				</div>
					
				</form> 
		<?php
	}
	
	public function addUsuarios(){//	INSERCION DE DATOS DE UN NUEVO USUARIO
		if(isset($_FILES['foto_usuario']) && ($_FILES['foto_usuario']['name'] != "")){
			
			$obj  = new Upload();
			$destino = "../aplication/webroot/imgs/catalogo/";
			
			$name = time().$_FILES['foto_usuario']['name'];
			$temp = $_FILES['foto_usuario']['tmp_name'];
			$type = $_FILES['foto_usuario']['type'];
			$size = $_FILES['foto_usuario']['size'];
			
			$obj->upload_imagen($name, $temp, $destino, $type, $size);
		}
		$sql = "INSERT INTO usuarios(`id_rol`,`nombre_usuario`,`apellidos_usuario`,`email_usuario`,`foto_usuario`,`login_usuario`,`password_usuario`,`fecha_ingreso_usuario`) VALUES('".$_POST['id_rol']."',
	 								'".$_POST['nombre_usuario']."',
									'".$_POST['apellidos_usuario']."',
									'".$_POST['email_usuario']."',
									'".$name."', 
									'".$_POST['login_usuario']."', 
									'".$_POST['password_usuario']."', 
									'".date("Y-m-d")."')";
									
		$query = new Consulta($sql);
		$this->_msgbox->setMsgbox('Se grabo correctamente.',2);
		location("usuarios.php");
	}
		
	public function editUsuarios($idioma){//	FORMULARIO DE EDICION DE DATOS DEL USUARIO
		$usuario = new ModeloUsuario($_GET['id']);
		$roles =  new ModeloRoles();
		$rols = $roles->getRoles();
		?>
		
			<form name='usuarios' method='post' action='' enctype="multipart/form-data" class="form-horizontal form-label-left"> 
 
				
  				<div class="form-group">
  					<label class="control-label col-md-3 col-sm-3 col-xs-12">  Rol: </label>
  					<div class="col-md-6 col-sm-6 col-xs-12">
	  					<select name='id_rol' id='id_rol' class='form-control col-md-7 col-xs-12'> 
							<option value=' '> Seleccione rol</option> 
							<?php foreach($rols as $key):?>
			                <option value='<?php echo $key['id'] ?>' <?php if($key['nombre']==$usuario->getRol()){echo "selected";} ?>><?php echo $key['nombre'] ?></option> 
			                <?php endforeach ?>
					</select>
  						
  					</div>
  				</div>
  				<div class="form-group">
  					<label class="control-label col-md-3 col-sm-3 col-xs-12"> Nombre Usuario: </label>
  					<div class="col-md-6 col-sm-6 col-xs-12">
  						<input type='text' name='nombre_usuario' value='<?php echo $usuario->getNombre(); ?>' class='form-control col-md-7 col-xs-12' size='59'  maxlength=50 >
  					</div>
  				</div>
  				<div class="form-group">
  					<label class="control-label col-md-3 col-sm-3 col-xs-12"> Apellidos Usuario: </label>
  					<div class="col-md-6 col-sm-6 col-xs-12">
  						<input type='text' name='apellidos_usuario' value='<?php echo $usuario->getApellidos(); ?>' class='form-control col-md-7 col-xs-12' size='59'  maxlength=50 >
  					</div>
  				</div>
  				<div class="form-group">
  					<label class="control-label col-md-3 col-sm-3 col-xs-12"> Email Usuario: </label>
  					<div class="col-md-6 col-sm-6 col-xs-12">
  						<input type='text' name='email_usuario' value='<?php echo $usuario->getEmail(); ?>' class='form-control col-md-7 col-xs-12' size='59'  maxlength=50 >
  					</div>
  				</div>
  				<div class="form-group">
  					<label class="control-label col-md-3 col-sm-3 col-xs-12"> Login Usuario: </label>
  					<div class="col-md-6 col-sm-6 col-xs-12">
  						<input type='text' name='login_usuario' value='<?php echo $usuario->getLogin(); ?>' class='form-control col-md-7 col-xs-12' size='59'  maxlength=20 >
  					</div>
  				</div>
  				<div class="form-group">
  					<label class="control-label col-md-3 col-sm-3 col-xs-12"> Password Usuario: </label>
  					<div class="col-md-6 col-sm-6 col-xs-12">
  						<input type='password' name='password_usuario' value='' class='form-control col-md-7 col-xs-12' size='59'  maxlength=20 >
  					</div>
  				</div>
  				<!-- <div class="form-group">
  					<label class="control-label col-md-3 col-sm-3 col-xs-12"> Foto Usuario: </label>
  					<div class="col-md-6 col-sm-6 col-xs-12">
  						<input type='file' name='foto_usuario' value=''  class='form-control col-md-7 col-xs-12'>
  					</div>
  				</div> -->
  				<!-- <div class="form-group">
  					<div align="center" style="width:500px;"><img src="../aplication/webroot/imgs/catalogo/<?php echo $usuario->getFoto(); ?>" width="90" /></div>
  				</div> -->

  				<div class="ln_solid"></div>
	  				<div class="form-group">
	  					<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
	  						<input type="hidden" name="foto_usuario" value="">
	  						<input type='reset' name='cancelar' value='CANCELAR' class='btn btn-danger' onclick="return history.back()">  
							<input type='button' name='actualizar' value='ACTUALIZAR' onclick='return valida_usuarios("update", "<?php echo $usuario->getId() ?>")' class='btn btn-success'><br clear='all' />
	  					</div>

	  					
	  				</div>
					
                    
				</form> 
            <?php 
	}
	
	public function updateUsuarios($id, ModeloUsuario $usuario){//	ACTUALIZACION DE LA INFORMACION DE LOS USUARIOS
		if($_POST['nombre_usuario']){
			
			if(isset($_FILES['foto_usuario']) && ($_FILES['foto_usuario']['name'] != "")){
			
				$obj  = new Upload();
				$destino = "../aplication/webroot/imgs/catalogo/";
				
				$name = time().$_FILES['foto_usuario']['name'];
				$temp = $_FILES['foto_usuario']['tmp_name'];
				$type = $_FILES['foto_usuario']['type'];
				$size = $_FILES['foto_usuario']['size'];
				
				$upload = ", foto_usuario = '".$name."'";
				
				$obj->upload_imagen($name, $temp, $destino, $type, $size);
			}
			if(isset($_POST['password_usuario']) && $_POST['password_usuario']!='')
				$pass = ", password_usuario='".$_POST['password_usuario']."' ";
			
			$sql = "UPDATE usuarios SET 
						id_rol		='".$_POST['id_rol']."',
						nombre_usuario='".$_POST['nombre_usuario']."',
						apellidos_usuario='".$_POST['apellidos_usuario']."',
						email_usuario='".$_POST['email_usuario']."',
						login_usuario='".$_POST['login_usuario']."'
						".$pass."
						".$upload."
				WHERE id_usuario = '".$_GET['id']."' ";
			$query= new Consulta($sql);
		}else{
			$this->UpdatePassword($id, $usuario);
		}
		
		$this->_msgbox->setMsgbox('Usuarios actualizado.',2);
		location("usuarios.php");	 	
	}

	public function editPassword($id, ModeloUsuario $usuario){
		 	
		if($usuario->getId() == $id){
			$sql = "SELECT id_usuario, email_usuario, password_usuario FROM usuarios WHERE id_usuario='".$id."' ";	 
			$query = new Consulta($sql);
			Form::getForm($query,"edit","usuarios.php");
		}else{
			echo "<div id=error> Usted no puede cambiar el password de otros usuarios </div>";				
		}		
	}
	public function UpdatePassword($id, ModeloUsuario $usuario){
		$sql = "UPDATE usuarios SET email_usuario='".$_POST['email_usuario']."', password_usuario='".$_POST['password_usuario']."' WHERE id_usuario='".$id."'";
		$query= new Consulta($sql);
	}
	
	public function deleteUsuarios(){//	ELIMINA::Eliminar el usuario seleccionado
		$sql = "DELETE FROM usuarios WHERE id_usuario='".$_GET['id']."'";	
		$query = new Consulta($sql);
		$this->_msgbox->setMsgbox('Se elimino correctamente.',2);
		location("usuarios.php");
	}
	
	public function listUsuarios(){	//	LISTAR LOS USUARIOS DEL SISTEMA	
		$sql = " SELECT id_usuario, nombre_usuario, apellidos_usuario, email_usuario, login_usuario, nombre_rol FROM usuarios INNER JOIN roles USING(id_rol)";	
		$query = new Consulta($sql);
		?>
        <div id="info_user" title="Datos del Usuario"><!--	Campo para mostrar los datos del Usuario -->
        </div>	 	 		
		<table class="table table-striped jambo_table">
			<thead>
	        	<tr class="headings">
	            	<th class="column-title">Nombre</th>
	                <th class="column-title">Apellidos</th>
	                <th class="column-title">Email</th>
	                <th class="column-title">Rol</th>
	                <th class="column-title">Opciones</th>
	            </tr>
				
			</thead>
            <?php
			$w = 1;
			while($row = $query->VerRegistro())
			{
			$class = ($w%2 == 0) ? "odl": "";
			?>
			<tr class="<?php echo $class ?>">
				<td><?php echo $row['nombre_usuario'] ?></td>
				<td><?php echo $row['apellidos_usuario'] ?></td>
				<td><?php echo $row['email_usuario'] ?></td>
                <td><?php echo $row['nombre_rol']; ?></td>
				<td>
					<a class="" title="Editar" onclick="mantenimiento('usuarios.php',<?php echo $row['id_usuario'] ?>,'edit')" href="#">
					<i class="fa fa-pencil"></i></a> &nbsp;

					<a class="" title="Eliminar" onclick="mantenimiento('usuarios.php',<?php echo $row['id_usuario'] ?>,'delete')" href="#">
					<i class="fa fa-close"></i></a>&nbsp; 
					<a class="" title="Detalle" href="accesos.php?action=list&id1=<?php echo $row['id_usuario'] ?>">
					<i class="fa fa-tasks"></i></a>
					<a title="Vista Previa" data-toggle="modal" data-target="#myModal" href="javascript:;" onclick="view_user('<?php echo $row['id_usuario']?>')">
					<i class="fa fa-eye"></i></a></td>
			</tr>
			<?php
			$w++;
			}
			?>
        </table>
		<?php		
	}
	
	function AccesosAddUsuarios($id){//	FUNCION DE ACCESOS A LOS USUARIOS
		
		$DelQuery=new Consulta( "DELETE FROM usuarios_secciones WHERE id_usuario=".$id."");		
		for($j=0; $j<sizeof($_POST['seccion']);$j++){
			if($_POST['seccion'][$j]){
				$Query= new Consulta($sql = "INSERT INTO usuarios_secciones VALUES('".$id."' ,'".$_POST['seccion'][$j]."') "		);
			}		
		}		
			
		$this->_msgbox->setMsgbox('Se guardaron los cambios correctamente.',2);
		location("accesos.php?id1=".$id);	
	}
	
	public function getUsuarios(){//	DATOS DE LOS USUARIOS
		$data;
		$sql = "SELECT * FROM usuarios ORDER BY nombre_usuario DESC ";
		$query = new Consulta($sql);
		while($row = $query->VerRegistro()){
			$data[] = array(
				'id'			=> $row['id_usuario'],
				'rol'			=> $row['id_rol'],
				'usuario'   	=> $row['nombre_usuario'].' '.$row['apellidos_usuario'],
				'email'			=> $row['email_usuario'],
				'foto'			=> $row['foto_usuario'],
				'login'			=> $row['login_usuario'],
				'fecha_ingreso'	=> $row['fecha_ingreso_usuario']
			);
		}
		return $data; 	
	}

	function AccesoslistUsuarios($id){//	ACCESO A LOS USUARIOS A LAS SECCIONES DEL SISTEMA 
		if(!$id){
			echo "<br /><div id=error>ERROR: no se encontro ningun usuario con ese Id ó le falta Id  </div>";	
		}else{
			$sql = "SELECT s.id_seccion, m.nombre_modulo as MODULO, s.nombre_seccion as PAGINAS, s.url_seccion as URL 
					FROM  secciones s, modulos m 
					WHERE s.id_modulo = m.id_modulo";
			$Query= new Consulta($sql);	?>
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_title">
						<h2><a href="usuarios.php">Usuarios</a><i class="glyphicon glyphicon-chevron-right"></i>Accesos</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<div id="content-area">
				<form name="f1" action="" method="post">		
					
				<table class="table table-striped jambo_table">
					<thead class="headings">
						<tr> <?php			
						for($i = 1; $i < $Query->NumeroCampos(); $i++){ ?>
							<th class="column-title"> <?php echo $Query->nombrecampo($i)?> </th><?php
						}	?>
						<th class="column-title">Activar</th>
						</tr>
						
					</thead>

					<?php
					$x=0;
					while($row = $Query->VerRegistro()){ ?>
						<tr <?php if($x==0){ ?>class="" <?php }else{ ?> class=" odl" <?php }?> > <?php
						for ($i = 1; $i < $Query->NumeroCampos(); $i++){?>
							<td align=left class=""><?php echo $row[$i]?></td><?php
						}
						$Query_SA  =  new Consulta("SELECT * FROM usuarios_secciones WHERE id_usuario=".$id." AND id_seccion=".$row[0]."");

						$NUM= $Query_SA->NumeroRegistros(); ?>
							<td align="center">
							<input type="checkbox" name="seccion[]" value="<?php echo $row[0]?>" <?php if($NUM==1){ echo "checked"; }?>>
							</td>
						</tr><?php
						if($x==0){$x++;}else{$x=0;} 
					}	?>					
							<tr bgcolor="#F2F2F2">
								<td colspan="4" align="center"  style="padding-top:20px; padding-bottom:20px" >
									<input type="submit" class="btn btn-success" name="guardar" value="GUARDAR" onClick="void(document.f1.action='accesos.php?id1=<?php echo $id?>&action=add');void(document.f1.submit())"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<input type="reset" name="cancelar" class="btn btn-danger" onclick="history.back();" value="CANCELAR"></td>
								</tr>					
							</table>
							</form>	
						</div>
					</div>
				</div>
			</div>
			
			<?php
		}
	}			
}	
?>