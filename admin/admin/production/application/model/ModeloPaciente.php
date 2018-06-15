<?php

class ModeloPaciente{
	
	private $_id, $_nombre, $_apellido, $_correo, $_registro;
	
	public function __construct($id = 0){
		$this->_id = $id;
		
		if($this->_id > 0){
			 
			$sql = " SELECT * FROM pacientes n
						WHERE n.id_usuario = '".$this->_id."'";
			
			$query = new Consulta($sql);
			
			if($row = $query->VerRegistro()){ 
				$this->_nombre 	   		= $row['nombre'];
				$this->_apellido 		= $row['apellido'];
				$this->_correo	 		= $row['correo'];
				$this->_registro		= $row['registro'];
			}
		}					
	}
	
	public function __get($attribute){
		return	$this->$attribute;
	}
	
}
 ?>