<?php

	/*======================================================================*\
	|| #################################################################### ||
	|| # 	                  Powered by Walter Meneses Calderon          # ||
	|| # ---------------------------------------------------------------- # ||
	|| # -------------------       Develoweb             ---------------- # ||
	|| #################################################################### ||
	\*======================================================================*/
	
	/*************************************************************************
		La clase sirve para generar thumbnails y poder guardarlo en la base de
		datos, soporta imagenes de tipo jpg, gif, png, wbmp, y es personalizable
		en tama�o y se le puede agregar un texto en la imagen.
	**************************************************************************/


class ThumbnailBlob{
	
	var $image    = "";
	var $width    = 0;
	var $height   = 0;
	var $new_width;
	var $new_height;
	var $error    = "";
	var $extencion= "";
	var $name     = "";
	var $thumbnail;
	var $texto    = "";
	var $fontColor;	
	var $ruta_temp;	
  	var $tmp_name;
	var $type;
	var $mimetypesuported;
	var $data = array();
	var $path;
	var $calidad;
	
	/**
	*	constructor ThumbnailBlobFile inicializa los datos mas importantes 
	*	de la imagen a tratar, parametros: 
	*
	*	@param	string	$imagefile	imagen a tratar, 
	*	@param	string	$tmp 	 	ruta temporal del servidor donde se tratara a la imagen.  
	*
	*	@return no
	*/
	
		function ThumbnailBlob($file,$tmp, $path){
	
		$this->path = $path;
		if($tmp){
			
			$this->name		= $file["name"];
			$this->type		= $file["type"];
			$this->tmp_name	= $file["tmp_name"];
			$this->size		= $file["size"];
			$this->ruta_temp= $tmp;
			$this->mimetypesuported = array("image/jpeg", "image/pjpeg", "image/gif", "image/png", "image/wbmp");
			
			if(!in_array($this->type, $this->mimetypesuported))
				die("El archivo que subiste no es una imagen valida");
				switch($this->type){
					case $this->mimetypesuported[0]:
					case $this->mimetypesuported[1]:
					  $this->image = imagecreatefromjpeg($this->tmp_name);
					break;
					case $this->mimetypesuported[2]:
					  $this->image = imagecreatefromgif($this->tmp_name);
					break;
					case $this->mimetypesuported[3]:
					  $this->image = imagecreatefrompng($this->tmp_name);
					break;
					case $this->mimetypesuported[4]:
					  $this->image = imagecreatefromwbmp($this->tmp_name);
					break;
				}
			$imagesize = getimagesize($this->tmp_name);
			$this->width  = $imagesize[0];	//ancho 
			$this->height = $imagesize[1];	//alto
			$this->SetfontColor("azul");  	//color del texto
		}else{
			die("ERROR: Tiene que ingresar el archivo a procesar y la ruta del su carpeta temporal");
		}		
	}  

	
	/*
	*  Asigna la transparencia o no	
	*/
	
	public function SetTransparencia($transparency){
		$this->transparencia = $transparency;	
	} 
	
	/* function para generar imagenes con transparencia */
	function setTransparency($new_image,$image_source){ 
        
			imagealphablending($new_image, false);
			imagesavealpha($new_image, true); 
		
            //$source = imagecreatefrompng($fileName);
			imagealphablending($image_source, true);
			
			//imagecopyresampled($new_image, $image_source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
			
			//imagesavealpha($image_source, true); 
		   
		   
		   /* $transparencyIndex = imagecolortransparent($image_source); 
            $transparencyColor = array('red' => 255, 'green' => 255, 'blue' => 255); 
             
            if ($transparencyIndex >= 0) { 
                $transparencyColor    = imagecolorsforindex($image_source, $transparencyIndex);    
            } 
            
            $transparencyIndex    = imagecolorallocate($new_image, $transparencyColor['red'], $transparencyColor['green'], $transparencyColor['blue']); 
            imagefill($new_image, 0, 0, $transparencyIndex); 
            imagecolortransparent($new_image, $transparencyIndex); 
        */
    }	 
	 
	 /*
	 *
	 *
	 */
	 
	 
	function setQuality($calidad=""){
		  if(!empty($calidad)){
		   $this->calidad = $calidad;
		  }  
	 } 
	
	
	/*
	*	Asigna una ruta a la imagen ==>> aun no muy  estable su fincionamiento
	*
	*	@param	string	$ruta   

	*
	*	@return no
	*/	
	function SetRuta($url=""){
		if(!empty($url)){
			$this->ruta = $url;
		}		
	}
	
	/*
	*	Asigna un nombre a la imagen ==>> aun no muiy  estable su fincionamiento
	*
	*	@param	string	$nombre   
	*
	*	@return no
	*/	
	function SetName($name=""){
		if(!empty($name)){
			$this->name = $url;
		}		
	}
	
	/**
	*	Asigna texto que saldra impreso en la imagen
	*
	*	@param	string	$color	color, 
	*
	*	@return no
	*/	
	function SetTexto($texto){
		if(!empty($texto)){
			$this->texto = $texto;
		}		
	}
	
	/**
	*	Asigna color al texto que saldra impreso en la imagen
	*
	*	@param	string	$color	color, 
	*
	*	@return no
	*/	
	function SetfontColor($color){
	
		switch($color){
			case "blanco":
				$this->fontColor	= 	imagecolorallocate($this->image, 255, 255, 255);
			break;
			case "negro":
				$this->fontColor 	= 	imagecolorallocate($this->image, 0, 0, 0);
			break;
			case "azul":
				$this->fontColor 	= 	imagecolorallocate($this->image, 0, 0, 255);			
			break;
			case "naranja":
				$this->fontColor	=	imagecolorallocate($this->image, 251, 87, 9);
			break;
			case "transparente":
				$this->fontColor	= 	imagecolorallocate($this->image, 219, 224, 229);
			break;
			case "gris":
				$this->fontColor 	= 	imagecolorallocate($this->image, 110, 106, 110);
			break;
			case "grisclaro":
				$this->fontColor	= 	imagecolorallocate($this->image, 180, 180, 180); 
			break;
			case "lavender":
				$this->fontColor 	= 	imagecolorallocate($this->image, 180, 180, 250); 
			break;
			default:
				$this->fontColor 	= 	imagecolorallocate($this->image, 180, 180, 180); 
			break;
		}
	}
	
	/**
	*	Crea el thumbnail segun los parametros de tama�o pasados
	*	de la imagen a tratar, parametros: 
	*
	*	@param	string	$width	 ancho del tama�o que tomara la imagen,
	*	@param	string	$height	 alto del tama�o que tomara la imagen, 
	*
	*	@return array $data =>  nombre, imagen normal, thumbnail, tipo de imagen
	*/
			
	function CreateThumbnail($width=0, $height=0, $new_name=''){		
		
		if($width > 0 || $height > 0 ){
		
			if(!empty($this->image)){		
				
				// intentamos escalar la imagen original a la medida que nos interesa				
				
				/* EN CASO DE ANCHURA (tengo la altura) */
				$wratio = ($this->height / $height);
				$this->new_width = round($this->width / $wratio);
			
				/* EN CASO DE ALTURA (teniendo la anchura)*/
				$hratio=($this->width / $width);
				$this->new_height = round($this->height / $hratio);
								
				if($this->new_height > $height && $this->new_width <= $width){
					$this->new_height = $height;
				}else if($this->new_width > $width && $this->new_height <= $height){
					$this->new_width = $width;
				}
				/*
				else{
					$this->error = "Error al Redimensionar";
					return $this->error;
				}*/
				
				// esta ser� la nueva imagen reescalada
				$this->thumbnail = imagecreatetruecolor($this->new_width,$this->new_height);
				
				// si se puede genero transparencia
				$this->setTransparency($this->thumbnail,$this->image); 
									
				// con esta funci�n la reescalamos
				imagecopyresampled ($this->thumbnail, $this->image, 0, 0, 0, 0, $this->new_width,$this->new_height,$this->width,$this->height)or die ("error");
								
				//aqui verificamos si contiene texto
				if($this->texto!=""){					
					imagestring($this->thumbnail,2,0,0,$this->texto,$this->fontColor);
				}
				if($new_name == '') { $new_name = $this->name; } 
				
				   if(!empty($this->calidad)){
						/* depende de que tipo de imagen sea genero el png(transparencia) � jpg */
						switch ($this->transparencia){
							case false : imagejpeg($this->thumbnail, $this->path.$new_name, $this->calidad);	break;					
							case true :  imagepng($this->thumbnail, $this->path.$new_name, $this->calidad); break;
							break;
						}			
				   }else{
						/* depende de que tipo de imagen sea genero el png(transparencia) � jpg */
						switch ($this->transparencia){
							case false : imagejpeg($this->thumbnail, $this->path.$new_name, 98);	break;					
							case true :  imagepng($this->thumbnail, $this->path.$new_name, 9); break;
							break;
						}	
				   }
				//imagejpeg($this->thumbnail, $this->path.$new_name, 98);
				imagedestroy($this->image); 
			}else{
				$error="No se Pudo Inicializar la Imagen por falta de Parametros";
				$this->error = $error;
				return $this->error;
			}	
		}else{
			$this->error = "No se Pudo trabajar Imagen, Verifique que la imagen Existe ";
			return $this->error;		
		}			
	}
}
/*
Usos:
	define("NAMETHUMB", "/tmp/thumbtemp"); 
	$thumbnail = new ThumbnailBlobFile($_FILES["imagen"], NAMETHUMB);
	$thumbnail->SetTexto("Develoweb");
	$thumbnail->SetfontColor("lavender");
	$datos = $thumbnail->CreateThumbnail(300, 300);
	
	datos recuperados:
	
	$datos['nombre'];
	$datos['imagen'];
	$datos['thumbnail'];
	$datos['type'];
	
*/
?>