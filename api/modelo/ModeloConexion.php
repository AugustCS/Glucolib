<?php
/**
 * Description of ModeloConexion
 *
 * @author Segundo
 */

Class ModeloConexion {


    protected static function conectar( $DB_NAME_CURRENT ) {


        $conexion = new mysqli( DB_HOST , DB_USER , DB_PASS , $DB_NAME_CURRENT );        

        $conexion->query( DB_TIMEZONE );
        $conexion->query(" SET NAMES 'utf8' ");
            
        if (mysqli_connect_error()) {
            die('Arañitas del mal xD :(' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
        }

        return $conexion;

    }
    
    public static function ejecutar( $SQL , $dbName , $tipo ) {
        
        //echo $dbName.'<br>';
        //echo $SQL.'<br>';


        $conexion = self::conectar( $dbName );

        $data       = "";
        $resultado  = "";
        $totalpag   = "";


        switch ( $tipo ) {
            case '1':{ //PARA LOS SELECT


                $resultado = $conexion->query( $SQL );
                                
                //Validamos si hay resultados
                if( $resultado->num_rows >  0 ){

                    while ( $dato = $resultado->fetch_object() ) {
                        //echo "{$row->ID} is {$row->RABBIT} years old.<br />";
                        $data['LISTA'][] = $dato;
                        //$data['ltotal']++;
                    }
                    //GUARDAMOS EL NRO DE FILAS DEVUELTAS
                    $data['TOTAL'] = $resultado->num_rows;
                    //OBTENEMOS EL RESULTADO FILAS DE LA TABLA PARA LA PAGINACIÓN :D
                    $data['PAGINA'] = $conexion->query(" SELECT FOUND_ROWS() AS PAGINA ")->fetch_object()->PAGINA;



                }else{

                    //echo 'No hay datos';
                    $data['TOTAL'] = 0;

                }

                


                break;
            }
            case 2:{ //PARA LOS INSERT
                if( $resultado = $conexion->query( $SQL ) ){
                    $data['INSERT_ID'] = $conexion->insert_id;
                    $data['TOTAL'] = 1;
                }else{
                    $data['TOTAL'] = 0;
                }
                break;
            }
            case 3:{ //PARA LOS UPDATE
                $conexion->query( $SQL );
                if( $conexion->affected_rows > 0 ){
                    $data['TOTAL'] = 1;
                }else{
                    $data['TOTAL'] = 0;
                }
                break;
            }
            case 4:{ //PARA LOS UPDATE
                $conexion->query( $SQL );
                if( $conexion->affected_rows > 0 ){
                    $data['TOTAL'] = 1;
                }else{
                    $data['TOTAL'] = 0;
                }
                break;
            }

        }

        
        return $data;
        
    }
    
    


    

}



/*



/*
                if ( $stmt = $conexion->prepare( $SQL ) ) {

                    $stmt->execute();
                    $result = $stmt->get_result();

                    while ($data = $result->fetch_assoc()) {

                        // use your $myrow array as you would with any other fetch
                       //print_r($data);

                    }
                    
                    echo $result->num_rows;
                    print_r($result);
                    /*
                    
                    $row = array();
                    $data = mysqli_stmt_result_metadata($stmt);
                    $fields = array();

                    $fields[0] = $stmt;
                    $count = 1;

                    while($field = mysqli_fetch_field($data)) {
                        $fields[$count] = &$row[$field->name];
                        $count++;
                    }    
                    call_user_func_array('mysqli_stmt_bind_result', $fields);
                                        
                    while($stmt->fetch()){                        
                       echo $row['PERID'].'--';
                    }
                    


                   

                }



                $totalpag = $conexion->query(" SELECT FOUND_ROWS() ");
                $olo = $totalpag->fetch_object();
                print_r($olo);
                
                








    var $localhost = "localhost";
    var $usuario = "root";
    var $passwor = "2docool";
    var $basedatos = "entraatu_unmsm_derecho_2013";





    public function conectar() {
        mysql_pconnect($this->localhost, $this->usuario, $this->passwor) or die("Arañitas del mal xD :" . mysql_error());
        mysql_select_db($this->basedatos) or die("why?? : " . mysql_error());
        mysql_query("SET NAMES utf8");
        mysql_query("SET time_zone = 'America/Lima'");
    }

    public function desconectar() {
        mysql_close() or die("second chance : " . mysql_error());
    }

    protected function actualizaRegistro($tabla, $columnas, $filtro, $valores, $opcion = "", $imprime = "") {
        
        $tabla = strtolower($tabla);
        $ad = " SET ";
        $conta = count($columnas);

        for ($i = 0; $i < $conta; $i++) {
            $ad .= $columnas[$i] . " = '" . $valores[$i] . "' ,";
        }

        $ad = substr($ad, 0, -1);
        $sql = " UPDATE " . $tabla . $ad . " WHERE " . $filtro;
        
        if ($imprime == 1) {
            echo '<br/>' . $sql . '<br/>';
        }
        
        $this->conectar();
        $resultado = mysql_query($sql);
        if ($resultado) {
            $this->desconectar();
            return true;
        } else {
            return mysql_error();
        }
    }

    protected function leeProcesosAlmacenados($proceso, $parametro, $imprime = "") {

        $data = "";
        $sql = " CALL $proceso(" . $parametro . ") ";
        if ($imprime == 1) {
            echo '<br/>' . $sql . '<br/>';
        }

        $data = "";
        $cnxtmp = $this->conectar_proceso();
        $obja = $cnxtmp->query($sql);

        if ($cnxtmp->affected_rows > 0) {

            //Llenamos el arreglo con la data
            while ($dato = $obja->fetch_assoc()) {
                $data['lista'][] = $dato;
            }
            //Agregamos el total de filas de la bd
            $data['total'] = $cnxtmp->affected_rows;
        } else {
            $data['total'] = 0;
        }

        return $data;
    }

    protected function leeRegistro($tabla, $columnas, $filtro, $orden, $opciones = "", $inner = "", $imprime = "") {
        //$tabla=strtolower($tabla);
        if (empty($columnas)) {
            $columnas = "*";
        }

        $sql = " SELECT SQL_CALC_FOUND_ROWS " . $columnas . " FROM " . $tabla . " " . $inner . " ";

        if (!empty($filtro)) {
            $sql.=" WHERE " . $filtro;
        }

        if (!empty($orden)) {
            $sql.=" ORDER BY " . $orden;
        }

        if (!empty($opciones)) {
            $sql.=" " . $opciones;
        }

        if ($imprime == 1) {
            echo '<br/><br/>' . $sql . '<br/><br/>';
        }


        $data = "";
        $this->conectar();
        $que = mysql_query($sql);
        // echo mysql_query(" SELECT FOUND_ROWS() ");
        $tot = mysql_fetch_row(mysql_query(" SELECT FOUND_ROWS() "));

        //Evaluamos si hay registros        

        if ($tot[0] > 0) {
            $data['ltotal'] = 0;


            //Llenamos el arreglo con la data
            while ($dato = mysql_fetch_assoc($que)) {
                $data['lista'][] = $dato;
                $data['ltotal']++;
            }

            //Agregamos el total de filas de la bd
            $data['total'] = $tot[0];

            $this->desconectar();
        } else {
            $data['total'] = 0;
        }


        return $data;
    }

    protected function GrabaRegistro($tabla, $columnas, $filtro, $valores, $opcion = "", $imprime = "") {
        $tabla = strtolower($tabla);
        $col = "";
        $val = "";
        $total = count($columnas);
        for ($i = 0; $i < $total; $i++) {
            $col .= $columnas[$i] . ",";
            $val .= "'" . $valores[$i] . "',";
        }

        $col = substr($col, 0, -1);
        $val = substr($val, 0, -1);
        $sql = " INSERT INTO " . $tabla . " ( " . $col . " ) VALUES ( " . $val . " ) ";

        if ($imprime == 1) {
            echo '<br/><br/>' . $sql . '<br/><br/>';
        }
        //echo '<br/><br/>'.$sql.'<br/><br/>';
        $this->conectar();
        $resultado = mysql_query($sql);
        if ($resultado) {
            $this->idultimo = mysql_insert_id();
            $this->desconectar();
            return true;
        } else {
            return mysql_error();
        }
    }

*/

?>