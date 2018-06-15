<?php  

/**
* 
*/
class ModeloIglesias
{
	
	public function listado($obj)
	{
		$nivel = "";
		$curso = "";

		if ($obj->nivel != '') {
			$nivel = " AND n.nivel LIKE '%".$obj->nivel."%'";
		}

		if ($obj->curso != '') {
			$curso = " AND cu.curso LIKE '%".$obj->curso."%'";
		}

	$sql = "SELECT 	cu.id_curso, 
				cu.curso, 
				nc.id_nivel, 
				n.nivel, 
				cd.id_docente, 
				d.dni, 
				CONCAT(d.nombres,' ', d.paterno,' ',d.materno) AS docente
				,du.direccion, du.latitud, du.longitud,
				(6371 * ACOS( SIN(RADIANS(du.latitud)) * SIN(RADIANS('$obj->latitud')) + 
						COS(RADIANS(du.longitud - '$obj->longitud')) * COS(RADIANS(du.latitud)) * COS(RADIANS('$obj->latitud')) ) ) AS distancia 
			FROM curso AS cu
			INNER JOIN nivel_curso AS nc ON (nc.id_curso = cu.id_curso)
			INNER JOIN nivel AS n ON (n.id_nivel = nc.id_nivel)
			INNER JOIN curso_docente AS cd ON (cd.id_nivel_curso = nc.id_nc)
			INNER JOIN docente AS d ON (d.id_docente = cd.id_docente)
			 INNER JOIN docente_ubicacion AS du ON (du.dni = d.dni)
			WHERE n.estado = 1
			$nivel
			$curso
			GROUP BY id_curso,id_nivel,id_docente
			HAVING distancia < '30'
			ORDER BY distancia ASC";			

			$data = ModeloConexion::ejecutar( $sql , DB_NAME ,DB_SELECT);
        	$respuesta 	= array();
        	$retorno 	= new stdClass();

        	$retorno->TOTAL 	= $data['TOTAL'];
        	$tipoMetraje = '';
                for ( $i = 0; $i < $data['TOTAL']; $i++) {
                		$distancia = number_format($data['LISTA'][$i]->distancia,2);
                	if ($distancia < 1) {
                		$tipoMetraje = 'Mts';
                	}else if ($distancia >1) {
                		$tipoMetraje = 'Kms';
                	}
                
                    $rp = new stdClass();
                    $rp->id    				= $data['LISTA'][$i]->id_docente;
                    $rp->id_curso			= $data['LISTA'][$i]->id_curso;
                    $rp->id_nivel			= $data['LISTA'][$i]->id_nivel;
                    $rp->nombre         	= "Profesor(a): ".$data['LISTA'][$i]->docente;
                    $rp->hora_inicio        = "Curso: ".$data['LISTA'][$i]->curso;
                    $rp->logo          		= "https://media.licdn.com/mpr/mpr/shrinknp_400_400/AAEAAQAAAAAAAAhrAAAAJDllODgyNWI2LTkxYTMtNGI3Ni04ODg4LWM1NWQwNDhkZGJlOA.jpg";
                    $rp->distance          	= $distancia.' '.$tipoMetraje;
                    $rp->direccion          = $data['LISTA'][$i]->direccion;
                    $rp->latitud          	= $data['LISTA'][$i]->latitud;
                    $rp->longitud          	= $data['LISTA'][$i]->longitud;
                    $rp->descripcion        = "Se dictan clases de matemáticas a domicilio. Tengo la lincenciatura para dictar. Los espero";
                    $respuesta[]            = $rp;
                }
                $retorno->LISTA = $respuesta;
    	return $respuesta;
	}

	public function detalle($obj)
	{
		
		$sql 	= "SELECT id_docente,dni,CONCAT(nombres,' ',paterno,' ',materno) AS nombre, email,telefono FROM docente WHERE id_docente = '$obj->id'";
		$data 	= ModeloConexion::ejecutar( $sql , DB_NAME ,DB_SELECT);

		$respuesta = array();
        	$tipoMetraje = '';
                for ( $i = 0; $i < $data['TOTAL']; $i++) {
                		
                    $rp = new stdClass();
                    $rp->id    				= $data['LISTA'][$i]->id_docente;
                    $rp->nombre         	= "Profesor(a): ".$data['LISTA'][$i]->nombre;
                    $rp->hora_inicio        = "Email: ".$data['LISTA'][$i]->email;
                    $rp->direccion          = "Avenida los cedros 450 - chaclacayo";
                    $rp->latitud          	= $obj->latitud;
                    $rp->longitud          	= $obj->longitud;
                    $rp->descripcion        = "Se dictan clases de matemáticas a domicilio. Tengo la lincenciatura para dictar. Los espero";
                    $respuesta[]            = $rp;
                }
    	return $respuesta;

	}

	public function telefonos($obj)
	{
		//$sql 	= "SELECT telefono FROM docente WHERE id_docente = '$obj->id'";
		$sql 	= "SELECT telefono FROM docente_telefono WHERE docente_id = '$obj->id'";
		$data 	= ModeloConexion::ejecutar( $sql , DB_NAME ,DB_SELECT);

		$total 		= $data['TOTAL'];
		$respuesta 	= array();

		for ( $i = 0; $i < $data['TOTAL']; $i++) {
			$numero = $data['LISTA'][$i]->telefono;
			if ($numero == 'null' || $numero == "") {
				$numero = "El docente no tiene un número de contacto";
			}
			$rp 			= new stdClass();
			$rp->numero 	= $numero;
			$respuesta[] 	= $rp;
		}
		return $respuesta;
	}

	public function misasxCapilla()
	{
		
		for ($i=0; $i < 3; $i++) { 
			$data[] = array(
				'dias'	=> 'L-M-M',
				'hora_inicio'	=> '08:50',
				
			);	
		}
		return $data;
	}

	public function cursos($obj)
	{
		$sql =  "SELECT cu.id_curso, cu.curso, nivel
				FROM curso AS cu
				INNER JOIN nivel_curso AS nc ON (nc.id_curso = cu.id_curso)
				INNER JOIN nivel AS n ON (n.id_nivel = nc.id_nivel)
				INNER JOIN curso_docente AS cd ON (cd.id_nivel_curso = nc.id_nc)
				INNER JOIN docente AS d ON (d.id_docente = cd.id_docente)
				WHERE d.id_docente = '$obj->id'
				GROUP BY cu.id_curso
				ORDER BY curso ASC";
		$data 	= ModeloConexion::ejecutar( $sql , DB_NAME ,DB_SELECT);

		$total 		= $data['TOTAL'];
		$respuesta 	= array();

		for ( $i = 0; $i < $data['TOTAL']; $i++) {
			
			$rp 			= new stdClass();
			$rp->cursos 	= $data['LISTA'][$i]->curso;
			$rp->nivel 		= $data['LISTA'][$i]->nivel;
			$respuesta[] 	= $rp;
		}
		return $respuesta;
	}
}


?>