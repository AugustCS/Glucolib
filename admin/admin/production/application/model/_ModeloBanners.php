<?php 
class ModeloBanners
{
	private $_msgbox;
    public function __construct($msg='')
    {
		$this->_msgbox = $msg;
    }

	public function getBanners()
	{
		$sql = "SELECT * FROM banners  ORDER BY id ASC LIMIT 5 ";
			$query_p = new Consulta($sql);
			while($row_p = $query_p->VerRegistro()){
			$data[] = array(
				'id'			=> $row_p['id'],
				'thumb' 		=> $row_p['thumb_banner_imagen'],
				'imagen' 		=> $row_p['imagen_banner_imagen'],
				'nombre' 		=> $row_p['nombre_banner'],
				'url' 			=> $row_p['url_banner']
			);
		}
		return $data;
	}
	public function editBanners(){
            $obj =  new Form();
		echo "<div class='success' style='padding:10px;'>&nbsp;&nbsp;&nbsp;&nbsp;Subir imagenes con tamaño <strong>exacto</strong> de <strong>w = 1600px x h 440px</strong>  pixeles.</div>";

		$query = new Consulta("SELECT id, imagen_banner_imagen, nombre_banner, url_banner FROM banners WHERE id = '".$_GET['id']."'");
		$obj->getForm($query, "edit", "banners.php",'','','img');
    }

	public function newBanners(){
            $obj =  new Form();
		echo "<div class='success' style='padding:10px;'>&nbsp;&nbsp;&nbsp;&nbsp;Subir imagenes con tamaño <strong>exacto</strong> de <strong>w = 1600px x h 440px</strong>  pixeles.</div>";
		$query = new Consulta("SELECT id, imagen_banner_imagen, nombre_banner, url_banner FROM banners");
		
		$obj->getForm($query, "new", "banners.php",'','','img');
    }


     public function addBanners() {

		$destino = '../aplication/controller/static.img/catalogo/';
        $update = ", '" . $nombre . "' ";
		
        if (isset($_FILES['imagen_banner_imagen']['name']) && $_FILES['imagen_banner_imagen']['name'] != "") {

			$ext = explode('.',$_FILES['imagen_banner_imagen']['name']);
			$nombre_file = time().sef_string($ext[0]);
			$type_file = typeImage($_FILES['imagen_banner_imagen']['type']);				
			$nombre = $nombre_file . $type_file;	
			
			define("NAMETHUMB", "/tmp/thumbtemp");
			$thumbnail = new ThumbnailBlob($_FILES['imagen_banner_imagen'],NAMETHUMB,'../aplication/controller/static.img/catalogo/banner_');
			$thumbnail->setQuality(9);
			$thumbnail->SetTransparencia(true);
			$thumbnail->CreateThumbnail(1600, 440,$nombre);		
			
			
			$thumbnail2 = new ThumbnailBlob($_FILES['imagen_banner_imagen'],NAMETHUMB, '../aplication/controller/static.img/catalogo/thumb_');
			$thumbnail2->setQuality(31);
			$thumbnail2->CreateThumbnail(135, 90,$nombre);	
	        
	        $query = new Consulta("INSERT INTO banners(thumb_banner_imagen, imagen_banner_imagen, nombre_banner,  url_banner) VALUES('thumb_".$nombre."','banner_".$nombre."' ,'".$_POST['nombre_banner']."','".$_POST['url_banner']."')");

	        $this->_msgbox->setMsgbox('Banner actualizado correctamente.',2);
	        location("banners.php");
        }
		
    }


     public function updateBanners() {


        $destino = '../aplication/controller/static.img/catalogo/';

        if (isset($_FILES['imagen_banner_imagen']['name']) && $_FILES['imagen_banner_imagen']['name'] != "") {

        	// ELIMINA LA FOTO ANTERIOR DE LA CARPETA DE CATALOGO
		    $query2 = new consulta("SELECT * FROM banners WHERE id = '$_GET[id]' ");
		    $datos = $query2->VerRegistro();
		        
		     if(isset($datos['imagen_banner_imagen'])){
					if(file_exists(_link_file_ . $datos['imagen_banner_imagen'])){
						unlink (_link_file_ . $datos['imagen_banner_imagen']);
						unlink (_link_file_ . $datos['thumb_banner_imagen']);
					}							
				}

			// ACTUALIZA LA FOTO ANTERIOR DE LA CARPETA DE CATALOGO
           define("NAMETHUMB", "/tmp/thumbtemp");
			$ext = explode('.',$_FILES['imagen_banner_imagen']['name']);
			$nombre_file = time().sef_string($ext[0]);
			$type_file = typeImage($_FILES['imagen_banner_imagen']['type']);				
			$nombre = $nombre_file . $type_file;	
			
			$thumbnail = new ThumbnailBlob($_FILES['imagen_banner_imagen'],NAMETHUMB,'../aplication/controller/static.img/catalogo/banner_');
			$thumbnail->setQuality(9);
			$thumbnail->SetTransparencia(true);
			$thumbnail->CreateThumbnail(1600, 440,$nombre);	
			
			
			$thumbnail2 = new ThumbnailBlob($_FILES['imagen_banner_imagen'],NAMETHUMB, '../aplication/controller/static.img/catalogo/thumb_');
			$thumbnail->setQuality(9);
			$thumbnail->SetTransparencia(true);
			$thumbnail2->CreateThumbnail(135, 90,$nombre);	

			$update = "thumb_banner_imagen='thumb_".$nombre."',imagen_banner_imagen='banner_".$nombre."', ";
        }		

        $query = new Consulta("UPDATE banners SET  ". $update ." nombre_banner='".$_POST['nombre_banner']."', url_banner='".$_POST['url_banner']."' WHERE id = '" . $_GET['id'] . "'");




        $this->_msgbox->setMsgbox('Banner actualizado correctamente.',2);
        location("banners.php");
    }




    public function deleteBanners(  ){
		$this->deleteFilesBanners( $_GET['id'] );
		$query = new Consulta("DELETE  FROM banners WHERE id = '".$_GET['id']."'");						
		$this->_msgbox->setMsgbox('Se elimino correctamente.',2);
		location("banners.php");		
	}
	public function deleteFilesBanners( $id ){
		$query = new Consulta( "SELECT * FROM banners WHERE id = '".$id."'" );
		$row = $query->VerRegistro();

		if($row['imagen_banner_imagen']!= '' ){
			if(file_exists(_link_file_ . $row['imagen_banner_imagen'])){
				unlink (_link_file_ . $row['imagen_banner_imagen']);
				unlink (_link_file_ . $row['thumb_banner_imagen']);
			}							
		}	
	}

	public function listBanners()
	{			
		$banners = array();
		$banners = $this->getBanners();
		
       ?>
	   	<div id="content-area">
            <table cellspacing="1" cellpading="1" class="listado">
                <thead>
                    <tr class="head">
                        <th align="left">Banners</th>
                        <th align="center" width="100" class="titulo">Opciones</th>
                   </tr>
                </thead>
            </table>	
            <ul id="listadoul" data-orden="ordenarBanner">
			 <?php
				if(count($banners) > 0)	{
					$y = 1;
					foreach($banners as $b){				
				?>
					<li class="<?php echo ($y%2 == 0) ? "fila1" : "fila2"; ?>" id="list_item_<?php echo $b['id']; ?>">
						<div class="data">
							<img style="vertical-align: middle;" src="<?php echo _admin_ ?>photo_upload.png" class="handle">
							<?php echo $b['nombre'] ?>
						</div>
						<div class="options">
							
							<!-- <a class="tooltip move" title="Ordenar ( Click + Arrastrar )">
								<img src="<?php echo _admin_ ?>move.png" class="handle">
							</a>&nbsp;&nbsp; -->
							<a title="Editar" class="tooltip" href="banners.php?id=<?php echo $b['id'] ?>&action=edit">
								<img src="<?php echo _admin_ ?>edit.png">
							</a>&nbsp;&nbsp;
							<a title="Eliminar"  href="#" class="tooltip" onClick="mantenimiento('banners.php','<?php echo $b['id'] ?>','delete')">
								<img src="<?php echo _admin_ ?>delete.png">
							</a>&nbsp;&nbsp;

	                    </div>
					</li>
				<?php
					$y++;
					}
				}

				
			?>
             </ul>
        </div>
		<?php		
	}

}

?>