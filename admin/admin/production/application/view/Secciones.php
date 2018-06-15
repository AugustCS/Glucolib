<?php  

/**
* 
*/
class Secciones
{

	public function listInsumosAction(){

  }
	

  public function listPedidosAction()
  {
    
    ?> 
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
            <h2>Listado de Pedidos <small></h2>
              <br>
              <br>
                <div class="table-responsive">
                  <form action="#" method="post" name="frmstock" id="frmstock">
                    
                    <table class="table table-striped jambo_table">
                      <thead>
                        <tr class="headings">
                          <th colspan="6" align="center">Búsqueda Avanzada</th>
                        </tr>
                      </thead>
                        <tr>
                          <td>Desde</td>
                          <td>
                            <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                              <input type="text" class="form-control has-feedback-left" id="desde" value="" name="desde" placeholder="17/02/2017" aria-describedby="inputSuccess2Status2">
                              <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                              <span id="inputSuccess2Status2" class="sr-only">(success)</span>
                            </div>

                            </td>
                          <td>Hasta</td>
                          <td>
                            <div class="col-md-11 xdisplay_inputx form-group has-feedback">
                              <input type="text" class="form-control has-feedback-left" id="hasta" name="hasta" value="" placeholder="17/02/2017" aria-describedby="inputSuccess2Status2">
                              <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                              <span id="inputSuccess2Status2" class="sr-only">(success)</span>
                            </div>
                            </td>
                          <td><input type="submit" class="btn btn-success" value="BUSCAR"></td>
                            
                        </tr>
                      </table>

                  </form>

                </div> 

        </div>
   <?php
  }

}

?>