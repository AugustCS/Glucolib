<?php
if(basename($_SERVER['PHP_SELF'])=="conexion.php")exit;
class Conexion{
	
	static $link	= 	0;
	var $host ;	
	var $user ;
	var $psw  ;
	var $db   ;

	public function Conexion($host, $user, $psw, $db){
		$this->host=	$host;
		$this->user=	$user;
		$this->psw	=	$psw;
		$this->db	=	$db;	
	
		self::$link = @mysqli_connect($this->host, $this->user, $this->psw, $this->db) or die(mysqli_error() ."error al conectarse al servidor");
		
		mysqli_set_charset( self::$link, 'utf8' );
		
		return self::$link;
	}
	public static function getInstance(){
		return self::$link;
	}
}
?>