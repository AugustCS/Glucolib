<?php  
/**
* 
*/
class ControladorAjax
{
	public function eliminarPedidoAjax()
       {
              $retorno             = new stdClass();
              $objVentas           =  new ModeloVentas();
              
              $retorno->mensaje    = 'pedido eliminado correctamente';
              $retorno->respuesta  = 'OK';

              $objVentas->eliminarPedido($_POST['pedido']);

              VistaJson($retorno);

       }
	public function cierreCajaAjax()
	{
              $obj          = new ModeloVentas();
		$objInsumos   = new ModeloInsumos();
		$data 		= new stdClass();
		$retorno 	= new stdClass();
		$retorno->respuesta = 'ERROR';
		$retorno->mensaje 	= 'No es posible hacer el cierre de caja, ya tenemos un cierre con esta fecha, si crees que se trata de un error debes ponerte en contacto con el administrador de Tienda';

		$data->fecha 	       = $_POST['dia'];
		$data->registro      = TIEMPO;
              $data->desde         = $data->fecha;
              $data->hasta         = $data->fecha;


		//verificamos existencia de cierre de caja
		$respuesta = $obj->verificarCierreCaja($data);
		if ($respuesta > 0) {
			VistaJson($retorno);
			exit();
		}else{
			//registramos cierre de caja

			$data->total 		= $obj->totalVentasDia($data);
			//generar cierre de caja
			$respuesta  		= $obj->generarCierreCaja($data);
                     $dato             = $objInsumos->stockAlmacen($data);
                     //insertamos este stock para el dia siguiente como reingreso
                     $objInsumos->reingresoAlmacenInsumosSobrantes($dato, $data->fecha);
			$retorno->respuesta = 'OK';
			$retorno->mensaje 	= 'El cierre de caja fué un éxito';

			VistaJson($retorno);

			

		}
	}

       public function cambiarEstadoVentaAjax()
       {
              $obj =  new ModeloVentas();
              if (isset($_POST['id']) && $_POST['id'] != '') {
                     
              }
                     $id =  $_POST['id'];
                     $obj->cambiarEstadoVenta($id, 2);
       }

	public function viewUserAjax()
	{
		if($_GET['id']){
			$obj = new ModeloUsuario($_GET['id']);
		?>
        
       	<div id="datos_usuario">
       		<div class="col-lg-12 col-md-12">
       			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
       				<label>Nombre:</label>
       			</div>
       			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
       				<label for=""><?php echo $obj->getNombre(); ?></label>
       			</div>

       		</div>
       		<div class="col-lg-12 col-md-12">
       			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
       				<label>Apellidos:</label>
       			</div>
       			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
       				<label for=""><?php echo $obj->getApellidos(); ?></label>
       			</div>

       		</div>
       		<div class="col-lg-12 col-md-12">
       			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
       				<label>Cargo:</label>
       			</div>
       			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
       				<label for=""><?php echo $obj->getRol()->getNombre(); ?></label>
       			</div>

       		</div>
       		<div class="col-lg-12 col-md-12">
       			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
       				<label>Email:</label>
       			</div>
       			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
       				<label for=""><?php echo $obj->getEmail(); ?></label>
       			</div>

       		</div>
       		<div class="col-lg-12 col-md-12">
       			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
       				<label>Login:</label>
       			</div>
       			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
       				<label for=""><?php echo $obj->getLogin(); ?></label>
       			</div>

       		</div>
       		 
       	</div>
		<?php
		}
	}


       public function catalogoProductosAjax()
       {
              
       }
}


?>