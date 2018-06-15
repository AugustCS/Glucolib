




$( document ).ready(init());



function init(){

	'use strict';

	var timout;

	var cerrarVentaDia 	= $('#btn-cerrar-venta');
	var eliminarVenta 	= $('.delete-pedido');


	cerrarVentaDia.on('click', procesarCierreCaja);
	eliminarVenta.on('click', procesoEliminacionVenta);

}

function procesoEliminacionVenta() {
	
	var input 		= $(this);
	var id 			= input.data('id');
	var url 		= input.data('url');
	var urlaccion 	= input.data('url2');
	var seccion 	= input.data('seccion');
	var mensaje = "¿Estas seguro que quieres eliminar esta venta?, recuerda que al ejecutar este proceso la venta quedará anulada por completo";
	bootbox.confirm(mensaje, function(result){ 
            if(result){
            	var modaldiv = $('#myModal');
				modaldiv.find('.modal-body p').text('Espere estamos Procesando...');
				bootbox.alert('Espere estamos Procesando...');

				$.post(urlaccion+seccion+'ajax.php',
				    {
				        action: "eliminarPedido",
				        pedido: id
				    },
				    function(data, status){
				    		timout=setTimeout(function(){
				    			var mensaje = data['mensaje'];
				    				bootbox.alert(mensaje);

					    		if (data['respuesta'] == 'OK') {
					    					setTimeout(function(){
					     						location.reload();
					    					},2000);
					     		}
				    				
				    		},2000);	
				    });

            }
    });
	return false;
}

function procesarCierreCaja() {
	var boton 	= $(this);
	var url 	= boton.data('url');
	var seccion = boton.data('seccion');
	var dia 	= boton.data('dia');
	var estado 	= boton.data('estado');

	if(estado == 1){
            bootbox.alert("Las ventas del día ya fueron procesadas");
            return false;
          }



	bootbox.confirm("¿Estas seguro que quieres terminar la venta de día?, recuerda que al ejecutar este proceso ya no podrás realizar más venta del dia", function(result){ 
            if(result){
            		var modaldiv = $('#myModal');
					modaldiv.find('.modal-body p').text('Espere estamos Procesando...');

					$.post(url+seccion+'ajax.php',
				    {
				        action: "cierreCaja",
				        dia: dia
				    },
				    function(data, status){
				    	var mensaje = data['mensaje'];
				    	// console.log(data['respuesta']);
				    	// console.log(data['mensaje']);


				    	timout=setTimeout(function(){
				    	modaldiv.find('.modal-body p').text(mensaje);

				    	if (data['respuesta'] == 'OK') {

				    		setTimeout(function(){
					    		modaldiv.modal('hide');
					    			setTimeout(function(){
					    				location.reload();
							    	},1000);

					    	},1000);
				    	}else{

				    		setTimeout(function(){
					    		modaldiv.modal('hide');
					    			setTimeout(function(){
					    				location.reload();
							    	},4000);

					    	},1000);

				    	}
				    	
				    },5000,"JavaScript");

				    });
            }
        });

	return false;

	

}

