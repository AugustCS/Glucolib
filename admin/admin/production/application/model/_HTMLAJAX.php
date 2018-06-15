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


	public function estadisticas($fechas, $aGlucosa, $id, $getFecha)
	{
        $mostrarFecha   = isset($getFecha) ? $getFecha : '';
        $horas          = horas();

        // $fechas = array(
        //             '10/07/2017' => array(
        //                                 '04:15' => 120,
        //                                 '05:34' => 100,
        //                                 '06:15' => 180,
        //                                 '07:42' => 90,
        //                                 '08:15' => 97,
        //                                 '09:20' => 124,
        //                                 '10:15' => 125,
        //                                 '11:15' => 120,
        //                                 '12:28' => 110,
        //                                 '13:54' => 100,
        //                             ), 
        //             '11/07/2017' => array(
        //                                 '04:30' => 100,
        //                                 '05:30' => 120,
        //                                 '06:30' => 140,
        //                                 '07:00' => 98,
        //                                 '09:00' => 87,
        //                                 '09:48' => 167,
        //                                 '15:15' => 114,
        //                                 '17:47' => 117,
        //                                 '19:28' => 105,
        //                             )
        //     );

        

        $aHora = array();

        foreach ($fechas as $fecha => $aHorasLinea) :
            foreach ($aHorasLinea as $horasLinea => $glucosa) :
                array_unshift ($aHora, $horasLinea);
            endforeach;
        endforeach;
        
        asort($aHora); 
        $aHhra          = $aHora;
        $arrayNumerico  = array();
        $horaArray      = array_values($aHhra);

            for ($n=0; $n < count($horaArray); $n++) { 
                $arrayNumerico[] = $n;
            }

            $m = 0; 
            $glucosa_maxima     = 0;
            $array_glucosa      = array();
            $dato               = $arrayNumerico;
            $array_fragmentos   = array();
            $glucosa_max           = array();
            $glucosa_min           = array();
            $glucosa_promedio      = array();
            $glucosa_standar      = array();
            foreach ($fechas as $fecha => $aHoras) :
                    $promedio = array_sum($aHoras)/count($aHoras); 
                    $standar  = stats_standard_deviation ($aHoras);
                    array_push($glucosa_max, max($aHoras));
                    array_push($glucosa_min, min($aHoras));
                    array_push($glucosa_promedio, $promedio); 
                    array_push($glucosa_standar, $standar); 
                $k = 0;
                foreach ($aHoras as $hora => $glucosa) {
                    array_push($array_glucosa, $glucosa);
                    $posiciones_encontradas = array_search($hora, $horaArray);
                    unset($dato[$posiciones_encontradas]);
                    $horaArrayP = $horaArray;
                    $k++;
                    $posY[$m] = $pos; 
                }
                $retono                 = $dato;
                $array_fragmentos[$m]   = $dato;
                $dato                   = $arrayNumerico;

                    $m++;
            endforeach;

            $glucosa_maxima =  max($array_glucosa) + (max($array_glucosa) * 0.20);
        ?>
        <div class="x_title">
            <form action="" method="get">
                <input type="hidden" value="estadisticas" name="action">
                <input type="hidden" value="<?= $id; ?>" name="id">
                <label for="">Ver por Rango de fechas <br></label>
               <input type="text" id="desde" name="desde" class="range" value="<?= $mostrarFecha; ?>">
                <input type="submit" value="BUSCAR" class="btn btn-success">
            </form>
        </div> 
        
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.3/Chart.bundle.js"></script>
		<script src="/js/utils.js"></script>
		    <div style="width:100%;" id="capa-grafica">
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
                    foreach ($horaArray as $indice => $hora):
                    $m = 0; 
                        echo '"'.$aHoras[$hora].'",';
                        endforeach;
                        echo '"'.$glucosa_maxima.'",';
                ?>
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

    <div class="form-group">
        <label for="">Leyenda:</label><br>
        <label for="">Eje X: Glucosa (Datos del sensor mg/dL)</label><br>
        <label for="">Eje Y: horas tomadas</label><br>
    </div>
    <div id="contenido-tabla">
    <?php  
    //pre($fechas);
    ?>
        <table class="table table-striped jambo_table bulk_action">
            <thead>
                <tr class="headings">
                    <th class="column-title">ACTIVIDADES / FECHAS </th>
                    <?php  
                    foreach ($fechas as $fecha => $valor) {
                    ?> 
                    <th class="column-title"><?php echo $fecha; ?></th>    
                    <?php
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php  
                foreach ($horaArray as $indice => $aHora) {
                    //pre($aHora);
                ?> 
                <tr>
                    <td class="even pointer"><?= $aHora ?></td>
                    <?php  
                    foreach ($fechas as $fecha => $horas) {
                        //pre($horas[$aHora]) ;
                        //pre($horas);
                        //foreach ($horas as $hora => $glucosa) {
                            //pre($valor);
                         //echo '<td>'.pre($horas[$aHora]) .' - '.$aHora.'</td>';
                            if ($horas[$aHora] != '') {
                                echo '<td>'.$horas[$aHora].'</td>';
                            }else{
                                echo '<td>-</td>';
                            }
                        //}
                    }
                    ?>
                </tr>

                <?php    
                }
                ?>
                <tr>
                    <td>Valor Mínimo</td>
                    <?php  
                    $i = 0;
                    foreach ($fechas as $fecha => $horas) :
                        echo "<td>".$glucosa_min[$i]."</td>";
                        $i++;
                    endforeach;
                    ?>
                </tr>
                <tr>
                    <td>Valor Máximo</td>
                    <?php  
                    $i=0;
                    foreach ($fechas as $fecha => $horas) :
                        echo "<td>".$glucosa_max[$i]."</td>";
                    $i++;
                    endforeach;
                    ?>
                </tr>
                <tr>
                    <td>Valor Promedio</td>
                    <?php  
                    $i=0;
                    foreach ($fechas as $fecha => $horas) :
                        echo "<td>".round($glucosa_promedio[$i],3)."</td>";
                    $i++;
                    endforeach;
                    ?>
                </tr>
                <tr>
                    <td>Desviación estandar</td>
                    <?php  
                    $i = 0;
                    foreach ($fechas as $fecha => $horas) :
                        echo "<td>".round($glucosa_standar[$i],3)."</td>";
                    $i++;
                    endforeach;
                    ?>
                </tr>
            </tbody>
        </table>
        
    </div>
		<?php
	}
}

?>