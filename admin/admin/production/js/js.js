$(document).ready(function() {
	$("#mostrar-tabla").click(function(){
				$(this).addClass('temporal');
				$( ".capa_oculta" ).addClass('capa');
				//$( "#mostrar-tabla" ).text('Ocultar tabla');
	});
	$(".table-responsive #mostrar-tabla.temporal").click(function(){
		$( ".capa_oculta" ).removeClass('capa');
	})
	$('.range').daterangepicker({
		minDate: moment().subtract(2, 'years'),
		  callback: function (startDate, endDate, period) {
		    $(this).val(startDate.format('L') + '–' + endDate.format('L'));
		  }
	});

		var idContenido = '';
		var idContenido = $("#idContenido").val();
	 	tinyMCE.init({
            mode:"specific_textareas",
            editor_selector : "tinymce",
            theme : "advanced",
            plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,safari,advlink",
            theme_advanced_buttons1 : "bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect,styleprops",
theme_advanced_buttons2 : "tablecontrols,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,code,|,forecolor,|,insertimage,image",
theme_advanced_buttons3 : "",
theme_advanced_buttons4 : "",
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left"
    });

	$("textarea:not('.material')").addClass("tinymce");
	$(".textarea").addClass("tinymce");

	$('.date').daterangepicker({
          singleDatePicker: true,
          singleClasses: "picker_2",
          locale: {
              format: 'DD/MM/YYYY'
            },

        }, function(start, end, label) {
          //console.log(start.toISOString(), end.toISOString(), label);
        });

	$(".fileinput").fileinput({
		showPreview: false,
	    allowedFileExtensions: ["jpg", "jpeg", "gif", "png"],
	    elErrorContainer: "#errorBlock"
    });
    $(".fileinput-banner").fileinput({
		showPreview: false,
	    allowedFileExtensions: ["jpg", "jpeg", "gif", "png"],
	    elErrorContainer: "#errorBlock",
		showUploadedThumbs: false,
		showRemove: false,
		showUpload: false,
		maxFileCount: 1,
    });

    $(".foto").fileinput({
		showPreview: false,
	    allowedFileExtensions: ["jpg", "jpeg", "gif", "png","pdf"],
	    elErrorContainer: "#errorBlock",
		showUploadedThumbs: false,
		showRemove: false,
		showUpload: false,
		maxFileCount: 1,
    });

    $("#images a").click( function(){
		
		var descripcion = $(this).attr("rel");
		var title = $(this).attr("title");		
		var id = $(this).attr("rev");		
		
		$("#imgp").hide();
		$("#imgp").attr("src", title).fadeIn('slow'); 
		
		$("#title_img").hide();
		$("#idimg").val(id);
		$("#title_img").val(descripcion).fadeIn('slow'); 
	});
});

function delete_imagen(opcion){
	var f1 = eval("document.f1");
	$("#msg_delete").hide();
	if(f1.chkimag.length > 0){
		for(var i=0; i < f1.chkimag.length; i++){
			if(f1.chkimag[i].checked == 1){			
				var id = f1.chkimag[i].value;
				$(".imagen" + id).fadeOut('slow');
				$("#msg_delete").load("delete_imagen.php?id="+id+"&opcion="+opcion).fadeIn("slow");
				$("#imgp").fadeOut("slow");
			}
		}
	}else{
		if(f1.chkimag.checked == 1){			
			var id = f1.chkimag.value;
			$(".imagen" + id).fadeOut('slow');
			$("#msg_delete").load("delete_imagen.php?id="+id+"&opcion="+opcion).fadeIn("slow");
			$("#imgp").fadeOut("slow");
		}	
	}	 			
}
function mantenimiento_cat(url,id,opcion){
    if(opcion!="delete"){ 
  
    location.replace(url+'?actioncat='+opcion+'&id='+id);      
  }else if(opcion=="delete"){
    if(!confirm("Esta Seguro que desea Eliminar el Registro")){
      return false; 
    }else{
      location.replace(url+'?actioncat='+opcion+'&cat='+id);      
    }   
  }
}

function mantenimiento(url,id,opcion){
    if(opcion!="delete"){ 
  
    location.replace(url+'?action='+opcion+'&id='+id);      
  }else if(opcion=="delete"){
    if(!confirm("Esta Seguro que desea Eliminar el Registro")){
      return false; 
    }else{
      location.replace(url+'?action='+opcion+'&id='+id);      
    }   
  }
}
function valida_contenido(opcion,id) {
	var nombre 		= document.contenido.elements['titulo[]'];

	if(nombre.length > 0){
		for(i = 0; i< nombre.length; i++){
			if(nombre[i].value == ""){ 
				alert("Ingrese el titulo del contenido");
				nombre[i].focus();
				return false;
			}
		}
	}else{
		if(nombre.value == ""){ 
			alert("Ingrese el titulo del contenido");
			nombre.focus();
			return false;
		}
	}

	
	document.contenido.action="modulos-web.php?action="+opcion+"&id="+id;
	document.contenido.submit();
}
function valida_proyecto(opcion,id) {
	var nombre 		= document.contenido.elements['titulo[]'];

	if(nombre.length > 0){
		for(i = 0; i< nombre.length; i++){
			if(nombre[i].value == ""){ 
				alert("Ingrese el titulo del contenido");
				nombre[i].focus();
				return false;
			}
		}
	}else{
		if(nombre.value == ""){ 
			alert("Ingrese el titulo del contenido");
			nombre.focus();
			return false;
		}
	}

	
	document.contenido.action="ejecutores-proyecto.php?action="+opcion+"&id="+id;
	document.contenido.submit();
}

function valida_noticias(opcion,id) {
	var nombre 		= document.noticias.elements['titulo[]'];

	if(nombre.length > 0){
		for(i = 0; i< nombre.length; i++){
			if(nombre[i].value == ""){ 
				alert("Ingrese el titulo de la noticia");
				nombre[i].focus();
				return false;
			}
		}
	}else{
		if(nombre.value == ""){ 
			alert("Ingrese el titulo de la noticia");
			nombre.focus();
			return false;
		}
	}

	
	document.noticias.action="noticias.php?action="+opcion+"&id="+id;
	document.noticias.submit();
}
function valida_categorias (opcion, id, idform) {
	var nombre = document.categorias.elements['nombre_categoria[]'];
	if(nombre.length > 0){
		for(i = 0; i< nombre.length; i++){
			if(nombre[i].value == ""){ 
				alert("Ingrese el nombre de la categoria");
				nombre[i].focus();
				return false;
			}
		}
	}else{
		if(nombre.value == ""){ 
			alert("Ingrese el nombre de la categoria");
			nombre.focus();
			return false;
		}
	}

	document.categorias.action="modulos-web.php?actioncat="+opcion+"&id="+id;
	document.categorias.submit();	
}

function valida_categoriasP (opcion, id, idform) {
	var nombre = document.categorias.elements['nombre[]'];
	if(nombre.length > 0){
		for(i = 0; i< nombre.length; i++){
			if(nombre[i].value == ""){ 
				alert("Ingrese el nombre de la categoria");
				nombre[i].focus();
				return false;
			}
		}
	}else{
		if(nombre.value == ""){ 
			alert("Ingrese el nombre de la categoria");
			nombre.focus();
			return false;
		}
	}

	document.categorias.action="ejecutores-proyecto.php?actioncat="+opcion+"&id="+id;
	document.categorias.submit();	
}