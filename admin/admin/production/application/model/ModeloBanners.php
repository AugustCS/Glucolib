<?php 
class ModeloBanners
{
	public function getBanners()
	{
		$sql = "SELECT * FROM banners  ORDER BY id ASC LIMIT 5 ";
			$query_p = new Consulta($sql);
			while($row_p = $query_p->VerRegistro()){
			$data[] = array(
				'id'		=> $row_p['id'],
				'thumb' 	=> $row_p['thumb_banner_imagen'],
				'imagen' 	=> $row_p['imagen_banner_imagen'],
			);
		}
		return $data;
	}
	public function imagenesBanners()
	{
		$obj_idiomas = new ModeloIdiomas();
		$idiomas	 = $obj_idiomas->getIdiomas();
		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {	


			$titulo 		= $_POST['titulo'];
			$descripcion 	= $_POST['descripcion'];

			// pre($titulo);

			// die();


			$ftmp   = $_FILES['image']['tmp_name'];
			$nombre = time().$_FILES['image']['name'];
			//$fname  = '../aplication/webroot/imgs/catalogo/'.$nombre;
			//$fname  = '../aplication/webroot/imgs/imgs_banners/'.$nombre;
			$fname 	= _ruta_imagenes_saweto_.'banners/'.$nombre;
			if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {	
				define("NAMETHUMB", "/tmp/thumbtemp");
				$thumbnail = new ThumbnailBlob($_FILES['image'], NAMETHUMB, _ruta_imagenes_saweto_.'banners/thumb_');
				$thumbnail->CreateThumbnail(961,961,$nombre);			
			}
			if(move_uploaded_file($ftmp, $fname)){	
				$k = 1;
				for($i = 0; $i < count($idiomas); $i++){

					$queryU = new Consulta("INSERT INTO banners (nombre_banner, descripcion_banner,id_idioma, thumb_banner_imagen,imagen_banner_imagen) VALUES('".$titulo[$i]."', '".$descripcion[$i]."','".$k."', '".'thumb_'.$nombre."','".$nombre."')"); 							 
					$k++;
				}		
			} ?>
			<script> location.replace("banners.php?id=<?php echo $id ?>&action=imagenes") </script>
			<?php
		}
		$obj = new ModeloBanner($id);//instancia una clase de Bammer para hacer la consulta a la base de datos
		$imagenes = $obj->__get("_imagenes");
		//pre($imagenes);
		 ?>
		<div id="mantinance">
			<fieldset id="crud">
				<legend> Galeria de Imagenes </legend>
				<form name="f1" id="f1" method="post" enctype="multipart/form-data" action="banners.php?id=<?php echo $id; ?>&action=imagenes"   class="form-horizontal form-label-left">
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
					<label class="control-label col-md-3 col-sm-3 col-xs-12 pull-left text-left" style="float:left !important; text-align: left;"><img src="<?php echo $bandera; ?>">&nbsp;Titulo: </label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" name="titulo[]" value="" class="form-control col-md-7 col-xs-12" size="59" maxlength="250">
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
					<label class="control-label col-md-3 col-sm-3 col-xs-12" style="float:left !important; text-align: left;"><img src="<?php echo $bandera; ?>">&nbsp;Descripción: </label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input type="text" name="descripcion[]" value="" class="form-control col-md-7 col-xs-12" size="59" maxlength="550">
					</div>
				</div>
				<?php } ?>
				<div id="iframe" class="form-group">
					<div class="ileft_img" style="float: left;">
						<label for="imagen">Imagen : </label>
						<input id="file" type="file" name="image" size="31" class="btn btn-info fileinput-banner" />
					</div>
				</div>
				<div class="ln_solid"></div>
  				<div class="form-group">
  					<div class="col-md-12 col-sm-12 col-xs-12 pull-right">
  					
						<input type="submit" name="" value="GUARDAR"  class="btn btn-success pull-right">
						<input type="reset" name="" value="CANCELAR"  class="btn btn-danger pull-right">
						<br clear="all">
  					</div>
  				</div>
				<div style="clear:both"></div>
				<br><br>
				<div id="images">
					<div class="lefti" style="width: 270px; float: left;"> <?php
						if(is_array($imagenes) && count($imagenes) > 0){

							for($i=0; $i < count($imagenes); $i++){ ?>
								<div id="item_image" class="imagen<?php echo $imagenes[$i]['id'];?>">
									<input type="checkbox" name="chkimag" value="<?php echo $imagenes[$i]['imagen'];?>"/>
									<a href="#" title="<?php echo _imagenes_saweto_.'banners/'.$imagenes[$i]['imagen'];?>">
									<?php echo $imagenes[$i]['imagen'];?> </a>
								</div> <?php

							}
						} ?>
						<p id="msg_delete"> </p>
	 				</div>
					<div class="righti" id="imgs" style="width: 570px; float: right;"><?php if(!empty($imagenes[0]['imagen'])){ ?>
						<table width="100%" height="100%">
                        	<tr><td valign="middle" align="center"><img src="<?php echo _imagenes_saweto_.'banners/'.$imagenes[0]['imagen'];?>" id="imgp" width="250"/></td></tr>
                        </table><?php
						}else{
							echo "<BR><BR><BR><BR><BR><BR><H3> SIN IMAGENES </H3>";
						} ?>
					</div>
					<br clear="all" />
					<br clear="all" />
					<br clear="all" />
					<div class="bottom"><a href="javascript:;">
						<i class="glyphicon glyphicon-option-vertical"></i></a> Para eliminar una imagen activa su(s) respectiva(s) casilla de verificacion y haz cilck en <span class="btn btn-danger" onclick="javascript: delete_imagen('banner')" >ELIMINAR </span>
					</div>
				</div>
			</form>
			</fieldset>
		</div>

		<?php		

	}

}

?>