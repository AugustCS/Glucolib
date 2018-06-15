<?php 
class ModeloConfiguration{
	
	var $data = array();
	private $_msgbox;
	private $_usuario;
	
	public function __construct($msg='', ModeloUsuario $user)
	{
		$this->_msgbox = $msg;
		$this->_usuario = $user;
	}

	function editConfiguration($id){
		//echo $id;
	?>
	<div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Editar Configuración</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form name="f1" action="<?php echo $_SERVER['PHP_SELF']."?action=update"?>" method="post" data-parsley-validate class="form-horizontal form-label-left">
						<?php
						foreach($this->getData() as $clave => $valor){ ?> 
				      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?php echo str_replace("_"," ",$clave); ?> <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <?php 
                        if(($clave=="CUENTA_BANCARIA")or($clave=="CONDICIONES_TERMINOS")){
                        ?> 
                        <textarea  name="<?php echo $clave; ?>" class="form-control col-md-7 col-xs-12" rows="10" cols="41"> <?php echo $valor; ?></textarea>
                        <?php	
                        }else{
                        ?> 
                        <input type="text" id="<?php echo $clave; ?>" name="<?php echo $clave; ?>" required="required" class="form-control col-md-7 col-xs-12" value="<?php echo $valor; ?>">
                        <?php	
                        } ?>
                          
                        </div>
                      </div>
                      	<?php				
						} ?>
                      
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="button" name="limpia" class="btn btn-primary" onclick="history.back();">Cancelar</button>
                          <button type="submit" name="guarda" class="btn btn-success">GUARDAR</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
              </div>	
		<?php				
	}
	
	function updateConfiguration(){
		
		foreach($_POST as $nombre => $valor){
			$sql = "UPDATE configuracion SET valor_configuracion = '".$valor."' WHERE nombre_configuracion = '".$nombre."' ";	
			$query = new Consulta($sql);
		}	
		
		$this->_msgbox->setMsgbox('Actualizado correctamente',2);
		location("configuracion.php");	
		
	}
	
	function listConfiguration(){
		$sql = "SELECT * FROM configuracion";
		$query = new Consulta($sql);
		

	echo Listado::VerListado($query, "configuracion.php","","",$this->_usuario);	
	}
	
	function getData(){
		
		$sql   = "SELECT * FROM configuracion ";
		$query = new Consulta($sql);
		
		while($row = $query->VerRegistro()){
			$this->data[$row['nombre_configuracion']] = $row['valor_configuracion'];			
		}
		
		return $this->data;		
	}
}

?>