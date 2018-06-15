<?php  
/**
* 
*/
class HTMLAJAX
{
	
	public function tabla($columnas, $data)
	{
          array_unshift ($columnas,'paciente');
		  //pre($columnas);

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
        ?>
        <div class="x_title">
            <form action="" method="get">
                <input type="hidden" value="estadisticas" name="action">
                <input type="hidden" value="<?= $id; ?>" name="id">
                <label for="">Ver por Rango de fechas <br></label>
<!--                 <strong>Desde: </strong>
 -->                <input type="text" id="desde" name="desde" class="range">
                <!-- <strong>Hasta: </strong>
                <input type="text" id="hasta" name="hasta" class="range"> -->
                <input type="submit" value="BUSCAR" class="btn btn-success">
                
            </form>


        </div> 
        <?php  
        $glucosa = array();
        foreach ($columnas as $indice => $column):
                array_push($glucosa, $column['glucosa']);
        endforeach; 
        $glucosaMaxima = max($glucosa);
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
        		foreach ($data as $indice => $column): 
                    //pre($indice);
        				//if($indice >2):
        					echo '"'.$column['registro'].'",';
        				//endif;
        		endforeach;
        		?>
        	 ],
        datasets: [
        <?php 
         //for ($i=0; $i < count($data); $i++) : 
        // 	if ($i == 0 || $i == 4) {
        // 		$color = 'red';
        // 	}elseif ($i == 1 || $i == 5) {
        // 		$color = 'green';
        // 	}elseif ($i == 2 || $i == 6) {
        // 		$color = 'yellow';
        // 	}elseif($i == 3 || $i == 7) {
        // 		$color = 'blue';
        // 	}

        // $valorMax = 0;

        ?>
		 {
            label: "Resultados",<!-- (<?= $data[$i]['registro'];?>)", -->
            borderColor: window.chartColors.green, <!--<?php echo $color; ?>, -->
            backgroundColor: window.chartColors.green,<!--<?php echo $color;?>,-->
            fill: false,
            data: [
            	<?php  
            	foreach ($columnas as $indice => $column):
                        echo '"'.$column['glucosa'].'",';
                        $valorMax = 1+$column['glucosa'];
            	endforeach;	
                $max = $glucosaMaxima + ($glucosaMaxima * 0.20);
                echo '"'.$max.'",';
                ?>

            ],
            yAxisID: "y-axis-1",
        },

		<?php
        //endfor;
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
                    text:'Reporte de muestras del paciente'
                 },
               scales: {
                    yAxes: [{
                        type: "linear", // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                        display: true,
                        position: "left",
                        id: "y-axis-1",
                    }, {
                        type: "linear", // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
                        display: true,
                        position: "right",
                        id: "y-axis-2",

                        // grid line settings
                        gridLines: {
                            drawOnChartArea: false, // only want the grid lines for one axis to show up
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