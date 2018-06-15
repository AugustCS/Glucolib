<?php
ini_set('display_errors', true );
ini_set('track_errors', 'on');
		
		$ventas = '';
		$url = 'http://www.digital-realplaza.com:9797/middleware/api/middleware/1?method=metodMerListarVenta&json={"pi_Inmueble":16,"ps_Local":"LA-101","ps_Periodo":"201704"}';
		echo '<pre>';
		print_r($url);
		echo '</pre>';
		$output 	= file_get_contents($url);
		$respuesta 	= json_decode($output,TRUE);
		echo '<pre>';
		print_r($respuesta);
		echo '</pre>';



		// create curl resource 
        $ch = curl_init(); 

        // set url 
        curl_setopt($ch, CURLOPT_URL, $url); 

        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // $output contains the output string 
        $output = curl_exec($ch); 

        // close curl resource to free up system resources 
        curl_close($ch);  


        $respuesta2 	= json_decode($output,TRUE);


        echo '<pre>';
		print_r($respuesta2);
		echo '</pre>';

?>	