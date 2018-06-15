<?php  
/**
* 
*/
class HTMLAJAX
{
	
	public function tabla($columnas, $data)
	{
          array_unshift ($columnas,'paciente');
        ?> 
        <div class="capa_oculta">
            <table class="table table-striped jambo_table bulk_action">
				<thead>
				  <tr class="headings">
				  	<?php 
                    foreach ($columnas as $indice => $column): 
                        $ancho = '200px';
                        if ($indice > 4) {
                            $ancho = '30px';
                        }
				  		if ($indice <> 1) : ?>
				  			<th class="column-title" style="width: <?= $ancho; ?>"><?= $column; ?></th>
				  	<?php	
				  		endif;
				  	endforeach; 
                    ?>
				  </tr>
				</thead>
				<tbody>
				<?php  
				for ($i=0; $i < count($data); $i++) { 
					?> 
					<tr class="even pointer">
					<?php
					foreach ($columnas as $indice => $column):
                        $ancho = '200px';
                        if ($indice > 4) {
                            $ancho = '30px';
                        }
					if ($indice <> 1) :
						?><td class="" style="width: <?= $ancho;  ?>"><?= $data[$i][$column]; ?></td><?php
						endif;
					endforeach;
					?>
					</tr>
					
				<?php
				}
				?>
           	 	</tbody>
			</table>

        </div>
		<?php
	}


	public function estadisticas($data, $columnas, $id)
	{
        $horas = horas();

        $fechas = array(
                    '10/07/2017' => array(
                                        '04:15' => 120,
                                        '05:15' => 100,
                                        '06:15' => 180,
                                        '07:15' => 90,
                                        '08:15' => 97,
                                        '09:15' => 124,
                                        '10:15' => 125,
                                        '11:15' => 120,
                                        '12:15' => 110,
                                        '13:15' => 100,
                                    ), 
                    '11/07/2017' => array(
                                        '04:30' => 100,
                                        '05:30' => 120,
                                        '06:30' => 140,
                                        '07:00' => 98,
                                        '09:00' => 87,
                                        '09:48' => 167,
                                        '10:00' => 162,
                                        '15:15' => 114,
                                        '17:47' => 117,
                                        '19:28' => 105,
                                    )
            );

        pre($fechas);

        $aHora = array();

        foreach ($fechas as $fecha => $aHorasLinea) :
            foreach ($aHorasLinea as $horasLinea => $glucosa) :
                array_unshift ($aHora, $horasLinea);
            endforeach;
        endforeach;
        
        asort($aHora); 
        $aHhra = $aHora;
        $horaArray = array_values($aHhra);
        //pre($horaArray);

        ?>
        <div class="x_title">
            <form action="" method="get">
                <input type="hidden" value="estadisticas" name="action">
                <input type="hidden" value="<?= $id; ?>" name="id">
                <label for="">Ver por Rango de fechas <br></label>
               <input type="text" id="desde" name="desde" class="range">
                <input type="submit" value="BUSCAR" class="btn btn-success">
            </form>
        </div> 
        <?php  
        // $glucosa = array();
        // foreach ($columnas as $indice => $column):
        //         array_push($glucosa, $column['glucosa']);
        // endforeach; 
        // $glucosaMaxima = max($glucosa);
        // $info = array();
        // $i = 0;
        // foreach ($fechas as $fecha => $aHoras) {
        //     //pre($fecha);
        //     $info[$i] = $aHoras;
        //     $m = 0;
        //     foreach ($aHoras as $aHora => $glucosa) {
        //         //echo $aHora.' - ';
        //         //if ($aHora == $hora[$i]) {
        //             # code...
        //         //echo '"'.$glucosa.'",';
        //         //}
        //         //array_unshift ($info[$i], $glucosa);
        //         $info[$i][$aHora] = $glucosa;
        //         $m++;
        //     }
        //     $i++;

        //     echo '<br>';
        //     //pre($hora);
        // }

        // pre($info); 
        // $i = 0;


        ?>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.3/Chart.bundle.js"></script>
		<script src="/js/utils.js"></script>
		    <div style="width:100%;">
		        <canvas id="canvas"></canvas>
		    </div>
    <script>
    var lineChartData = {
        labels: [
        		<?php  
        		foreach ($horaArray as $indice => $valor): 
        			echo '"'.$valor.'",';
        		endforeach;
        		?>
        	 ],
        datasets: [
        <?php 
        $i = 0;
         foreach ($fechas as $fecha => $aHoras) :
            $color = '';
        	if ($i == 0 || $i == 4) {
        		$color = 'red';
        	}elseif ($i == 1 || $i == 5) {
        		$color = 'green';
        	}elseif ($i == 2 || $i == 6) {
        		$color = 'yellow';
        	}elseif($i == 3 || $i == 7) {
        		$color = 'blue';
        	}
        ?> 
		 {
            label: "<?= $fecha; ?>", 
            borderColor: window.chartColors.<?php echo $color; ?>,
            backgroundColor: window.chartColors.<?php echo $color;?>,
            fill: false,
            data: [ 

                <?php 
                    foreach ($horaArray as $indice => $valor): 
                        foreach ($aHoras as $hora => $glucosa) {
                    
                            if (in_array($hora, $aHhra)) {
                                echo '"'.$glucosa.'",';
                                //echo "Existe Irix";
                            }else{
                                echo '"0",';
                            }
                            // if ($valor == $hora) {
                            //     echo '"'.$glucosa.'",';
                            // } else{
                            //     echo '"0",';
                            // }
                        }


                            

                        endforeach;
                ?>
            <!--"","","","","","","","","", "140","110","98","","115","","","","","","","","120","","","","114", -->
            ],
            yAxisID: "y-axis-1",
        },
		<?php
        $i++;
        endforeach;
        ?>
        ]
    };

    window.onload = function() {
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myLine = Chart.Line(ctx, {
            data: lineChartData,
            options: {
                responsive: true,
                hoverMode: 'index',
                stacked: false,
                title:{
                    display: true,
                    text:'Reporte de muestras del paciente Glucolib'
                 },
               scales: {
                    yAxes: [{
                        type: "linear", 
                        display: true,
                        position: "left",
                        id: "y-axis-1",
                    }, {
                        type: "linear", 
                        display: false,
                        position: "right",
                        id: "y-axis-2",

                        // grid line settings
                        gridLines: {
                            drawOnChartArea: false, 
                        },
                    }],
                }
            }
        });
    };
    </script>
		<?php
	}
}

?>